<?php $__env->startSection('title', translate('messages.transaction_report')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->

        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/report.png')); ?>" class="w--22" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.transection_report')); ?>

                    <?php if( $from && $to): ?>
                    <span class="mb-0 h6 badge badge-soft-success ml-2"
                        id="itemCount">( <?php echo e($from); ?> - <?php echo e($to); ?> )</span>
                        <?php endif; ?>
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card mb-20">
            <div class="card-body">
                <h4 class=""><?php echo e(translate('Search Data')); ?></h4>
                <form >
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <select name="module_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="module_id"
                                title="<?php echo e(translate('messages.select_modules')); ?>">
                                <option value="" <?php echo e(!request('module_id') ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.all_modules')); ?></option>
                                <?php $__currentLoopData = \App\Models\Module::notRental()->get(['id', 'module_name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($module->id); ?>"
                                        <?php echo e(request('module_id') == $module->id ? 'selected' : ''); ?>>
                                        <?php echo e($module['module_name']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id" id="zone">
                                <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                                <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(['id', 'name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($z['id']); ?>"
                                        <?php echo e(isset($zone) && $zone->id == $z['id'] ? 'selected' : ''); ?>>
                                        <?php echo e($z['name']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="store_id" data-url="<?php echo e(url()->full()); ?>" data-filter="store_id"
                                data-placeholder="<?php echo e(translate('messages.select_store')); ?>"
                                class="js-data-example-ajax form-control set-filter">
                                <?php if(isset($store)): ?>
                                    <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <select class="form-control set-filter" name="filter" data-url="<?php echo e(url()->full()); ?>" data-filter="filter">
                                <option value="all_time" <?php echo e(isset($filter) && $filter == 'all_time' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.All Time')); ?></option>
                                <option value="this_year" <?php echo e(isset($filter) && $filter == 'this_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Year')); ?></option>
                                <option value="previous_year"
                                    <?php echo e(isset($filter) && $filter == 'previous_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.Previous Year')); ?></option>
                                <option value="this_month"
                                    <?php echo e(isset($filter) && $filter == 'this_month' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Month')); ?></option>
                                <option value="this_week" <?php echo e(isset($filter) && $filter == 'this_week' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Week')); ?></option>
                                <option value="custom" <?php echo e(isset($filter) && $filter == 'custom' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.Custom')); ?></option>
                            </select>
                        </div>
                        <?php if(isset($filter) && $filter == 'custom'): ?>
                            <div class="col-sm-6 col-md-3">

                                <input type="date" name="from" id="from_date" class="form-control"
                                    placeholder="<?php echo e(translate('Start Date')); ?>" value="<?php echo e($from ?? ''); ?>" required>

                            </div>
                            <div class="col-sm-6 col-md-3">

                                <input type="date" name="to" id="to_date" class="form-control"
                                    placeholder="<?php echo e(translate('End Date')); ?>"
                                    value="<?php echo e($to ?? ''); ?>" required>

                            </div>
                        <?php endif; ?>
                        <div class="col-sm-6 col-md-3 ml-auto">
                            <button type="submit"
                                class="btn btn-primary btn-block h--45px"><?php echo e(translate('Filter')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
            $from = $from . ' 00:00:00';
            $to = $to  . ' 23:59:59';
            $total = \App\Models\Order::when(isset($zone), function ($query) use ($zone) {
                return $query->where('zone_id', $zone->id);
            })
            ->when(isset($key), function ($query) use ($key) {
                    return $query->where(function ($q) use ($key) {
                            foreach ($key as $value) {
                                $q->orWhere('id', 'like', "%{$value}%");
                            }
                        });
                })
                ->when(request('module_id'), function ($query) {
                    return $query->module(request('module_id'));
                })
                ->when(isset($store), function ($query) use ($store) {
                    return $query->where('store_id', $store->id);
                })
                ->when(isset($from) && isset($to) && $from != null && $to != null && $filter == 'custom', function ($query) use ($from, $to) {
                    return $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
                })
                ->when(isset($filter) && $filter == 'this_year', function ($query) {
                    return $query->whereYear('created_at', now()->format('Y'));
                })
                ->when(isset($filter) && $filter == 'this_month', function ($query) {
                    return $query->whereMonth('created_at', now()->format('m'))->whereYear('created_at', now()->format('Y'));
                })
                ->when(isset($filter) && $filter == 'this_month', function ($query) {
                    return $query->whereMonth('created_at', now()->format('m'))->whereYear('created_at', now()->format('Y'));
                })
                ->when(isset($filter) && $filter == 'previous_year', function ($query) {
                    return $query->whereYear('created_at', date('Y') - 1);
                })
                ->when(isset($filter) && $filter == 'this_week', function ($query) {
                    return $query->whereBetween('created_at', [
                        now()
                            ->startOfWeek()
                            ->format('Y-m-d H:i:s'),
                        now()
                            ->endOfWeek()
                            ->format('Y-m-d H:i:s'),
                    ]);
                })
                ->Notpos()
                ->count();
            if ($total == 0) {
                $total = 0.01;
            }
        ?>
        <div class="mb-20">
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <?php
                                $delivered = \App\Models\Order::when(isset($zone), function ($query) use ($zone) {
                                    return $query->where('zone_id', $zone->id);
                                })
                                ->when(isset($key), function ($query) use ($key) {
                                        return $query->where(function ($q) use ($key) {
                                                foreach ($key as $value) {
                                                    $q->orWhere('id', 'like', "%{$value}%");
                                                }
                                            });
                                    })
                                    ->when(request('module_id'), function ($query) {
                                        return $query->module(request('module_id'));
                                    })
                                    ->whereIn('order_status', ['delivered','refund_requested','refund_request_canceled'])
                                    ->when(isset($store), function ($query) use ($store) {
                                        return $query->where('store_id', $store->id);
                                    })
                                    ->when(isset($from) && isset($to) && $from != null && $to != null && $filter == 'custom', function ($query) use ($from, $to) {
                                        return $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
                                    })
                                    ->when(isset($filter) && $filter == 'this_year', function ($query) {
                                        return $query->whereYear('created_at', now()->format('Y'));
                                    })
                                    ->when(isset($filter) && $filter == 'this_month', function ($query) {
                                        return $query->whereMonth('created_at', now()->format('m'))->whereYear('created_at', now()->format('Y'));
                                    })
                                    ->when(isset($filter) && $filter == 'this_month', function ($query) {
                                        return $query->whereMonth('created_at', now()->format('m'))->whereYear('created_at', now()->format('Y'));
                                    })
                                    ->when(isset($filter) && $filter == 'previous_year', function ($query) {
                                        return $query->whereYear('created_at', date('Y') - 1);
                                    })
                                    ->when(isset($filter) && $filter == 'this_week', function ($query) {
                                        return $query->whereBetween('created_at', [
                                            now()
                                                ->startOfWeek()
                                                ->format('Y-m-d H:i:s'),
                                            now()
                                                ->endOfWeek()
                                                ->format('Y-m-d H:i:s'),
                                        ]);
                                    })
                                    ->Notpos()
                                    ->sum('order_amount');
                            ?>
                            <a class="__card-3 h-100" href="#">
                                <img src="<?php echo e(asset('/public/assets/admin/img/report/new/trx1.png')); ?>" class="icon"
                                    alt="report/new">
                                <h3 class="title text-008958"><?php echo e(\App\CentralLogics\Helpers::number_format_short($delivered)); ?>

                                </h3>
                                <h6 class="subtitle"><?php echo e(translate('Completed Transaction')); ?></h6>
                                <div class="info-icon" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?php echo e(translate('When the order is successfully delivered full order amount goes to this section.')); ?>">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/report/new/info1.png')); ?>"
                                        alt="report/new">
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <?php
                                $canceled = \App\Models\Order::when(isset($zone), function ($query) use ($zone) {
                                    return $query->where('zone_id', $zone->id);
                                })
                                ->when(isset($key), function ($query) use ($key) {
                                        return $query->where(function ($q) use ($key) {
                                                foreach ($key as $value) {
                                                    $q->orWhere('id', 'like', "%{$value}%");
                                                }
                                            });
                                    })
                                    ->when(request('module_id'), function ($query) {
                                        return $query->module(request('module_id'));
                                    })
                                    ->where(['order_status' => 'refunded'])
                                    ->when(isset($store), function ($query) use ($store) {
                                        return $query->where('store_id', $store->id);
                                    })
                                    ->when(isset($from) && isset($to) && $from != null && $to != null && $filter == 'custom', function ($query) use ($from, $to) {
                                        return $query->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
                                    })
                                    ->when(isset($filter) && $filter == 'this_year', function ($query) {
                                        return $query->whereYear('created_at', now()->format('Y'));
                                    })
                                    ->when(isset($filter) && $filter == 'this_month', function ($query) {
                                        return $query->whereMonth('created_at', now()->format('m'))->whereYear('created_at', now()->format('Y'));
                                    })
                                    ->when(isset($filter) && $filter == 'this_month', function ($query) {
                                        return $query->whereMonth('created_at', now()->format('m'))->whereYear('created_at', now()->format('Y'));
                                    })
                                    ->when(isset($filter) && $filter == 'previous_year', function ($query) {
                                        return $query->whereYear('created_at', date('Y') - 1);
                                    })
                                    ->when(isset($filter) && $filter == 'this_week', function ($query) {
                                        return $query->whereBetween('created_at', [
                                            now()
                                                ->startOfWeek()
                                                ->format('Y-m-d H:i:s'),
                                            now()
                                                ->endOfWeek()
                                                ->format('Y-m-d H:i:s'),
                                        ]);
                                    })
                                    ->Notpos()
                                    // ->sum(DB::raw('order_amount - original_delivery_charge'));
                                    ->sum(DB::raw('order_amount - delivery_charge - dm_tips'));
                            ?>
                            <a class="__card-3 h-100" href="#">
                                <img src="<?php echo e(asset('/public/assets/admin/img/report/new/trx3.png')); ?>" class="icon"
                                    alt="report/new">
                                <h3 class="title text-FF5A54"><?php echo e(\App\CentralLogics\Helpers::number_format_short($canceled)); ?>

                                </h3>
                                <h6 class="subtitle"><?php echo e(translate('Refunded Transaction')); ?></h6>
                                <div class="info-icon" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?php echo e(translate('If the order is successfully refunded, the full order amount goes to this section without the delivery fee and delivery tips.')); ?>">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/report/new/info3.png')); ?>"
                                        alt="report/new">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <div class="__card-vertical">
                                <div class="__card-vertical-img">
                                    <img class="img"
                                        src="<?php echo e(asset('/public/assets/admin/img/report/new/admin-earning.png')); ?>"
                                        alt="">
                                    <h4 class="name"><?php echo e(translate('Admin Earning')); ?></h4>
                                    <div class="info-icon" data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('Deducting the admin discount from the admin earning amount and goes to this section.')); ?>">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/report/new/info1.png')); ?>"
                                            alt="report/new">
                                    </div>
                                </div>
                                <h4 class="earning text-0661CB">
                                    <?php echo e(\App\CentralLogics\Helpers::number_format_short($admin_earned)); ?></h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="__card-vertical">
                                <div class="__card-vertical-img">
                                    <img class="img"
                                        src="<?php echo e(asset('/public/assets/admin/img/report/new/store-earning.png')); ?>"
                                        alt="">
                                    <h4 class="name"><?php echo e(translate('Store Earning')); ?></h4>
                                    <div class="info-icon" data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('Adding_store_earning_amount_with_vat/tax_amount')); ?>">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/report/new/info2.png')); ?>"
                                            alt="report/new">
                                    </div>
                                </div>
                                <h4 class="earning text-00AA6D">
                                    <?php echo e(\App\CentralLogics\Helpers::number_format_short($store_earned)); ?></h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="__card-vertical">
                                <div class="__card-vertical-img">
                                    <img class="img"
                                        src="<?php echo e(asset('/public/assets/admin/img/report/new/deliveryman-earning.png')); ?>"
                                        alt="">
                                    <h4 class="name"><?php echo e(translate('Deliveryman Earning')); ?></h4>
                                    <div class="info-icon" data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('Deducting the admin commission on the delivery fee, the delivery fee & tips amount goes to earning section.')); ?>">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/report/new/info3.png')); ?>"
                                            alt="report/new">
                                    </div>
                                </div>
                                <h4 class="earning text-FF7500">
                                    <?php echo e(\App\CentralLogics\Helpers::number_format_short($deliveryman_earned)); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Stats -->
        <!-- Card -->
        <div class="card mt-3">
            <!-- Header -->
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h3 class="card-title">
                        <?php echo e(translate('messages.order_transactions')); ?> <span
                            class="badge badge-soft-secondary" id="countItems"><?php echo e($order_transactions->total()); ?></span>
                    </h3>
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input--group input-group input-group-merge input-group-flush">
                            <input class="form-control" placeholder="<?php echo e(translate('Search by Order ID')); ?>" value="<?php echo e(request()?->search ?? null); ?>" name="search">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <!-- Static Export Button -->
                    <div class="hs-unfold ml-3">
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
                                href="<?php echo e(route('admin.transactions.report.day-wise-report-export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.report.day-wise-report-export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- Static Export Button -->
                </div>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable" class="table table-thead-bordered table-align-middle card-table">
                        <thead class="thead-light text-nowrap">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.order_id')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.store')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.customer_name')); ?></th>
                                <th class="border-0 min-w-120"><?php echo e(translate('messages.total_item_amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.item_discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.coupon_discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.referral_discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.discounted_amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.vat/tax')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.delivery_charge')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.order_amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.admin_discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.store_discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.admin_commission')); ?></th>
                                <th class="border-0"><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.extra_packaging_amount')); ?></th>
                                <th class="min-w-140 text-capitalize"><?php echo e(translate('commision_on_delivery_charge')); ?></th>
                                <th class="min-w-140 text-capitalize"><?php echo e(translate('admin_net_income')); ?></th>
                                <th class="min-w-140 text-capitalize"><?php echo e(translate('store_net_income')); ?></th>
                                <th class="border-0 min-w-120"><?php echo e(translate('messages.amount_received_by')); ?></th>
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('messages.payment_method')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.payment_status')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>
                        <tbody id="set-rows">
                            <?php $__currentLoopData = $order_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr scope="row">
                                    <td><?php echo e($k + $order_transactions->firstItem()); ?></td>
                                    <?php if($ot->order->order_type == 'parcel'): ?>
                                        <td><a
                                                href="<?php echo e(route('admin.transactions.parcel.order.details', $ot->order_id)); ?>"><?php echo e($ot->order_id); ?></a>
                                        </td>
                                    <?php else: ?>
                                        <td><a
                                                href="<?php echo e(route('admin.transactions.order.details', $ot->order_id)); ?>"><?php echo e($ot->order_id); ?></a>
                                        </td>
                                    <?php endif; ?>
                                    <td  class="text-capitalize">
                                        <?php if($ot->order->store): ?>
                                            <?php echo e(Str::limit($ot->order->store->name,25,'...')); ?>

                                        <?php else: ?>
                                            <label class="badge badge-soft-success white-space-nowrap"><?php echo e(translate('messages.parcel_order')); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="white-space-nowrap">
                                        <?php if($ot->order->customer): ?>
                                            <a class="text-body text-capitalize"
                                                href="<?php echo e(route('admin.users.customer.view', [$ot->order['user_id']])); ?>">
                                                <strong><?php echo e($ot->order->customer['f_name'] . ' ' . $ot->order->customer['l_name']); ?></strong>
                                            </a>
                                        <?php else: ?>
                                            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['order_amount'] - $ot->additional_charge - $ot->order['dm_tips']-$ot->order['delivery_charge']  - $ot['tax'] - $ot->order['extra_packaging_amount'] + $ot->order['coupon_discount_amount'] + $ot->order['store_discount_amount'] + $ot->order['ref_bonus_amount']  +$ot->order['flash_admin_discount_amount'] +$ot->order['flash_store_discount_amount'])); ?></td>

                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order->details()->sum(DB::raw('discount_on_item * quantity')) + $ot->order['flash_admin_discount_amount'] +$ot->order['flash_store_discount_amount'])); ?></td>

                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['coupon_discount_amount'])); ?></td>
                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['ref_bonus_amount'])); ?></td>
                                    
                                    <td class="white-space-nowrap">  <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['coupon_discount_amount'] + $ot->order['store_discount_amount']+$ot->order['flash_store_discount_amount']+$ot->order['flash_admin_discount_amount'] +$ot->order['ref_bonus_amount'])); ?></td>

                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->tax)); ?></td>
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->delivery_charge)); ?></td>
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order_amount)); ?></td>

                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->admin_expense)); ?></td>

                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->discount_amount_by_store+$ot->order['flash_store_discount_amount'])); ?></td>

                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency(($ot->admin_commission + $ot->admin_expense) - $ot->delivery_fee_comission -$ot->additional_charge - $ot->order['flash_admin_discount_amount'] )); ?></td>

                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency(($ot->additional_charge))); ?></td>
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency(($ot->extra_packaging_amount))); ?></td>
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->delivery_fee_comission)); ?></td>
                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency(($ot->admin_commission - $ot->order['flash_admin_discount_amount']))); ?></td>

                                    
                                    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->store_amount - ($ot?->order?->order_type == 'parcel' ? 0: $ot->tax))); ?></td>
                                    <?php if($ot->received_by == 'admin'): ?>
                                        <td class="text-capitalize white-space-nowrap"><?php echo e(translate('messages.admin')); ?></td>
                                    <?php elseif($ot->received_by == 'deliveryman'): ?>
                                        <td class="text-capitalize white-space-nowrap">
                                            <div><?php echo e(translate('messages.delivery_man')); ?></div>
                                            <div class="text-right mw--85px">
                                                <?php if(isset($ot->delivery_man) && $ot->delivery_man->earning == 1): ?>
                                                <span class="badge badge-soft-primary">
                                                    <?php echo e(translate('messages.freelance')); ?>

                                                </span>
                                                <?php elseif(isset($ot->delivery_man) && $ot->delivery_man->earning == 0 && $ot->delivery_man->type == 'restaurant_wise'): ?>
                                                <span class="badge badge-soft-warning">
                                                    <?php echo e(translate('messages.restaurant')); ?>

                                                </span>
                                                <?php elseif(isset($ot->delivery_man) && $ot->delivery_man->earning == 0 && $ot->delivery_man->type == 'zone_wise'): ?>
                                                <span class="badge badge-soft-success">
                                                    <?php echo e(translate('messages.admin')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php elseif($ot->received_by == 'store'): ?>
                                        <td class="text-capitalize white-space-nowrap"><?php echo e(translate('messages.store')); ?></td>
                                    <?php endif; ?>
                                    <td class="mw--85px text-capitalize min-w-120 ">
                                            <?php echo e(translate(str_replace('_', ' ', $ot->order['payment_method']))); ?>

                                    </td>
                                    <td class="text-capitalize white-space-nowrap">
                                        <?php if($ot->status): ?>
                                        <span class="badge badge-soft-danger">
                                            <?php echo e(translate('messages.refunded')); ?>

                                          </span>
                                        <?php else: ?>
                                        <span class="badge badge-soft-success">
                                            <?php echo e(translate('messages.completed')); ?>

                                          </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn btn-outline-success square-btn btn-sm mr-1 action-btn"  href="<?php echo e(route('admin.report.generate-statement',[$ot['id']])); ?>">
                                                <i class="tio-download-to"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Body -->
            <?php if(count($order_transactions) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $order_transactions->links(); ?>

            </div>
            <?php if(count($order_transactions) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
        </div>
        <!-- End Card -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js">
    </script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/hs.chartjs-matrix.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/admin-reports.js"></script>

    <script>
        "use strict";
        $(document).on('ready', function() {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            // all:true,
                            <?php if(isset($zone)): ?>
                                zone_ids: [<?php echo e($zone->id); ?>],
                            <?php endif; ?>
                            <?php if(request('module_id')): ?>
                                module_id: <?php echo e(request('module_id')); ?>,
                            <?php endif; ?>
                            page: params.page
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    __port: function(params, success, failure) {
                        let $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });
        });

        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.transactions.report.day-wise-report-search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#set-rows').html(data.view);
                    $('#countItems').html(data.count);
                    $('.page-area').hide();
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/report/day-wise-report.blade.php ENDPATH**/ ?>