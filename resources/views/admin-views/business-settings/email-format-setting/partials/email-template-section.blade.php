
<input type="hidden" value="{{ $template }}" name="email_template">
<style>
    .email-format-wrapper div:has(> label.custom-file > #mail-icon) {
        display: none !important;
    }
</style>
@if (in_array(request()->route('type'), ['store', 'dm', 'user', 'admin'], true))
    <div class="__bg-F8F9FC-card mb-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5 class="mb-1">{{ translate('Action button') }}</h5>
                <p class="mb-0 text-muted">{{ translate('Show the action button only when this email has a valid destination link.') }}</p>
            </div>
            <label class="toggle-switch toggle-switch-sm mb-0">
                <input type="checkbox" name="button_enabled" value="1" class="toggle-switch-input js-email-button-toggle"
                    {{ ($data?->button_enabled ?? false) ? 'checked' : '' }}>
                <span class="toggle-switch-label text mb-0">
                    <span class="toggle-switch-indicator"></span>
                </span>
            </label>
        </div>
    </div>
@endif
