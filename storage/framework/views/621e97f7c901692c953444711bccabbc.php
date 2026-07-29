<?php $__env->startSection('title',translate('messages.disbursement')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('/public/assets/admin/img/report/new/disburstment.png')); ?>" class="w--22" alt="">
            </span>
            <span><?php echo e(translate('Deliveryman_Disbursement')); ?></span>
        </h1>
        <ul class="nav nav-tabs mb-4 border-0 pt-2">
            <li class="nav-item">
                <a class="nav-link <?php echo e($status == 'all'?'active':''); ?>" href="<?php echo e(route('admin.transactions.dm-disbursement.list', ['status' => 'all'])); ?>" ><?php echo e(translate('all')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status == 'pending'?'active':''); ?>" href="<?php echo e(route('admin.transactions.dm-disbursement.list', ['status' => 'pending'])); ?>"><?php echo e(translate('pending')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status == 'processing'?'active':''); ?>" href="<?php echo e(route('admin.transactions.dm-disbursement.list', ['status' => 'processing'])); ?>"><?php echo e(translate('processing')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status == 'completed'?'active':''); ?>" href="<?php echo e(route('admin.transactions.dm-disbursement.list', ['status' => 'completed'])); ?>"><?php echo e(translate('completed')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status == 'partially_completed'?'active':''); ?>" href="<?php echo e(route('admin.transactions.dm-disbursement.list', ['status' => 'partially_completed'])); ?>"><?php echo e(translate('partially_completed')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e($status == 'canceled'?'active':''); ?>" href="<?php echo e(route('admin.transactions.dm-disbursement.list', ['status' => 'canceled'])); ?>"><?php echo e(translate('canceled')); ?></a>
            </li>
        </ul>
    </div>
    <!-- Reports -->
    <div class="d-flex flex-column gap-2">
        <?php $__currentLoopData = $disbursements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disbursement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <div class="card-header border-0 flex-wrap justify-content-between gap-4">
                    <div class="left">
                        <h3 class="m-0 font-bold"><?php echo e($disbursement->title); ?>

                            <?php if($disbursement->status=='pending'): ?>
                                <label class="badge badge-soft-primary"><?php echo e(translate('pending')); ?></label>
                            <?php elseif($disbursement->status=='completed'): ?>
                                <label class="badge badge-soft-success"><?php echo e(translate('Completed')); ?></label>
                            <?php elseif($disbursement->status=='partially_completed'): ?>
                                <label class="badge badge-soft-info"><?php echo e(translate('partially_completed')); ?></label>
                            <?php else: ?>
                                <label class="badge badge-soft-danger"><?php echo e(translate('canceled')); ?></label>
                            <?php endif; ?>
                        </h3>
                        <span><?php echo e(translate('created_at')); ?> <?php echo e(\App\CentralLogics\Helpers::time_date_format($disbursement->created_at)); ?></span>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <div class="d-flex flex-wrap align-items-center mr-2">
                            <span><?php echo e(translate('total_amount')); ?></span> <span class="mx-2">:</span> <h3 class="m-0"><?php echo e(\App\CentralLogics\Helpers::format_currency($disbursement['total_amount'])); ?></h3>
                        </div>
                        <div>
                            <a href="<?php echo e(route('admin.transactions.dm-disbursement.view', ['id' => $disbursement->id])); ?>" class="btn btn--primary"><?php echo e(translate('view_details')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if(count($disbursements) === 0): ?>
          
                <div class="empty--data">
                     <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
    </div>
    <div class="page-area px-4 pb-3">
        <div class="d-flex align-items-center justify-content-end">
            <div>
                <?php echo $disbursements->links(); ?>

            </div>
        </div>
    </div>

</div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/dm-disbursement/index.blade.php ENDPATH**/ ?>