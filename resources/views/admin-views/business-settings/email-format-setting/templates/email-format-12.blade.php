@php($previewButtonEnabled = (bool) ($data?->button_enabled ?? false))
@php($previewLogo = \App\Models\BusinessSetting::where('key', 'logo')->first())
@php($previewLogoUrl = $previewLogo?->value ? \App\CentralLogics\Helpers::get_full_url('business', $previewLogo->value, $previewLogo?->storage[0]?->value ?? 'public', 'favicon') : '')
<table role="presentation" style="width:100%;max-width:600px;margin:0 auto;border:1px solid #e1e5ea;border-radius:8px;background:#fff;color:#4a5568;font-family:Verdana,Geneva,sans-serif;box-shadow:0 4px 6px rgba(0,0,0,0.02);">
    <tr>
        <td style="padding:25px 40px;background:#0d988d;color:#fff;text-align:center;border-radius:7px 7px 0 0;">
            @if ($previewLogoUrl !== '')
                <img src="{{ $previewLogoUrl }}" alt="Zaqoota" style="display:inline-block;max-width:170px;max-height:58px;width:auto;height:auto;filter:brightness(0) invert(1);">
            @else
                <strong style="font-size:26px;">ZAQOOTA</strong>
            @endif
        </td>
    </tr>
    <tr>
        <td style="padding:40px;text-align:start;">
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
