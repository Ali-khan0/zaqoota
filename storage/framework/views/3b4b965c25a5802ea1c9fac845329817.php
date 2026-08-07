<!DOCTYPE html>
<?php
    $lang = \App\CentralLogics\Helpers::system_default_language();
    $siteDirection = \App\CentralLogics\Helpers::system_default_direction();
    $buttonEnabled = (bool) ($data?->button_enabled ?? false);
    $dynamicUrl = isset($url) && is_string($url) ? trim($url) : '';
    $configuredUrl = trim((string) ($data?->button_url ?? ''));
    $candidateUrl = $dynamicUrl !== '' ? $dynamicUrl : $configuredUrl;
    $actionUrl = filter_var($candidateUrl, FILTER_VALIDATE_URL) ? $candidateUrl : '';
    $buttonName = trim((string) ($data?->button_name ?? '')) ?: translate('View_details');
    $businessLogo = \App\Models\BusinessSetting::where('key', 'logo')->first();
    $businessLogoUrl = $businessLogo?->value
        ? \App\CentralLogics\Helpers::get_full_url('business', $businessLogo->value, $businessLogo?->storage[0]?->value ?? 'public', 'favicon')
        : '';
    $landingData = \App\Models\DataSetting::where('type', 'admin_landing_page')
        ->whereIn('key', ['shipping_policy_status', 'refund_policy_status', 'cancellation_policy_status'])
        ->pluck('value', 'key')
        ->toArray();
    $socialMedia = \App\Models\SocialMedia::active()->get();
