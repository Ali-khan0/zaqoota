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
@endphp
<html lang="{{ $lang }}" dir="{{ $siteDirection }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? translate('Email_Template') }}</title>
</head>
<body style="margin:0;padding:20px;background:#f3f6f8;color:#46556d;font-family:Arial,sans-serif;font-size:14px;line-height:1.55;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:560px;background:#ffffff;border:1px solid #dce4e8;">
                <tr>
                    <td style="padding:22px 32px;background:#149b94;color:#ffffff;text-align:center;font-size:21px;font-weight:700;letter-spacing:0;">
                        {{ strtoupper($company_name) }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:30px 32px;">
                        @if ($data?->icon)
                            <div style="margin-bottom:18px;text-align:center;">
                                <img src="{{ $data->icon_full_url }}" alt="" style="display:inline-block;max-width:64px;max-height:64px;border:0;">
                            </div>
                        @endif

                        <h1 style="margin:0 0 14px;color:#222222;font-size:19px;line-height:1.35;font-weight:700;letter-spacing:0;">
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
                                <a href="{{ $actionUrl }}" style="display:inline-block;padding:12px 20px;background:#149b94;color:#ffffff;text-decoration:none;font-weight:700;border-radius:4px;">{{ $buttonName }}</a>
                            </div>
                        @endif

                        <div style="margin-top:26px;padding-top:20px;border-top:1px solid #d7e2e7;color:#65758d;">
                            <div>{{ $footer_text ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.') }}</div>
                            <div style="margin-top:12px;">{{ translate('Thanks_&_Regards') }},<br>{{ $company_name }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:18px 32px;background:#f7fafb;color:#748196;text-align:center;font-size:12px;">
                        <div>{{ $copyright_text ?? '' }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
