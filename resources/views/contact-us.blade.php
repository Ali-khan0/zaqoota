@extends('layouts.landing.app')

@section('title', translate('messages.contact_us'))

@section('content')
    @include('partials.public-page-styles')
    @php($contactTitle = \App\Models\DataSetting::where(['key' => 'contact_us_title'])->value('value'))
    @php($contactSubtitle = \App\Models\DataSetting::where(['key' => 'contact_us_sub_title'])->value('value'))
    @php($phone = \App\CentralLogics\Helpers::get_settings('phone'))
    @php($email = \App\CentralLogics\Helpers::get_settings('email_address'))
    @php($address = \App\CentralLogics\Helpers::get_settings('address'))
    @php($defaultLocation = \App\CentralLogics\Helpers::get_settings('default_location'))
    @php($recaptcha = \App\CentralLogics\Helpers::get_business_settings('recaptcha'))

    <main class="public-page">
        <div class="public-reader-bar">
            <div class="container public-reader-bar__inner">
                <a href="{{ route('home') }}" class="public-reader-bar__back"><span aria-hidden="true">&larr;</span> {{ translate('messages.Return to home page') }}</a>
            </div>
        </div>
        <header class="public-page__hero">
            <div class="container">
                <div class="public-page__eyebrow">{{ translate('messages.Zaqoota Support') }}</div>
                <h1 class="public-page__title">{{ $contactTitle ?: translate('messages.Contact_Us') }}</h1>
                <p class="public-page__subtitle">{{ $contactSubtitle ?: translate('messages.We are here to help with your questions and feedback.') }}</p>
            </div>
        </header>

        <div class="container public-page__body">
            <div class="contact-page__grid">
                <aside class="contact-panel contact-panel--details">
                    <h2>{{ translate('messages.Contact information') }}</h2>
                    <p class="contact-panel__intro">{{ translate('messages.Reach the Zaqoota team using the details below.') }}</p>
                    <div class="contact-detail">
                        <span class="contact-detail__label">{{ translate('messages.Email') }}</span>
                        <a href="mailto:{{ $email }}">{{ $email }}</a>
                    </div>
                    <div class="contact-detail">
                        <span class="contact-detail__label">{{ translate('messages.phone') }}</span>
                        <a href="tel:{{ $phone }}">{{ $phone }}</a>
                    </div>
                    <div class="contact-detail">
                        <span class="contact-detail__label">{{ translate('messages.Address') }}</span>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ data_get($defaultLocation, 'lat', 0) }},{{ data_get($defaultLocation, 'lng', 0) }}" target="_blank" rel="noopener">{{ $address }}</a>
                    </div>
                    <div class="contact-detail">
                        <span class="contact-detail__label">{{ translate('messages.Business hours') }}</span>
                        <span>{{ translate(\App\CentralLogics\Helpers::get_settings('opening_day')) }} - {{ translate(\App\CentralLogics\Helpers::get_settings('closing_day')) }}<br>{{ \App\CentralLogics\Helpers::time_format(\App\CentralLogics\Helpers::get_settings('opening_time')) }} - {{ \App\CentralLogics\Helpers::time_format(\App\CentralLogics\Helpers::get_settings('closing_time')) }}</span>
                    </div>
                </aside>

                <section class="contact-panel">
                    <h2>{{ translate('messages.Send us a message') }}</h2>
                    <p class="contact-panel__intro">{{ translate('messages.Complete the form and our team will get back to you.') }}</p>
                    <form method="post" action="{{ route('send-message') }}" id="contact-form">
                        @csrf
                        <div class="contact-form-grid">
                            <div>
                                <label for="contact-name">{{ translate('messages.Your Name') }}</label>
                                <input id="contact-name" type="text" required name="name" value="{{ old('name') }}" class="form-control">
                            </div>
                            <div>
                                <label for="contact-email">{{ translate('messages.Email') }}</label>
                                <input id="contact-email" type="email" required name="email" value="{{ old('email') }}" class="form-control">
                            </div>
                            <div class="full">
                                <label for="contact-subject">{{ translate('messages.Subject') }}</label>
                                <input id="contact-subject" type="text" required name="subject" value="{{ old('subject') }}" class="form-control">
                            </div>
                            <div class="full">
                                <label for="contact-message">{{ translate('messages.Message') }}</label>
                                <textarea id="contact-message" name="message" required class="form-control">{{ old('message') }}</textarea>
                            </div>
                            <div class="full">
                                @if(isset($recaptcha) && $recaptcha['status'] == 1)
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                @else
                                    <div class="row g-3 align-items-center">
                                        <div class="col-sm-7"><input type="text" class="form-control" name="custome_recaptcha" required placeholder="{{ translate('Enter recaptcha value') }}" autocomplete="off"></div>
                                        <div class="col-sm-5"><img src="{{ $custome_recaptcha->inline() }}" class="w-100 rounded" alt="{{ translate('messages.Captcha') }}"></div>
                                    </div>
                                @endif
                            </div>
                            <div class="full"><button type="submit" class="contact-submit" id="contact-submit">{{ translate('messages.Send Message') }}</button></div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
@endsection

@if(isset($recaptcha) && $recaptcha['status'] == 1)
    @push('script_2')
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptcha['site_key'] }}"></script>
        <script>
            document.getElementById('contact-form').addEventListener('submit', function (event) {
                if (this.dataset.verified === 'true') return;
                event.preventDefault();
                const form = this;
                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ $recaptcha['site_key'] }}', {action: 'contact'}).then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                        form.dataset.verified = 'true';
                        form.submit();
                    });
                });
            });
        </script>
    @endpush
@endif
