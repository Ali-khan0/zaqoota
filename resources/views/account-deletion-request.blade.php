@extends('layouts.landing.app')

@section('title', translate('Account Deletion Request'))

@section('content')
    <!-- ==== Account Deletion Request Section ==== -->
    <section class="about-section py-5 position-relative">
        <div class="container contact-container">
            <div class="section-header">
                <h2 class="title mb-2">{{ translate('Account Deletion Request') }}</h2>
                <div class="text">{{ translate('Please enter your email address to submit a request for account deletion. Our admin team will review your request.') }}</div>
            </div>
            <div class="row gy-5 mt-0">
                <div class="col-lg-8 mx-auto">
                    <form class="contact-form-wrapper" method="post" action="{{ route('submit-account-deletion-request') }}" id="form-id">
                        @csrf
                        <div class="row g-4">
                            <div class="col-sm-12">
                                <input type="email" required name="email" placeholder="{{ translate('Your Email Address') }}" class="form-control form--control" value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-12">
                                <textarea name="reason" class="form-control form--control" placeholder="{{ translate('Reason for account deletion (Optional)') }}" rows="5">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            @php($recaptcha = \App\CentralLogics\Helpers::get_business_settings('recaptcha'))
                            @if(isset($recaptcha) && $recaptcha['status'] == 1)
                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                            @else
                                <div class="m-auto p-3 row" id="reload-captcha">
                                    <div class="col-6 pr-0">
                                        <input type="text" class="form-control form-control-lg" name="custome_recaptcha"
                                               id="custome_recaptcha" required placeholder="{{translate('Enter recaptcha value')}}" autocomplete="off" value="{{env('APP_MODE')=='dev'? session('six_captcha'):''}}">
                                    </div>
                                    <div class="col-6 bg-white rounded d-flex w-auto">
                                        <img src="<?php echo $custome_recaptcha->inline(); ?>" class="rounded w-100" />
                                    </div>
                                </div>
                            @endif
                            <div class="col-sm-12 text-center">
                                <button class="cmn--btn border-0" type="submit" id="signInBtn">{{translate("Submit Request")}} </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== Account Deletion Request Section ==== -->
@endsection

@if(isset($recaptcha) && $recaptcha['status'] == 1)
    <script src="https://www.google.com/recaptcha/api.js?render={{$recaptcha['site_key']}}"></script>
@endif
@if(isset($recaptcha) && $recaptcha['status'] == 1)
    <script>
        $(document).ready(function() {
            $('#signInBtn').click(function (e) {
                e.preventDefault();
                if (typeof grecaptcha === 'undefined') {
                    toastr.error('Invalid recaptcha key provided. Please check the recaptcha configuration.');
                    return;
                }
                grecaptcha.ready(function () {
                    grecaptcha.execute('{{$recaptcha['site_key']}}', {action: 'submit'}).then(function (token) {
                        $('#g-recaptcha-response').val(token);
                        $('#form-id').submit();
                    });
                });
                window.onerror = function (message) {
                    var errorMessage = 'An unexpected error occurred. Please check the recaptcha configuration';
                    if (message.includes('Invalid site key')) {
                        errorMessage = 'Invalid site key provided. Please check the recaptcha configuration.';
                    } else if (message.includes('not loaded in api.js')) {
                        errorMessage = 'reCAPTCHA API could not be loaded. Please check the recaptcha API configuration.';
                    }
                    toastr.error(errorMessage)
                    return true;
                };
            });
        });
    </script>
@endif
