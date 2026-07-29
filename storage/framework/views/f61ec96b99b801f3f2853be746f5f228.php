<div class="modal fade" id="modalForTwitterPixel" tabindex="-1" aria-labelledby="modalForTwitterPixel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered max-w-655px">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                <button type="button" class="close border-0 btn-circle bg-section2 shadow-none" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-20 py-0 mb-30">
                <div class="swiper instruction-carousel pb-3">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="swiper-slide">
                                <div class="">
                                    <div class="d-flex justify-content-center mb-5">
                                        <img height="60"
                                            src="<?php echo e(asset('public/assets/admin/img/svg/twitter.svg')); ?>"
                                            loading="lazy" alt="">
                                    </div>
                                    <div class="text-dark mb-3">
                                        <h3 class="lh-base">
                                            <?php echo e(translate('how_to_get_the_x_(twitter)_pixel_id')); ?>

                                        </h3>
                                        <p class="opacity-75">
                                            <?php echo e(translate('to_get_your_x_(twitter)_pixel_id,_log_in_to_your_twitter_ads_account.')); ?>

                                            <?php echo e(translate('from_the_top_navigation,_click_on_tools_and_select_events_manager.')); ?>

                                            <?php echo e(translate('once_in_the_events_manager,_create_your_pixel_id_by_clicking_on_add_event_source.')); ?>

                                            <?php echo e(translate('choose_the_install_with_pixel_code_option_and_press_save.')); ?>

                                            <?php echo e(translate('your_pixel_id_will_then_be_generated,_and_you_can_copy_it_from_the_interface.')); ?>

                                        </p>
                                    </div>

                                    <div class="text-dark mb-3">
                                        <h3 class="lh-base">
                                            <?php echo e(translate('where_to_use_the_x_(twitter)_pixel_id')); ?>

                                        </h3>
                                        <p class="opacity-75">
                                            <?php echo e(translate('go_to_the_marketing_tools_section_in_your_admin_panel_and_complete_the_steps:')); ?>

                                        </p>
                                        <ol class="d-flex flex-column gap-2 opacity-75">
                                            <li>
                                                <?php echo e(translate('navigate_to_the_x_(twitter)_pixel_id_section_under_marketing_tools.')); ?>

                                            </li>
                                            <li>
                                                <?php echo e(translate('turn_on_the_toggle_button.')); ?>

                                            </li>
                                            <li>
                                                <?php echo e(translate('paste_your_x_(twitter)_pixel_id_into_the_input_box_and_click_submit.')); ?>

                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/analytics/_twitter-modal.blade.php ENDPATH**/ ?>