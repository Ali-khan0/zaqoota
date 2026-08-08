<!DOCTYPE html>
@php
    $lang = \App\CentralLogics\Helpers::system_default_language();
    $siteDirection = \App\CentralLogics\Helpers::system_default_direction();
    $buttonEnabled = (bool) ($data?->button_enabled ?? false);
    $dynamicUrl = isset($url) && is_string($url) ? trim($url) : '';
    $configuredUrl = trim((string) ($data?->button_url ?? ''));
    $candidateUrl = $dynamicUrl !== '' ? $dynamicUrl : $configuredUrl;
    $actionUrl = filter_var($candidateUrl, FILTER_VALIDATE_URL) ? $candidateUrl : '';
    $buttonName = trim((string) ($data?->button_name ?? '')) ?: translate('View_details');
    $landingData = \App\Models\DataSetting::where('type', 'admin_landing_page')
        ->whereIn('key', ['shipping_policy_status', 'refund_policy_status', 'cancellation_policy_status'])
        ->pluck('value', 'key')
        ->toArray();
    $socialMedia = \App\Models\SocialMedia::active()->get();
@endphp
<html lang="{{ $lang }}" dir="{{ $siteDirection }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? translate('Email_Template') }}</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;color:#4a5568;font-family:Verdana,Geneva,sans-serif;font-size:14px;line-height:1.6;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td align="center" style="padding:30px 15px;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px;background:#ffffff;border:1px solid rgba(13,152,141,0.16);border-radius:4px;box-shadow:0 3px 10px rgba(24,45,58,0.06);">
                <tr>
                    <td style="padding:25px 40px;background:#0d988d;color:#ffffff;text-align:center;border-radius:3px 3px 0 0;">
                        <strong style="display:inline-block;color:#ffffff;font-family:Verdana,Geneva,sans-serif;font-size:26px;line-height:1.2;font-weight:700;letter-spacing:0;">ZAQOOTA</strong>
                    </td>
                </tr>
                <tr>
                    <td style="padding:40px;">
                        <h1 style="margin:0 0 20px;color:#111111;font-size:20px;line-height:1.4;font-weight:600;letter-spacing:0;">
                            {{ $title ?? translate('Main_Title_or_Subject_of_the_Mail') }}
                        </h1>
                        <div style="margin:0 0 18px;color:#46556d;">{!! $body ?? '' !!}</div>

                        @if ($data?->image)
                            <div style="margin:20px 0;">
                                <img src="{{ $data->image_full_url }}" alt="" style="display:block;width:100%;height:auto;border:0;">
                            </div>
                        @endif

                        @isset($code)
                            <div style="margin:20px 0;padding:16px;border:1px solid #d7e2e7;background:#f7fafb;color:#222222;text-align:center;font-size:26px;font-weight:700;letter-spacing:4px;">
                                {{ $code }}
                            </div>
                        @endisset

                        @if (isset($email) || isset($password))
                            <div style="margin:20px 0;padding:16px;border:1px solid #d7e2e7;background:#f7fafb;">
                                <div style="margin-bottom:10px;color:#222222;font-weight:700;">{{ translate('Your_account_credential:') }}</div>
                                @isset($email)<div><strong>{{ translate('messages.Email') }}:</strong> {{ $email }}</div>@endisset
                                @isset($password)<div><strong>{{ translate('messages.Password') }}:</strong> {{ $password }}</div>@endisset
                            </div>
                        @endif

                        @if (isset($transaction_id, $time, $amount))
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:20px 0;border:1px solid #d7e2e7;">
                                <tr style="background:#f1f7f7;color:#222222;font-weight:700;">
                                    <td style="padding:10px;border-bottom:1px solid #d7e2e7;">{{ translate('messages.transaction_id') }}</td>
                                    <td style="padding:10px;border-bottom:1px solid #d7e2e7;">{{ translate('messages.Time') }}</td>
                                    <td style="padding:10px;border-bottom:1px solid #d7e2e7;">{{ translate('messages.amount') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;">{{ $transaction_id }}</td>
                                    <td style="padding:10px;">{{ $time }}</td>
                                    <td style="padding:10px;">{{ \App\CentralLogics\Helpers::format_currency($amount) }}</td>
                                </tr>
                            </table>
                        @endif

                        @isset($order)
                            <div style="margin:20px 0;padding:16px;border:1px solid #d7e2e7;background:#f7fafb;">
                                <div style="margin-bottom:8px;color:#222222;font-weight:700;">{{ translate('Order_Info') }}</div>
                                <div><strong>{{ translate('Order') }}:</strong> #{{ $order->id }}</div>
                                <div><strong>{{ translate('messages.Date') }}:</strong> {{ $order->created_at }}</div>
                                @if (isset($order->order_amount))
                                    <div><strong>{{ translate('messages.amount') }}:</strong> {{ \App\CentralLogics\Helpers::format_currency($order->order_amount) }}</div>
                                @endif
                            </div>
                        @endisset

                        @isset($body_2)
                            <div style="margin:18px 0;">{!! $body_2 !!}</div>
                        @endisset

                        @if ($buttonEnabled && $actionUrl !== '')
                            <div style="margin:24px 0;">
                                <a href="{{ $actionUrl }}" style="display:inline-block;padding:13px 25px;background:#0d988d;color:#ffffff;text-decoration:none;font-size:15px;font-weight:600;border-radius:6px;">{{ $buttonName }}</a>
                            </div>
                        @endif

                        <div style="margin-top:30px;padding-top:22px;border-top:1px solid #e2e8f0;color:#718096;">
                            <div>{{ $footer_text ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.') }}</div>
                            <div style="margin-top:12px;">{{ translate('Thanks_&_Regards') }},<br>{{ $company_name }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 40px;background:#f8fafc;color:#a0aec0;text-align:center;font-size:12px;border-top:1px solid rgba(13,152,141,0.12);border-radius:0 0 3px 3px;">
                        <div style="margin-bottom:10px;">
                            @if ($data?->privacy)
                                <a href="{{ route('privacy-policy') }}" style="margin:0 7px;color:#718096;text-decoration:none;">{{ translate('Privacy_Policy') }}</a>
                            @endif
                            @if ($data?->refund && ($landingData['refund_policy_status'] ?? 0) == 1)
                                <a href="{{ route('refund') }}" style="margin:0 7px;color:#718096;text-decoration:none;">{{ translate('Refund_Policy') }}</a>
                            @endif
                            @if ($data?->cancelation && ($landingData['cancellation_policy_status'] ?? 0) == 1)
                                <a href="{{ route('cancelation') }}" style="margin:0 7px;color:#718096;text-decoration:none;">{{ translate('Cancelation_Policy') }}</a>
                            @endif
                            @if ($data?->contact)
                                <a href="{{ route('contact-us') }}" style="margin:0 7px;color:#718096;text-decoration:none;">{{ translate('Contact_us') }}</a>
                            @endif
                        </div>
                        @if ($socialMedia->isNotEmpty())
                            <div style="margin-bottom:10px;">
                                @foreach ($socialMedia as $social)
                                    @if ($data?->{$social->name})
                                        <a href="{{ $social->link }}" style="margin:0 5px;text-decoration:none;">
                                            <img src="{{ asset('/public/assets/admin/img/img/'.$social->name.'.png') }}" alt="{{ $social->name }}" width="22" height="22" style="display:inline-block;border:0;">
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div>{{ $copyright_text ?? '' }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
