@once
    @push('css_or_js')
        <style>
            :root { --zq-teal: #0d988d; --zq-teal-dark: #08756d; --zq-ink: #172b2d; --zq-muted: #607176; --zq-line: #dce9e8; --zq-soft: #f2f9f8; }
            .public-page { background: #f7faf9; color: var(--zq-ink); padding: 0 0 72px; min-height: 60vh; }
            .public-page__hero { background: var(--zq-teal); color: #fff; padding: 58px 0 86px; }
            .public-page__eyebrow { color: rgba(255,255,255,.78); font-size: 13px; font-weight: 700; letter-spacing: 0; margin-bottom: 10px; text-transform: uppercase; }
            .public-page__title { color: #fff; font-size: 38px; line-height: 1.2; margin: 0 0 12px; }
            .public-page__subtitle { color: rgba(255,255,255,.86); font-size: 16px; line-height: 1.7; margin: 0; max-width: 680px; }
            .public-page__body { margin-top: -42px; position: relative; }
            .public-page__content { background: #fff; border: 1px solid rgba(13,152,141,.18); border-radius: 6px; box-shadow: 0 12px 34px rgba(20,64,61,.07); padding: 46px 52px; min-width: 0; }
            .public-page__content, .public-page__content p, .public-page__content li { color: #465b60; font-size: 15px; line-height: 1.8; }
            .public-page__content p { margin-bottom: 17px; }
            .public-page__content h1, .public-page__content h2, .public-page__content h3, .public-page__content h4 { color: var(--zq-ink); line-height: 1.35; margin: 34px 0 13px; }
            .public-page__content h1 { font-size: 28px; }
            .public-page__content h2 { border-bottom: 1px solid var(--zq-line); font-size: 23px; padding-bottom: 10px; }
            .public-page__content h3 { color: var(--zq-teal-dark); font-size: 19px; }
            .public-page__content h4 { font-size: 16px; }
            .public-page__content h1:first-child, .public-page__content h2:first-child, .public-page__content h3:first-child { margin-top: 0; }
            .public-page__content strong { color: #243b3f; font-weight: 700; }
            .public-page__content p > strong:first-child { color: var(--zq-teal-dark); }
            .public-page__content ul, .public-page__content ol { margin: 12px 0 22px; padding-inline-start: 24px; }
            .public-page__content li { margin-bottom: 8px; padding-inline-start: 5px; }
            .public-page__content li::marker { color: var(--zq-teal); font-weight: 700; }
            .public-page__content blockquote { background: var(--zq-soft); border-inline-start: 3px solid var(--zq-teal); color: #40565a; margin: 24px 0; padding: 18px 20px; }
            .public-page__content hr { border: 0; border-top: 1px solid var(--zq-line); margin: 30px 0; }
            .public-page__content a { color: var(--zq-teal-dark); text-decoration: underline; text-underline-offset: 3px; overflow-wrap: anywhere; }
            .public-page__content img { border-radius: 4px; height: auto; max-width: 100%; }
            .public-page__content table { border-collapse: collapse; display: block; max-width: 100%; overflow-x: auto; width: 100%; }
            .public-page__content th, .public-page__content td { border: 1px solid var(--zq-line); padding: 10px 12px; }
            .public-page__nav { align-items: center; background: #fff; border: 1px solid var(--zq-line); border-radius: 6px; display: flex; gap: 4px; margin-bottom: 16px; overflow-x: auto; padding: 7px; position: static; }
            .public-page__nav a { border-radius: 4px; color: #40565a; display: block; flex: 1 0 auto; font-size: 13px; font-weight: 600; padding: 10px 12px; text-align: center; white-space: nowrap; }
            .public-page__nav a:hover, .public-page__nav a.active { background: var(--zq-soft); color: var(--zq-teal-dark); }
            .contact-page__grid { display: grid; gap: 24px; grid-template-columns: minmax(280px,.72fr) minmax(0,1.28fr); }
            .contact-panel { background: #fff; border: 1px solid rgba(13,152,141,.18); border-radius: 6px; box-shadow: 0 12px 34px rgba(20,64,61,.07); padding: 34px; }
            .contact-panel--details { background: #eaf7f5; }
            .contact-panel h2 { color: var(--zq-ink); font-size: 24px; margin-bottom: 10px; }
            .contact-panel__intro { color: var(--zq-muted); line-height: 1.7; margin-bottom: 28px; }
            .contact-detail { border-top: 1px solid rgba(13,152,141,.18); padding: 18px 0; }
            .contact-detail:first-of-type { border-top: 0; padding-top: 0; }
            .contact-detail__label { color: var(--zq-teal-dark); display: block; font-size: 12px; font-weight: 700; margin-bottom: 5px; text-transform: uppercase; }
            .contact-detail a, .contact-detail span { color: #31484c; line-height: 1.6; overflow-wrap: anywhere; }
            .contact-form-grid { display: grid; gap: 18px; grid-template-columns: 1fr 1fr; }
            .contact-form-grid .full { grid-column: 1 / -1; }
            .contact-panel label { color: #31484c; display: block; font-size: 13px; font-weight: 700; margin-bottom: 7px; }
            .contact-panel .form-control { border: 1px solid #cbdcda; border-radius: 4px; min-height: 48px; padding: 11px 14px; }
            .contact-panel textarea.form-control { min-height: 150px; resize: vertical; }
            .contact-panel .form-control:focus { border-color: var(--zq-teal); box-shadow: 0 0 0 3px rgba(13,152,141,.12); }
            .contact-submit { background: var(--zq-teal); border: 0; border-radius: 4px; color: #fff; font-weight: 700; min-height: 48px; padding: 11px 24px; }
            .contact-submit:hover { background: var(--zq-teal-dark); color: #fff; }
            @media (max-width: 991px) {
                .contact-page__grid { grid-template-columns: 1fr; }
            }
            @media (max-width: 575px) {
                .public-page { padding-bottom: 42px; }
                .public-page__hero { padding: 38px 0 68px; }
                .public-page__title { font-size: 29px; }
                .public-page__content, .contact-panel { padding: 24px 20px; }
                .public-page__body { margin-top: -30px; }
                .contact-form-grid { grid-template-columns: 1fr; }
                .contact-form-grid .full { grid-column: auto; }
            }
        </style>
    @endpush
@endonce
