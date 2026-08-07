<?php $__env->startSection('title',translate('messages.Subscriber_List')); ?>

<?php $__env->startSection('subscriberList'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-2">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-start">
                        <img src="<?php echo e(asset('/public/assets/admin/img/store.png')); ?>" width="24" alt="img">
                        <div class="w-0 flex-grow pl-2">
                            <h1 class="page-header-title"><?php echo e(translate('Subscribed Store List')); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="min--200">
                    <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id" id="zone">
                        <option value="all"><?php echo e(translate('All Zones')); ?></option>
                        <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($z['id']); ?>" <?php echo e(request()?->zone_id == $z['id']?'selected':''); ?>>
                                <?php echo e(($z['name'])); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-20">
            <div class="row g-3">
                <div class="col-sm-6 col-lg-3">
                    <a class="__card-2 __bg-1" href="#">
                        <h4 class="title text--title"><?php echo e($data['total_subscribed_user']); ?></h4>
                        <span class="subtitle"><?php echo e(translate('Total_Subscribed_User')); ?></span>
                        <img src="<?php echo e(asset('public/assets/admin/img/subscription-plan/subscribed-user.png')); ?>" alt="report/new" class="card-icon" width="35px">
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a class="__card-2 __bg-3" href="#">
                        <h4 class="title text--title"><?php echo e($data['active_subscription']); ?></h4>
                        <span class="subtitle"><?php echo e(translate('Active_Subscriptions')); ?></span>
                        <img src="<?php echo e(asset('public/assets/admin/img/subscription-plan/active-user.png')); ?>" alt="report/new" class="card-icon" width="35px">
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a class="__card-2 __bg-6" href="#">
                        <h4 class="title text--title"><?php echo e($data['expired_subscription']); ?></h4>
                        <span class="subtitle"><?php echo e(translate('Expired_Subscription')); ?></span>
                        <img src="<?php echo e(asset('public/assets/admin/img/subscription-plan/expired-user.png')); ?>" alt="report/new" class="card-icon" width="35px">
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a class="__card-2 __bg-4" href="#">
                        <h4 class="title text--title"><?php echo e($data['expired_soon']); ?></h4>
                        <span class="subtitle"><?php echo e(translate('Expiring_Soon')); ?> </span>
                        <img src="<?php echo e(asset('public/assets/admin/img/subscription-plan/expired-soon.png')); ?>" alt="report/new" class="card-icon" width="35px">
                    </a>
                </div>
            </div>
        </div>
        <ul class="transaction--information text-uppercase">
            <li class="text--info">
                <i class="tio-document-text-outlined"></i>
                <div>
                    <span> <?php echo e(translate('Total_transactions')); ?> </span> <strong> <?php echo e($data['total_transactions']); ?></strong>
                </div>
            </li>
            <li class="seperator"></li>
            <li class="text--success">
                <i class="tio-checkmark-circle-outlined success--icon"></i>
                <div>
                    <span> <?php echo e(translate('Total_earning')); ?> </span> <strong> <?php echo e(\App\CentralLogics\Helpers::format_currency($data['total_paid_amount'])); ?></strong>
                </div>
            </li>
            <li class="seperator"></li>
            <li class="text--warning">
                <i class="tio-atm"></i>
                <div>
                    <span> <?php echo e(translate('EARNED_THIS_MONTH')); ?> </span> <strong> <?php echo e(\App\CentralLogics\Helpers::format_currency($data['current_month_paid_amount'])); ?></strong>
                </div>
            </li>
        </ul>
        <div class="card">
            <div class="card-header flex-wrap py-2 border-0">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h4 class="mb-0"><?php echo e(translate('Store_List')); ?></h4>
                    <span class="badge badge-soft-dark rounded-circle"><?php echo e($subscribers->total()); ?></span>
                </div>
                <div class="search--button-wrapper justify-content-end">
                    <div class="max-sm-flex-1">
                        <select   name="subscription_type"  data-url="<?php echo e(url()->full()); ?>" data-filter="subscription_type" class="custom-select h--40px py-0 status-filter set-filter" >
                            <option <?php echo e(request()?->subscription_type == 'all' ? 'selected' : ''); ?>  value="all">
                                <?php echo e(translate('all')); ?>

                            </option>
                            <option <?php echo e(request()?->subscription_type == 'active' ? 'selected' : ''); ?>  value="active">
                                <?php echo e(translate('active')); ?>

                            </option>
                            <option <?php echo e(request()?->subscription_type == 'expired' ? 'selected' : ''); ?>  value="expired">
                                <?php echo e(translate('expired')); ?>

                            </option>
                            <option <?php echo e(request()?->subscription_type == 'cancaled' ? 'selected' : ''); ?>  value="cancaled">
                                <?php echo e(translate('cancaled')); ?>

                            </option>
                            <option <?php echo e(request()?->subscription_type == 'free_trial' ? 'selected' : ''); ?>  value="free_trial">
                                <?php echo e(translate('Free_trial')); ?>

                            </option>

                        </select>
                    </div>
                    <form class="search-form">
                        <div class="input-group input--group">
                            <input name="search" type="search" value="<?php echo e(request()?->search); ?>" class="form-control h--40px" placeholder="<?php echo e(translate('Ex :Search by name & package name')); ?>" aria-label="Search here">
                            <button type="submit" class="btn btn--secondary h--40px"><i class="tio-search"></i></button>
                        </div>
                    </form>
                    <!-- Unfold -->
                    <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn font--sm"
                            href="javascript:;"
                            data-hs-unfold-options="{
                                &quot;target&quot;: &quot;#usersExportDropdown&quot;,
                                &quot;type&quot;: &quot;css-animation&quot;
                            }"
                            data-hs-unfold-target="#usersExportDropdown" data-hs-unfold-invoker="">
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right hs-unfold-content-initialized hs-unfold-css-animation animated hs-unfold-reverse-y hs-unfold-hidden">

                            <span class="dropdown-header"><?php echo e(translate('download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item"
                                href="<?php echo e(route('admin.business-settings.subscriptionackage.subscriberListExport', ['export_type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.business-settings.subscriptionackage.subscriberListExport', ['export_type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
                <!-- End Row -->
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless middle-align __txt-14px">
                        <thead class="thead-light white--space-false">
                            <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('sl')); ?></th>
                            <th class="border-top px-4 border-bottom"> <?php echo e(translate('Store Info')); ?>  </th>
                            <th class="border-top px-4 border-bottom"> <?php echo e(translate('Current Package Name')); ?> </th>
                            <th class="border-top px-4 border-bottom"> <?php echo e(translate('Package Price')); ?>  </th>
                            <th class="border-top px-4 border-bottom"> <?php echo e(translate('Exp Date')); ?>  </th>
                            <th class="border-top px-4 border-bottom text-center"> <?php echo e(translate('Total Subscription Used')); ?>  </th>
                            <th class="border-top px-4 border-bottom text-center"> <?php echo e(translate('is_trial')); ?>  </th>
                            <th class="border-top px-4 border-bottom text-center"> <?php echo e(translate('is_cancel')); ?>  </th>
                            <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('Status')); ?> </th>
                            <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('Action')); ?> </th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $subscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $subscriber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-4 text-center"><?php echo e($k + $subscribers->firstItem()); ?></td>
                                <td class="px-4">
                                    <a href="<?php echo e(route('admin.store.view', $subscriber->id)); ?>" alt="view restaurant" class="table-rest-info min--200">
                                        <img src="<?php echo e($subscriber->logo_full_url ?? asset('public/assets/admin/img/100x100/1.png')); ?>" >
                                        <div class="info">
                                            <span class="d-block text-title">
                                                <?php echo e($subscriber->name); ?><br>
                                                <?php ($user_rating = null); ?>
                                                <?php ($store_reviews = \App\CentralLogics\StoreLogic::calculate_store_rating($subscriber['rating'])); ?>
                                                <?php ($user_rating = $store_reviews['rating']); ?>
                                                <span class="rating text-star"><i class="tio-star"></i> <?php echo e(number_format($user_rating, 1)); ?></span>
                                            </span>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-4">
                                    <div><?php echo e($subscriber?->store_sub_update_application?->package?->package_name  ?? translate('Package_Not_Found!')); ?></div>
                                </td>
                                <td class="px-4">
                                    <div class="text-title"><?php echo e(\App\CentralLogics\Helpers::format_currency($subscriber?->store_sub_update_application?->package?->price)); ?></div>
                                </td>
                                <td class="px-4">
                                    <div class="text-title"><?php echo e(\App\CentralLogics\Helpers::date_format($subscriber?->store_sub_update_application?->expiry_date_parsed)); ?></div>
                                </td>
                                <td class="px-4">
                                    <div class="text-title pl-3"><?php echo e($subscriber?->store_all_sub_trans_count); ?></div>
                                </td>

                                <td class="px-4">
                                    <div class="text-title pl-3">
                                        <?php if($subscriber?->store_sub_update_application?->is_trial): ?>
                                        <span class="badge badge-pill badge-info"><?php echo e(translate('Yes')); ?></span>

                                        <?php else: ?>
                                        <span class="badge badge-pill badge-success"><?php echo e(translate('No')); ?></span>
                                        <?php endif; ?>

                                </div>
                                <td class="px-4">
                                    <div class="text-title pl-3">
                                        <?php if($subscriber?->store_sub_update_application?->is_canceled): ?>
                                        <span class="badge badge-pill badge-warning"><?php echo e(translate('Yes')); ?></span>

                                        <?php else: ?>
                                        <span class="badge badge-pill badge-success"><?php echo e(translate('No')); ?></span>
                                        <?php endif; ?>

                                </div>
                                </td>
                                <td class="px-4 text-center">
                                    <div>
                                        <?php if($subscriber?->status == 0 &&  $subscriber?->vendor?->status == 0): ?>
                                        <span class="badge badge-soft-info"><?php echo e(translate('Approval_Pending')); ?></span>
                                        
                                        <?php elseif($subscriber?->store_sub_update_application?->status == 0): ?>
                                        <span class="badge badge-soft-danger"><?php echo e(translate('Expired')); ?></span>
                                        <?php elseif($subscriber?->store_sub_update_application?->status == 1): ?>
                                        <span class="badge badge-soft-success"><?php echo e(translate('Active')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--warning btn-outline-warning" href="<?php echo e(route('admin.business-settings.subscriptionackage.subscriberDetail',$subscriber->id)); ?>">
                                            <i class="tio-invisible"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if(count($subscribers) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $subscribers->withQueryString()->links(); ?>

                </div>
                <?php if(count($subscribers) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/subscription/subscriber/list.blade.php ENDPATH**/ ?>