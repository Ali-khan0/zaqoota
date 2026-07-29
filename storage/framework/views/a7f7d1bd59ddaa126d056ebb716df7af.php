
<?php if($deliveryMan->application_status == 'approved'): ?>

<div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
    <!-- Nav -->
    <ul class="nav nav-tabs mb-3 border-0 nav--tabs">
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()?->tab == 'info' ||  !request()?->tab ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.users.delivery-man.preview', ['id' => $deliveryMan->id, 'tab' => 'info'])); ?>"
                aria-disabled="true"><?php echo e(translate('messages.info')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()?->tab == 'transaction' ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.users.delivery-man.preview', ['id' => $deliveryMan->id, 'tab' => 'transaction'])); ?>"
                aria-disabled="true"><?php echo e(translate('messages.transaction')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()?->tab == 'order_list' ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.users.delivery-man.preview', ['id' => $deliveryMan->id, 'tab' => 'order_list'])); ?>"
                aria-disabled="true"><?php echo e(translate('messages.order_list')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()?->tab == 'conversation' ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.users.delivery-man.preview', ['id' => $deliveryMan->id, 'tab' => 'conversation'])); ?>"
                aria-disabled="true"><?php echo e(translate('messages.conversations')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()?->tab == 'disbursement' ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.users.delivery-man.preview', ['id' => $deliveryMan->id, 'tab' => 'disbursement'])); ?>"
                aria-disabled="true"><?php echo e(translate('messages.disbursements')); ?></a>
        </li>
    </ul>
    <!-- End Nav -->
</div>
<?php endif; ?>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/delivery-man/partials/_tab_menu.blade.php ENDPATH**/ ?>