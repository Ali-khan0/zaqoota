@php($previewButtonEnabled = (bool) ($data?->button_enabled ?? false))
<table role="presentation" style="width:100%;max-width:520px;margin:0 auto;border:1px solid #dce4e8;background:#fff;color:#46556d;font-family:Arial,sans-serif;">
    <tr>
        <td style="padding:20px 28px;background:#149b94;color:#fff;text-align:center;font-size:20px;font-weight:700;">
            {{ strtoupper(\App\Models\BusinessSetting::where('key', 'business_name')->first()?->value ?? 'ZAQOOTA') }}
        </td>
    </tr>
    <tr>
        <td style="padding:28px 30px;text-align:start;">
            @if ($data?->icon)
                <div style="margin-bottom:16px;text-align:center;">
                    <img id="iconViewer" src="{{ $data->icon_full_url }}" alt="" style="max-width:64px;max-height:64px;">
                </div>
            @endif
            <h2 id="mail-title" style="margin:0 0 14px;color:#222;font-size:19px;">{{ $data?->title ?? translate('Main_Title_or_Subject_of_the_Mail') }}</h2>
            <div id="mail-body" style="margin-bottom:18px;">{!! $data?->body ?? translate('Mail Body Message') !!}</div>
            @if ($data?->image)
                <img id="bannerViewer" src="{{ $data->image_full_url }}" alt="" style="display:block;width:100%;height:auto;margin:18px 0;">
            @endif
            @if ($previewButtonEnabled)
                <div id="action-button-preview" style="margin:22px 0;">
                    <span id="mail-button" style="display:inline-block;padding:11px 18px;background:#149b94;color:#fff;font-weight:700;border-radius:4px;">{{ $data?->button_name ?: translate('View_details') }}</span>
                </div>
            @endif
            <div style="margin-top:24px;padding-top:18px;border-top:1px solid #d7e2e7;color:#65758d;">
                <div id="mail-footer">{{ $data?->footer_text ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.') }}</div>
            </div>
        </td>
    </tr>
    <tr>
        <td id="mail-copyright" style="padding:16px 30px;background:#f7fafb;color:#748196;text-align:center;font-size:12px;">
            {{ $data?->copyright_text ?? '' }}
        </td>
    </tr>
</table>
