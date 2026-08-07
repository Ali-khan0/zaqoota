<?php $__env->startSection('title', translate('messages.Setup Tax Calculation')); ?>

<?php $__env->startSection('taxmodule'); ?>
    active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('taxmoduleDisplay'); ?>
    block
<?php $__env->stopSection(); ?>
<?php $__env->startSection('tax_system_setup'); ?>
    show active
<?php $__env->stopSection(); ?>




<?php $__env->startSection('content'); ?>
    <?php ($tax_payer = $tax_payer ?? 'vendor'); ?>


    <div class="content container-fluid">
        <h2 class="mb-20"><?php echo e(translate('messages.Setup Tax Calculation')); ?></h3>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
                <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
                    <!-- Nav -->
                    <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
                        <li class="nav-item">
                            <a class="nav-link  <?php echo e(Request::is('taxvat/system-taxvat') && request('type') == 'vendor' ? 'active' : ''); ?>"
                                href="<?php echo e(route('taxvat.systemTaxvat', ['type' => 'vendor'])); ?>"
                                aria-disabled="true"><?php echo e(translate('Order Module')); ?></a>
                        </li>
                        <?php if(addon_published_status('Rental')): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(Request::is('taxvat/system-taxvat') && request('type') == 'rental' ? 'active' : ''); ?>"
                                    href="<?php echo e(route('taxvat.systemTaxvat', ['type' => 'rental'])); ?>"
                                    aria-disabled="true"><?php echo e(translate('Rental Module')); ?></a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(Request::is('taxvat/system-taxvat') && request('type') == 'parcel' ? 'active' : ''); ?>"
                                href="<?php echo e(route('taxvat.systemTaxvat', ['type' => 'parcel'])); ?>"
                                aria-disabled="true"><?php echo e(translate('Parcel Module')); ?></a>
                        </li>
                    </ul>
                    <!-- End Nav -->
                </div>
            </div>
            <div class="card p-20 mb-20">
                <div class="row g-md-3 g-2 justify-content-between">
                    <div class="col-md-8">
                        <h3 class="mb-1 text-capitalize">
                            <?php echo e(translate('messages.Allow Tax Calculation For') . ' ' . translate($tax_payer)); ?> ?</h3>
                        <p class="fz-12 mb-0"><?php echo e(translate('messages.To active tax calculation Turn On The Status.')); ?></p>
                    </div>
                    <div class="col-md-4 col-xxl-3">
                        <label class="border d-flex align-items-center justify-content-between rounded p-10px px-3">
                            <?php echo e(translate('messages.Status')); ?>

                            <div class="toggle-switch ml-auto justify-content-end toggle-switch-sm confirmStatus"
                                data-id="<?php echo e($systemTaxVat?->id); ?>"
                                data-on_title="<?php echo e(translate('messages.Turn On The Status?')); ?>"
                                data-off_title="<?php echo e(translate('messages.Turn Off The Status?')); ?>"
                                data-on_message= "<?php echo e(translate('Are you sure, do you want to turn ON the VAT status from your system. It will  effect on tax calculation & report')); ?>"
                                data-off_message= "<?php echo e(translate('Are you sure, do you want to turn off the VAT status from your system. It will  effect on tax calculation & report')); ?>"
                                data-url="<?php echo e(route('taxvat.systemTaxVatVendorStatus', ['id' => $systemTaxVat?->id, 'prescription_system_id' => $systemTaxVatForPrescription?->id, 'country_code' => $country_code ?? ($systemTaxVat?->country_code ?? null), 'type' => $tax_payer])); ?>"
                                data-env="<?php echo e(env('APP_MODE')); ?>"
                                for="vendor_tax_status">
                                <input type="checkbox" class="toggle-switch-input"
                                    <?php echo e($systemTaxVat?->is_active == 1 ? 'checked' : ''); ?> id="vendor_tax_status">
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div id='tax_settings' class="<?php echo e($systemTaxVat?->is_active == 1 ? '' : 'disabled'); ?>">

                <form action="<?php echo e(route('taxvat.systemTaxVatStore')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <input type="hidden" name="country_code"
                        value="<?php echo e($country_code ?? ($systemTaxVat?->country_code ?? null)); ?>">
                    <input type="hidden" id="system_tax_id" name="system_tax_id" value="<?php echo e($systemTaxVat?->id); ?>">
                    <div class="card p-20">
                        <div class="bg--secondary p-15 rounded mb-20">
                            <div class="mb-20">
                                <?php if($tax_payer == 'rental_provider'): ?>
                                    <?php ($productType = translate('Trip_Amount')); ?>
                                <?php elseif($tax_payer == 'parcel'): ?>
                                    <?php ($productType = translate('Parcel_Amount')); ?>
                                <?php else: ?>
                                    <?php ($productType = translate('Product Price')); ?>
                                <?php endif; ?>
                                <h4 class="mb-1"><?php echo e(translate('Tax calculation based on') . ' ' . $productType); ?> </h4>
                            </div>
                            <div class="bg-white border rounded p-15">
                                <div class="row g-lg-4 g-md-3 g-2">
                                    <div class="col-md-6">
                                        <div class="custom-radio d-flex align-items-start gap-2">
                                            <input class="w-20px h-20px" type="radio" id="include1" name="tax_status"
                                                value="include"
                                                <?php echo e(!$systemTaxVat || $systemTaxVat?->is_included == 1 ? 'checked' : ''); ?>>
                                            <label for="include1" class="fz-14 mb-0">
                                                <h5 class="mb-1"><?php echo e(translate('Calculate Tax Include')); ?>

                                                    <?php echo e($productType); ?>

                                                </h5>
                                                <p class="mb-0 fz-11 fw-normal">
                                                    <?php echo e(translate('Calculate Tax Included. By selecting this option you will need to setup same tax rate for all types of income source.')); ?>

                                                </p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="custom-radio d-flex align-items-start gap-2">
                                            <input class="w-20px h-20px" type="radio" id="include2" name="tax_status"
                                                <?php echo e($systemTaxVat && $systemTaxVat?->is_included == 0 ? 'checked' : ''); ?>

                                                value="exclude">
                                            <label for="include2" class="fz-14 mb-0">
                                                <h5 class="mb-1"><?php echo e(translate('Calculate Tax Exclude')); ?>

                                                    <?php echo e($productType); ?>

                                                </h5>
                                                <p class="mb-0 fz-11 fw-normal">
                                                    <?php echo e(translate('By selecting this option you will need to setup individual tax rate for different types of income source.')); ?>

                                                </p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tax_rate_setup"
                            class="<?php echo e(!$systemTaxVat || $systemTaxVat?->is_included == 1 ? 'disabled' : ''); ?>">



                            <div class="bg--secondary rounded p-20 mb-20">
                                <div class="row g-lg-4 g-md-3 g-2">
                                    <div class="col-md-6">
                                        <h3 class="mb-1"><?php echo e(translate('messages.Basic Setup')); ?></h3>
                                        
                                        <div class="danger-notes-bg px-2 py-2 rounded fz-11  gap-2 align-items-center mt-10px d-none"
                                            id=tax_type_change_alert>
                                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_13920_306)">
                                                    <path
                                                        d="M13.464 9.10734L8.75069 1.664C8.35402 1.09234 7.69485 0.748169 7.00069 0.748169C6.30652 0.748169 5.64735 1.0865 5.23319 1.6815L0.543187 9.09567C-0.051813 9.94734 -0.162646 10.9682 0.25152 11.7557C0.659854 12.5432 1.51735 12.9923 2.59069 12.9923H11.4107C12.4899 12.9923 13.3415 12.5432 13.7499 11.7557C14.1582 10.9682 14.0474 9.95317 13.464 9.10734ZM6.41735 4.24817C6.41735 3.92734 6.67985 3.66484 7.00069 3.66484C7.32152 3.66484 7.58402 3.92734 7.58402 4.24817V7.74817C7.58402 8.069 7.32152 8.3315 7.00069 8.3315C6.67985 8.3315 6.41735 8.069 6.41735 7.74817V4.24817ZM7.00069 11.2482C6.51652 11.2482 6.12569 10.8573 6.12569 10.3732C6.12569 9.889 6.51652 9.49817 7.00069 9.49817C7.48485 9.49817 7.87569 9.889 7.87569 10.3732C7.87569 10.8573 7.48485 11.2482 7.00069 11.2482Z"
                                                        fill="#FF4040" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_13920_306">
                                                        <rect width="14" height="14" fill="white"
                                                            transform="translate(0 0.164795)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <span>
                                                <?php echo e(translate('messages.When you change')); ?> <span
                                                    class="font-semibold title-clr"><?php echo e(translate('messages.Tax Type')); ?></span>
                                                <?php echo e(translate('to product wise.Vendors will have control to setup the taxes of their products.')); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column gap-lg-4 gap-3">
                                            <div>
                                                <span
                                                    class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('messages.Select Tax Type')); ?></span>
                                                <select id="tax_type"
                                                    class="custom-select custom-select-color border rounded w-100"
                                                    name="tax_type"
                                                    data-current_seclected="<?php echo e($systemTaxVat?->tax_type); ?>">

                                                    <?php ($tax_calculate_on = $tax_payer == 'vendor' ? 'tax_calculate_on' : 'tax_calculate_on_' . $tax_payer); ?>

                                                    <?php $__currentLoopData = data_get($systemData, $tax_calculate_on, ['order_wise', 'product_wise', 'category_wise']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php echo e($systemTaxVat?->tax_type == $item ? 'selected' : ''); ?>

                                                            value="<?php echo e($item); ?>"> <?php echo e(translate($item)); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div id="tax_rate_div"
                                                class="<?php echo e(!$systemTaxVat || in_array($systemTaxVat?->tax_type, ['order_wise', 'trip_wise']) ? '' : 'd-none'); ?>">
                                                <span
                                                    class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Tax Rate')); ?></span>
                                                <select
                                                    <?php echo e(in_array($systemTaxVat?->tax_type, ['order_wise', 'trip_wise']) ? 'selected' : ''); ?>

                                                    name="tax_ids[]" id="tax__rate"
                                                    class="form-control js-select2-custom" multiple="multiple"
                                                    placeholder="<?php echo e(translate('Type & Select Tax Rate')); ?>">
                                                    <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option
                                                            <?php echo e(in_array($taxVat->id, $systemTaxVat?->tax_ids ?? []) ? 'selected' : ''); ?>

                                                            value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                                            (<?php echo e($taxVat->tax_rate); ?>%)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </select>
                                            </div>
                                            <div id="info_notes"
                                                class="info-notes-bg px-2 py-2 rounded fz-11  gap-2 align-items-center <?php echo e(in_array($systemTaxVat?->tax_type, ['category_wise', 'product_wise']) ? 'd-flex' : 'd-none'); ?> ">
                                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_13899_104013)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M10.3125 2.53979V1.28979C10.3125 1.11729 10.1725 0.977295 10 0.977295C9.8275 0.977295 9.6875 1.11729 9.6875 1.28979V2.53979C9.6875 2.71229 9.8275 2.85229 10 2.85229C10.1725 2.85229 10.3125 2.71229 10.3125 2.53979Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M5.34578 4.31882L4.47078 3.44382C4.34891 3.32195 4.15078 3.32195 4.02891 3.44382C3.90703 3.5657 3.90703 3.76382 4.02891 3.8857L4.90391 4.7607C5.02578 4.88257 5.22391 4.88257 5.34578 4.7607C5.46766 4.63882 5.46766 4.4407 5.34578 4.31882Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M3.125 9.10229H1.875C1.7025 9.10229 1.5625 9.24229 1.5625 9.41479C1.5625 9.58729 1.7025 9.72729 1.875 9.72729H3.125C3.2975 9.72729 3.4375 9.58729 3.4375 9.41479C3.4375 9.24229 3.2975 9.10229 3.125 9.10229Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M4.90391 14.0688L4.02891 14.9438C3.90703 15.0657 3.90703 15.2638 4.02891 15.3857C4.15078 15.5076 4.34891 15.5076 4.47078 15.3857L5.34578 14.5107C5.46766 14.3888 5.46766 14.1907 5.34578 14.0688C5.22391 13.9469 5.02578 13.9469 4.90391 14.0688Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M14.6539 14.5107L15.5289 15.3857C15.6508 15.5076 15.8489 15.5076 15.9708 15.3857C16.0927 15.2638 16.0927 15.0657 15.9708 14.9438L15.0958 14.0688C14.9739 13.9469 14.7758 13.9469 14.6539 14.0688C14.532 14.1907 14.532 14.3888 14.6539 14.5107Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M16.875 9.72729H18.125C18.2975 9.72729 18.4375 9.58729 18.4375 9.41479C18.4375 9.24229 18.2975 9.10229 18.125 9.10229H16.875C16.7025 9.10229 16.5625 9.24229 16.5625 9.41479C16.5625 9.58729 16.7025 9.72729 16.875 9.72729Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M15.0958 4.7607L15.9708 3.8857C16.0927 3.76382 16.0927 3.5657 15.9708 3.44382C15.8489 3.32195 15.6508 3.32195 15.5289 3.44382L14.6539 4.31882C14.532 4.4407 14.532 4.63882 14.6539 4.7607C14.7758 4.88257 14.9739 4.88257 15.0958 4.7607Z"
                                                            fill="#245BD1" />
                                                        <path
                                                            d="M7.5 16.6023V15.6648C7.5 14.9773 7.1875 14.321 6.625 13.9148C5.25 12.8835 4.375 11.2585 4.375 9.41477C4.375 6.10227 7.25 3.44602 10.625 3.82102C13.2188 4.10227 15.2812 6.16477 15.5938 8.75852C15.8438 10.8835 14.9062 12.7898 13.375 13.9148C12.8125 14.321 12.5 14.9773 12.5 15.6648V16.6023H7.5Z"
                                                            fill="#BED2FE" />
                                                        <path
                                                            d="M7.5 16.2898H12.5V18.2273C12.5 18.5398 12.25 18.7898 11.9375 18.7898H11.25C11.25 19.4773 10.6875 20.0398 10 20.0398C9.3125 20.0398 8.75 19.4773 8.75 18.7898H8.0625C7.75 18.7898 7.5 18.5398 7.5 18.2273V16.2898Z"
                                                            fill="#245BD1" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_13899_104013">
                                                            <rect width="20" height="20" fill="white"
                                                                transform="translate(0 0.664795)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                <span
                                                    class="<?php echo e($systemTaxVat?->tax_type == 'category_wise' ? '' : 'd-none'); ?>"
                                                    id="info_for_category">
                                                    <?php echo e(translate('messages.Please specify the tax rate while creating a category from')); ?>

                                                    <span
                                                        class="font-semibold theme-clr text-decoration-underline"><?php echo e(translate('Category List')); ?>.</span>
                                                    <?php echo e(translate('If you already created category without tax then go to category edit & update tax.')); ?>

                                                </span>
                                                <span
                                                    class="<?php echo e($systemTaxVat?->tax_type == 'product_wise' ? '' : 'd-none'); ?>"
                                                    id="info_for_item">
                                                    <?php echo e(translate('messages.Please specify the tax rate while creating a Product from')); ?>

                                                    <span
                                                        class="font-semibold theme-clr text-decoration-underline"><?php echo e(translate('Products List')); ?>.</span>
                                                    <?php echo e(translate('If you already created Products without tax then go to edit Product and update tax.')); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(request('type') == 'vendor' || !request('type')): ?>
                                <div class="bg--secondary rounded p-20 mb-20">
                                    <div class="row g-lg-4 g-md-3 g-2">
                                        <div class="col-md-6">
                                            <h3 class="mb-1"><?php echo e(translate('Uploaded Prescription Order')); ?></h3>
                                            <p class="mb-0 fz-12">
                                                <?php echo e(translate('Here you can setup your tax type & tax rate for the tax type.')); ?>

                                            </p>
                                            <div
                                                class="info-notes-bg px-2 py-2 rounded fz-11  gap-2 align-items-center d-flex ">
                                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_13899_104013)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M10.3125 2.53979V1.28979C10.3125 1.11729 10.1725 0.977295 10 0.977295C9.8275 0.977295 9.6875 1.11729 9.6875 1.28979V2.53979C9.6875 2.71229 9.8275 2.85229 10 2.85229C10.1725 2.85229 10.3125 2.71229 10.3125 2.53979Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M5.34578 4.31882L4.47078 3.44382C4.34891 3.32195 4.15078 3.32195 4.02891 3.44382C3.90703 3.5657 3.90703 3.76382 4.02891 3.8857L4.90391 4.7607C5.02578 4.88257 5.22391 4.88257 5.34578 4.7607C5.46766 4.63882 5.46766 4.4407 5.34578 4.31882Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M3.125 9.10229H1.875C1.7025 9.10229 1.5625 9.24229 1.5625 9.41479C1.5625 9.58729 1.7025 9.72729 1.875 9.72729H3.125C3.2975 9.72729 3.4375 9.58729 3.4375 9.41479C3.4375 9.24229 3.2975 9.10229 3.125 9.10229Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M4.90391 14.0688L4.02891 14.9438C3.90703 15.0657 3.90703 15.2638 4.02891 15.3857C4.15078 15.5076 4.34891 15.5076 4.47078 15.3857L5.34578 14.5107C5.46766 14.3888 5.46766 14.1907 5.34578 14.0688C5.22391 13.9469 5.02578 13.9469 4.90391 14.0688Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M14.6539 14.5107L15.5289 15.3857C15.6508 15.5076 15.8489 15.5076 15.9708 15.3857C16.0927 15.2638 16.0927 15.0657 15.9708 14.9438L15.0958 14.0688C14.9739 13.9469 14.7758 13.9469 14.6539 14.0688C14.532 14.1907 14.532 14.3888 14.6539 14.5107Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M16.875 9.72729H18.125C18.2975 9.72729 18.4375 9.58729 18.4375 9.41479C18.4375 9.24229 18.2975 9.10229 18.125 9.10229H16.875C16.7025 9.10229 16.5625 9.24229 16.5625 9.41479C16.5625 9.58729 16.7025 9.72729 16.875 9.72729Z"
                                                            fill="#245BD1" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M15.0958 4.7607L15.9708 3.8857C16.0927 3.76382 16.0927 3.5657 15.9708 3.44382C15.8489 3.32195 15.6508 3.32195 15.5289 3.44382L14.6539 4.31882C14.532 4.4407 14.532 4.63882 14.6539 4.7607C14.7758 4.88257 14.9739 4.88257 15.0958 4.7607Z"
                                                            fill="#245BD1" />
                                                        <path
                                                            d="M7.5 16.6023V15.6648C7.5 14.9773 7.1875 14.321 6.625 13.9148C5.25 12.8835 4.375 11.2585 4.375 9.41477C4.375 6.10227 7.25 3.44602 10.625 3.82102C13.2188 4.10227 15.2812 6.16477 15.5938 8.75852C15.8438 10.8835 14.9062 12.7898 13.375 13.9148C12.8125 14.321 12.5 14.9773 12.5 15.6648V16.6023H7.5Z"
                                                            fill="#BED2FE" />
                                                        <path
                                                            d="M7.5 16.2898H12.5V18.2273C12.5 18.5398 12.25 18.7898 11.9375 18.7898H11.25C11.25 19.4773 10.6875 20.0398 10 20.0398C9.3125 20.0398 8.75 19.4773 8.75 18.7898H8.0625C7.75 18.7898 7.5 18.5398 7.5 18.2273V16.2898Z"
                                                            fill="#245BD1" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_13899_104013">
                                                            <rect width="20" height="20" fill="white"
                                                                transform="translate(0 0.664795)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <span>
                                                    <?php echo e(translate('Only for Pharmacy Module uploaded prescription orders')); ?>


                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column gap-lg-4 gap-3">
                                                <input type="hidden" id="prescription_system_tax_id"
                                                    name="prescription_system_tax_id"
                                                    value="<?php echo e($systemTaxVatForPrescription?->id); ?>">
                                                <div>
                                                    <span
                                                        class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('messages.Select Tax Type')); ?></span>
                                                    <select class="custom-select custom-select-color border rounded w-100"
                                                        name="prescription_tax_type"
                                                        data-current_seclected="<?php echo e($systemTaxVatForPrescription?->tax_type); ?>">

                                                        <?php ($tax_calculate_on = $systemTaxVatForPrescription?->tax_payer == 'vendor' ? 'tax_calculate_on' : 'tax_calculate_on_' . $systemTaxVatForPrescription?->tax_payer); ?>

                                                        <?php $__currentLoopData = data_get($systemData, $tax_calculate_on, ['order_wise']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                <?php echo e($systemTaxVatForPrescription?->tax_type == $item ? 'selected' : ''); ?>

                                                                value="<?php echo e($item); ?>"> <?php echo e(translate($item)); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div>
                                                    <span
                                                        class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Tax Rate')); ?></span>
                                                    <select
                                                        <?php echo e(in_array($systemTaxVatForPrescription?->tax_type, ['order_wise', 'trip_wise']) ? 'selected' : ''); ?>

                                                        name="tax_ids_for_prescription[]" id="tax__rate1"
                                                        class="form-control js-select2-custom" multiple="multiple"
                                                        placeholder="<?php echo e(translate('Type & Select Tax Rate')); ?>">
                                                        <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option
                                                                <?php echo e(in_array($taxVat->id, $systemTaxVatForPrescription?->tax_ids ?? []) ? 'selected' : ''); ?>

                                                                value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                                                (<?php echo e($taxVat->tax_rate); ?>%)
                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                               <?php ($additional_tax = $tax_payer == 'vendor' ? 'additional_tax' : 'additional_tax_' . $tax_payer); ?>

                            <?php if(data_get($systemData, $additional_tax, null)): ?>

                                <div class="bg--secondary rounded p-20">
                                    <div class="row g-lg-4 g-md-3 g-2">
                                        <div class="col-md-6">
                                            <h3 class="mb-1"><?php echo e(translate('messages.Additional Setup')); ?></h3>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex flex-column gap-lg-4 gap-3">
                                                <?php $__currentLoopData = $systemData[$additional_tax]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php ($additionalData = $systemTaxVat?->additionalData?->where('name', $item)->first()); ?>
                                                    <div>
                                                        <div
                                                            class="d-flex align-items-center gap-1 justify-content-between mb-2">
                                                            <span
                                                                class="title-clr fw-normal"><?php echo e(translate($item)); ?></span>
                                                            <label class="toggle-switch toggle-switch-sm"
                                                                for="services__charge_<?php echo e($item); ?>">
                                                                <input type="checkbox"
                                                                    name="additional_status[<?php echo e($item); ?>]"
                                                                    class="toggle-switch-input check_additional_data"
                                                                    <?php echo e($additionalData?->is_active ? 'checked' : ''); ?>

                                                                    data-id="<?php echo e($item); ?>" value="1"
                                                                    id="services__charge_<?php echo e($item); ?>">
                                                                <span class="toggle-switch-label">
                                                                    <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <select id="additional_charge_<?php echo e($item); ?>"
                                                            name="additional[<?php echo e($item); ?>][]"
                                                            class="form-control js-select2-custom service__charge"
                                                            multiple="multiple" placeholder="<?php echo e(translate('Type & Select Tax Rate')); ?>">
                                                            <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option
                                                                    <?php echo e(in_array($taxVat->id, $additionalData?->tax_ids ?? []) ? 'selected' : ''); ?>

                                                                    value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                                                    (<?php echo e($taxVat->tax_rate); ?>%)
                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-end mt-4 gap-md-3 gap-2">
                        <button type="button"
                            class="btn bg--secondary h--42px title-clr px-4"><?php echo e(translate('messages.Reset')); ?></button>
                        <button type="<?php echo e(env('APP_MODE') != 'demo' ? 'submit' : 'button'); ?>" class="btn btn--primary call-demo"><?php echo e(translate('Save Information')); ?></button>
                    </div>
                </form>
            </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="<?php echo e(asset('Modules/TaxModule/public/assets/admin/img/status-ons.png')); ?>" class="mb-20"
                        alt="">
                    <h3 class="title-clr mb-2" id="confirmationTitle"></h3>
                    <p class="fz--14px" id="confirmationMessage"></p>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0 gap-2">
                    <button type="button" class="btn min-w-120px btn--secondary"
                        data-dismiss="modal"><?php echo e(translate('No')); ?></button>
                    <button type="button" id="seturl" data-url=""
                        class="btn min-w-120px btn--primary"><?php echo e(translate('Yes')); ?></button>
                </div>
            </div>
        </div>
    </div>

    <!-- global guideline view Offcanvas here -->
    <div id="global_guideline_offcanvas" class="custom-offcanvas d-flex flex-column justify-content-between">
        <form action="<?php echo e(route('taxvat.store')); ?>" method="post">
            <div>
                <div class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
                    <div class="py-1">
                        <h3 class="mb-0 line--limit-1"><?php echo e(translate('messages.Create Tax Guideline')); ?></h3>
                    </div>
                    <button type="button" class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="custom-offcanvas-body custom-offcanvas-body-100  p-20">
                    <div class="">
                        <div class="py-3 px-3 bg-light rounded mb-3">
                            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                                <button class="btn-collapse line--limit-1 d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapse show" type="button"
                                        data-toggle="collapse" data-target="#collapseGeneralSetup_01" aria-expanded="true">
                                    <div class="btn-collapse-icon w-35px h-35px bg-white d-flex align-items-center justify-content-center border icon-btn rounded-circle fs-12 lh-1">
                                        <i class="tio-down-ui top-01 color-656566"></i>
                                    </div>
                                    <span class="font-semibold text-left fs-14 text-title line--limit-1"><?php echo e(translate('Setup Tax Calculation')); ?></span>
                                </button>
                                <!-- <a href="javascript:void(0)" class="fs-12 text-nowrap theme-clr text-underline">
                                    <?php echo e(translate('Let’s Setup')); ?>

                                </a> -->
                            </div>
                            <div class="collapse mt-3 show" id="collapseGeneralSetup_01">
                                <div class="card rounded border p-3 card-body">
                                    <div class="mb-3">
                                        <p class="m-0 fs-12 color-656566">
                                            This page allows you to configure how and where taxes are calculated for your vendors.
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('You can decide:')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('Whether tax should be included in the product price or added separately')); ?></li>
                                            <li class="fs-12 color-656566"><?php echo e(translate('Which parts of the order should have taxes applied — items, delivery fees, or packaging')); ?></li>
                                            <li class="fs-12 color-656566"><?php echo e(translate('This gives you full control over how your business handles tax visibility and accuracy.')); ?></li>                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-12 p-sm-20 bg-light rounded mb-3">
                            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                                <button class="btn-collapse line--limit-1 d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseGeneralSetup_032" aria-expanded="true">
                                    <div class="btn-collapse-icon w-35px h-35px bg-white d-flex align-items-center justify-content-center border icon-btn rounded-circle fs-12 lh-1 collapsed">
                                        <i class="tio-down-ui top-01 color-656566"></i>
                                    </div>
                                    <span class="font-semibold text-left fs-14 text-title line--limit-1"><?php echo e(translate('Tax Calculation Method')); ?></span>
                                </button>
                            </div>
                            <div class="collapse mt-3" id="collapseGeneralSetup_032">
                                <div class="card rounded border p-3 card-body"> 
                                    <div class="mb-3">
                                        <p class="m-0 color-656566 fs-12"><?php echo e(translate('You can choose one of two ways to calculate tax:')); ?></p>
                                    </div>                               
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('Calculate Tax Included in Product Price')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('The tax is already included in the listed item price.')); ?></li>
                                            <li class="fs-12 color-656566"><?php echo e(translate('The customer sees a single total price (no separate tax line).')); ?></li>
                                            <li class="fs-12 color-656566"><?php echo e(translate('Invoices and reports won’t show separate VAT amounts.')); ?></li>
                                            <li class="fs-12 color-656566"><?php echo e(translate('Use this method if your displayed prices are “tax-included.')); ?></li>
                                        </ul>
                                    </div>
                                     <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('Calculate Tax Excluded from Product Price')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('The tax is added on top of the item price.')); ?></li>
                                            <li class="fs-12 color-656566"><?php echo e(translate('Customers will see a separate tax line during checkout and in their invoice.')); ?></li>
                                            <li class="fs-12 color-656566"><?php echo e(translate('This method gives you clear, transparent VAT reporting.')); ?></li>
                                        </ul>
                                    </div>
                                    <p class="m-0 fs-12 color-656566">
                                        <?php echo e(translate('Recommendation: Use “Tax Excluded from Product Price” if you want to show taxes separately for better reporting.')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-12 p-sm-20 bg-light rounded mb-3">
                            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                                <button class="btn-collapse line--limit-1 d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseGeneralSetup_033" aria-expanded="true">
                                    <div class="btn-collapse-icon w-35px h-35px bg-white d-flex align-items-center justify-content-center border icon-btn rounded-circle fs-12 lh-1 collapsed">
                                        <i class="tio-down-ui top-01 color-656566"></i>
                                    </div>
                                    <span class="font-semibold text-left fs-14 text-title line--limit-1"><?php echo e(translate('Tax Effect on Orders')); ?></span>
                                </button>
                            </div>
                            <div class="collapse mt-3" id="collapseGeneralSetup_033">
                                <div class="card rounded border p-3 card-body"> 
                                    <p class="fs-12 mb-3 color-656566">The system applies tax only to orders placed after you enable it.</p>  
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('Before activation:')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('Orders placed earlier will not have any tax added.')); ?></li>                                            
                                        </ul>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('After activation:')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('All new orders will automatically calculate and apply the correct tax.')); ?></li>                                            
                                        </ul>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('After deactivation:')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('If you turn off tax again, future orders will not include tax until reactivated.')); ?></li>                                            
                                        </ul>
                                    </div>
                                    <p class="m-0 fs-12 color-656566">
                                        <?php echo e(translate('This ensures older orders stay accurate while new ones follow updated rules.')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-12 p-sm-20 bg-light rounded mb-3">
                            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                                <button class="btn-collapse line--limit-1 d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseGeneralSetup_044" aria-expanded="true">
                                    <div class="btn-collapse-icon w-35px h-35px bg-white d-flex align-items-center justify-content-center border icon-btn rounded-circle fs-12 lh-1 collapsed">
                                        <i class="tio-down-ui top-01 color-656566"></i>
                                    </div>
                                    <span class="font-semibold text-left fs-14 text-title line--limit-1"><?php echo e(translate('Flexible Tax Application Options')); ?></span>
                                </button>
                            </div>
                            <div class="collapse mt-3" id="collapseGeneralSetup_044">
                                <div class="card rounded border p-3 card-body"> 
                                    <p class="fs-12 mb-3 color-656566">You can choose how the tax applies depending on your business model:</p>  
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('Order-wise Tax:')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('One flat tax rate applies to the total order.')); ?></li>                                            
                                        </ul>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('Product-wise Tax: ')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('Each product or food item can have its own tax rate.')); ?></li>                                            
                                        </ul>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('Category-wise Tax: ')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('Different product categories can carry different tax rates.')); ?></li>                                            
                                        </ul>
                                    </div>
                                    <p class="m-0 fs-12 color-656566">
                                        <?php echo e(translate('This flexibility lets you match complex tax rules for restaurants, grocery stores, or other service types.')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-12 p-sm-20 bg-light rounded mb-3">
                            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                                <button class="btn-collapse line--limit-1 d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseGeneralSetup_055" aria-expanded="true">
                                    <div class="btn-collapse-icon w-35px h-35px bg-white d-flex align-items-center justify-content-center border icon-btn rounded-circle fs-12 lh-1 collapsed">
                                        <i class="tio-down-ui top-01 color-656566"></i>
                                    </div>
                                    <span class="font-semibold text-left fs-14 text-title line--limit-1"><?php echo e(translate('Uploaded Prescription Orders (Pharmacy Module Only)')); ?></span>
                                </button>
                            </div>
                            <div class="collapse mt-3" id="collapseGeneralSetup_055">
                                <div class="card rounded border p-3 card-body"> 
                                    <div class="mb-3">
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('For pharmacy modules, tax applies order-wise on uploaded prescription orders.')); ?></li>                                            
                                            <li class="fs-12 color-656566"><?php echo e(translate('You can set the tax type and rate specifically for these orders.')); ?></li>                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-12 p-sm-20 bg-light rounded mb-3">
                            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                                <button class="btn-collapse line--limit-1 d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseGeneralSetup_066" aria-expanded="true">
                                    <div class="btn-collapse-icon w-35px h-35px bg-white d-flex align-items-center justify-content-center border icon-btn rounded-circle fs-12 lh-1 collapsed">
                                        <i class="tio-down-ui top-01 color-656566"></i>
                                    </div>
                                    <span class="font-semibold text-left fs-14 text-title line--limit-1"><?php echo e(translate('Additional Setup')); ?></span>
                                </button>
                            </div>
                            <div class="collapse mt-3" id="collapseGeneralSetup_066">
                                <div class="card rounded border p-3 card-body"> 
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('You can also configure tax for packaging charges.')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('If enabled, packaging costs will include tax as per your setup — ensuring your total billing remains compliant.')); ?></li>                                            
                                        </ul>
                                    </div>
                                    <p class="m-0 fs-12 color-656566">
                                        <?php echo e(translate('Example: If packaging costs $2 and tax is 10%, the total will show as $2.20.')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-12 p-sm-20 bg-light rounded mb-3">
                            <div class="d-flex gap-3 align-items-center justify-content-between overflow-hidden">
                                <button class="btn-collapse line--limit-1 d-flex gap-3 align-items-center bg-transparent border-0 p-0 collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseGeneralSetup_077" aria-expanded="true">
                                    <div class="btn-collapse-icon w-35px h-35px bg-white d-flex align-items-center justify-content-center border icon-btn rounded-circle fs-12 lh-1 collapsed">
                                        <i class="tio-down-ui top-01 color-656566"></i>
                                    </div>
                                    <span class="font-semibold text-left fs-14 text-title line--limit-1"><?php echo e(translate('Final Step – Save Your Setup')); ?></span>
                                </button>
                            </div>
                            <div class="collapse mt-3" id="collapseGeneralSetup_077">
                                <div class="card rounded border p-3 card-body"> 
                                    <div class="mb-3">
                                        <h6 class="mb-2 fs-12 color-656566"><?php echo e(translate('After completing all configurations:')); ?></h6>
                                        <ul class="mb-0 list-group pl-3 d-flex flex-column gap-1px">
                                            <li class="fs-12 color-656566"><?php echo e(translate('Click Save Information to apply changes.')); ?></li>                                            
                                            <li class="fs-12 color-656566"><?php echo e(translate('Click Reset if you want to start over or discard unsaved edits.')); ?></li>                                            
                                        </ul>
                                    </div>
                                    <p class="m-0 fs-12 color-656566">
                                        <?php echo e(translate('Once saved, your tax setup will instantly affect all applicable orders moving forward.')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div id="offcanvasOverlay" class="offcanvas-overlay"></div>
    <!-- global guideline view Offcanvas end -->
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('Modules/TaxModule/public/assets/js/admin/toastr_notification.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/TaxModule/public/assets/js/admin/system_taxvat.js')); ?>"></script>
    <script>
        $(document).on('click', '.call-demo', function () {
            <?php if(env('APP_MODE') =='demo'): ?>
                toastr.info('<?php echo e(translate('Update option is disabled for demo!')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
            <?php endif; ?>
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/TaxModule/Resources/views/tax/system_tax_setup.blade.php ENDPATH**/ ?>