<?php
$company_name = App\Models\BusinessSetting::where('key', 'business_name')->first()->value;
?>
<table class="email-template-table-style">
    <tr>
        <td class="email-template-table-td-style">
            <img class="mail-img-2 onerror-image" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/blank3.png')); ?>"

            src="<?php echo e($data['icon_full_url'] ?? asset('/public/assets/admin/img/blank3.png')); ?>"


            id="iconViewer" alt="">
            <h3  class="mt-2 email-template-table-td-title-style" id="mail-title"><?php echo e($data['title']?? translate('Main_Title_or_Subject_of_the_Mail')); ?></h3>

        </td>
    </tr>
    <tr>
        <td class="email-template-table-td-style-2">
            <span class="email-template-table-td-span" id="mail-body"><?php echo $data['body']??'Please click the link below to change your password'; ?></span>

            <?php if(strpos(Request::url(), '/suspend') == false): ?>
            <span class="email-template-table-td-span-2">
                <a href="#" class="email-template-table-td-span-h-ref"><?php echo e(translate('generated_link')); ?></a>
            </span>


            <?php endif; ?>
            <span class="border-top"></span>
            <span class="d-block" id="mail-footer" class="email-template-table-td-span-3  mail-footer"><?php echo e($data['footer_text'] ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.')); ?></span>
            <span class="d-block"><?php echo e(translate('Thanks_&_Regards')); ?>,</span>
            <span class="d-block" class="email-template-table-td-span-4"><?php echo e($company_name); ?></span>
            <?php ($provider_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
            <img class="email-template-img onerror-image"
            src="<?php echo e($data?->logo ? $data->logo_full_url : \App\CentralLogics\Helpers::get_full_url('business',$provider_logo?->value,$provider_logo?->storage[0]?->value ?? 'public', 'favicon')); ?>"


            alt="public/img">

            <span class="privacy">
                <a href="#" id="privacy-check" style="<?php echo e((isset($data['privacy']) && $data['privacy'] == 1)?'':'display:none;'); ?>"><span class="dot"></span><?php echo e(translate('Privacy_Policy')); ?></a>
                <a href="#" id="refund-check" style="<?php echo e((isset($data['refund']) && $data['refund'] == 1)?'':'display:none;'); ?>"><span class="dot"></span><?php echo e(translate('Refund_Policy')); ?></a>
                <a href="#" id="cancelation-check" style="<?php echo e((isset($data['cancelation']) && $data['cancelation'] == 1)?'':'display:none;'); ?>"><span class="dot"></span><?php echo e(translate('Cancelation_Policy')); ?></a>
                <a href="#" id="contact-check" style="<?php echo e((isset($data['contact']) && $data['contact'] == 1)?'':'display:none;'); ?>"><span class="dot"></span><?php echo e(translate('Contact_us')); ?></a>
            </span>

            <span class="social email-template-social-span">
                <a href="" id="facebook-check" class="email-template-social-media" style="<?php echo e((isset($data['facebook']) && $data['facebook'] == 1)?'':'display:none;'); ?>">
                    <img src="<?php echo e(asset('/public/assets/admin/img/img/facebook.png')); ?>" alt="">
                </a>
                <a href="" id="instagram-check" class="email-template-social-media" style="<?php echo e((isset($data['instagram']) && $data['instagram'] == 1)?'':'display:none;'); ?>">
                    <img src="<?php echo e(asset('/public/assets/admin/img/img/instagram.png')); ?>" alt="">
                </a>
                <a href="" id="twitter-check" class="email-template-social-media" style="<?php echo e((isset($data['twitter']) && $data['twitter'] == 1)?'':'display:none;'); ?>">
                    <img src="<?php echo e(asset('/public/assets/admin/img/img/twitter.png')); ?>" alt="">
                </a>
                <a href="" id="linkedin-check" class="email-template-social-media" style="<?php echo e((isset($data['linkedin']) && $data['linkedin'] == 1)?'':'display:none;'); ?>">
                    <img src="<?php echo e(asset('/public/assets/admin/img/img/linkedin.png')); ?>" alt="">
                </a>
                <a href="" id="pinterest-check" class="email-template-social-media" style="<?php echo e((isset($data['pinterest']) && $data['pinterest'] == 1)?'':'display:none;'); ?>">
                    <img src="<?php echo e(asset('/public/assets/admin/img/img/pinterest.png')); ?>" alt="">
                </a>
            </span>
            <span class="copyright" id="mail-copyright">
                <?php echo e($data['copyright_text']?? translate('Copyright 2023 6ammart. All right reserved')); ?>

            </span>
        </td>
    </tr>
</table>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/business-settings/email-format-setting/templates/email-format-5.blade.php ENDPATH**/ ?>