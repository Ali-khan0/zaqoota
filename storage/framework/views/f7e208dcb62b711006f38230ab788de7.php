<div>
    <select id="rental-mail-route-selector" class="custom-select w-auto min-width-170px">
        <option value="admin" <?php echo e(Request::is('admin/business-settings/rental-email-setup/admin*') ? 'selected' : ''); ?>><a href="#"><?php echo e(translate('Admin_Mail_Templates')); ?></a></option>
        <option value="provider" <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider*') ? 'selected' : ''); ?>><a href="#"><?php echo e(translate('Provider_Mail_Templates')); ?></a></option>
        <option value="user" <?php echo e(Request::is('admin/business-settings/rental-email-setup/user*') ? 'selected' : ''); ?>><a href="#"><?php echo e(translate('Customer_Mail_Templates')); ?></a></option>
    </select>
    <div class="d-flex justify-content-end mt-2">
        <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button"   id="see-how-it-works"  >
            <strong class="mr-2"><?php echo e(translate('See_how_it_works!')); ?></strong>
            <div>
                <i class="tio-info-outined"></i>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/business-settings/email-format-setting/partials/email-template-options.blade.php ENDPATH**/ ?>