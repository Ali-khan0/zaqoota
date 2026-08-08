@extends('layouts.landing.app')

@section('title', translate('messages.Become Captain'))

@push('css_or_js')
<style>
    :root { --captain-teal: #0d988d; --captain-ink: #172b2a; --captain-line: #dce9e7; }
    .captain-page { background: #f5f8f8; padding: 48px 0 72px; }
    .captain-shell { max-width: 1240px; margin: 0 auto; display: grid; grid-template-columns: minmax(300px, 36%) minmax(0, 1fr); background: #fff; border: 1px solid var(--captain-line); border-radius: 8px; overflow: hidden; box-shadow: 0 18px 50px rgba(23, 43, 42, .08); }
    .captain-visual { position: relative; min-height: 100%; padding: 52px 42px; background: var(--captain-teal); color: #fff; display: flex; flex-direction: column; overflow: hidden; }
    .captain-brand { font-size: 26px; font-weight: 800; letter-spacing: 0; }
    .captain-visual h1 { margin: 60px 0 14px; color: #fff; font-size: 38px; line-height: 1.14; letter-spacing: 0; }
    .captain-visual p { color: rgba(255,255,255,.86); font-size: 16px; line-height: 1.7; }
    .captain-art { width: min(100%, 330px); margin: auto auto 0; filter: drop-shadow(0 16px 22px rgba(0,0,0,.15)); }
    .captain-mobile-head { display: none; background: var(--captain-teal); color: #fff; padding: 22px 20px; }
    .captain-mobile-head strong { display: block; font-size: 21px; }
    .captain-form { padding: 42px 46px 48px; min-width: 0; }
    .captain-form-header { margin-bottom: 34px; }
    .captain-form-header h2 { color: var(--captain-ink); font-size: 28px; margin-bottom: 7px; letter-spacing: 0; }
    .captain-form-header p { color: #6d807e; margin: 0; }
    .captain-section { padding: 0 0 30px; margin: 0 0 30px; border-bottom: 1px solid var(--captain-line); }
    .captain-section:last-of-type { border-bottom: 0; margin-bottom: 10px; }
    .captain-section-title { display: flex; align-items: center; gap: 10px; color: var(--captain-ink); font-size: 17px; margin-bottom: 20px; }
    .captain-step { width: 28px; height: 28px; flex: 0 0 28px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; color: #fff; background: var(--captain-teal); font-size: 13px; }
    .captain-form .form-control { min-height: 46px; border: 1px solid #cadbd8; border-radius: 5px; color: var(--captain-ink); }
    .captain-form .form-control:focus { border-color: var(--captain-teal); box-shadow: 0 0 0 3px rgba(13,152,141,.12); }
    .captain-form .input-label { color: #344b49; font-weight: 600; margin-bottom: 8px; }
    .captain-upload { position: relative; display: flex; min-height: 150px; align-items: center; justify-content: center; text-align: center; border: 2px dashed var(--captain-teal); border-radius: 6px; background: rgba(13,152,141,.035); overflow: hidden; cursor: pointer; transition: background .2s ease, border-color .2s ease; }
    .captain-upload:hover { background: rgba(13,152,141,.075); }
    .captain-upload input { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
    .captain-upload-content { padding: 18px; color: #58706d; }
    .captain-upload-icon { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; margin-bottom: 8px; border-radius: 50%; background: rgba(13,152,141,.12); color: var(--captain-teal); font-size: 22px; font-weight: 700; }
    .captain-upload-content strong { display: block; color: var(--captain-teal); font-size: 14px; }
    .captain-upload-content small { display: block; margin-top: 4px; color: #81928f; }
    .captain-upload-preview { position: absolute; inset: 8px; width: calc(100% - 16px); height: calc(100% - 16px); object-fit: cover; border-radius: 4px; display: none; }
    .captain-upload.has-preview .captain-upload-preview { display: block; }
    .captain-upload.has-preview .captain-upload-content { opacity: 0; }
    .captain-submit { width: 100%; min-height: 50px; border: 0; border-radius: 5px; background: var(--captain-teal); color: #fff; font-weight: 700; font-size: 16px; }
    .captain-submit:hover { background: #087d74; color: #fff; }
    .captain-required { color: #d94d4d; }
    .captain-captcha { display: flex; gap: 10px; align-items: stretch; }
    .captain-captcha > * { min-width: 0; flex: 1; }
    .captain-captcha img { width: 100%; height: 46px; object-fit: contain; border: 1px solid var(--captain-line); border-radius: 5px; background: #fff; }
    @media (max-width: 991px) {
        .captain-page { padding: 24px 12px 48px; }
        .captain-shell { display: block; max-width: 760px; }
        .captain-visual { display: none; }
        .captain-mobile-head { display: block; }
        .captain-form { padding: 30px 28px 38px; }
    }
    @media (max-width: 575px) {
        .captain-page { padding: 0 0 32px; }
        .captain-shell { border-width: 0 0 1px; border-radius: 0; box-shadow: none; }
        .captain-form { padding: 26px 18px 34px; }
        .captain-form-header h2 { font-size: 24px; }
        .captain-upload { min-height: 132px; }
        .captain-captcha { flex-direction: column; }
    }
</style>
@endpush

@section('content')
@php($recaptcha = \App\CentralLogics\Helpers::get_business_settings('recaptcha'))
<section class="captain-page">
    <div class="container-fluid px-0 px-lg-3">
        <div class="captain-shell">
            <aside class="captain-visual" aria-label="{{ translate('messages.Become Captain') }}">
                <div class="captain-brand">ZAQOOTA</div>
                <h1>{{ translate('messages.Move with purpose. Earn with Zaqoota.') }}</h1>
                <p>{{ translate('messages.Register once to deliver orders, carry parcels, and submit your vehicle for ride approval.') }}</p>
                <img class="captain-art" src="{{ asset('public/assets/admin/img/400x400/deliveryman-dirver.png') }}" alt="Zaqoota Captain">
            </aside>

            <div>
                <div class="captain-mobile-head">
                    <strong>ZAQOOTA</strong>
                    <span>{{ translate('messages.Become Captain') }}</span>
                </div>
                <form action="{{ route('captain.store') }}" method="post" enctype="multipart/form-data" id="form-id" class="captain-form">
                    @csrf
                    <header class="captain-form-header">
                        <h2>{{ translate('messages.Become Captain') }}</h2>
                        <p>{{ translate('messages.Complete your details and submit your vehicle for verification.') }}</p>
                    </header>

                    <section class="captain-section">
                        <h3 class="captain-section-title"><span class="captain-step">1</span>{{ translate('messages.Personal Information') }}</h3>
                        <div class="row g-3">
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.first_name') }} <span class="captain-required">*</span></label><input type="text" name="f_name" class="form-control" value="{{ old('f_name') }}" required></div>
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.last_name') }} <span class="captain-required">*</span></label><input type="text" name="l_name" class="form-control" value="{{ old('l_name') }}" required></div>
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.email') }} <span class="captain-required">*</span></label><input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="name@example.com" required></div>
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.zone') }} <span class="captain-required">*</span></label><select name="zone_id" class="form-control" required><option value="">{{ translate('messages.select_zone') }}</option>@foreach (\App\Models\Zone::active()->get() as $zone)<option value="{{ $zone->id }}" @selected(old('zone_id') == $zone->id)>{{ $zone->name }}</option>@endforeach</select></div>
                        </div>
                    </section>

                    <section class="captain-section">
                        <h3 class="captain-section-title"><span class="captain-step">2</span>{{ translate('messages.Vehicle Information') }}</h3>
                        <div class="row g-3">
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.Vehicle Type') }} <span class="captain-required">*</span></label><select name="ride_vehicle_type_id" id="ride_vehicle_type_id" class="form-control" required><option value="">{{ translate('messages.select_vehicle') }}</option>@foreach ($rideVehicleTypes as $type)<option value="{{ $type->id }}" @selected(old('ride_vehicle_type_id') == $type->id)>{{ $type->name }}</option>@endforeach</select></div>
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.Vehicle Category') }} <span class="captain-required">*</span></label><select name="ride_category_id" id="ride_category_id" class="form-control" required></select></div>
                            <div class="col-sm-4"><label class="input-label">{{ translate('messages.Fuel Type') }} <span class="captain-required">*</span></label><select name="fuel_type" id="fuel_type" class="form-control" required>@foreach (\App\Models\RideVehicle::FUEL_TYPES as $fuelType)<option value="{{ $fuelType }}" @selected(old('fuel_type') === $fuelType)>{{ ucfirst($fuelType) }}</option>@endforeach</select></div>
                            <div class="col-sm-4"><label class="input-label">{{ translate('messages.Vehicle Make') }} <span class="captain-required">*</span></label><input name="make" class="form-control" value="{{ old('make') }}" placeholder="Honda" required></div>
                            <div class="col-sm-4"><label class="input-label">{{ translate('messages.Vehicle Model') }} <span class="captain-required">*</span></label><input name="model" class="form-control" value="{{ old('model') }}" placeholder="CD 70" required></div>
                            <div class="col-sm-4"><label class="input-label">{{ translate('messages.Model Year') }}</label><input type="number" name="model_year" min="1980" max="{{ now()->year + 1 }}" class="form-control" value="{{ old('model_year') }}"></div>
                            <div class="col-sm-4"><label class="input-label">{{ translate('messages.Vehicle Color') }} <span class="captain-required">*</span></label><input name="color" class="form-control" value="{{ old('color') }}" required></div>
                            <div class="col-sm-4"><label class="input-label">{{ translate('messages.Registration Number') }} <span class="captain-required">*</span></label><input name="registration_number" class="form-control text-uppercase" value="{{ old('registration_number') }}" required></div>
                        </div>
                    </section>

                    <section class="captain-section">
                        <h3 class="captain-section-title"><span class="captain-step">3</span>{{ translate('messages.Verification Photos') }}</h3>
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.identity_type') }} <span class="captain-required">*</span></label><select name="identity_type" class="form-control" required><option value="nid" @selected(old('identity_type') === 'nid')>{{ translate('messages.CNIC') }}</option><option value="passport" @selected(old('identity_type') === 'passport')>{{ translate('messages.passport') }}</option><option value="driving_license" @selected(old('identity_type') === 'driving_license')>{{ translate('messages.driving_license') }}</option></select></div>
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.identity_number') }} <span class="captain-required">*</span></label><input type="text" name="identity_number" class="form-control" value="{{ old('identity_number') }}" required></div>
                        </div>
                        <div class="row g-3">
                            @php($uploads = [
                                ['image', 'face_photo', translate('messages.Face Photo'), true],
                                ['identity_image[]', 'identity_front', translate('messages.Identity Document Front'), true],
                                ['identity_image[]', 'identity_back', translate('messages.Identity Document Back'), false],
                                ['vehicle_front_image', 'vehicle_front', translate('messages.Vehicle Front Photo'), true],
                                ['vehicle_back_image', 'vehicle_back', translate('messages.Vehicle Back Photo'), true],
                            ])
                            @foreach ($uploads as [$field, $id, $label, $required])
                                <div class="{{ $id === 'face_photo' ? 'col-12' : 'col-sm-6' }}">
                                    <label class="input-label" for="{{ $id }}">{{ $label }} @if($required)<span class="captain-required">*</span>@else<small class="text-muted">({{ translate('messages.Optional') }})</small>@endif</label>
                                    <label class="captain-upload" for="{{ $id }}">
                                        <input type="file" name="{{ $field }}" id="{{ $id }}" accept="image/jpeg,image/png,image/webp" data-image-preview {{ $required ? 'required' : '' }}>
                                        <img class="captain-upload-preview" alt="{{ $label }} preview">
                                        <span class="captain-upload-content"><span class="captain-upload-icon">+</span><strong>{{ translate('messages.Choose a photo') }}</strong><small>JPG, PNG or WebP · 5 MB max</small></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="captain-section">
                        <h3 class="captain-section-title"><span class="captain-step">4</span>{{ translate('messages.Account Security') }}</h3>
                        <div class="row g-3">
                            <div class="col-sm-6"><label class="input-label" for="phone">{{ translate('messages.phone') }} <span class="captain-required">*</span></label><input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="+92 300 0000000" required></div>
                            <div class="col-sm-6"><label class="input-label">{{ translate('messages.password') }} <span class="captain-required">*</span></label><input type="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required></div>
                            <div class="col-12">
                                @if(isset($recaptcha) && $recaptcha['status'] == 1)
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                @else
                                    <label class="input-label">{{ translate('messages.Security Check') }} <span class="captain-required">*</span></label>
                                    <div class="captain-captcha"><input type="text" class="form-control" name="custome_recaptcha" id="custome_recaptcha" required autocomplete="off" value="{{ env('APP_DEBUG') ? session('six_captcha') : '' }}"><div><img src="<?php echo $custome_recaptcha->inline(); ?>" alt="Captcha"></div></div>
                                @endif
                            </div>
                        </div>
                    </section>

                    <button type="submit" class="captain-submit" id="signInBtn">{{ translate('messages.Submit Captain Application') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script_2')
<script>
    "use strict";
    const rideVehicleTypes = @json($rideVehicleTypes);
    const oldRideCategoryId = @json(old('ride_category_id'));

    function updateRideCategories() {
        const selectedType = rideVehicleTypes.find(type => String(type.id) === String($('#ride_vehicle_type_id').val()));
        const categorySelect = $('#ride_category_id');
        categorySelect.empty().append(new Option('{{ translate('messages.Select vehicle category') }}', ''));
        (selectedType?.categories || []).forEach(category => {
            const option = new Option(category.name, category.id, false, String(category.id) === String(oldRideCategoryId));
            option.dataset.fuelType = category.fuel_type || '';
            categorySelect.append(option);
        });
        categorySelect.trigger('change');
    }

    $('#ride_vehicle_type_id').on('change', updateRideCategories);
    $('#ride_category_id').on('change', function () {
        const fuelType = this.options[this.selectedIndex]?.dataset?.fuelType;
        if (fuelType) $('#fuel_type').val(fuelType);
    });
    updateRideCategories();

    document.querySelectorAll('[data-image-preview]').forEach(input => {
        input.addEventListener('change', function () {
            const file = this.files?.[0];
            const upload = this.closest('.captain-upload');
            const preview = upload.querySelector('.captain-upload-preview');
            if (!file) { upload.classList.remove('has-preview'); return; }
            const reader = new FileReader();
            reader.onload = event => { preview.src = event.target.result; upload.classList.add('has-preview'); };
            reader.readAsDataURL(file);
        });
    });
</script>

@if(isset($recaptcha) && $recaptcha['status'] == 1)
<script src="https://www.google.com/recaptcha/api.js?render={{ $recaptcha['site_key'] }}"></script>
<script>
    $('#signInBtn').on('click', function (event) {
        event.preventDefault();
        const form = document.getElementById('form-id');
        if (!form.reportValidity()) return;
        if (typeof grecaptcha === 'undefined') { toastr.error('{{ translate('messages.Invalid recaptcha key') }}'); return; }
        grecaptcha.ready(function () {
            grecaptcha.execute('{{ $recaptcha['site_key'] }}', {action: 'submit'}).then(function (token) {
                $('#g-recaptcha-response').val(token);
                form.submit();
            });
        });
    });
</script>
@endif
@endpush
