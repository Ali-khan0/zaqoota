@php($buttonFieldsVisible = (bool) ($data?->button_enabled ?? false))
<div class="js-email-button-fields" style="{{ $buttonFieldsVisible ? '' : 'display:none;' }}">
    <h5 class="card-title mb-3">
        <img src="{{ asset('public/assets/admin/img/pointer.png') }}" class="mr-2" alt="">
        {{ translate('Button Content') }}
    </h5>
    <div class="__bg-F8F9FC-card">
        <div class="row g-3">
            <div class="col-sm-6">
                @if ($language)
                    <div class="form-group m-0 lang_form default-form">
                        <label class="form-label text-capitalize">
                            {{ translate('Button Name') }} ({{ translate('messages.default') }})
                        </label>
                        <input type="text" data-id="mail-button" name="button_name[]"
                            placeholder="{{ translate('Ex: Order now') }}" class="form-control h--45px"
                            value="{{ $data?->getRawOriginal('button_name') }}">
                    </div>
                    @foreach (json_decode($language) as $lang)
                        @php($translatedButtonName = $data?->translations?->first(fn ($translation) => $translation->locale === $lang && $translation->key === 'button_name')?->value ?? '')
                        <div class="form-group m-0 d-none lang_form" id="{{ $lang }}-form1">
                            <label class="form-label text-capitalize">
                                {{ translate('Button Name') }} ({{ strtoupper($lang) }})
                            </label>
                            <input type="text" name="button_name[]" placeholder="{{ translate('Ex: Order now') }}"
                                class="form-control h--45px" value="{{ $translatedButtonName }}">
                        </div>
                    @endforeach
                @else
                    <div class="form-group m-0">
                        <label class="form-label text-capitalize">{{ translate('Button Name') }}</label>
                        <input type="text" data-id="mail-button" name="button_name[]"
                            placeholder="{{ translate('Ex: Order now') }}" class="form-control h--45px"
                            value="{{ $data?->getRawOriginal('button_name') }}">
                    </div>
                @endif
            </div>
            <div class="col-sm-6">
                <div class="form-group m-0">
                    <label class="form-label">{{ translate('Redirect Link') }}</label>
                    <input type="url" name="button_url" placeholder="https://example.com" class="form-control h--45px"
                        value="{{ $data?->button_url ?? '' }}">
                </div>
            </div>
        </div>
    </div>
</div>
<br class="js-email-button-fields" style="{{ $buttonFieldsVisible ? '' : 'display:none;' }}">
