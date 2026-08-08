@php($previewButtonEnabled = (bool) ($data?->button_enabled ?? false))
@php($previewShowsOtp = in_array(($data?->type ?? '').':'.($data?->email_type ?? ''), ['user:registration_otp', 'user:login_otp', 'user:order_verification', 'user:forget_password', 'dm:forget_password'], true))
<table role="presentation" style="width:100%;max-width:600px;margin:0 auto;border:1px solid rgba(13,152,141,0.16);border-radius:4px;background:#fff;color:#4a5568;font-family:Verdana,Geneva,sans-serif;box-shadow:0 3px 10px rgba(24,45,58,0.06);">
    <tr>
        <td style="padding:25px 40px;background:#0d988d;color:#fff;text-align:center;border-radius:3px 3px 0 0;">
            <strong style="display:inline-block;color:#fff;font-family:Verdana,Geneva,sans-serif;font-size:26px;line-height:1.2;font-weight:700;letter-spacing:0;">ZAQOOTA</strong>
        </td>
    </tr>
    <tr>
        <td style="padding:40px;text-align:start;">
            <h2 id="mail-title" style="margin:0 0 14px;color:#222;font-size:19px;">{{ $data?->title ?? translate('Main_Title_or_Subject_of_the_Mail') }}</h2>
            <div id="mail-body" style="margin-bottom:18px;">{!! $data?->body ?? translate('Mail Body Message') !!}</div>
            @if ($previewShowsOtp)
                <div style="margin:20px 0;padding:16px;border:1px solid rgba(13,152,141,0.18);background:#f7fafb;color:#222;text-align:center;font-size:26px;font-weight:700;letter-spacing:4px;">
                    123456
                </div>
            @endif
            @if ($data?->image)
                <img id="bannerViewer" src="{{ $data->image_full_url }}" alt="" style="display:block;width:100%;height:auto;margin:18px 0;">
            @endif
            <div id="action-button-preview" style="margin:22px 0;{{ $previewButtonEnabled ? '' : 'display:none;' }}">
                <span id="mail-button" style="display:inline-block;padding:11px 18px;background:#149b94;color:#fff;font-weight:700;border-radius:4px;">{{ $data?->button_name ?: translate('View_details') }}</span>
            </div>
            <div style="margin-top:24px;padding-top:18px;border-top:1px solid #d7e2e7;color:#65758d;">
                <div id="mail-footer">{{ $data?->footer_text ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.') }}</div>
            </div>
        </td>
    </tr>
    <tr>
        <td style="padding:18px 30px;background:#f7fafb;color:#748196;text-align:center;font-size:12px;border-top:1px solid rgba(13,152,141,0.12);border-radius:0 0 3px 3px;">
            <div style="margin-bottom:10px;line-height:1.8;">
                <a href="#" id="privacy-check" style="margin:0 6px;color:#65758d;text-decoration:none;{{ ($data?->privacy ?? false) ? '' : 'display:none;' }}">{{ translate('Privacy_Policy') }}</a>
                <a href="#" id="refund-check" style="margin:0 6px;color:#65758d;text-decoration:none;{{ ($data?->refund ?? false) ? '' : 'display:none;' }}">{{ translate('Refund_Policy') }}</a>
                <a href="#" id="cancelation-check" style="margin:0 6px;color:#65758d;text-decoration:none;{{ ($data?->cancelation ?? false) ? '' : 'display:none;' }}">{{ translate('Cancelation_Policy') }}</a>
                <a href="#" id="contact-check" style="margin:0 6px;color:#65758d;text-decoration:none;{{ ($data?->contact ?? false) ? '' : 'display:none;' }}">{{ translate('Contact_us') }}</a>
            </div>
            <div class="email-template-social-span" style="margin-bottom:10px;line-height:1;">
                @foreach (['facebook', 'instagram', 'twitter', 'linkedin', 'pinterest'] as $socialName)
                    <a href="#" id="{{ $socialName }}-check" class="email-template-social-media" style="display:{{ ($data?->{$socialName} ?? false) ? 'inline-block' : 'none' }};margin:0 5px;text-decoration:none;">
                        <img src="{{ asset('/public/assets/admin/img/img/'.$socialName.'.png') }}" alt="{{ ucfirst($socialName) }}" width="22" height="22" style="display:block;border:0;">
                    </a>
                @endforeach
            </div>
            <div id="mail-copyright">{{ $data?->copyright_text ?? '' }}</div>
        </td>
    </tr>
</table>
