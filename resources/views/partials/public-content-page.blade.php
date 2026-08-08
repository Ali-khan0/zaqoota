@include('partials.public-page-styles')

<main class="public-page">
    <header class="public-page__hero">
        <div class="container">
            <div class="public-page__eyebrow">{{ translate('messages.Zaqoota Information') }}</div>
            <h1 class="public-page__title">{{ $pageTitle }}</h1>
            <p class="public-page__subtitle">{{ $pageSubtitle }}</p>
        </div>
    </header>

    <div class="container public-page__body">
        <nav class="public-page__nav" aria-label="{{ translate('messages.Information pages') }}">
                <a href="{{ route('about-us') }}" class="{{ request()->routeIs('about-us') ? 'active' : '' }}">{{ translate('messages.about_us') }}</a>
                <a href="{{ route('privacy-policy') }}" class="{{ request()->routeIs('privacy-policy') ? 'active' : '' }}">{{ translate('messages.privacy_policy') }}</a>
                <a href="{{ route('services-policy') }}" class="{{ request()->routeIs('services-policy') ? 'active' : '' }}">{{ translate('messages.services_policy') }}</a>
                <a href="{{ route('terms-and-conditions') }}" class="{{ request()->routeIs('terms-and-conditions') ? 'active' : '' }}">{{ translate('messages.terms_and_condition') }}</a>
                <a href="{{ route('contact-us') }}" class="{{ request()->routeIs('contact-us') ? 'active' : '' }}">{{ translate('messages.Contact_Us') }}</a>
        </nav>
        <article class="public-page__content">
            {!! $pageContent !!}
        </article>
    </div>
</main>
