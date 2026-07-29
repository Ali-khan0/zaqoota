@extends('layouts.landing.app')
@php($business_name =    \App\CentralLogics\Helpers::get_business_settings('business_name'))
@section('title', translate('messages.landing_page') . ' | ' . $business_name != 'null' ? $business_name : 'Sixam Mart')
@section('content')

    <!-- Basic Settings -->
    @php($landing_page_links =   \App\CentralLogics\Helpers::get_business_settings('landing_page_links'))
    <!-- ==== Banner Section Starts Here ==== -->
<section class="banner-section position-relative">

    <div class="banner-video-hero">

        <!-- Video -->
        <video autoplay loop muted playsinline>
            <source src="{{ asset('public/assets/landing/image/video.mp4') }}" type="video/mp4">
        </video>

        <!-- Overlay -->
        <div class="banner-overlay"></div>

        <!-- Content -->
        <div class="container">
            <div class="banner-overlay-content">
                <h1 class="title">
                    {{ $landing_data['fixed_header_title'] }}
                </h1>

                <div class="text">
                    {{ $landing_data['fixed_header_sub_title'] }}
                </div>
            </div>
        </div>

    </div>

</section>
    <!-- ==== Banner Section Ends Here ==== -->

    <!-- ==== Ecommerce Venture Section Starts Here ==== -->
 <section class="ecommerce-venture-section zaqoota-modules-section">
    <div class="container">

        <div class="section-header text-center mb-5 wow fadeInUp">
            <span class="module-label">Zaqoota Modules</span>

            <h2 class="title">
                {{ $landing_data['fixed_module_title'] }}
            </h2>

            <p>
                {{ $landing_data['fixed_module_sub_title'] }}
            </p>
        </div>

        @php($modules = \App\Models\Module::Active()->get())

        <div class="module-tabs-card">
            <div class="owl-theme owl-carousel module-tabs-carousel" id="sync2">
                @foreach ($modules as $key => $item)
                    <div class="module-tab-item">
                        <img class="module-tab-icon onerror-image"
                            data-onerror-image="{{ asset('public/assets/admin/img/100x100/2.png') }}"
                            src="{{ $item['icon_full_url'] ?? asset('public/assets/admin/img/100x100/2.png') }}"
                            alt="image">

                        <div class="module-tab-title">
                            {{ translate("messages.{$item->module_name}") }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="owl-theme owl-carousel module-content-carousel" id="sync1">
            @foreach ($modules as $key => $item)
                <div class="module-slide">
                    <div class="row align-items-center justify-content-between g-5">

                        <div class="col-lg-6">
                            <div class="module-content-box">
                                <span class="module-count">
                                    0{{ $key + 1 }}
                                </span>

                                <h3>
                                    {{ translate("messages.{$item->module_name}") }}
                                </h3>

                                <div class="module-description">
                                    {!! $item->description ?? '' !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="module-image-box">
                                <img src="{{ $item['thumbnail_full_url'] ?? asset('public/assets/admin/img/100x100/2.png') }}"
                                    class="img-fluid onerror-image"
                                    data-onerror-image="{{ asset('public/assets/admin/img/100x100/2.png') }}"
                                    alt="image">
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
    <!-- ==== Ecommerce Venture Section Ends Here ==== -->

<!-- ==== Module Banner Section Starts Here ==== -->
@php($promotion_banner = $landing_data['promotional_banners'])

@if ($promotion_banner && count($promotion_banner) > 0)
    <section class="main-category module-banner-section">
        <div class="container">

            <div class="module-banner-slider owl-theme owl-carousel main-category-slider">
                @foreach ($promotion_banner as $item)
                    <div class="module-banner-card"
                        style="background-image: url({{ $item['image_full_url'] }});">

                        <div class="module-banner-overlay"></div>

                        <div class="module-banner-content">
                            <span class="module-banner-label">Zaqoota Service</span>

                            <h2 class="title">
                                {{ $item['title'] ?? '' }}
                            </h2>

                            <div class="text">
                                {{ $item['sub_title'] ?? '' }}
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endif
<!-- ==== Module Banner Section Ends Here ==== -->

    <!-- ==== Learn Feature Section Starts Here ==== -->
<section class="learn-feature-section zaqoota-feature-section">
    <div class="container position-relative">

        <div class="row gy-5 align-items-center">

            <div class="col-lg-5">
                <div class="feature-left-content wow fadeInUp">
                    <span class="feature-label">Why Choose Zaqoota</span>

                    <h2 class="title">
                        {{ $landing_data['feature_title'] }}
                    </h2>

                    <div class="text">
                        {{ $landing_data['feature_short_description'] }}
                    </div>
                </div>
            </div>

            @php($feature = $landing_data['features'])

            @if (isset($feature) && count($feature) > 0)
                <div class="col-lg-7">
                    <div class="feature-card-grid">

                        @foreach ($feature as $item)
                            <div class="feature-modern-card wow fadeInUp">
                                <div class="feature-modern-icon">
                                    <img src="{{ $item['image_full_url'] }}"
                                        alt="{{ $item['title'] ?? '' }}">
                                </div>

                                <div class="feature-modern-content">
                                    <h5>{{ $item['title'] ?? '' }}</h5>

                                    <p>
                                        {{ $item['sub_title'] ?? '' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

        </div>

    </div>
</section>
<!-- ==== Learn Feature Section Ends Here ==== -->

    <!-- ==== Delivery Area Section Starts Here ==== -->
    @if ($landing_data['available_zone_status'] && $landing_data['available_zone_list'])
        <section class="delivery-area-section">
            <div class="container">
                <div class="row text-center gy-4 flex-wrap-reverse align-items-center">
                    <div class="col-lg-5 col-xl-6 text-lg-start">
                        <div class="section-header text-lg-start wow fadeInUp">
                            <h2 class="title">
                                {{-- <span>Available delivery</span> <span class="text--base">areas / Zone</span> --}}
                                <span>{{ $landing_data['available_zone_title'] }}</span>

                            </h2>
                        </div>
                        <div class="text">
                            {{ $landing_data['available_zone_short_description'] }}
                        </div>
                        <div class="zone-list-container">
                            <div class="zone-list-wrapper mt-4">
                                <div class="zone-list">
                                    @foreach ($landing_data['available_zone_list'] as $zone)
                                        @if (count($zone['modules']->toArray()) > 0)
                                            <span class="item" data-bs-trigger="hover" data-bs-toggle="popover"
                                                data-bs-placement="top" title="{{ $zone['display_name'] }}"
                                                data-bs-content="{{ count($zone['modules']->toArray()) > 0 ? implode(', ', $zone['modules']->toArray()) . ' ' . translate('are_available.') : translate('right_now_no_module_available.') }}">
                                                {{ $zone['display_name'] }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-7 col-xl-6 text-lg-end">
                        <img src="{{ $landing_data['available_zone_image_full_url'] }}" alt=""
                            class="img-fluid w-100 mw-450">
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- ==== Delivery Area Section Ends Here ==== -->

    <!-- ==== Refer Section Starts Here ==== -->
    <!--<section class="refer-section pb-80">-->
    <!--    <div class="container">-->
    <!--        <div class="row align-items-center text-center gy-4 flex-wrap-reverse">-->
    <!--            <div class="col-lg-5 col-xl-6 text-lg-start">-->
    <!--                <div class="section-header text-lg-start mb-3 wow fadeInUp">-->
    <!--                    <h2 class="title">-->
    <!--                        <div>-->
    <!--                            {{ $landing_data['fixed_referal_title'] }}-->

    <!--                        </div>-->
    <!--                    </h2>-->
    <!--                </div>-->
    <!--                <div class="text">-->
    <!--                    {{ $landing_data['fixed_referal_sub_title'] }}-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="col-lg-7 col-xl-6 text-lg-end">-->
                  
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    <!-- ==== Refer Section Ends Here ==== -->
<!-- ==== Earn Money Section Starts Here ==== -->
<section class="earn-money-section zaqoota-earn-money-section">
    <div class="container">

        <div class="section-header text-center wow fadeInUp">
            <h2 class="title">
                {{ $landing_data['earning_title'] }}
            </h2>
            <div class="text">
                {{ $landing_data['earning_sub_title'] }}
            </div>
        </div>

        <div class="row g-4 mt-4">

            @php($join_as_seller = $landing_data['seller_app_earning_links'])

            <div class="col-lg-6">
                <div class="earn-modern-card seller-card wow fadeInUp"
                    style="background-image: url({{ \App\CentralLogics\Helpers::get_full_url('earning', isset($landing_data['earning_seller_image']) ? $landing_data['earning_seller_image'] : null, isset($landing_data['earning_seller_image_storage']) ? $landing_data['earning_seller_image_storage'] : 'public') }});">

                    <div class="earn-modern-overlay"></div>

                    <div class="earn-modern-content">
                        <span class="earn-badge">For Vendors</span>

                        <h4>{{ translate('messages.Become a best') }}</h4>
                        <h3>{{ translate('messages.Seller') }}</h3>

                        <p>Grow your business online and reach more customers with Zaqoota.</p>

                        <div class="position-relative dropdown text-capitalize z-2">
                            @if (isset($join_as_seller['playstore_url_status']) &&
                                    $join_as_seller['playstore_url_status'] == '1' &&
                                    isset($join_as_seller['apple_store_url_status']) &&
                                    $join_as_seller['apple_store_url_status'] == '1')
                                <button type="button" class="earn-modern-btn border-0" data-bs-toggle="dropdown">
                                    {{ translate('Seller App') }}
                                </button>

                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <a href="{{ isset($join_as_seller['playstore_url']) ? $join_as_seller['playstore_url'] : '' }}" class="dropdown-item">
                                        <img src="{{ asset('/public/assets/landing/img/google-play.png') }}" alt="">
                                        {{ translate('google_play') }}
                                    </a>
                                    <a href="{{ isset($join_as_seller['apple_store_url']) ? $join_as_seller['apple_store_url'] : '' }}" class="dropdown-item">
                                        <img src="{{ asset('/public/assets/landing/img/apple-store.png') }}" alt="">
                                        {{ translate('apple_store') }}
                                    </a>
                                </div>
                            @elseif(isset($join_as_seller['playstore_url_status']) && $join_as_seller['playstore_url_status'] == '1')
                                <a class="earn-modern-btn" href="{{ isset($join_as_seller['playstore_url']) ? $join_as_seller['playstore_url'] : '' }}">
                                    {{ translate('Seller App') }}
                                </a>
                            @elseif(isset($join_as_seller['apple_store_url_status']) && $join_as_seller['apple_store_url_status'] == '1')
                                <a class="earn-modern-btn" href="{{ isset($join_as_seller['apple_store_url']) ? $join_as_seller['apple_store_url'] : '' }}">
                                    {{ translate('Seller App') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @php($join_as_dm = $landing_data['dm_app_earning_links'])

            <div class="col-lg-6">
                <div class="earn-modern-card delivery-card wow fadeInUp"
                    style="background-image: url({{ \App\CentralLogics\Helpers::get_full_url('earning', isset($landing_data['earning_delivery_image']) ? $landing_data['earning_delivery_image'] : null, isset($landing_data['earning_delivery_image_storage']) ? $landing_data['earning_delivery_image_storage'] : 'public') }});">

                    <div class="earn-modern-overlay"></div>

                    <div class="earn-modern-content">
                        <span class="earn-badge">For Captains</span>

                        <h4>{{ translate('messages.Become a smart') }}</h4>
                        <h3>{{ translate('messages.Deliveryman') }}</h3>

                        <p>Deliver with Zaqoota and earn on your own road, your own rhythm.</p>

                        <div class="position-relative dropdown text-capitalize z-2">
                            @if (isset($join_as_dm['playstore_url_status']) &&
                                    $join_as_dm['playstore_url_status'] == '1' &&
                                    isset($join_as_dm['apple_store_url_status']) &&
                                    $join_as_dm['apple_store_url_status'] == '1')
                                <button type="button" class="earn-modern-btn border-0" data-bs-toggle="dropdown">
                                    {{ translate('Deliveryman App') }}
                                </button>

                                <div class="dropdown-menu p-0">
                                    <a href="{{ isset($join_as_dm['playstore_url']) ? $join_as_dm['playstore_url'] : '' }}" class="dropdown-item">
                                        <img src="{{ asset('/public/assets/landing/img/google-play.png') }}" alt="">
                                        {{ translate('google_play') }}
                                    </a>
                                    <a href="{{ isset($join_as_dm['apple_store_url']) ? $join_as_dm['apple_store_url'] : '' }}" class="dropdown-item">
                                        <img src="{{ asset('/public/assets/landing/img/apple-store.png') }}" alt="">
                                        {{ translate('apple_store') }}
                                    </a>
                                </div>
                            @elseif(isset($join_as_dm['playstore_url_status']) && $join_as_dm['playstore_url_status'] == '1')
                                <a class="earn-modern-btn" href="{{ isset($join_as_dm['playstore_url']) ? $join_as_dm['playstore_url'] : '' }}">
                                    {{ translate('Zaqoota Captain') }}
                                </a>
                            @elseif(isset($join_as_dm['apple_store_url_status']) && $join_as_dm['apple_store_url_status'] == '1')
                                <a class="earn-modern-btn" href="{{ isset($join_as_dm['apple_store_url']) ? $join_as_dm['apple_store_url'] : '' }}">
                                    {{ translate('Become Partner') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- ==== Earn Money Section Ends Here

<!-- ==== Special Feature Section Starts Here ==== -->
@php($special = $landing_data['criterias'])

@if ($special && count($special) > 0)
    <section class="special-feature-section zaqoota-why-section">
        <div class="container">

            <div class="section-header text-center wow fadeInUp">
                <h2 class="title">
                    {{ $landing_data['why_choose_title'] }}
                </h2>
            </div>

            <div class="why-feature-grid wow fadeInUp">
                @foreach ($special as $item)
                    @if ($item->status == '1')
                        <div class="why-feature-card">
                            <div class="why-feature-icon">
                                <img src="{{ $item['image_full_url'] }}"
                                    alt="{{ $item['title'] }}"
                                    class="onerror-image"
                                    data-onerror-image="{{ asset('public/assets/admin/img/160x160/img2.jpg') }}">
                            </div>

                            <h4 class="why-feature-title">
                                {{ $item['title'] }}
                            </h4>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </section>
@endif
<!-- ==== Special Feature Section Ends Here ==== -->

<!-- ==== Counter Section Starts Here ==== -->
@php($counter = $landing_data['counter_section'])

@if (isset($counter) && $counter['status'] == '1')
<section class="counter-section zaqoota-counter-section">
    <div class="container">

        <div class="counter-modern-wrapper">

            <div class="counter-grid">

                <!-- Downloads -->
                <div class="counter-modern-item wow fadeInUp">
                    <div class="counter-modern-icon download-icon">
                        <img src="{{ asset('public/assets/landing/image/download-icon.png') }}"
                             alt="Downloads">
                    </div>

                    <h4 class="title">
                        <span class="odometer"
                            data-odometer-final="{{ $counter['app_download_count_numbers'] ?? 1000 }}">
                        </span>
                        <span>+</span>
                    </h4>

                    <div class="text">
                        {{ translate('messages.Download') }}
                    </div>
                </div>

                <!-- Sellers -->
                <div class="counter-modern-item wow fadeInUp">
                    <div class="counter-modern-icon seller-icon">
                        <img src="{{ asset('public/assets/landing/image/seller-icon.png') }}"
                             alt="Seller">
                    </div>

                    <h4 class="title">
                        <span class="odometer"
                            data-odometer-final="{{ $counter['seller_count_numbers'] ?? 25 }}">
                        </span>
                        <span>+</span>
                    </h4>

                    <div class="text">
                        {{ translate('messages.Seller') }}
                    </div>
                </div>

                <!-- Riders -->
                <div class="counter-modern-item wow fadeInUp">
                    <div class="counter-modern-icon delivery-icon">
                        <img src="{{ asset('public/assets/landing/image/rider-icon.png') }}"
                             alt="Deliveryman">
                    </div>

                    <h4 class="title">
                        <span class="odometer"
                            data-odometer-final="{{ $counter['deliveryman_count_numbers'] ?? 37 }}">
                        </span>
                        <span>+</span>
                    </h4>

                    <div class="text">
                        {{ translate('messages.Deliveryman') }}
                    </div>
                </div>

                <!-- Customers -->
                <div class="counter-modern-item wow fadeInUp">
                    <div class="counter-modern-icon customer-icon">
                        <img src="{{ asset('public/assets/landing/image/customer-icon.png') }}"
                             alt="Customer">
                    </div>

                    <h4 class="title">
                        <span class="odometer"
                            data-odometer-final="{{ $counter['customer_count_numbers'] ?? 1000 }}">
                        </span>
                        <span>+</span>
                    </h4>

                    <div class="text">
                        {{ translate('messages.customer') }}
                    </div>
                </div>

            </div>

            <div class="counter-status">
                <div class="counter-status-logo">
                    <img class="onerror-image"
                        data-onerror-image="{{ asset('public/assets/admin/img/160x160/img2.jpg') }}"
                        src="{{ \App\CentralLogics\Helpers::iconFullUrl() }}"
                        alt="image">
                </div>

                <div>
                    <span>{{ translate('messages.Still increasing') }}</span>
                </div>
            </div>

        </div>

    </div>
</section>
@endif
<!-- ==== Counter Section Ends Here ==== -->
<!-- ==== Download App Starts Here ==== -->
@php($landing_page_links = $landing_data['download_user_app_links'])

@if (
    (isset($landing_page_links['playstore_url_status']) && $landing_page_links['playstore_url_status'] == '1') ||
    (isset($landing_page_links['apple_store_url_status']) && $landing_page_links['apple_store_url_status'] == '1')
)
<section class="download-app-section zaqoota-download-section">
    <div class="container">

        <div class="download-app-card">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <div class="download-app-content wow fadeInUp">

                        <span class="download-label">Download Zaqoota App</span>

                        <h2 class="title">
                            {{ $landing_data['download_user_app_title'] ?? translate('Order Anything, Anytime') }}
                        </h2>

                        <div class="text">
                            {{ $landing_data['download_user_app_sub_title'] ?? translate('Get food, grocery, pharmacy, parcel and shopping delivery in one smart app.') }}
                        </div>

                        <div class="download-feature-list">
                            <span>Food</span>
                            <span>Grocery</span>
                            <span>Pharmacy</span>
                            <span>Parcel</span>
                            <span>Ecommerce</span>
                        </div>

                        <div class="store-buttons">

                            @if (isset($landing_page_links['playstore_url_status']) && $landing_page_links['playstore_url_status'] == '1')
                                <a href="{{ $landing_page_links['playstore_url'] }}" class="store-btn">
                                    <img src="{{ asset('/public/assets/landing/img/google-play.png') }}" alt="Google Play">
                                    <div>
                                        <small>Get it on</small>
                                        <strong>{{ translate('google_play') }}</strong>
                                    </div>
                                </a>
                            @endif

                            @if (isset($landing_page_links['apple_store_url_status']) && $landing_page_links['apple_store_url_status'] == '1')
                                <a href="{{ $landing_page_links['apple_store_url'] }}" class="store-btn">
                                    <img src="{{ asset('/public/assets/landing/img/apple-store.png') }}" alt="App Store">
                                    <div>
                                        <small>Download on the</small>
                                        <strong>{{ translate('apple_store') }}</strong>
                                    </div>
                                </a>
                            @endif

                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="download-phone-wrap wow fadeInUp">
                        <div class="phone-glow"></div>

                        <img class="download-phone-img"
                            src="{{ \App\CentralLogics\Helpers::get_full_url('download_user_app_image', isset($landing_data['download_user_app_image']) ? $landing_data['download_user_app_image'] : null, isset($landing_data['download_user_app_image_storage']) ? $landing_data['download_user_app_image_storage'] : 'public') }}"
                            alt="Download App">

                        <div class="floating-pill pill-food">Food</div>
                        <div class="floating-pill pill-grocery">Grocery</div>
                        <div class="floating-pill pill-parcel">Parcel</div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endif
<!-- ==== Download App Ends Here ==== -->

<!-- ==== Restaurant / Store List Starts Here ==== -->
@php($testimonial = $landing_data['testimonials'])

@if ($testimonial && count($testimonial) > 0)
    <section class="testimonial-section zaqoota-store-section">
        <div class="container">

            <div class="section-header text-center wow fadeInUp">
                <h2 class="title">
                    {{ $landing_data['testimonial_title'] }}
                </h2>
            </div>

            <div class="testimonial-slider store-list-slider owl-theme owl-carousel wow fadeInUp">
                @foreach ($testimonial as $data)
                    <div class="store-card">

                        <div class="store-logo-box">
                            <img src="{{ $data['company_image_full_url'] ?? $data['reviewer_image_full_url'] }}"
                                alt="{{ $data['name'] ?? 'Store' }}">
                        </div>

                        <h4 class="store-name">
                            {{ $data['name'] ?? '' }}
                        </h4>

                        <span class="store-badge">
                            Now on Zaqoota
                        </span>

                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endif
<!-- ==== Restaurant / Store List Ends Here ==== -->
    @if (isset($new_user) && $new_user == true)
        <!-- Modal -->
        <div class="modal fade show" id="welcome-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header border-0 pt-4 px-4">
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-sm-5 pb-5">
                        <div class="text-center">
                            <img src="{{ asset('/public/assets/landing/img/welcome.svg') }}" class="mw-100 mb-3"
                                alt="">
                            <h5 class="mb-3">{{ translate('Welcome_to') }} {{ $business_name }}!</h5>
                            <p class="m-0 mb-4">
                                {{ translate('Thanks for joining us! Your registration is under review. Hang tight, we’ll notify you once approved!') }}
                            </p>
                            <button type="button" class="border-0 outline-0 shadow-none cmn--btn"
                                data-bs-dismiss="modal">
                                {{ translate('okay') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
    @endif

@endsection
@push('script_2')
    <script>
        $(document).ready(function() {
            $('#welcome-modal').modal('show');
        });
    </script>
    <script>
        "use strict";
        $(document).ready(function() {
            "use strict";
            $('.onerror-image').on('error', function() {
                let img = $(this).data('onerror-image')
                $(this).attr('src', img);
            });
        });
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))

        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
@endpush
