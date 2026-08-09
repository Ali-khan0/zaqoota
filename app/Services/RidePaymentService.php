<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Library\Payer;
use App\Library\Payment as PaymentInfo;
use App\Library\Receiver;
use App\Models\Admin;
use App\Models\AdminWallet;
use App\Models\BusinessSetting;
use App\Models\DeliveryManWallet;
use App\Models\DeliveryManWalletLedger;
use App\Models\Expense;
use App\Models\RidePayment;
use App\Models\RideRequest;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Traits\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class RidePaymentService
{
    public const DIGITAL_GATEWAYS = [
        'ssl_commerz', 'stripe', 'paymob_accept', 'flutterwave', 'paytm',
        'paypal', 'paytabs', 'liqpay', 'razor_pay', 'senang_pay', 'assan_pay',
        'mercadopago', 'bkash', 'paystack', 'fatoorah', 'xendit', 'amazon_pay',
        'iyzi_pay', 'hyper_pay', 'foloosi', 'ccavenue', 'pvit', 'moncash',
        'thawani', 'tap', 'viva_wallet', 'hubtel', 'maxicash', 'esewa', 'swish',
        'momo', 'payfast', 'worldpay', 'sixcash', 'phonepe', 'cashfree', 'instamojo',
    ];

    public function __construct(
        private readonly RideSettlementCalculator $calculator,
        private readonly RideNotificationService $notificationService,
        private readonly RideRealtimeService $realtimeService,
    ) {}

    public function createWalletAttempt(RideRequest $ride): RidePayment
    {
        $plan = $this->prepareAttempt($ride, 'wallet', null, true);
        $this->settle($plan['settlement_payment_id']);

        return $plan['wallet_payment']->fresh();
    }

    public function createCashAttempt(RideRequest $ride, bool $useWallet = false): array
    {
        $plan = $this->prepareAttempt($ride, 'cash', null, $useWallet);
        if ($plan['settlement_payment_id']) {
            $this->settle($plan['settlement_payment_id']);
        } else {
            $this->realtimeService->payment($plan['payment']->rideRequest()->firstOrFail());
        }

        return $plan;
    }

    public function createDigitalAttempt(RideRequest $ride, string $gateway, string $callbackUrl, string $platform, bool $useWallet = false): array
    {
        if (! in_array($gateway, self::DIGITAL_GATEWAYS, true)) {
            throw new RuntimeException('The selected payment gateway is not supported.');
        }

        $plan = $this->prepareAttempt($ride, 'digital', $gateway, $useWallet);
        if ($plan['settlement_payment_id']) {
            $this->settle($plan['settlement_payment_id']);

            return [...$plan, 'redirect_link' => null];
        }

        $payment = $plan['payment'];
        $customer = $ride->user;
        $logo = BusinessSetting::query()->where('key', 'logo')->first();
        $paymentInfo = new PaymentInfo(
            success_hook: 'ride_payment_success',
            failure_hook: 'ride_payment_fail',
            currency_code: Helpers::currency_code(),
            payment_method: $gateway,
            payment_platform: $platform,
            payer_id: $ride->user_id,
            receiver_id: 1,
            additional_data: [
                'business_name' => BusinessSetting::query()->where('key', 'business_name')->value('value'),
                'business_logo' => Helpers::get_full_url('business', $logo?->value, $logo?->storage[0]?->value ?? 'public'),
                'ride_request_number' => $ride->request_number,
            ],
            payment_amount: $payment->amount,
            external_redirect_link: $callbackUrl,
            attribute: 'ride_payment',
            attribute_id: $payment->id,
        );
        try {
            $link = Payment::generate_link(
                new Payer(trim($customer->f_name.' '.$customer->l_name), (string) $customer->email, (string) $customer->phone, ''),
                $paymentInfo,
                new Receiver('Zaqoota', 'example.png'),
            );
        } catch (\Throwable $exception) {
            $this->fail($payment->id);
            throw new RuntimeException('The payment link could not be created. Please try again.', previous: $exception);
        }
        if (! $link) {
            $this->fail($payment->id);
            throw new RuntimeException('The selected payment gateway is not available.');
        }

        parse_str((string) parse_url((string) $link, PHP_URL_QUERY), $query);
        if (! empty($query['payment_id'])) {
            $payment->update(['payment_request_id' => $query['payment_id']]);
        }
        $this->realtimeService->payment($payment->rideRequest()->firstOrFail());

        return [...$plan, 'payment' => $payment->fresh(), 'redirect_link' => (string) $link];
    }

    public function settle(int $paymentId, ?string $gateway = null, ?string $transactionReference = null): ?RideRequest
    {
        $result = DB::transaction(function () use ($paymentId, $gateway, $transactionReference) {
            $payment = RidePayment::query()->lockForUpdate()->find($paymentId);
            if (! $payment || $payment->status === RidePayment::STATUS_FAILED) {
                return null;
            }
            $ride = RideRequest::query()->lockForUpdate()->findOrFail($payment->ride_request_id);
            if ($ride->settled_at) {
                return ['ride' => $ride->fresh(['user', 'deliveryMan', 'rideVehicle', 'category']), 'newly_settled' => false];
            }
            $this->assertPayable($ride);
            $financials = $this->calculator->calculate($ride);
            $isCancellationRecovery = $ride->status === RideRequest::STATUS_CANCELLED && $ride->cancellation_compensation_paid_at;

            if ($payment->status !== RidePayment::STATUS_PAID) {
                $payment->update([
                    'status' => RidePayment::STATUS_PAID,
                    'payment_gateway' => $gateway ?: $payment->payment_gateway,
                    'transaction_reference' => $transactionReference,
                    'paid_at' => now(),
                ]);
            }

            $paidPayments = RidePayment::query()->where('ride_request_id', $ride->id)
                ->where('status', RidePayment::STATUS_PAID)->lockForUpdate()->get();
            $paidTotal = round((float) $paidPayments->sum('amount'), 2);
            if ($paidTotal > $financials['final_payable_amount']) {
                throw new RuntimeException('Ride payments exceed the payable amount.');
            }
            if ($paidTotal < $financials['final_payable_amount']) {
                $ride->update([
                    'payment_status' => 'partially_paid',
                    'payment_method' => 'partial_payment',
                    'wallet_paid_amount' => round((float) $paidPayments->where('payment_method', 'wallet')->sum('amount'), 2),
                ]);

                return ['ride' => $ride->fresh(['user', 'deliveryMan', 'rideVehicle', 'category']), 'newly_settled' => false];
            }

            $cashPaid = round((float) $paidPayments->where('payment_method', 'cash')->sum('amount'), 2);
            $digitalPaid = round((float) $paidPayments->where('payment_method', 'digital')->sum('amount'), 2);
            $walletPaid = round((float) $paidPayments->where('payment_method', 'wallet')->sum('amount'), 2);
            $methods = $paidPayments->pluck('payment_method')->unique()->values();
            $method = $methods->count() > 1 ? 'partial_payment' : (string) $methods->first();
            $digitalPayment = $paidPayments->where('payment_method', 'digital')->last();
            $reference = 'ride:'.$ride->id;

            if (! $isCancellationRecovery) {
                $wallet = DeliveryManWallet::query()->firstOrCreate(['delivery_man_id' => $ride->delivery_man_id]);
                $wallet = DeliveryManWallet::query()->whereKey($wallet->id)->lockForUpdate()->firstOrFail();
                $wallet->total_earning += $financials['captain_total_earning_amount'];
                $wallet->collected_cash += $cashPaid;
                $wallet->save();

                $grossCaptainBase = round($financials['captain_total_earning_amount'] + $financials['platform_commission_amount'], 2);
                $this->ledger($ride, DeliveryManWalletLedger::TYPE_RIDE_EARNING, $reference, $grossCaptainBase, DeliveryManWalletLedger::DIR_CREDIT, $financials);
                if ($financials['platform_commission_amount'] > 0) {
                    $this->ledger($ride, DeliveryManWalletLedger::TYPE_RIDE_PLATFORM_COMMISSION, $reference, $financials['platform_commission_amount'], DeliveryManWalletLedger::DIR_DEBIT, $financials);
                }
                if ($cashPaid > 0) {
                    $this->ledger($ride, DeliveryManWalletLedger::TYPE_RIDE_CASH_COLLECTION, $reference, $cashPaid, DeliveryManWalletLedger::DIR_DEBIT, $financials);
                }
            }

            $admin = Admin::query()->where('role_id', 1)->first();
            if ($admin) {
                $adminWallet = AdminWallet::query()->firstOrCreate(['admin_id' => $admin->id]);
                $adminWallet = AdminWallet::query()->whereKey($adminWallet->id)->lockForUpdate()->firstOrFail();
                $adminWallet->total_commission_earning += $financials['platform_commission_amount'];
                $adminWallet->digital_received += $digitalPaid;
                $adminWallet->save();
            }

            if (! $isCancellationRecovery && $ride->admin_coupon_expense_amount > 0) {
                $expense = new Expense;
                $expense->amount = $ride->admin_coupon_expense_amount;
                $expense->type = 'ride_coupon_discount';
                $expense->ride_request_id = $ride->id;
                $expense->created_by = 'admin';
                $expense->user_id = $ride->user_id;
                $expense->description = 'Ride coupon '.$ride->coupon_code.' for '.$ride->request_number;
                $expense->created_at = now();
                $expense->updated_at = now();
                $expense->save();
            }

            $ride->update([
                ...$financials,
                'payment_status' => $isCancellationRecovery ? 'recovered' : 'paid',
                'payment_method' => $method,
                'payment_gateway' => $digitalPayment?->payment_gateway,
                'payment_transaction_reference' => $digitalPayment?->transaction_reference ?: $payment->transaction_reference,
                'wallet_paid_amount' => $walletPaid,
                'receipt_number' => 'ZQR-R-'.str_pad((string) $ride->id, 7, '0', STR_PAD_LEFT),
                'paid_at' => now(),
                'settled_at' => now(),
                'cancellation_recovered_at' => $isCancellationRecovery ? now() : $ride->cancellation_recovered_at,
            ]);
            if ($isCancellationRecovery) {
                $recovery = new Expense;
                $recovery->amount = -$ride->cancellation_charge_amount;
                $recovery->type = 'ride_cancellation_recovery';
                $recovery->ride_request_id = $ride->id;
                $recovery->created_by = 'admin';
                $recovery->user_id = $ride->user_id;
                $recovery->description = 'Cancellation advance recovered directly for '.$ride->request_number;
                $recovery->save();
            }
            $recoveredCancellations = RideRequest::query()->where('recovery_ride_id', $ride->id)->whereNull('cancellation_recovered_at')->lockForUpdate()->get();
            if ($recoveredCancellations->isNotEmpty()) {
                $recovery = new Expense;
                $recovery->amount = -round((float) $recoveredCancellations->sum('cancellation_charge_amount'), 2);
                $recovery->type = 'ride_cancellation_recovery';
                $recovery->ride_request_id = $ride->id;
                $recovery->created_by = 'admin';
                $recovery->user_id = $ride->user_id;
                $recovery->description = 'Cancellation advances recovered through '.$ride->request_number;
                $recovery->save();
                RideRequest::query()->whereKey($recoveredCancellations->pluck('id'))->update([
                    'cancellation_recovered_at' => now(), 'payment_status' => 'recovered',
                    'payment_method' => 'next_ride', 'paid_at' => now(), 'settled_at' => now(),
                ]);
            }

            return ['ride' => $ride->fresh(['user', 'deliveryMan', 'rideVehicle', 'category']), 'newly_settled' => true, 'cancellation_recovery' => $isCancellationRecovery];
        });

        if (! $result) {
            return null;
        }
        if ($result['newly_settled']) {
            $this->notificationService->event($result['ride'], 'payment_received');
            if (! ($result['cancellation_recovery'] ?? false)) {
                $this->notificationService->event($result['ride'], 'earning_posted');
            }
            $this->realtimeService->payment($result['ride']);
        }

        return $result['ride'];
    }

    public function fail(int $paymentId): void
    {
        $ride = DB::transaction(function () use ($paymentId) {
            $payment = RidePayment::query()->lockForUpdate()->find($paymentId);
            if (! $payment || $payment->status === RidePayment::STATUS_PAID) {
                return null;
            }
            $payment->update(['status' => RidePayment::STATUS_FAILED, 'failed_at' => now()]);
            $ride = RideRequest::query()->lockForUpdate()->find($payment->ride_request_id);
            if ($ride && ! $ride->settled_at) {
                $walletPaid = round((float) $ride->payments()->where('status', RidePayment::STATUS_PAID)->where('payment_method', 'wallet')->sum('amount'), 2);
                $ride->update([
                    'payment_status' => $walletPaid > 0 ? 'partially_paid' : 'unpaid',
                    'payment_method' => $walletPaid > 0 ? 'partial_payment' : null,
                    'payment_gateway' => null,
                    'wallet_paid_amount' => $walletPaid,
                ]);
            }

            return $ride;
        });
        if ($ride) {
            $this->realtimeService->payment($ride);
        }
    }

    private function prepareAttempt(RideRequest $ride, string $method, ?string $gateway, bool $useWallet): array
    {
        return DB::transaction(function () use ($ride, $method, $gateway, $useWallet) {
            $ride = RideRequest::query()->lockForUpdate()->findOrFail($ride->id);
            $this->assertPayable($ride);
            if ($ride->payments()->where('status', RidePayment::STATUS_PENDING)->exists()) {
                throw new RuntimeException('A payment attempt is already pending for this ride.');
            }

            $payable = $this->calculator->calculate($ride)['final_payable_amount'];
            $alreadyPaid = round((float) $ride->payments()->where('status', RidePayment::STATUS_PAID)->sum('amount'), 2);
            $remainingBeforeWallet = round($payable - $alreadyPaid, 2);
            if ($remainingBeforeWallet <= 0) {
                throw new RuntimeException('This ride has already been paid.');
            }

            $user = User::query()->withoutGlobalScopes()->whereKey($ride->user_id)->lockForUpdate()->firstOrFail();
            if ($useWallet && (int) BusinessSetting::query()->where('key', 'wallet_status')->value('value') !== 1) {
                throw new RuntimeException('Customer wallet payment is not active.');
            }
            $split = $this->calculator->paymentSplit($remainingBeforeWallet, (float) $user->wallet_balance, $useWallet);
            if ($method === 'wallet' && $split['remaining_amount'] > 0) {
                throw new RuntimeException('The customer wallet balance is insufficient for this ride payment.');
            }
            if ($useWallet && $split['wallet_amount'] <= 0) {
                throw new RuntimeException('The customer wallet does not have an available balance.');
            }

            if ($method !== 'wallet' && $split['wallet_amount'] > 0 && $split['remaining_amount'] > 0) {
                $this->assertPartialPaymentAllowed($method);
            }

            $walletPayment = null;
            if ($split['wallet_amount'] > 0) {
                $transactionId = (string) Str::uuid();
                $user->wallet_balance = round((float) $user->wallet_balance - $split['wallet_amount'], 3);
                $user->save();
                $walletTransaction = new WalletTransaction;
                $walletTransaction->user_id = $user->id;
                $walletTransaction->transaction_id = $transactionId;
                $walletTransaction->reference = 'ride:'.$ride->id;
                $walletTransaction->transaction_type = $method === 'wallet' ? 'trip_booking' : 'partial_payment';
                $walletTransaction->credit = 0;
                $walletTransaction->debit = $split['wallet_amount'];
                $walletTransaction->admin_bonus = 0;
                $walletTransaction->balance = $user->wallet_balance;
                $walletTransaction->created_at = now();
                $walletTransaction->updated_at = now();
                $walletTransaction->save();
                $walletPayment = RidePayment::query()->create([
                    'ride_request_id' => $ride->id,
                    'user_id' => $ride->user_id,
                    'delivery_man_id' => $ride->delivery_man_id,
                    'amount' => $split['wallet_amount'],
                    'payment_method' => 'wallet',
                    'transaction_reference' => $transactionId,
                    'status' => RidePayment::STATUS_PAID,
                    'paid_at' => now(),
                ]);
            }

            $remaining = round($remainingBeforeWallet - $split['wallet_amount'], 2);
            $payment = null;
            if ($remaining > 0 && $method !== 'wallet') {
                $payment = RidePayment::query()->create([
                    'ride_request_id' => $ride->id,
                    'user_id' => $ride->user_id,
                    'delivery_man_id' => $ride->delivery_man_id,
                    'amount' => $remaining,
                    'payment_method' => $method,
                    'payment_gateway' => $gateway,
                    'status' => RidePayment::STATUS_PENDING,
                ]);
            }

            $totalWalletPaid = round($alreadyPaid + $split['wallet_amount'], 2);
            $ride->update([
                'payment_status' => $totalWalletPaid > 0 ? 'partially_paid' : 'pending',
                'payment_method' => $totalWalletPaid > 0 && $remaining > 0 ? 'partial_payment' : $method,
                'payment_gateway' => $gateway,
                'wallet_paid_amount' => $totalWalletPaid,
            ]);

            return [
                'payment' => $payment ?: $walletPayment,
                'wallet_payment' => $walletPayment,
                'wallet_amount' => $split['wallet_amount'],
                'remaining_amount' => $remaining,
                'settlement_payment_id' => $remaining === 0 ? $walletPayment?->id : null,
            ];
        });
    }

    private function assertPartialPaymentAllowed(string $method): void
    {
        if ((int) BusinessSetting::query()->where('key', 'partial_payment_status')->value('value') !== 1) {
            throw new RuntimeException('Partial payment is not active.');
        }
        $configuredMethod = (string) BusinessSetting::query()->where('key', 'partial_payment_method')->value('value');
        $allowed = $configuredMethod === 'both'
            || ($method === 'cash' && $configuredMethod === 'cod')
            || ($method === 'digital' && $configuredMethod === 'digital_payment');
        if (! $allowed) {
            throw new RuntimeException('The selected partial payment method is not active.');
        }
    }

    private function assertPayable(RideRequest $ride): void
    {
        $payable = $ride->status === RideRequest::STATUS_COMPLETED
            || ($ride->status === RideRequest::STATUS_CANCELLED && $ride->cancellation_charge_amount > 0 && $ride->cancellation_compensation_paid_at && ! $ride->cancellation_recovered_at);
        if (! $payable) {
            throw new RuntimeException('This ride is not ready for payment.');
        }
        if ($ride->settled_at || $ride->payment_status === 'paid') {
            throw new RuntimeException('This ride has already been paid.');
        }
    }

    private function ledger(RideRequest $ride, string $type, string $reference, float $amount, string $direction, array $financials): void
    {
        DeliveryManWalletLedger::query()->create([
            'delivery_man_id' => $ride->delivery_man_id,
            'transaction_type' => $type,
            'reference' => $reference,
            'amount' => $amount,
            'direction' => $direction,
            'meta' => ['ride_request_id' => $ride->id, ...$financials],
        ]);
    }
}
