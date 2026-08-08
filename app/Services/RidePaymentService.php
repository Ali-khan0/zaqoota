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
use App\Models\RidePayment;
use App\Models\RideRequest;
use App\Traits\Payment;
use Illuminate\Support\Facades\DB;
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

    public function createCashAttempt(RideRequest $ride): RidePayment
    {
        $payment = DB::transaction(function () use ($ride) {
            $ride = RideRequest::query()->lockForUpdate()->findOrFail($ride->id);
            $this->assertPayable($ride);
            if ($ride->payments()->where('status', RidePayment::STATUS_PENDING)->where('payment_method', 'digital')->exists()) {
                throw new RuntimeException('An online payment attempt is already pending for this ride.');
            }
            $amount = $this->calculator->calculate($ride)['final_payable_amount'];
            $payment = RidePayment::query()->firstOrCreate([
                'ride_request_id' => $ride->id,
                'payment_method' => 'cash',
                'status' => RidePayment::STATUS_PENDING,
            ], [
                'user_id' => $ride->user_id,
                'delivery_man_id' => $ride->delivery_man_id,
                'amount' => $amount,
            ]);
            $ride->update(['payment_status' => 'pending', 'payment_method' => 'cash', 'payment_gateway' => null]);

            return $payment;
        });

        $this->realtimeService->payment($payment->rideRequest()->firstOrFail());

        return $payment;
    }

    public function createDigitalAttempt(RideRequest $ride, string $gateway, string $callbackUrl, string $platform): array
    {
        if (! in_array($gateway, self::DIGITAL_GATEWAYS, true)) {
            throw new RuntimeException('The selected payment gateway is not supported.');
        }

        $payment = DB::transaction(function () use ($ride, $gateway) {
            $ride = RideRequest::query()->lockForUpdate()->findOrFail($ride->id);
            $this->assertPayable($ride);
            if ($ride->payments()->where('status', RidePayment::STATUS_PENDING)->exists()) {
                throw new RuntimeException('A payment attempt is already pending for this ride.');
            }
            $financials = $this->calculator->calculate($ride);
            $ride->update(['payment_status' => 'pending', 'payment_method' => 'digital', 'payment_gateway' => $gateway]);

            return RidePayment::query()->create([
                'ride_request_id' => $ride->id,
                'user_id' => $ride->user_id,
                'delivery_man_id' => $ride->delivery_man_id,
                'amount' => $financials['final_payable_amount'],
                'payment_method' => 'digital',
                'payment_gateway' => $gateway,
                'status' => RidePayment::STATUS_PENDING,
            ]);
        });

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

        return ['payment' => $payment->fresh(), 'redirect_link' => (string) $link];
    }

    public function settle(int $paymentId, ?string $gateway = null, ?string $transactionReference = null): ?RideRequest
    {
        $result = DB::transaction(function () use ($paymentId, $gateway, $transactionReference) {
            $payment = RidePayment::query()->lockForUpdate()->find($paymentId);
            if (! $payment) {
                return null;
            }
            $ride = RideRequest::query()->lockForUpdate()->findOrFail($payment->ride_request_id);
            if ($ride->settled_at) {
                return ['ride' => $ride->fresh(['user', 'deliveryMan', 'rideVehicle', 'category']), 'newly_settled' => false];
            }
            $this->assertPayable($ride);
            $financials = $this->calculator->calculate($ride);
            if (round((float) $payment->amount, 2) !== $financials['final_payable_amount']) {
                throw new RuntimeException('The ride payment amount no longer matches the payable amount.');
            }

            $method = $payment->payment_method;
            $reference = 'ride:'.$ride->id;
            $wallet = DeliveryManWallet::query()->firstOrCreate(['delivery_man_id' => $ride->delivery_man_id]);
            $wallet = DeliveryManWallet::query()->whereKey($wallet->id)->lockForUpdate()->firstOrFail();
            $wallet->total_earning += $financials['captain_total_earning_amount'];
            if ($method === 'cash') {
                $wallet->collected_cash += $financials['final_payable_amount'];
            }
            $wallet->save();

            $grossCaptainBase = round($financials['captain_total_earning_amount'] + $financials['platform_commission_amount'], 2);
            $this->ledger($ride, DeliveryManWalletLedger::TYPE_RIDE_EARNING, $reference, $grossCaptainBase, DeliveryManWalletLedger::DIR_CREDIT, $financials);
            if ($financials['platform_commission_amount'] > 0) {
                $this->ledger($ride, DeliveryManWalletLedger::TYPE_RIDE_PLATFORM_COMMISSION, $reference, $financials['platform_commission_amount'], DeliveryManWalletLedger::DIR_DEBIT, $financials);
            }
            if ($method === 'cash') {
                $this->ledger($ride, DeliveryManWalletLedger::TYPE_RIDE_CASH_COLLECTION, $reference, $financials['final_payable_amount'], DeliveryManWalletLedger::DIR_DEBIT, $financials);
            }

            $admin = Admin::query()->where('role_id', 1)->first();
            if ($admin) {
                $adminWallet = AdminWallet::query()->firstOrCreate(['admin_id' => $admin->id]);
                $adminWallet = AdminWallet::query()->whereKey($adminWallet->id)->lockForUpdate()->firstOrFail();
                $adminWallet->total_commission_earning += $financials['platform_commission_amount'];
                if ($method === 'digital') {
                    $adminWallet->digital_received += $financials['final_payable_amount'];
                }
                $adminWallet->save();
            }

            $payment->update([
                'status' => RidePayment::STATUS_PAID,
                'payment_gateway' => $gateway ?: $payment->payment_gateway,
                'transaction_reference' => $transactionReference,
                'paid_at' => now(),
            ]);
            $ride->update([
                ...$financials,
                'payment_status' => 'paid',
                'payment_method' => $method,
                'payment_gateway' => $gateway ?: $payment->payment_gateway,
                'payment_transaction_reference' => $transactionReference,
                'receipt_number' => 'ZQR-R-'.str_pad((string) $ride->id, 7, '0', STR_PAD_LEFT),
                'paid_at' => now(),
                'settled_at' => now(),
            ]);

            return ['ride' => $ride->fresh(['user', 'deliveryMan', 'rideVehicle', 'category']), 'newly_settled' => true];
        });

        if (! $result) {
            return null;
        }
        if ($result['newly_settled']) {
            $this->notificationService->customer($result['ride'], 'Ride payment received', 'Your ride payment was confirmed and the receipt is ready.');
            $this->notificationService->captain($result['ride'], 'Ride earning posted', 'Your ride earning has been added to your wallet.');
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
                $ride->update(['payment_status' => 'unpaid']);
            }

            return $ride;
        });
        if ($ride) {
            $this->realtimeService->payment($ride);
        }
    }

    private function assertPayable(RideRequest $ride): void
    {
        $payable = $ride->status === RideRequest::STATUS_COMPLETED
            || ($ride->status === RideRequest::STATUS_CANCELLED && $ride->cancellation_charge_amount > 0);
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
