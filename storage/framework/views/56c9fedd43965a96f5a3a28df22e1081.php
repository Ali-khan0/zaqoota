<?php ($previewButtonEnabled = (bool) ($data?->button_enabled ?? false)); ?>
<?php ($previewLogo = \App\Models\BusinessSetting::where('key', 'logo')->first()); ?>
<?php ($previewLogoUrl = $previewLogo?->value ? \App\CentralLogics\Helpers::get_full_url('business', $previewLogo->value, $previewLogo?->storage[0]?->value ?? 'public', 'favicon') : ''); ?>
<table role="presentation" style="width:100%;max-width:600px;margin:0 auto;border:1px solid rgba(13,152,141,0.16);border-radius:4px;background:#fff;color:#4a5568;font-family:Verdana,Geneva,sans-serif;box-shadow:0 3px 10px rgba(24,45,58,0.06);">
    <tr>
        <td style="padding:25px 40px;background:#0d988d;color:#fff;text-align:center;border-radius:3px 3px 0 0;">
            <?php if($previewLogoUrl !== ''): ?>
                <img src="<?php echo e($previewLogoUrl); ?>" alt="Zaqoota" style="display:inline-block;max-width:170px;max-height:58px;width:auto;height:auto;filter:brightness(0) invert(1);">
            <?php else: ?>
                <strong style="font-size:26px;">ZAQOOTA</strong>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td style="padding:40px;text-align:start;">
            <h2 id="mail-title" style="margin:0 0 14px;color:#222;font-size:19px;"><?php echo e($data?->title ?? translate('Main_Title_or_Subject_of_the_Mail')); ?></h2>
            <div id="mail-body" style="margin-bottom:18px;"><?php echo $data?->body ?? translate('Mail Body Message'); ?></div>
            <?php if($data?->image): ?>
                <img id="bannerViewer" src="<?php echo e($data->image_full_url); ?>" alt="" style="display:block;width:100%;height:auto;margin:18px 0;">
            <?php endif; ?>
            <?php if($previewButtonEnabled): ?>
                <div id="action-button-preview" style="margin:22px 0;">
                    <span id="mail-button" style="display:inline-block;padding:11px 18px;background:#149b94;color:#fff;font-weight:700;border-radius:4px;"><?php echo e($data?->button_name ?: translate('View_details')); ?></span>
                </div>
            <?php endif; ?>
            <div style="margin-top:24px;padding-top:18px;border-top:1px solid #d7e2e7;color:#65758d;">
                <div id="mail-footer"><?php echo e($data?->footer_text ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.')); ?></div>
            </div>
        </td>
    </tr>
    <tr>
        <td style="padding:18px 30px;background:#f7fafb;color:#748196;text-align:center;font-size:12px;border-top:1px solid rgba(13,152,141,0.12);border-radius:0 0 3px 3px;">
            <div style="margin-bottom:10px;line-height:1.8;">
                <a href="#" id="privacy-check" style="margin:0 6px;color:#65758d;text-decoration:none;<?php echo e(($data?->privacy ?? false) ? '' : 'display:none;'); ?>"><?php echo e(translate('Privacy_Policy')); ?></a>
                <a href="#" id="refund-check" style="margin:0 6px;color:#65758d;text-decoration:none;<?php echo e(($data?->refund ?? false) ? '' : 'display:none;'); ?>"><?php echo e(translate('Refund_Policy')); ?></a>
                <a href="#" id="cancelation-check" style="margin:0 6px;color:#65758d;text-decoration:none;<?php echo e(($data?->cancelation ?? false) ? '' : 'display:none;'); ?>"><?php echo e(translate('Cancelation_Policy')); ?></a>
                <a href="#" id="contact-check" style="margin:0 6px;color:#65758d;text-decoration:none;<?php echo e(($data?->contact ?? false) ? '' : 'display:none;'); ?>"><?php echo e(translate('Contact_us')); ?></a>
            </div>
            <div class="email-template-social-span" style="margin-bottom:10px;line-height:1;">
                <?php $__currentLoopData = ['facebook', 'instagram', 'twitter', 'linkedin', 'pinterest']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socialName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="#" id="<?php echo e($socialName); ?>-check" class="email-template-social-media" style="display:<?php echo e(($data?->{$socialName} ?? false) ? 'inline-block' : 'none'); ?>;margin:0 5px;text-decoration:none;">
                        <img src="<?php echo e(asset('/public/assets/admin/img/img/'.$socialName.'.png')); ?>" alt="<?php echo e(ucfirst($socialName)); ?>" width="22" height="22" style="display:block;border:0;">
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div id="mail-copyright"><?php echo e($data?->copyright_text ?? ''); ?></div>
        </td>
    </tr>
</table>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/email-format-setting/templates/email-format-12.blade.php ENDPATH**/ ?>