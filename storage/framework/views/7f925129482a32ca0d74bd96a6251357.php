<?php
$company_name = App\Models\BusinessSetting::where('key', 'business_name')->first()->value;
?>
<table class="main-table">
    <tbody>
        <tr>
            <td class="main-table-td">
                <h2 class="mb-3" id="mail-title"><?php echo e($data['title']?? translate('Main_Title_or_Subject_of_the_Mail')); ?></h2>
                <div class="mb-1" id="mail-body"><?php echo $data['body']?? translate('Hi_Sabrina,'); ?></div>
                <table class="bg-section p-10 w-100">
                    <tbody>
                        <tr>
                            <td class="p-10">
                                <span class="d-block text-center">
                                    <?php ($restaurant_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                                    <img class="mb-2 mail-img-2 onerror-image" data-onerror-image="<?php echo e(asset('storage/app/public/business/' . $restaurant_logo)); ?>"

                                    src="<?php echo e($data?->logo ? $data->logo_full_url : \App\CentralLogics\Helpers::get_full_url('business',$restaurant_logo?->value,$restaurant_logo?->storage[0]?->value ?? 'public', 'favicon')); ?>"

                                    id="logoViewer" alt="">
                                    <h3 class="mb-3 mt-0"><?php echo e(translate('Order_Info')); ?></h3>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="order-table w-100">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h3 class="subtitle"><?php echo e(translate('Order_Summary')); ?></h3>
                                                <span class="d-block"><?php echo e(translate('Order')); ?><?php echo e(translate('#_48573')); ?></span>
                                                <span class="d-block"><?php echo e(translate('23 Jul, 2023 4:30 am')); ?></span>
                                            </td>
                                            <td class="email-template-09-max-width">
                                                <h3 class="subtitle"><?php echo e(translate('Delivery_Address')); ?></h3>
                                                <span class="d-block"><?php echo e(translate('Munam_Shahariar')); ?></span>
                                                <span class="d-block" ><?php echo e(translate('4517_Washington_Ave._Manchester,_Kentucky_39495')); ?></span>
                                            </td>
                                        </tr>
                                        <td colspan="2">
                                            <table class="w-100">
                                                <thead class="bg-section-2">
                                                    <tr>
                                                        <th class="text-left p-1 px-3"><?php echo e(translate('Product')); ?></th>
                                                        <th class="text-right p-1 px-3"><?php echo e(translate('Price')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-left p-2 px-3">
                                                            <?php echo e(translate('1._The_school_of_life_-_emotional_baggage_tote_bag_-_canvas_tote_bag_(navy)_x_1')); ?>

                                                        </td>
                                                        <td class="text-right p-2 px-3">
                                                            <h4>
                                                                <?php echo e(translate('$5,465')); ?>

                                                            </h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left p-2 px-3">
                                                            <?php echo e(translate('2._3USB_Head_Phone_x_1')); ?>

                                                        </td>
                                                        <td class="text-right p-2 px-3">
                                                            <h4>
                                                                <?php echo e(translate('$354')); ?>

                                                            </h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <hr class="mt-0">
                                                            <table class="w-100">
                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3"><?php echo e(translate('Item_Price')); ?></td>
                                                                    <td class="text-right p-1 px-3"><?php echo e(translate('$85')); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3"><?php echo e(translate('Addon')); ?></td>
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
                                                                    <td class="p-1 px-3"><?php echo e(translate('Delivery_Charge')); ?></td>
                                                                    <td class="text-right p-1 px-3"><?php echo e(translate('$20')); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="email-template-table-td-width"></td>
                                                                    <td class="p-1 px-3">
                                                                        <h4><?php echo e(translate('Total')); ?></h4>
                                                                    </td>
                                                                    <td class="text-right p-1 px-3">
                                                                        <span class="text-base"><?php echo e(translate('$105')); ?></span>
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
                    <a href="" id="facebook-check"  class="email-template-social-media"  style="<?php echo e((isset($data['facebook']) && $data['facebook'] == 1)?'':'display:none;'); ?>">
                        <img src="<?php echo e(asset('/public/assets/admin/img/img/facebook.png')); ?>" alt="">
                    </a>
                    <a href="" id="instagram-check"  class="email-template-social-media"  style="<?php echo e((isset($data['instagram']) && $data['instagram'] == 1)?'':'display:none;'); ?>">
                        <img src="<?php echo e(asset('/public/assets/admin/img/img/instagram.png')); ?>" alt="">
                    </a>
                    <a href="" id="twitter-check"  class="email-template-social-media"  style="<?php echo e((isset($data['twitter']) && $data['twitter'] == 1)?'':'display:none;'); ?>">
                        <img src="<?php echo e(asset('/public/assets/admin/img/img/twitter.png')); ?>" alt="">
                    </a>
                    <a href="" id="linkedin-check"  class="email-template-social-media"  style="<?php echo e((isset($data['linkedin']) && $data['linkedin'] == 1)?'':'display:none;'); ?>">
                        <img src="<?php echo e(asset('/public/assets/admin/img/img/linkedin.png')); ?>" alt="">
                    </a>
                    <a href="" id="pinterest-check"  class="email-template-social-media"  style="<?php echo e((isset($data['pinterest']) && $data['pinterest'] == 1)?'':'display:none;'); ?>">
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/email-format-setting/templates/email-format-9.blade.php ENDPATH**/ ?>