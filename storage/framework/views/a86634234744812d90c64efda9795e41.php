<?php
    $title = $metaData['meta_title']?->value ?? config('app.name');
    $description = $metaData['meta_description']?->value ?? config('app.name') . ' — best platform for your needs.';
    $image = \App\CentralLogics\Helpers::get_full_url(
        'landing/meta_image',
        $metaData['meta_image']?->value ?? '',
        $metaData['meta_image']?->storage[0]?->value ?? 'public',
        'upload_image'
    );
    $url = url()->current();
?>

<!-- ==================== BASIC SEO (Google, Bing, etc.) ==================== -->

<meta name="description" content="<?php echo e($description); ?>">
<meta name="robots" content="index, follow">
<meta name="author" content="<?php echo e(config('app.name')); ?>">
<link rel="canonical" href="<?php echo e($url); ?>">

<!-- ==================== OPEN GRAPH (Facebook, LinkedIn, WhatsApp, etc.) ==================== -->
<meta property="og:title" content="<?php echo e($title); ?>">
<meta property="og:description" content="<?php echo e($description); ?>">
<meta property="og:image" content="<?php echo e($image); ?>">
<meta property="og:url" content="<?php echo e($url); ?>">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?php echo e(config('app.name')); ?>">
<meta property="og:locale" content="<?php echo e(app()->getLocale()); ?>">

<!-- ==================== FACEBOOK ==================== -->
<meta property="fb:app_id" content="<?php echo e(config('services.facebook.app_id') ?? ''); ?>">
<meta property="og:updated_time" content="<?php echo e(now()->toIso8601String()); ?>">

<!-- ==================== TWITTER ==================== -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($title); ?>">
<meta name="twitter:description" content="<?php echo e($description); ?>">
<meta name="twitter:image" content="<?php echo e($image); ?>">
<meta name="twitter:url" content="<?php echo e($url); ?>">
<meta name="twitter:site" content="<?php echo e(config('services.twitter.handle') ?? ''); ?>">
<meta name="twitter:creator" content="<?php echo e(config('services.twitter.handle') ?? ''); ?>">

<!-- ==================== LINKEDIN ==================== -->
<meta property="og:image:alt" content="<?php echo e($title); ?>">
<meta name="linkedin:owner" content="<?php echo e(config('services.linkedin.handle') ?? ''); ?>">

<!-- ==================== PINTEREST ==================== -->
<meta name="pinterest-rich-pin" content="true">
<meta property="og:see_also" content="<?php echo e($url); ?>">
<meta name="pinterest:title" content="<?php echo e($title); ?>">
<meta name="pinterest:description" content="<?php echo e($description); ?>">
<meta name="pinterest:image" content="<?php echo e($image); ?>">

<!-- ==================== TIKTOK ==================== -->
<meta name="tiktok:card" content="summary_large_image">
<meta name="tiktok:title" content="<?php echo e($title); ?>">
<meta name="tiktok:description" content="<?php echo e($description); ?>">
<meta name="tiktok:image" content="<?php echo e($image); ?>">

<!-- ==================== SNAPCHAT ==================== -->
<meta name="snapchat:card" content="summary_large_image">
<meta name="snapchat:title" content="<?php echo e($title); ?>">
<meta name="snapchat:description" content="<?php echo e($description); ?>">
<meta name="snapchat:image" content="<?php echo e($image); ?>">

<!-- ==================== UNIVERSAL MESSAGING APPS (WhatsApp, Discord, Telegram, Slack, etc.) ==================== -->
<meta property="og:image:secure_url" content="<?php echo e($image); ?>">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

<!-- ==================== OPTIONAL ENHANCEMENTS ==================== -->
<meta name="theme-color" content="#ffffff">
<meta name="apple-mobile-web-app-title" content="<?php echo e($title); ?>">
<meta name="application-name" content="<?php echo e($title); ?>">
<?php /**PATH /var/www/zaqoota/resources/views/layouts/landing/_seo.blade.php ENDPATH**/ ?>