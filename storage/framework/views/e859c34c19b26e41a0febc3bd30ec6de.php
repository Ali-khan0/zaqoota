   <li class="__sidebar-hs-unfold px-2" id="tourb-9">
                    <div class="hs-unfold w-100">
                        <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#accountNavbarDropdown",
                                    "type": "css-animation"
                                }'>
                            <div class="cmn--media right-dropdown-icon d-flex align-items-center">
                                <div class="avatar avatar-sm avatar-circle">
                                   <img class="avatar-img onerror-image"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"

                                    src="<?php echo e(auth('admin')->user()?->toArray()['image_full_url']); ?>"

                                    alt="Image Description">
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                                <div class="media-body pl-3">
                                    <span class="card-title h5">
                                        <?php echo e(auth('admin')->user()->full_name); ?>

                                    </span>
                                    <span class="card-text"><?php echo e(Str::limit(auth('admin')->user()->email, 15, '...')); ?></span>
                                </div>
                            </div>
                        </a>

                        <div id="accountNavbarDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account min--240">
                            <div class="dropdown-item-text">
                                <div class="media align-items-center">
                                    <div class="avatar avatar-sm avatar-circle mr-2">
                                        <img class="avatar-img onerror-image"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"

                                    src="<?php echo e(auth('admin')->user()?->toArray()['image_full_url']); ?>"

                                    alt="Image Description">
                                    </div>
                                    <div class="media-body">
                                        <span class="card-title h5"><?php echo e(auth('admin')->user()->full_name); ?></span>
                                        <span class="card-text"><?php echo e(Str::limit(auth('admin')->user()->email, 15, '...')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="<?php echo e(route('admin.settings')); ?>">
                                <span class="text-truncate pr-2" title="Settings"><?php echo e(translate('messages.settings')); ?></span>
                            </a>

                            <div class="dropdown-divider"></div>

                           <a class="dropdown-item log-out" href="javascript:">
                                <span class="text-truncate pr-2" title="Sign out"><?php echo e(translate('messages.sign_out')); ?></span>
                            </a>
                        </div>
                    </div>
                </li>
<?php /**PATH /var/www/zaqoota/resources/views/layouts/admin/partials/_logout_modal.blade.php ENDPATH**/ ?>