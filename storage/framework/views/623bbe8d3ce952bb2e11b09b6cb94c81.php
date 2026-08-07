<?php
$company_name = App\Models\BusinessSetting::where('key', 'business_name')->first()->value;
?>
<table class="main-table">
    <tbody>
        <tr>
            <td class="main-table-td">
                <div class="text-center">
                <img class="mail-img-2 onerror-image" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/blank3.png')); ?>"

                src="<?php echo e($data['icon_full_url'] ?? asset('/public/assets/admin/img/blank3.png')); ?>"

                id="iconViewer" alt="">
                    <h2 id="mail-title" class="mt-2"><?php echo e($data['title']?? translate('Main_Title_or_Subject_of_the_Mail')); ?></h2>
                    <div class="mb-2" id="mail-body"><?php echo $data['body']?? translate('Hi_Sabrina,'); ?></div>
                </div>
                <table class="bg-section p-10 w-100 text-center">
                    <thead>
                        <tr>
                            <th><?php echo e(translate('SL')); ?></th>
                            <th><?php echo e(translate('Transaction_ID')); ?></th>
                            <th><?php echo e(translate('Time')); ?></th>
                            <th><?php echo e(translate('Amount')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo e(translate('1')); ?></td>
                            <td><?php echo e(translate('23984357sd834')); ?></td>
                            <td><?php echo e(translate('23 Jul, 2023 3:34 am')); ?></td>
                            <td><?php echo e(translate('$500')); ?></td>
                        </tr>
                    </tbody>
                </table>
                <span class="d-block text-center" class="email-template-06-span">
                    <a href="" class="cmn-btn" id="mail-button"><?php echo e($data['button_name']??'View Request'); ?></a>
                </span>
                <hr>
                <div class="mb-2" id="mail-footer">
                    <?php echo e($data['footer_text'] ?? translate('Please_contact_us_for_any_queries,_we’re_always_happy_to_help.')); ?>

                </div>
                <div>
                    <?php echo e(translate('Thanks_&_Regards')); ?>,
                </div>
                <div class="mb-4">
                    <?php echo e($company_name); ?>

                </div>
            </td>
        </tr>
        <tr>
            <td>
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
    </tbody>
</table>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/email-format-setting/templates/email-format-6.blade.php ENDPATH**/ ?>