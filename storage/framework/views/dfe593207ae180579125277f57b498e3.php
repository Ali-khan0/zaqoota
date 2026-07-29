 <div class="modal-body">
     <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-15">
         <div>
             <h3 class="title-clr mb-0"><?php echo e($coupon['title']); ?>

                 <?php echo e(in_array($coupon['coupon_type'], ['free_delivery']) ? translate('messages.Free Delivery') : ($coupon['discount_type'] == 'amount' ? '(' . \App\CentralLogics\Helpers::format_currency($coupon['discount']) . ')' : '(' . $coupon['discount'] . '%)')); ?>

             </h3>
             <div class="d-flex align-items-center gap-1">
                 <span class="fs-14"><?php echo e(translate('Duration:')); ?></span>
                 <p class="fs-14 m-0 text-title">
                     <?php echo e(\App\CentralLogics\Helpers::date_format($coupon['start_date']) . ' - ' . \App\CentralLogics\Helpers::date_format($coupon['expire_date'])); ?>

                 </p>
             </div>
         </div>

         <?php if(!in_array($coupon['coupon_type'], ['free_delivery'])): ?>
             <div class="bg-warning-10 py-2 px-3 rounded text-center">
                 <h2 class="mb-0 text_FF7500">
                     <?php echo e($coupon['discount_type'] == 'amount' ? \App\CentralLogics\Helpers::format_currency($coupon['discount']) : $coupon['discount'] . '%'); ?>

                 </h2>
                 <p class="fs-16 text_FF7500 m-0"><?php echo e(translate('Discount')); ?></p>
             </div>
         <?php endif; ?>
     </div>
     <!-- <ul class="coupon-details-list d-flex flex-wrap bg-light rounded p-3 mb-3">
         <li class="d-flex flex-sm-nowrap flex-wrap list-none li align-items-center gap-1">
             <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('messages.coupon_type')); ?> </span>
             <span>:</span>
             <span class="fs-14 text-title"><?php echo e(translate($coupon['coupon_type'])); ?></span>
         </li>
         <?php if($coupon['coupon_type'] == 'store_wise'): ?>
             <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                 <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Selected Store')); ?> </span>
                 <span>:</span>
                 <span class="fs-14 text-title"><?php echo e($coupon?->store?->name); ?></span>
             </li>
         <?php elseif(count($zoneData) > 0): ?>
             <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                 <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Selected Zones')); ?> </span>
                 <span>:</span>
                 <span class="fs-14 text-title">
                     <?php $__currentLoopData = $zoneData ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php echo e($zone->name); ?> <?php echo e(!$loop->last ? ',' : ''); ?>

                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </span>
             </li>


         <?php endif; ?>

         <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
             <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Limit for same user')); ?> </span>
             <span>:</span>
             <span class="fs-14 text-title"><?php echo e($coupon['limit']); ?></span>
         </li>
         <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
             <span
                 class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Max discount')); ?>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
             </span>
             <span>:</span>
             <span
                 class="fs-14 text-title"><?php echo e(\App\CentralLogics\Helpers::format_currency($coupon['max_discount'])); ?></span>
         </li>
         <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
             <span
                 class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Min purchase')); ?>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
             </span>
             <span>:</span>
             <span
                 class="fs-14 text-title"><?php echo e(\App\CentralLogics\Helpers::format_currency($coupon['min_purchase'])); ?></span>
         </li>
         <li class="d-flex flex-sm-nowrap flex-wrap list-none gap-1">
             <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('selected customer')); ?> </span>
             <span>:</span>
             <span class="fs-14 text-title">
                 <?php if($selectedCustomers == 'all'): ?>
                     <?php echo e(translate('All customers')); ?>

                 <?php else: ?>
                     <?php $__empty_1 = true; $__currentLoopData = $selectedCustomers??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                         <?php echo e($customer->f_name); ?> <?php echo e($customer->l_name); ?> <?php echo e(!$loop->last ? ',' : ''); ?>

                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                         <?php echo e(translate('All customers')); ?>

                     <?php endif; ?>
                 <?php endif; ?>
             </span>
         </li>
     </ul> -->
     <ul class="coupon-details-list d-flex flex-md-nowrap flex-wrap bg-light rounded p-3 mb-3">
        <div class="d-flex flex-column gap-2">
            <li class="d-flex flex-sm-nowrap flex-wrap list-none li align-items-center gap-1">
                <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('messages.coupon_type')); ?> </span>
                <span>:</span>
                <span class="fs-14 text-title"><?php echo e(translate($coupon['coupon_type'])); ?></span>
            </li>
            <?php if($coupon['coupon_type'] == 'store_wise'): ?>
                <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                    <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Selected Store')); ?> </span>
                    <span>:</span>
                    <span class="fs-14 text-title"><?php echo e($coupon?->store?->name); ?></span>
                </li>
            <?php elseif(count($zoneData) > 0): ?>
                <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                    <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Selected Zones')); ?> </span>
                    <span>:</span>
                    <span class="fs-14 text-title">
                        <?php $__currentLoopData = $zoneData ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($zone->name); ?> <?php echo e(!$loop->last ? ',' : ''); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </span>
                </li>
   
   
            <?php endif; ?>
   
            <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Limit for same user')); ?> </span>
                <span>:</span>
                <span class="fs-14 text-title"><?php echo e($coupon['limit']); ?></span>
            </li>
        </div>
        <div class="d-flex flex-column gap-2">
            <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                <span
                    class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Max discount')); ?>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                </span>
                <span>:</span>
                <span
                    class="fs-14 text-title"><?php echo e(\App\CentralLogics\Helpers::format_currency($coupon['max_discount'])); ?></span>
            </li>
            <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                <span
                    class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('Min purchase')); ?>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                </span>
                <span>:</span>
                <span
                    class="fs-14 text-title"><?php echo e(\App\CentralLogics\Helpers::format_currency($coupon['min_purchase'])); ?></span>
            </li>
            <li class="d-flex flex-sm-nowrap flex-wrap list-none gap-1">
                <span class="fs-14 w-135px d-block min-w-135px"><?php echo e(translate('selected customer')); ?> </span>
                <span>:</span>
                <span class="fs-14 text-title">
                    <?php if($selectedCustomers == 'all'): ?>
                        <?php echo e(translate('All customers')); ?>

                    <?php else: ?>
                        <?php $__empty_1 = true; $__currentLoopData = $selectedCustomers??[]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php echo e($customer->f_name); ?> <?php echo e($customer->l_name); ?> <?php echo e(!$loop->last ? ',' : ''); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo e(translate('All customers')); ?>

                        <?php endif; ?>
                    <?php endif; ?>
                </span>
            </li>
        </div>
     </ul>
     <div class="bg-light rounded p-3">
         <h5 class="title-clr mb-15"><?php echo e(translate('messages.Coupon Code')); ?></h5>
         <div class="custom-copy-text position-relative h--45px w-100 rounded overflow-hidden">
             <input type="text" id="coupon_code" class="text-inside form-control rounded-0 pe-30"
                 value="<?php echo e($coupon['code']); ?>" />
             <span data-id="coupon_code"
                 class="copy-btn copy-to-clipboard bg-primary text-white d-flex align-items-center justify-content-center w-40px h--45px position-absolute end-cus-0 top-50 cursor-pointer text-primary"><i
                     class="tio-copy text-white"></i></span>
         </div>
     </div>
 </div>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/coupon/_view.blade.php ENDPATH**/ ?>