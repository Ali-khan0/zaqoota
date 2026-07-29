<?php

namespace App\Http\Controllers;

use App\Models\BusinessSetting;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\Processor;

/**
 * AssanPay "Redirectional/Cashier" integration per official manual:
 * POST {base}/payment-request/{merchantId} then redirect user to data.completeLink.
 * Status: GET {base}/payment/all-inquiry/{merchantId}?transactionId={order_id}
 *
 * @see https://docs.assanpay.com/documentation#introduction
 */
class AssanPayController extends Controller
{
    use Processor;

    private const DEFAULT_API_BASE = 'https://api.assanpay.com';

    private mixed $config_values;

    public function __construct(private PaymentRequest $payment, private User $user)
    {
        $config = $this->payment_config('assan_pay', 'payment_config');
        if (!is_null($config) && $config->mode == 'live') {
            $this->config_values = json_decode($config->live_values);
        } elseif (!is_null($config) && $config->mode == 'test') {
            $this->config_values = json_decode($config->test_values);
        } else {
            $this->config_values = null;
        }
    }

    public function index(Request $request): View|Factory|JsonResponse|Application|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_400, null, $this->error_processor($validator)), 400);
        }

        $payment_data = $this->payment::where(['id' => $request['payment_id']])->where(['is_paid' => 0])->first();
        if (!isset($payment_data)) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_204), 200);
        }

        $config = $this->config_values;
        $merchantPathId = $this->merchantPortalId($config);
        $apiKey = $this->dashboardApiKey($config);

        if (!$config || $merchantPathId === '' || $apiKey === '') {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_204), 200);
        }

        $base = $this->apiBaseUrl($config);
        $storeName = (string) (BusinessSetting::where('key', 'business_name')->first()?->value ?? 'Store');
        $link = route('assan-pay.callback', ['payment_id' => $payment_data->id], absolute: true);

        $url = rtrim($base, '/') . '/payment-request/' . rawurlencode($merchantPathId);
        $http = $this->httpWithAssanAuth($config);

        $primaryOrderId = $this->buildAssanPayOrderId($payment_data, 0);
        $completeLink = null;
        $lastError = null;
        $gatewayTxnId = null;
        $usedOrderId = $primaryOrderId;

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $orderId = $attempt === 0 ? $primaryOrderId : substr(bin2hex(random_bytes(10)), 0, 20);
            $payload = [
                'amount' => number_format((float) $payment_data->payment_amount, 2, '.', ''),
                'order_id' => $orderId,
                'store_name' => $storeName,
                'link' => $link,
            ];

            $response = $http->post($url, $payload);
            $json = $response->json() ?? [];
            $completeLink = data_get($json, 'data.completeLink');
            $gatewayTxnId = data_get($json, 'data.transactionId');

            if ($response->successful() && is_string($completeLink) && $completeLink !== '') {
                $usedOrderId = $orderId;
                break;
            }

            $message = strtolower((string) data_get($json, 'message', ''));
            $lastError = data_get($json, 'message') ?? $response->body();

            if ($response->successful() && str_contains($message, 'already exists')) {
                continue;
            }

            break;
        }

        if (!is_string($completeLink) || $completeLink === '') {
            return view('payment-views.assan-pay', [
                'errorMessage' => is_string($lastError) ? $lastError : __('Could not start AssanPay payment. Check API base URL, Merchant ID, and API key.'),
            ]);
        }

        session([
            'assan_pay_payment_id' => $payment_data->id,
            'assan_pay_order_id' => $usedOrderId,
            'assan_pay_gateway_txn' => $gatewayTxnId,
        ]);

        return redirect()->away($completeLink);
    }

    public function callback(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        if (!is_object($this->config_values)) {
            return redirect()->route('payment-fail');
        }

        $paymentId = $request->query('payment_id');
        if (!is_string($paymentId) || !Str::isUuid($paymentId)) {
            $paymentId = session('assan_pay_payment_id');
        }

        $payment_data = $paymentId ? $this->payment::where(['id' => $paymentId])->first() : null;
        if (!isset($payment_data)) {
            return redirect()->route('payment-fail');
        }

        $orderId = (string) (session('assan_pay_order_id') ?? '');
        if ($orderId === '') {
            if (isset($payment_data) && function_exists($payment_data->failure_hook)) {
                call_user_func($payment_data->failure_hook, $payment_data);
            }

            return $this->payment_response($payment_data, 'fail');
        }

        $merchantPathId = $this->merchantPortalId($this->config_values);
        $status = $this->fetchInquiryTransactionStatus($merchantPathId, $orderId);
        $paid = $this->isSuccessfulInquiryStatus($status);

        $gatewayTxn = session('assan_pay_gateway_txn');
        session()->forget(['assan_pay_payment_id', 'assan_pay_order_id', 'assan_pay_gateway_txn']);

        if (!$paid) {
            if (isset($payment_data) && function_exists($payment_data->failure_hook)) {
                call_user_func($payment_data->failure_hook, $payment_data);
            }

            return $this->payment_response($payment_data, 'fail');
        }

        $txnId = (string) ($gatewayTxn
            ?? $request->input('transactionId')
            ?? $request->input('transaction_id')
            ?? '');

        $this->payment::where(['id' => $payment_data->id])->update([
            'payment_method' => 'assan_pay',
            'is_paid' => 1,
            'transaction_id' => $txnId !== '' ? $txnId : $orderId,
        ]);
        $data = $this->payment::where(['id' => $payment_data->id])->first();
        if (isset($data) && function_exists($data->success_hook)) {
            call_user_func($data->success_hook, $data);
        }

        return $this->payment_response($data, 'success');
    }

    private function httpWithAssanAuth(mixed $config): \Illuminate\Http\Client\PendingRequest
    {
        $apiKey = $this->dashboardApiKey($config);
        $http = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withToken($apiKey)->timeout(45);

        $dec = $this->decryptionKey($config);
        if ($dec !== '') {
            $http = $http->withHeaders(['X-Decryption-Key' => $dec]);
        }

        return $http;
    }

    private function apiBaseUrl(mixed $config): string
    {
        if (!is_object($config)) {
            return self::DEFAULT_API_BASE;
        }

        $u = trim((string) ($config->checkout_url ?? ''));
        if ($u === '') {
            return self::DEFAULT_API_BASE;
        }

        return rtrim($u, '/');
    }

    /**
     * Merchant ID used in URL path (/payment-request/{merchantId}) — from Merchant Portal Dashboard.
     */
    private function merchantPortalId(mixed $config): string
    {
        if (!is_object($config)) {
            return '';
        }

        return trim((string) ($config->merchant_id ?? ''));
    }

    /**
     * API key from dashboard (sent as Bearer token; adjust if AssanPay specifies another header).
     */
    private function dashboardApiKey(mixed $config): string
    {
        if (!is_object($config)) {
            return '';
        }

        return trim((string) ($config->api_key ?? ''));
    }

    private function decryptionKey(mixed $config): string
    {
        if (!is_object($config)) {
            return '';
        }

        return trim((string) ($config->decryption_key ?? $config->secret_key ?? ''));
    }

    /**
     * order_id: max 20 chars, alphanumeric only (manual: no special characters).
     */
    private function buildAssanPayOrderId(PaymentRequest $payment, int $salt): string
    {
        $raw = hash('sha256', $payment->id . '|' . ($payment->updated_at?->timestamp ?? '') . '|' . $salt);

        return substr(preg_replace('/[^a-zA-Z0-9]/', '', $raw), 0, 20);
    }

    private function fetchInquiryTransactionStatus(string $merchantPathId, string $orderId): ?string
    {
        $base = $this->apiBaseUrl($this->config_values);
        $url = rtrim($base, '/') . '/payment/all-inquiry/' . rawurlencode($merchantPathId)
            . '?transactionId=' . rawurlencode($orderId);

        $response = $this->httpWithAssanAuth($this->config_values)->get($url);
        if (!$response->successful()) {
            return null;
        }

        $json = $response->json();

        return data_get($json, 'data.transactionStaus')
            ?? data_get($json, 'data.transactionStatus');
    }

    private function isSuccessfulInquiryStatus(?string $status): bool
    {
        if ($status === null || $status === '') {
            return false;
        }

        $s = strtolower(trim($status));
        if ($s === 'pending' || str_starts_with($s, 'pending')) {
            return false;
        }

        return in_array($s, [
            'success',
            'paid',
            'completed',
            'captured',
            'approved',
            'successful',
            'complete',
            'succeeded',
        ], true);
    }
}
