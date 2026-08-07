<div class="footer">
    <div class="row justify-content-sm-between justify-content-center align-items-center">
        <div class="col text-md-start">
            <p class="font-size-sm mb-0">
                &copy; <?php echo e(\App\CentralLogics\Helpers::get_business_settings('business_name')); ?>. <span
                    class="d-none d-sm-inline-block"><?php echo e(\App\CentralLogics\Helpers::get_business_settings('footer_text')); ?></span>
            </p>
        </div>
        <div class="col-auto">
            <div class="d-flex justify-content-end">
                <!-- List Dot -->
                <ul class="list-inline list-separator">
                    <li class="list-inline-item">
                        <a class="list-separator-link" href="<?php echo e(route('admin.business-settings.business-setup')); ?>"><?php echo e(translate('messages.business_setup')); ?></a>
                    </li>

                    <li class="list-inline-item">
                        <a class="list-separator-link" href="<?php echo e(route('admin.settings')); ?>"><?php echo e(translate('messages.profile')); ?></a>
                    </li>

                    <li class="list-inline-item">
                        <!-- Keyboard Shortcuts Toggle -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker h-unset btn btn-icon btn-ghost-secondary rounded-circle"
                               href="<?php echo e(route('admin.dashboard')); ?>">
                                <?php echo e(translate('messages.home')); ?>

                            </a>
                        </div>
                        <!-- End Keyboard Shortcuts Toggle -->
                    </li>
                    <li class="list-inline-item">
                        <label class="badge badge-soft-primary m-0">
                            <?php echo e(translate('messages.software_version')); ?> : <?php echo e(env('SOFTWARE_VERSION')); ?>

                        </label>
                    </li>
                </ul>
                <!-- End List Dot -->
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/layouts/admin/partials/_footer.blade.php ENDPATH**/ ?>