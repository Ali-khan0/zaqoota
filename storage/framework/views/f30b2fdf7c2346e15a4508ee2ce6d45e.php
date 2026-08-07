
<form action="<?php echo e(route('admin.brand.update',[$brand['id']])); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

            <div class="d-flex flex-column h-100">
                <div class="d-flex p-3 justify-content-between mb-3 bg-light">
                    <h4 class="mb-0"><?php echo e(translate('Update_Brand')); ?></h4>
                    <span class="circle bg-light withdraw-info-hide2 cursor-pointer">
                        <i class="tio-clear"></i>
                    </span>
                </div>


                <div class="p-3">
                    <div class="bg-light p-3 rounded">
                        <h4><?php echo e(translate('messages.status')); ?></h4>
                        <p class="fs-12"><?php echo e(translate('messages.If you turn off the switch the brand will not active or visible in customer app & website.')); ?></p>

                        <div class="maintenance-mode-toggle-bar d-flex flex-wrap justify-content-between border rounded align-items-center py-2 px-3">
                            <h5 class="text-capitalize m-0 text--primary"><?php echo e(translate('messages.Status')); ?></h5>

                            <label class="toggle-switch toggle-switch-sm">
                                <input type="checkbox" name="brand_status"  <?php echo e($brand->status == 1 ? 'checked' :  ''); ?>  class="status toggle-switch-input">
                                <span class="toggle-switch-label text mb-0">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded">
                        <?php if($language): ?>
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link1 active" href="#" id="default-link1"><?php echo e(translate('messages.default')); ?></a>
                                </li>
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a class="nav-link lang_link1" href="#" id="<?php echo e($lang); ?>-link1"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>

                        <?php if($language): ?>
                            <div class="form-group lang_form1" id="default-form1">
                                <label class="input-label">
                                    <?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>)
                                    <small class="text-danger">*</small>
                                    
                                </label>
                                <input type="text" name="name[]" value="<?php echo e($brand?->getRawOriginal('name')); ?>"  class="form-control" placeholder="<?php echo e(translate('messages.new_brand')); ?>" maxlength="191">
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php
                            if(count($brand['translations'])){
                                $translate = [];
                                foreach($brand['translations'] as $t)
                                {
                                    if($t->locale == $lang && $t->key=="name"){
                                        $translate[$lang]['name'] = $t->value;
                                    }
                                }
                            }
                        ?>

                                <div class="form-group d-none lang_form1" id="<?php echo e($lang); ?>-form1">
                                    <label class="input-label">
                                        <?php echo e(translate('messages.name')); ?> (<?php echo e(strtoupper($lang)); ?>)
                                        <small class="text-danger">*</small>
                                        
                                    </label>
                                    <input type="text" name="name[]" value="<?php echo e($translate[$lang]['name']??''); ?>"  class="form-control" placeholder="<?php echo e(translate('messages.new_brand')); ?>" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="form-group">
                                <label class="input-label">
                                    <?php echo e(translate('messages.name')); ?>

                                    <small class="text-danger">*</small>
                                    
                                </label>
                                <input type="text" name="name" class="form-control" placeholder="<?php echo e(translate('messages.type_brand_name')); ?>" value="<?php echo e($brand['name']); ?>" maxlength="191">
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                        <?php endif; ?>
                    </div>

                    <div class="bg-light p-3 rounded my-4">
                        <h4><?php echo e(translate('messages.Brand Logo')); ?> <small class="text-danger">*</small></h4>
                        <p class="fs-12"><?php echo e(translate('messages.It will show in website & app.')); ?></p>
                        <div class="d-flex justify-content-center">
                            <label class="text-center position-relative d-inline-block mb-3">
                                <img class="img--176 border" id="viewer2"
                                        <?php if(isset($brand)): ?>
                                            src="<?php echo e($brand['image_full_url']); ?>"
                                        <?php else: ?>
                                            src="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>"
                                        <?php endif; ?>
                                        alt="image"/>
                                <div class="icon-file-group">
                                    <div class="icon-file">
                                        <input type="file" name="image" id="customFileEg2" class="custom-file-input read-url"
                                                accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" >
                                        <i class="tio-edit"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <p class="text-center fs-12"><?php echo e(translate('messages.JPG, JPEG, PNG Less Than 1MB (Ratio 1 : 1)')); ?></p>
                    </div>

                </div>

                <div class="bg-white bottom-0 d-flex gap-3 mt-auto p-3 position-sticky shadow-lg">
                    <button  type="reset" id="reset_btn2" class="btn btn-secondary btn-block withdraw-info-hide2"><?php echo e(translate('messages.reset')); ?></button>
                    <button type="submit" class="btn btn-primary btn-block mt-0" ><?php echo e(translate('messages.save')); ?></button>
                </div>
            </div>
        </form>


<script>
    "use strict";
    $('#reset_btn2').click(function(){
        $('#viewer2').attr('src', "<?php echo e($brand['image_full_url']); ?>");
    })
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#viewer2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#customFileEg2").change(function () {
        readURL(this);
    });
    $(".lang_link1").click(function(e) {
        e.preventDefault();
        $(".lang_link1").removeClass('active');
        $(".lang_form1").addClass('d-none');
        $(this).addClass('active');
        let form_id = this.id;
        let lang = form_id.substring(0, form_id.length - 6);
        $("#" + lang + "-form1").removeClass('d-none');
        if (lang === 'default') {
            $(".default-form1").removeClass('d-none');
        }
    })
</script><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/brand/partials/edit_partial.blade.php ENDPATH**/ ?>