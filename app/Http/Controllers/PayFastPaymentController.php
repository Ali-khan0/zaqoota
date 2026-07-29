<?php

namespace App\Http\Controllers;

use App\Library\OrderPlace;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Traits\Processor;
use Illuminate\Contracts\Foundation\Application;
use App\Models\PaymentRequest;

class PayFastPaymentController extends Controller
{
    use Processor;

    private $merchant_id;
    private $merchant_key;
    private $passphrase;
    private $base_url;
    private PaymentRequest $payment;
    private $user;

    public function __construct(PaymentRequest $payment, User $user)
    {
        $config = $this->payment_config('payfast', 'payment_config');
        if (!is_null($config) && $config->mode == 'live') {
            $values = json_decode($config->live_values);
        } elseif (!is_null($config) && $config->mode == 'test') {
            $values = json_decode($config->test_values);
        }

        if ($config) {
            $this->merchant_id = $values->merchant_id;
            $this->merchant_key = $values->merchant_key;
            $this->passphrase = $values->passphrase ?? '';

            # PayFast URLs
            $this->base_url = ($config->mode == 'live') 
                ? 'https://www.payfast.co.za/eng/process' 
                : 'https://sandbox.payfast.co.za/eng/process';
        }
        $this->payment = $payment;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required|uuid'
        ]);

        if ($validator->fails()) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_400, null, $this->error_processor($validator)), 400);
        }

        $data = $this->payment::where(['id' => $request['payment_id']])->where(['is_paid' => 0])->first();
        if (!isset($data)) {
            return response()->json($this->response_formatter(GATEWAYS_DEFAULT_204), 200);
        }

        $payment_amount = $data['payment_amount'];
        $payer_information = json_decode($data['payer_information']);

        // PayFast requires amount in ZAR (South African Rand) or the currency specified
        // For Pakistani banks, you may need to convert PKR to ZAR or use PayFast's multi-currency support
        $amount = round($payment_amount, 2);

        // Build PayFast data array
        $data_array = array(
            // Merchant details
            'merchant_id' => $this->merchant_id,
            'merchant_key' => $this->merchant_key,
            'return_url' => url('/') . '/payment/payfast/success?payment_id=' . $data['id'],
            'cancel_url' => url('/') . '/payment/payfast/cancel?payment_id=' . $data['id'],
            'notify_url' => url('/') . '/payment/payfast/notify?payment_id=' . $data['id'],
            
            // Buyer details
            'name_first' => $this->getFirstName($payer_information->name ?? 'Customer'),
            'name_last' => $this->getLastName($payer_information->name ?? ''),
            'email_address' => $payer_information->email && $payer_information->email != '' ? $payer_information->email : 'example@example.com',
            'cell_number' => $payer_information->phone ?? '',
            
            // Transaction details
            'm_payment_id' => $data['id'],
            'amount' => number_format($amount, 2, '.', ''),
            'item_name' => 'Payment for Order #' . ($data['order_id'] ?? 'N/A'),
        );

        // Generate signature
        $pfParamString = '';
        foreach ($data_array as $key => $val) {
            if ($val !== '') {
                $pfParamString .= $key . '=' . urlencode($val) . '&';
            }
        }
        $pfParamString = substr($pfParamString, 0, -1);
        
        if (!empty($this->passphrase)) {
            $pfParamString .= '&passphrase=' . urlencode($this->passphrase);
        }
        
        $data_array['signature'] = md5($pfParamString);

        $base_url = $this->base_url;

        return view('payment-views.payfast', compact('data', 'data_array', 'base_url'));
    }

    # FUNCTION TO CHECK SIGNATURE
    protected function PayFast_signature_verify($data, $passphrase = '')
    {
        $pfParamString = '';
        $pfData = $data;
        
        // Remove signature from data
        unset($pfData['signature']);
        
        // Sort the data
        ksort($pfData);
        
        foreach ($pfData as $key => $val) {
            if ($val !== '') {
                $pfParamString .= $key . '=' . urlencode($val) . '&';
            }
        }
        $pfParamString = substr($pfParamString, 0, -1);
        
        if (!empty($passphrase)) {
            $pfParamString .= '&passphrase=' . urlencode($passphrase);
        }
        
        $calculatedSignature = md5($pfParamString);
        
        return ($calculatedSignature == $data['signature']);
    }

    public function success(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        if ($this->PayFast_signature_verify($request->all(), $this->passphrase)) {
            $this->payment::where(['id' => $request['payment_id']])->update([
                'payment_method' => 'payfast',
                'is_paid' => 1,
                'transaction_id' => $request->input('pf_payment_id') ?? $request->input('m_payment_id')
            ]);

            $data = $this->payment::where(['id' => $request['payment_id']])->first();

            if (isset($data) && function_exists($data->success_hook)) {
                call_user_func($data->success_hook, $data);
            }
            return $this->payment_response($data, 'success');
        }
        $payment_data = $this->payment::where(['id' => $request['payment_id']])->first();
        if (isset($payment_data) && function_exists($payment_data->failure_hook)) {
            call_user_func($payment_data->failure_hook, $payment_data);
        }
        return $this->payment_response($payment_data, 'fail');
    }

    public function notify(Request $request): JsonResponse
    {
        // PayFast ITN (Instant Transaction Notification) handler
        if ($this->PayFast_signature_verify($request->all(), $this->passphrase)) {
            $payment_status = $request->input('payment_status');
            
            if ($payment_status == 'COMPLETE') {
                $this->payment::where(['id' => $request['payment_id']])->update([
                    'payment_method' => 'payfast',
                    'is_paid' => 1,
                    'transaction_id' => $request->input('pf_payment_id') ?? $request->input('m_payment_id')
                ]);

                $data = $this->payment::where(['id' => $request['payment_id']])->first();

                if (isset($data) && function_exists($data->success_hook)) {
                    call_user_func($data->success_hook, $data);
                }
            }
            
            return response()->json(['status' => 'OK']);
        }
        
        return response()->json(['status' => 'FAILED'], 400);
    }

    public function cancel(Request $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        $payment_data = $this->payment::where(['id' => $request['payment_id']])->first();
        if (isset($payment_data) && function_exists($payment_data->failure_hook)) {
            call_user_func($payment_data->failure_hook, $payment_data);
        }
        return $this->payment_response($payment_data, 'cancel');
    }

    private function getFirstName($name)
    {
        $nameParts = explode(' ', trim($name));
        return $nameParts[0] ?? 'Customer';
    }

    private function getLastName($name)
    {
        $nameParts = explode(' ', trim($name));
        if (count($nameParts) > 1) {
            return implode(' ', array_slice($nameParts, 1));
        }
        return '';
    }
}
