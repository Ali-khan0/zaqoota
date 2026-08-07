<?php
$company_name = App\Models\BusinessSetting::where('key', 'business_name')->first()->value;
?>
<table class="main-table">
    <tbody>
        <tr>
            <td class="main-table-td">
                <h2 class="mb-3" id="mail-title"><?php echo e($data['title']?? translate('Main_Title_or_Subject_of_the_Mail')); ?></h2>
                <div class="mb-1" id="mail-body"><?php echo $data['body']?? translate('Hi_Sabrina,'); ?></div>
                <span class="d-block text-center mb-3">
                    <a href="" class="cmn-btn" id="mail-button"><?php echo e($data['button_name']??'Track Trip'); ?></a>
                </span>
                <table class="bg-section p-10 w-100">
                    <tbody>
                        <tr>
                            <td class="p-10">
                                <span class="d-block text-center">
                                    <?php ($restaurant_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                                    <img class="mb-2 mail-img-2 onerror-image" data-onerror-image="<?php echo e(asset('storage/app/public/business/' . $restaurant_logo)); ?>"
                                    src="<?php echo e($data?->logo ? $data->logo_full_url : \App\CentralLogics\Helpers::get_full_url('business',$restaurant_logo?->value,$restaurant_logo?->storage[0]?->value ?? 'public', 'favicon')); ?>"
                                    id="logoViewer" alt="">
                                    <h3 class="mb-3 mt-0"><?php echo e(translate('Trip_Info')); ?></h3>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="order-table w-100">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h3 class="subtitle"><?php echo e(translate('Trip_Summary')); ?></h3>
                                                <span class="d-block"><?php echo e(translate('Trip')); ?><?php echo e(translate('#_48573')); ?></span>
                                                <span class="d-block"><?php echo e(translate('23 Jul, 2023 4:30 am')); ?></span>

                                                <div class="text-break mb-1">
                                                    <span class="opacity-70"><?php echo e(translate('messages.pickup_location')); ?></span> <span>:</span>
                                                    <span><?php echo e(translate('4B Kemal Ataturk Ave, Dhaka 1212, Bangladesh')); ?></span>
                                                </div>
                                                <div class="text-break mb-1">
                                                    <span class="opacity-70"><?php echo e(translate('messages.destination_location')); ?></span> <span>:</span>
                                                    <span><?php echo e(translate('Dhanmondi 32 Road Bridge, Dhaka 1209, Bangladesh')); ?></span>
                                                </div>
                                            </td>
                                            <td class="email-template-table-td-max-width">
                                                <h3 class="subtitle"><?php echo e(translate('User_Info')); ?></h3>
                                                <span class="d-block"><?php echo e(translate('Munam_Shahariar')); ?></span>
                                                <span class="d-block" ><?php echo e(translate('xyz@gami.com')); ?></span>
                                            </td>
                                        </tr>
                                        <td colspan="4">
                                            <table class="w-100">
                                                <thead class="bg-section-2">
                                                    <tr>
                                                        <th class="text-left p-1 px-3"><?php echo e(translate('#')); ?></th>
                                                        <th class="text-left p-1 px-3"><?php echo e(translate('Vehicle')); ?></th>
                                                        <th class="text-left p-1 px-3"><?php echo e(translate('Hour/Km/Day')); ?></th>
                                                        <th class="text-right p-1 px-3"><?php echo e(translate('Fare')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <tr>
                                                        <td class="text-left p-1 px-3">
                                                            1
                                                        </td>
                                                        <td class="text-left p-2 px-3">
                                                            <?php echo e(translate('1.ABC_x_1')); ?>

                                                        </td>
                                                        <td class="text-left p-2 px-3">
                                                            <?php echo e(translate('$ 20.00 x 2 Hrs')); ?>

                                                        </td>
                                                        <td class="text-right p-2 px-3">
                                                            <h4>
                                                            <?php echo e(translate('$5,465')); ?>

                                                            </h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left p-1 px-3">
                                                            2
                                                        </td>
                                                        <td class="text-left p-2 px-3">
                                                            <?php echo e(translate('2.XYZ_x_1')); ?>

                                                        </td>
                                                        <td class="text-left p-2 px-3">
                                                            <?php echo e(translate('$ 44.00 x 2 Hrs')); ?>

                                                        </td>
                                                        <td class="text-right p-2 px-3">
                                                            <h4>
                                                            <?php echo e(translate('$354')); ?>

                                                            </h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                            <hr class="mt-0">
                                                            <table class="w-100">
                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3"><?php echo e(translate('Price')); ?></td>
                                                                    <td class="text-right p-1 px-3"><?php echo e(translate('$85')); ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3"><?php echo e(translate('Sub_total')); ?></td>
                                                                    <td class="text-right p-1 px-3"><?php echo e(translate('$90')); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3"><?php echo e(translate('Discount')); ?></td>
                                                                    <td class="text-right p-1 px-3"><?php echo e(translate('$10')); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3"><?php echo e(translate('Coupon_Discount')); ?></td>
                                                                    <td class="text-right p-1 px-3"><?php echo e(translate('$00')); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3"><?php echo e(translate('VAT_/_Tax')); ?></td>
                                                                    <td class="text-right p-1 px-3"><?php echo e(translate('$15')); ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3">
                                                                        <h4><?php echo e(translate('Total')); ?></h4>
                                                                    </td>
                                                                    <td class="text-right p-1 px-3">
                                                                        <span class="text-base"><?php echo e(translate('1$05')); ?></span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/business-settings/email-format-setting/templates/email-format-3.blade.php ENDPATH**/ ?>