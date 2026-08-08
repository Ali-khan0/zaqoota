@include('partials.public-page-styles')

<main class="public-page">
    <div class="public-reader-bar">
        <div class="container public-reader-bar__inner">
            <a href="{{ route('home') }}" class="public-reader-bar__back"><span aria-hidden="true">&larr;</span> {{ translate('messages.Return to home page') }}</a>
            <div class="public-reader-actions">
                <button type="button" class="public-reader-action js-public-print" title="{{ translate('messages.Print') }}"><i class="fas fa-print" aria-hidden="true"></i><span>{{ translate('messages.Print') }}</span></button>
                <button type="button" class="public-reader-action js-public-zen" title="{{ translate('messages.Reading mode') }}"><i class="fas fa-book-open" aria-hidden="true"></i><span>{{ translate('messages.Reading mode') }}</span></button>
            </div>
        </div>
    </div>

    <header class="public-page__hero">
        <div class="container">
            <div class="public-page__eyebrow">{{ translate('messages.Zaqoota Information') }}</div>
            <h1 class="public-page__title">{{ $pageTitle }}</h1>
            <p class="public-page__subtitle">{{ translate('messages.Official Zaqoota information') }}</p>
        </div>
    </header>

    <div class="container public-page__body">
        <div class="public-page__layout">
            <article class="public-page__content js-public-document">
                <div class="public-page__summary">{{ $pageSubtitle }}</div>
                {!! $pageContent !!}
            </article>
            <aside class="public-page__toc">
                <div class="public-page__toc-title">{{ translate('messages.Table of contents') }}</div>
                <ol class="public-page__toc-list js-public-toc"></ol>
                <div class="public-page__toc-empty js-public-toc-empty">{{ translate('messages.Section headings will appear here.') }}</div>
            </aside>
        </div>
    </div>
</main>

@once
    @push('script_2')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const documentBody = document.querySelector('.js-public-document');
                const toc = document.querySelector('.js-public-toc');
                const tocEmpty = document.querySelector('.js-public-toc-empty');
                if (documentBody && toc) {
                    let headings = Array.from(documentBody.querySelectorAll('h1, h2, h3'));
                    if (!headings.length) {
                        headings = Array.from(documentBody.querySelectorAll('p > strong:first-child')).map(function (strong) {
                            return strong.parentElement;
                        });
                    }
                    headings.forEach(function (heading, index) {
                        heading.id = heading.id || 'section-' + (index + 1);
                        const item = document.createElement('li');
                        const link = document.createElement('a');
                        link.href = '#' + heading.id;
                        link.textContent = heading.textContent.trim();
                        item.appendChild(link);
                        toc.appendChild(item);
                    });
                    if (headings.length && tocEmpty) tocEmpty.hidden = true;
                    if ('IntersectionObserver' in window && headings.length) {
                        const observer = new IntersectionObserver(function (entries) {
                            entries.forEach(function (entry) {
                                if (!entry.isIntersecting) return;
                                toc.querySelectorAll('a').forEach(function (link) { link.classList.remove('active'); });
                                const activeLink = toc.querySelector('a[href="#' + entry.target.id + '"]');
                                if (activeLink) activeLink.classList.add('active');
                            });
                        }, { rootMargin: '-20% 0px -65% 0px' });
                        headings.forEach(function (heading) { observer.observe(heading); });
                    }
                }
                document.querySelectorAll('.js-public-print').forEach(function (button) {
                    button.addEventListener('click', function () { window.print(); });
                });
                document.querySelectorAll('.js-public-zen').forEach(function (button) {
                    button.addEventListener('click', function () {
                        document.body.classList.toggle('public-zen');
                        button.classList.toggle('active');
                    });
                });
            });
        </script>
    @endpush
@endonce
