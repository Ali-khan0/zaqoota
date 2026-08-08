@once
    @push('css_or_js')
        <style>
            :root { --zq-teal:#0d988d; --zq-teal-light:#087f76; --zq-dark:#f5f8f8; --zq-panel:#fff; --zq-panel-2:#eef7f6; --zq-line:#d9e6e5; --zq-text:#263d40; --zq-muted:#697d80; }
            .public-page { background:var(--zq-dark); color:var(--zq-text); min-height:70vh; padding:0 0 72px; }
            .public-page__hero { background:#fff; color:#172b2d; padding:48px 0 30px; text-align:center; }
            .public-page__eyebrow { color:var(--zq-teal); font-size:12px; font-weight:700; margin-bottom:9px; text-transform:uppercase; }
            .public-page__title { color:#172b2d; font-size:36px; line-height:1.2; margin:0 0 9px; text-transform:uppercase; }
            .public-page__subtitle { color:var(--zq-muted); font-size:14px; line-height:1.7; margin:0 auto; max-width:720px; }
            .public-page__body { position:relative; }
            .public-page__summary { background:var(--zq-teal); border-radius:5px; color:#fff; font-size:14px; line-height:1.65; margin:0 0 24px; padding:16px 20px; text-align:center; }
            .public-page__layout { align-items:start; display:grid; gap:28px; grid-template-columns:minmax(0,1fr) 260px; margin:0 auto; max-width:1120px; }
            .public-page__content { background:var(--zq-panel); border:1px solid var(--zq-line); border-radius:6px; box-shadow:0 14px 36px rgba(20,64,61,.08); min-width:0; padding:38px 42px; }
            .public-page__content, .public-page__content p, .public-page__content li { color:#4b6063; font-size:15px; line-height:1.75; }
            .public-page__content p { margin-bottom:16px; }
            .public-page__content h1, .public-page__content h2, .public-page__content h3, .public-page__content h4 { color:#172b2d; line-height:1.35; margin:32px 0 12px; }
            .public-page__content h1 { font-size:27px; }
            .public-page__content h2 { font-size:22px; }
            .public-page__content h3 { color:var(--zq-teal-light); font-size:18px; }
            .public-page__content h4 { font-size:16px; }
            .public-page__content h1:first-child, .public-page__content h2:first-child, .public-page__content h3:first-child { margin-top:0; }
            .public-page__content strong { color:#223a3d; font-weight:700; }
            .public-page__content a { color:var(--zq-teal-light); overflow-wrap:anywhere; text-decoration:underline; text-underline-offset:3px; }
            .public-page__content ul, .public-page__content ol { margin:10px 0 22px; padding-inline-start:24px; }
            .public-page__content li { margin-bottom:8px; padding-inline-start:4px; }
            .public-page__content li::marker { color:var(--zq-teal-light); font-weight:700; }
            .public-page__content blockquote { background:var(--zq-panel-2); border-inline-start:3px solid var(--zq-teal); margin:22px 0; padding:17px 20px; }
            .public-page__content hr { border:0; border-top:1px solid var(--zq-line); margin:28px 0; }
            .public-page__content img { border-radius:4px; height:auto; max-width:100%; }
            .public-page__content table { border-collapse:collapse; display:block; max-width:100%; overflow-x:auto; width:100%; }
            .public-page__content th, .public-page__content td { border:1px solid var(--zq-line); padding:10px 12px; }
            .public-page__toc { background:var(--zq-panel); border:1px solid var(--zq-line); border-radius:6px; box-shadow:0 10px 28px rgba(20,64,61,.06); color:var(--zq-text); padding:18px 16px; position:sticky; top:92px; }
            .public-page__toc-title { border-bottom:1px solid var(--zq-line); color:#172b2d; font-size:12px; font-weight:800; margin-bottom:12px; padding-bottom:11px; text-transform:uppercase; }
            .public-page__toc-list { counter-reset:toc; list-style:none; margin:0; padding:0; }
            .public-page__toc-list li { counter-increment:toc; margin:0; }
            .public-page__toc-list a { border-inline-start:2px solid transparent; color:#64777a; display:block; font-size:12px; line-height:1.45; padding:7px 8px 7px 26px; position:relative; text-transform:uppercase; }
            .public-page__toc-list a::before { content:counter(toc) '.'; inset-inline-start:8px; position:absolute; }
            .public-page__toc-list a:hover, .public-page__toc-list a.active { border-color:var(--zq-teal); color:var(--zq-teal-light); }
            .public-page__toc-empty { color:#758789; font-size:12px; line-height:1.6; }
            .contact-page__grid { display:grid; gap:24px; grid-template-columns:minmax(280px,.72fr) minmax(0,1.28fr); margin:0 auto; max-width:1120px; }
            .contact-panel { background:var(--zq-panel); border:1px solid var(--zq-line); border-radius:6px; box-shadow:0 14px 36px rgba(20,64,61,.08); padding:34px; }
            .contact-panel--details { background:var(--zq-panel-2); }
            .contact-panel h2 { color:#172b2d; font-size:23px; margin-bottom:10px; }
            .contact-panel__intro { color:var(--zq-muted); line-height:1.7; margin-bottom:28px; }
            .contact-detail { border-top:1px solid var(--zq-line); padding:18px 0; }
            .contact-detail:first-of-type { border-top:0; padding-top:0; }
            .contact-detail__label { color:var(--zq-teal-light); display:block; font-size:11px; font-weight:700; margin-bottom:5px; text-transform:uppercase; }
            .contact-detail a, .contact-detail span { color:#40575a; line-height:1.6; overflow-wrap:anywhere; }
            .contact-form-grid { display:grid; gap:18px; grid-template-columns:1fr 1fr; }
            .contact-form-grid .full { grid-column:1 / -1; }
            .contact-panel label { color:#31484b; display:block; font-size:13px; font-weight:700; margin-bottom:7px; }
            .contact-panel .form-control { background:#fff; border:1px solid #cbdcda; border-radius:4px; color:#253b3e; min-height:48px; padding:11px 14px; }
            .contact-panel textarea.form-control { min-height:150px; resize:vertical; }
            .contact-panel .form-control:focus { background:#fff; border-color:var(--zq-teal); box-shadow:0 0 0 3px rgba(13,152,141,.13); color:#253b3e; }
            .contact-submit { background:var(--zq-teal); border:0; border-radius:4px; color:#fff; font-weight:700; min-height:48px; padding:11px 24px; }
            .contact-submit:hover { background:#08756d; color:#fff; }
            @media (max-width:991px) {
                .public-page__layout, .contact-page__grid { grid-template-columns:1fr; }
                .public-page__toc { background:var(--zq-panel); border:1px solid var(--zq-line); border-radius:5px; order:-1; padding:16px; position:static; }
                .public-page__toc-list { display:grid; grid-template-columns:1fr 1fr; }
            }
            @media (max-width:575px) {
                .public-page { padding-bottom:42px; }
                .public-page__hero { padding:36px 0 24px; }
                .public-page__title { font-size:27px; }
                .public-page__content, .contact-panel { padding:25px 20px; }
                .public-page__toc-list { grid-template-columns:1fr; }
                .contact-form-grid { grid-template-columns:1fr; }
                .contact-form-grid .full { grid-column:auto; }
            }
            @media print {
                body > header, body > footer, .public-page__toc { display:none!important; }
                .public-page, .public-page__hero { background:#fff!important; color:#111!important; }
                .public-page__hero { padding:20px 0; }
                .public-page__title, .public-page__content h1, .public-page__content h2, .public-page__content h3 { color:#111!important; }
                .public-page__content, .public-page__content p, .public-page__content li { background:#fff!important; border:0; box-shadow:none; color:#333!important; }
                .public-page__layout { display:block; }
            }
        </style>
    @endpush
@endonce