?>
<html lang="<?php echo e($lang); ?>" dir="<?php echo e($siteDirection); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? translate('Email_Template')); ?></title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;color:#4a5568;font-family:Verdana,Geneva,sans-serif;font-size:14px;line-height:1.6;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td align="center" style="padding:30px 15px;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px;background:#ffffff;border:1px solid rgba(13,152,141,0.16);border-radius:4px;box-shadow:0 3px 10px rgba(24,45,58,0.06);">
                <tr>
                    <td style="padding:25px 40px;background:#0d988d;color:#ffffff;text-align:center;border-radius:3px 3px 0 0;">
                        <?php if($businessLogoUrl !== ''): ?>
                            <img src="<?php echo e($businessLogoUrl); ?>" alt="<?php echo e($company_name); ?>" width="170" style="display:inline-block;max-width:170px;max-height:58px;width:auto;height:auto;border:0;filter:brightness(0) invert(1);">
                        <?php else: ?>
                            <strong style="font-size:26px;color:#ffffff;"><?php echo e(strtoupper($company_name)); ?></strong>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding:40px;">
                        <h1 style="margin:0 0 20px;color:#111111;font-size:20px;line-height:1.4;font-weight:600;letter-spacing:0;">
                            <?php echo e($title ?? translate('Main_Title_or_Subject_of_the_Mail')); ?>

                        </h1>
                        <div style="margin:0 0 18px;color:#46556d;"><?php echo $body ?? ''; ?></div>

                        <?php if($data?->image): ?>
                            <div style="margin:20px 0;">
                                <img src="<?php echo e($data->image_full_url); ?>" alt="" style="display:block;width:100%;height:auto;border:0;">
                            </div>
                        <?php endif; ?>

                        <?php if(isset($code)): ?>
                            <div style="margin:20px 0;padding:16px;border:1px solid #d7e2e7;background:#f7fafb;color:#222222;text-align:center;font-size:26px;font-weight:700;letter-spacing:4px;">
                                <?php echo e($code); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(isset($email) || isset($password)): ?>
                            <div style="margin:20px 0;padding:16px;border:1px solid #d7e2e7;background:#f7fafb;">
                                <div style="margin-bottom:10px;color:#222222;font-weight:700;"><?php echo e(translate('Your_account_credential:')); ?></div>
                                <?php if(isset($email)): ?><div><strong><?php echo e(translate('messages.Email')); ?>:</strong> <?php echo e($email); ?></div><?php endif; ?>
                                <?php if(isset($password)): ?><div><strong><?php echo e(translate('messages.Password')); ?>:</strong> <?php echo e($password); ?></div><?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(isset($transaction_id, $time, $amount)): ?>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:20px 0;border:1px solid #d7e2e7;">
                                <tr style="background:#f1f7f7;color:#222222;font-weight:700;">
                                    <td style="padding:10px;border-bottom:1px solid #d7e2e7;"><?php echo e(translate('messages.transaction_id')); ?></td>
                                    <td style="padding:10px;border-bottom:1px solid #d7e2e7;"><?php echo e(translate('messages.Time')); ?></td>
                                    <td style="padding:10px;border-bottom:1px solid #d7e2e7;"><?php echo e(translate('messages.amount')); ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><?php echo e($transaction_id); ?></td>
                                    <td style="padding:10px;"><?php echo e($time); ?></td>
                                    <td style="padding:10px;"><?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?></td>
                                </tr>
                            </table>
                        <?php endif; ?>

                        <?php if(isset($order)): ?>
                            <div style="margin:20px 0;padding:16px;border:1px solid #d7e2e7;background:#f7fafb;">
                                <div style="margin-bottom:8px;color:#222222;font-weight:700;"><?php echo e(translate('Order_Info')); ?></div>
                                <div><strong><?php echo e(translate('Order')); ?>:</strong> #<?php echo e($order->id); ?></div>
                                <div><strong><?php echo e(translate('messages.Date')); ?>:</strong> <?php echo e($order->created_at); ?></div>
                                <?php if(isset($order->order_amount)): ?>
                                    <div><strong><?php echo e(translate('messages.amount')); ?>:</strong> <?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount)); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(isset($body_2)): ?>
                            <div style="margin:18px 0;"><?php echo $body_2; ?></div>
                        <?php endif; ?>

                        <?php if($buttonEnabled && $actionUrl !== ''): ?>
                            <div style="margin:24px 0;">
                                <a href="<?php echo e($actionUrl); ?>" style="display:inline-block;padding:13px 25px;background:#0d988d;color:#ffffff;text-decoration:none;font-size:15px;font-weight:600;border-radius:6px;"><?php echo e($buttonName); ?></a>
                            </div>
                        <?php endif; ?>

                        <div style="margin-top:30px;padding-top:22px;border-top:1px solid #e2e8f0;color:#718096;">
                            <div><?php echo e($footer_text ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.')); ?></div>
                            <div style="margin-top:12px;"><?php echo e(translate('Thanks_&_Regards')); ?>,<br><?php echo e($company_name); ?></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 40px;background:#f8fafc;color:#a0aec0;text-align:center;font-size:12px;border-top:1px solid rgba(13,152,141,0.12);border-radius:0 0 3px 3px;">
                        <div style="margin-bottom:10px;">
                            <?php if($data?->privacy): ?>
                                <a href="<?php echo e(route('privacy-policy')); ?>" style="margin:0 7px;color:#718096;text-decoration:none;"><?php echo e(translate('Privacy_Policy')); ?></a>
                            <?php endif; ?>
                            <?php if($data?->refund && ($landingData['refund_policy_status'] ?? 0) == 1): ?>
                                <a href="<?php echo e(route('refund')); ?>" style="margin:0 7px;color:#718096;text-decoration:none;"><?php echo e(translate('Refund_Policy')); ?></a>
                            <?php endif; ?>
                            <?php if($data?->cancelation && ($landingData['cancellation_policy_status'] ?? 0) == 1): ?>
                                <a href="<?php echo e(route('cancelation')); ?>" style="margin:0 7px;color:#718096;text-decoration:none;"><?php echo e(translate('Cancelation_Policy')); ?></a>
                            <?php endif; ?>
                            <?php if($data?->contact): ?>
                                <a href="<?php echo e(route('contact-us')); ?>" style="margin:0 7px;color:#718096;text-decoration:none;"><?php echo e(translate('Contact_us')); ?></a>
                            <?php endif; ?>
                        </div>
                        <?php if($socialMedia->isNotEmpty()): ?>
                            <div style="margin-bottom:10px;">
                                <?php $__currentLoopData = $socialMedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data?->{$social->name}): ?>
                                        <a href="<?php echo e($social->link); ?>" style="margin:0 5px;text-decoration:none;">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/img/'.$social->name.'.png')); ?>" alt="<?php echo e($social->name); ?>" width="22" height="22" style="display:inline-block;border:0;">
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        <div><?php echo e($copyright_text ?? ''); ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/email-templates/new-email-format-12.blade.php ENDPATH**/ ?>