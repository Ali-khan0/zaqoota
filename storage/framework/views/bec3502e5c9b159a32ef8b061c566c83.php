<?php $__env->startSection('title',  translate('Update Withdraw Method')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-4 withdraw-header-sticky z-2">
            <div class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3">
                <h2 class="page-title m-0">
                    <img width="20" src="<?php echo e(asset('/public/assets/admin/img/withdraw-icon.png')); ?>" alt="">
                    <?php echo e(translate('Update Withdraw Method')); ?>

                </h2>
                <button class="btn btn--primary" id="add-more-field">
                    <i class="tio-add-circle"></i> <?php echo e(translate('messages.Add_New_Field')); ?>

                </button>
            </div>
        </div>
        <!-- End Page Title -->

        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.transactions.withdraw-method.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" value="<?php echo e($withdrawal_method['id']); ?>" name="id">
                    <div class="">
                        <div class="card card-body">
                            <div class="bg-1079801A p--20 rounded">
                                <div class="form-floating">
                                    <label class="text-title"><?php echo e(translate('messages.method_name')); ?> <span
                                                class="input-label-secondary text-danger">*</span></label>
                                    
                                    <input type="text" class="form-control " name="method_name" id="method_name"
                                           placeholder="Select method name"
                                           value="<?php echo e($withdrawal_method['method_name']); ?>" required>
                                </div>
                                  <div class="d-flex justify-content-start mt-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input checkbox-theme single-select" type="checkbox" value="1" name="is_default" id="flexCheckDefaultMethod" <?php echo e($withdrawal_method['is_default'] == 1 ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="flexCheckDefaultMethod">
                                    <?php echo e(translate('Mark this Method as Default')); ?>

                                </label>
                            </div>
                        </div>
                            </div>
                        </div>

                        <?php if($withdrawal_method['method_fields']): ?>
                            <?php $__currentLoopData = $withdrawal_method['method_fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="card card-body mt-3" id="field-row--<?php echo e($key); ?>">
                                        <div class="bg-1079801A p--20 rounded">
                                            <div class="row gy-2 align-items-center">
                                                <div class="col-md-4 col-12">
                                                    <div class="form-floating">
                                                        <label class="text-title"><?php echo e(translate('messages.Input_Field_Type')); ?> <span
                                                                class="input-label-secondary text-danger">*</span></label>
                                                        <select class="form-control" name="field_type[]" required>
                                                            <option value="string" <?php echo e($field['input_type']=='string'?'selected':''); ?>><?php echo e(translate('messages.Text')); ?></option>
                                                            <option value="number" <?php echo e($field['input_type']=='number'?'selected':''); ?>><?php echo e(translate('messages.Number')); ?></option>
                                                            <option value="date" <?php echo e($field['input_type']=='date'?'selected':''); ?>><?php echo e(translate('messages.Date')); ?></option>
                                                            <option value="email" <?php echo e($field['input_type']=='email'?'selected':''); ?>><?php echo e(translate('messages.Email')); ?></option>
                                                            <option value="phone" <?php echo e($field['input_type']=='phone'?'selected':''); ?>><?php echo e(translate('messages.Phone')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-floating">
                                                        <label class="text-title"><?php echo e(translate('messages.field_name')); ?> <span
                                                                class="input-label-secondary text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="field_name[]"
                                                               placeholder="<?php echo e(translate('messages.Ex:_Bank')); ?>"
                                                               value="<?php echo e(Str::title(str_replace('_', " ", $field['input_name']))  ?? ''); ?>"
                                                               required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-12">
                                                    <div class="form-floating">
                                                        <label class="text-title"><?php echo e(translate('messages.placeholder_text')); ?> <span
                                                                class="input-label-secondary text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="placeholder_text[]"
                                                               placeholder="<?php echo e(translate('messages.Ex:_John')); ?>"
                                                               value="<?php echo e($field['placeholder'] ?? ''); ?>"
                                                               required>
                                                    </div>
                                                </div>

                                                

                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center justify-content-between pt-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-theme single-select" type="checkbox" value="1"
                                                                   name="is_required[<?php echo e($key); ?>]" id="flexCheckDefault__e<?php echo e($key); ?>"
                                                                <?php echo e($field['is_required'] ? 'checked' : ''); ?>>
                                                            <label class="form-check-label" for="flexCheckDefault__e<?php echo e($key); ?>">
                                                                <?php echo e(translate('messages.Is_required_')); ?>

                                                            </label>
                                                        </div>
                                                        <span class="btn btn-danger remove-field w-30px h-30 py-1 px-1" data-id="<?php echo e($key); ?>">
                                                            <i class="tio-delete"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <!-- HERE CUSTOM FIELDS WILL BE ADDED -->
                        <div id="custom-field-section">

                        </div>





                        <!-- BUTTON -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="reset" class="btn btn--reset min-w-120px mx-2"><?php echo e(translate('messages.Reset')); ?></button>
                            <button type="submit" class="btn btn--primary min-w-120px demo_check"><?php echo e(translate('messages.Submit')); ?></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        let count= <?php echo e(isset($withdrawal_method->method_fields)?count($withdrawal_method->method_fields):0); ?>;
        let counter = 0;
        jQuery(document).ready(function ($) {
            counter = count + 1;

            $('#add-more-field').on('click', function (event) {
                if(counter < 15) {
                    event.preventDefault();

                    $('#custom-field-section').append(
                        `<div class="card card-body mt-3" id="field-row--${counter}">
                            <div class="bg-1079801A p--20 rounded">
                                <div class="row gy-2 align-items-center">
                                    <div class="col-md-4 col-12">
                                        <label class="text-title"><?php echo e(translate('messages.Input_Field_Type')); ?> <span
                                                class="input-label-secondary text-danger">*</span></label>
                                        <select class="form-control js-select2-custom js-select" name="field_type[]" required>
                                            <option value="" selected disabled><?php echo e(translate('messages.Input_Field_Type')); ?> <span
                                                class="input-label-secondary text-danger">*</span></option>
                                            <option value="string"><?php echo e(translate('messages.Text')); ?></option>
                                            <option value="number"><?php echo e(translate('messages.Number')); ?></option>
                                            <option value="date"><?php echo e(translate('messages.Date')); ?></option>
                                            <option value="email"><?php echo e(translate('messages.Email')); ?></option>
                                            <option value="phone"><?php echo e(translate('messages.Phone')); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-floating">
                                            <label class="text-title"><?php echo e(translate('messages.field_name')); ?> <span
                                                class="input-label-secondary text-danger">*</span></label>
                                            <input type="text" class="form-control" name="field_name[]"
                                                placeholder="<?php echo e(translate('messages.Ex:_Bank')); ?>" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-floating">
                                            <label class="text-title"><?php echo e(translate('messages.placeholder_text')); ?> <span
                                                class="input-label-secondary text-danger">*</span></label>
                                            <input type="text" class="form-control" name="placeholder_text[]"
                                                placeholder="<?php echo e(translate('messages.Ex:_John')); ?>" value="" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-between pt-1">
                                            <div class="form-check">
                                                <input class="form-check-input checkbox-theme single-select" type="checkbox" value="1" name="is_required[${counter}]" id="flexCheckDefault__${counter}" checked>
                                                <label class="form-check-label" for="flexCheckDefault__${counter}">
                                                    <?php echo e(translate('messages.Is_required_')); ?>

                                                </label>
                                            </div>
                                            <span class="btn btn-danger remove-field w-30px h-30 py-1 px-1" data-id="${counter}">
                                                <i class="tio-delete"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`
                        );

                    $(".js-select").select2();

                    const newRow = document.getElementById(`field-row--${counter}`);
                    if (newRow) {
                        setTimeout(function () {
                            const targetTop = newRow.getBoundingClientRect().top + window.pageYOffset - 100;
                            try {
                                window.scrollTo({ top: targetTop, behavior: 'smooth' });
                            } catch (e) {
                                if (typeof $ !== 'undefined' && $.fn && $.fn.animate) {
                                    $('html, body').stop().animate({ scrollTop: targetTop }, 400);
                                } else {
                                    window.scrollTo(0, targetTop);
                                }
                            }


                        }, 100);
                    }

                    counter++;
                } else {
                    Swal.fire({
                        title: '<?php echo e(translate('messages.Reached_maximum')); ?>',
                        confirmButtonText: '<?php echo e(translate('messages.ok')); ?>',
                    });
                }
            })

            $('form').on('reset', function (event) {
                if(counter > 1) {
                    $('#custom-field-section').html("");
                    $('#method_name').val("");
                }

                counter = 1;
            })

            $(document).on('click', '.remove-field', function () {
                const fieldRowId = $(this).data('id');
                let rowEl = document.getElementById(`field-row--${fieldRowId}`);
                if (!rowEl) {
                    const candidate = this.closest('.card.card-body');
                    if (candidate && candidate.id && candidate.id.indexOf('field-row--') === 0) {
                        rowEl = candidate;
                    }
                }
                if (rowEl) {
                    const duration = 250;
                    if (typeof $ !== 'undefined' && $.fn && $.fn.slideUp) {
                        $(rowEl).stop().slideUp(duration, function(){ this.remove(); });
                    } else {
                        const h = rowEl.offsetHeight;
                        rowEl.style.boxSizing = 'border-box';
                        rowEl.style.height = h + 'px';
                        rowEl.style.transition = `height ${duration}ms ease, margin ${duration}ms ease, padding ${duration}ms ease, opacity ${duration}ms ease`;
                        rowEl.style.opacity = '1';
                        rowEl.offsetHeight;
                        rowEl.style.height = '0px';
                        rowEl.style.opacity = '0';
                        rowEl.style.marginTop = '0';
                        rowEl.style.marginBottom = '0';
                        rowEl.style.paddingTop = '0';
                        rowEl.style.paddingBottom = '0';
                        setTimeout(function(){ rowEl.remove(); }, duration + 60);
                    }
                    counter--;
                }
            });
        });
    </script>

    <script>
        jQuery(function($){
            const $sticky = $('.withdraw-header-sticky').first();
            if(!$sticky.length) return;
            const origTop = $sticky.offset().top;
            function update(){
                const st = $(window).scrollTop();
                $sticky.toggleClass('scrolling', st >= origTop);
            }
            $(window).on('scroll', update);
            update();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/withdraw-method/withdraw-methods-edit.blade.php ENDPATH**/ ?>