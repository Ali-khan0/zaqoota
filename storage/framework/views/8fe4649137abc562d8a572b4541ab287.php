<?php echo $__env->make('email-templates.new-email-format-12', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php if(false): ?>
<!DOCTYPE html>
<?php
    $lang = \App\CentralLogics\Helpers::system_default_language();
    $site_direction = \App\CentralLogics\Helpers::system_default_direction();
?>
<html lang="<?php echo e($lang); ?>" class="<?php echo e($site_direction === 'rtl'?'active':''); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(translate('Email_Template')); ?></title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap');

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            line-height: 21px;
            color: #737883;
            background: #f7fbff;
            padding: 0;
            display: flex;align-items: center;justify-content: center;
            min-height: 100vh;
        }
        h1,h2,h3,h4,h5,h6 {
            color: #334257;
        }
        * {
            box-sizing: border-box
        }

        :root {
           --base: #006161
        }

        .main-table {
            width: 500px;
            background: #FFFFFF;
            margin: 0 auto;
            padding: 40px;
        }
        .main-table-td {
        }
        img {
            max-width: 100%;
        }
        .cmn-btn{
            background: var(--base);
            color: #fff;
            padding: 8px 20px;
            display: inline-block;
            text-decoration: none;
        }
        .mb-1 {
            margin-bottom: 5px;
        }
        .mb-2 {
            margin-bottom: 10px;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
        .mb-4 {
            margin-bottom: 20px;
        }
        .mb-5 {
            margin-bottom: 25px;
        }
        hr {
            border-color : rgba(0, 170, 109, 0.3);
            margin: 16px 0
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
        div {
            display: block;
        }
        .text-center {
            text-align: center;
        }
        .w-100 {
            width: 100%;
        }
        a {
            text-decoration: none;
        }
        .bg-section {
            background: #E3F5F1;
        }
        table.bg-section {
            color: #334257;
        }
        .p-10{
            padding: 10px;
        }
        table.bg-section tr th,
        table.bg-section tr td {
            padding: 5px;
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

    <table dir="<?php echo e($site_direction); ?>" class="main-table">
        <tbody>
            <tr>
                <td class="main-table-td">
                    <div class="text-center">
                    <img class="mail-img-2"
                    src="<?php echo e($data['icon_full_url'] ?? asset('/public/assets/admin/img/blank3.png')); ?>"


                    id="iconViewer" alt="">
                        <h2 id="mail-title" class="mt-2"><?php echo e($title?? translate('Main_Title_or_Subject_of_the_Mail')); ?></h2>
                        <div class="mb-2" id="mail-body"><?php echo $body?? translate('Hi_Sabrina,'); ?></div>
                    </div>
                    <table class="bg-section p-10 w-100 text-center">
                        <thead>
                            <tr>
                                <th><?php echo e(translate('messages.SL')); ?></th>
                                <th><?php echo e(translate('messages.transaction_id')); ?></th>
                                <th><?php echo e(translate('messages.Time')); ?></th>
                                <th><?php echo e(translate('messages.amount')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><?php echo e($transaction_id); ?></td>
                                <td><?php echo e($time); ?></td>
                                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if($data?->button_url): ?>
                    <span class="d-block text-center" style="margin-top: 16px">
                                        <a type="button" href="<?php echo e($data['button_url']??'#'); ?>" class="cmn-btn" id="mail-button"><?php echo e($data['button_name']??'Submit'); ?></a>

                    </span>
                    <?php endif; ?>
                    <hr>
                    <div class="mb-2" id="mail-footer">
                        <?php echo e($footer_text ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.')); ?>

                    </div>
                    <div>
                        <?php echo e(translate('Thanks & Regards')); ?>,
                    </div>
                    <div class="mb-4">
                        <?php echo e($company_name); ?>

                    </div>
                </td>
            </tr>
            <tr>
                <td>
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
        </tbody>
    </table>


</body>
</html>
<?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/email-templates/new-email-format-6.blade.php ENDPATH**/ ?>