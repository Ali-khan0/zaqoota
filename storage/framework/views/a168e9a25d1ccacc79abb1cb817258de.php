<!DOCTYPE html>
<?php
    $lang = \App\CentralLogics\Helpers::system_default_language();
    $site_direction = \App\CentralLogics\Helpers::system_default_direction();
?>
<html lang="<?php echo e($lang); ?>" class="<?php echo e($site_direction === 'rtl'?'active':''); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo e(translate('Email_Template')); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');
        body {
            font-family: 'Roboto', sans-serif;
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            background: #f7fbff;
            color: #334257;
            font-size: 13px;
            line-height: 1.5;
            display: flex;align-items: center;justify-content: center;
            min-height: 100vh;

        }

        table {
            border-collapse: collapse !important;
        }
        .border-top {
            border-top: 1px solid rgba(0, 170, 109, 0.3);
            padding: 15px 0 10px;
            display: block;
        }
        .d-block {
            display: block;
        }
        .privacy {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }
        .privacy a {
            text-decoration: none;
            color: #334257;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }
        .privacy a span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #334257;
            display: inline-block;
            margin: 0 7px;
        }
        .social {
            margin: 15px 0 8px;
            display: block;
        }
        .copyright{
            text-align: center;
            display: block;
        }
        .text-base {
            color: var(--base);
font-weight: 700
        }

        .mail-img-1 {
            width: 140px;
            height: 60px;
            object-fit: contain
        }
        .mail-img-2 {
            width: 130px;
            height: 45px;
            object-fit: contain
        }
        .mail-img-3 {
            width: 100%;
            height: 172px;
            object-fit: cover
        }
.social img {
width: 24px;
}
    </style>
</head>

<body style="background-color: #e9ecef;padding:15px">
    <table dir="<?php echo e($site_direction); ?>" style="width:100%;max-width:500px;margin:0 auto;text-align:center;background:#fff">
        <tr>
            <td style="padding:30px 30px 0">
                <img class="mail-img-2"
                src="<?php echo e($data['icon_full_url'] ?? asset('/public/assets/admin/img/blank3.png')); ?>"
                id="iconViewer" alt="">
                <h3 style="font-size:17px;font-weight:500" class="mt-2" id="mail-title"><?php echo e($title?? translate('Main_Title_or_Subject_of_the_Mail')); ?></h3>

            </td>
        </tr>
        <tr>
            <td style="padding:0 30px 30px; text-align:start">
                <span style="font-weight:500;display:block;margin: 20px 0 11px;" id="mail-body"><?php echo $body??'Please click the link below to change your password'; ?></span>
                
                <?php if(isset($url)): ?>
                <span style="display:block;margin-bottom:14px">
                    
                    <a href="<?php echo e($url); ?>" style="color: #0177CD"><?php echo e($url); ?></a>
                </span>
                <?php endif; ?>
                <?php if($data?->button_url): ?>
                    <span class="d-block text-center" style="margin-top: 16px">
                                        <a type="button" href="<?php echo e($data['button_url']??'#'); ?>" class="cmn-btn" id="mail-button"><?php echo e($data['button_name']??'Submit'); ?></a>

                    </span>
                    <?php endif; ?>
                <span class="border-top"></span>
                <span class="d-block" style="margin-bottom:14px" id="mail-footer"><?php echo e($data['footer_text'] ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.')); ?></span>
                <span class="d-block"><?php echo e(translate('Thanks & Regards')); ?>,</span>
                <span class="d-block" style="margin-bottom:20px"><?php echo e($company_name); ?></span>


                <?php ($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                <img style="width:100px;display:block;margin:10px auto" src="<?php echo e($data?->logo ? $data->logo_full_url : \App\CentralLogics\Helpers::get_full_url('business',$store_logo?->value,$store_logo?->storage[0]?->value ?? 'public', 'favicon')); ?>" alt="public/img">
               
                <span class="privacy">
                    <?php ($landing_data =\App\Models\DataSetting::where('type', 'admin_landing_page')->whereIn('key', ['shipping_policy_status','refund_policy_status','cancellation_policy_status'])->pluck('value','key')->toArray()); ?>
                    <a href="<?php echo e(route('privacy-policy')); ?>" id="privacy-check" style="<?php echo e((isset($data['privacy']) && $data['privacy'] == 1)?'':'display:none;'); ?>"><?php echo e(translate('Privacy_Policy')); ?></a>
                    <?php if(isset($landing_data['refund_policy_status']) && $landing_data['refund_policy_status']  == 1): ?>
                    <a href="<?php echo e(route('refund')); ?>" id="refund-check" style="<?php echo e((isset($data['refund']) && $data['refund'] == 1)?'':'display:none;'); ?>"><span class="dot"></span><?php echo e(translate('Refund_Policy')); ?></a>
                    <?php endif; ?>
                    <?php if(isset($landing_data['cancellation_policy_status']) && $landing_data['cancellation_policy_status']  == 1): ?>
                    <a href="<?php echo e(route('cancelation')); ?>" id="cancelation-check" style="<?php echo e((isset($data['cancelation']) && $data['cancelation'] == 1)?'':'display:none;'); ?>"><span class="dot"></span><?php echo e(translate('Cancelation_Policy')); ?></a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('contact-us')); ?>" id="contact-check" style="<?php echo e((isset($data['contact']) && $data['contact'] == 1)?'':'display:none;'); ?>"><span class="dot"></span><?php echo e(translate('Contact_us')); ?></a>
                </span>
                <span class="social" style="text-align:center">
                    <?php ($social_media = \App\Models\SocialMedia::active()->get()); ?>
                    <?php if(isset($social_media)): ?>
                        <?php $__currentLoopData = $social_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($social->link); ?>" target=”_blank” id="<?php echo e($social->name); ?>-check" style="margin: 0 5px;text-decoration:none;<?php echo e((isset($data[$social->name]) && $data[$social->name] == 1)?'':'display:none;'); ?>">
                                <img src="<?php echo e(asset('/public/assets/admin/img/img/')); ?>/<?php echo e($social->name); ?>.png" alt="">
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </span>
                <span class="copyright" id="mail-copyright">
                    <?php echo e($copyright_text?? translate('Copyright 2023 6ammart. All right reserved')); ?>

                </span>
            </td>
        </tr>
    </table>
</body>

</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/email-templates/rental/new-email-format-5.blade.php ENDPATH**/ ?>