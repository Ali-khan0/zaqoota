<div class="card h-100">
    <!-- Header -->
    <div class="card-header justify-content-between">
        <div class="chat-user-info w-100 d-flex align-items-center">
            <div class="chat-user-info-img">
                <img class="avatar-img onerror-image"
                src="<?php echo e($user['image_full_url']); ?>"
                    data-onerror-image="<?php echo e(asset('public/assets/admin')); ?>/img/160x160/img1.jpg"
                    alt="Image Description">
            </div>
            <div class="chat-user-info-content">
                <h5 class="mb-0 text-capitalize">
                    <?php echo e($user['f_name'].' '.$user['l_name']); ?></h5>
                <span dir="ltr"><?php echo e($user['phone']); ?></span>
            </div>
        </div>
        <div class="dropdown">
            <button class="btn shadow-none" data-toggle="dropdown">
                <img src="<?php echo e(asset('/public/assets/admin/img/ellipsis.png')); ?>" alt="">
            </button>
            <ul class="dropdown-menu conv-dropdown-menu">
                <li>
                    <a href="<?php echo e(route('admin.users.customer.view', [$user->user->id])); ?>"><?php echo e(translate('View_Details')); ?></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card-body">
        <div class="scroll-down">
            <?php $__currentLoopData = $convs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $con): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($con->sender_id == $receiver->id): ?>


            <?php if($con?->order): ?>
            <div class="conv-reply-1 p-0 m-0 bg-transparent">

                <div class="card shadow-sm my-3" >
                    <div class="card-body">
                        <!-- Order ID and Status -->
                        <div class="d-flex justify-content-between gap-2">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h5 class="card-title"><?php echo e(translate('Order ID')); ?> # <?php echo e($con?->order?->id); ?></h5>
                                    <?php if(in_array($con?->order?->order_status ,['pending' ,'confirmed',
                                    'accepted','processing','handover','picked_up'])): ?>
                                    <span class="badge badge-soft-info">

                                    <?php elseif(in_array($con?->order?->order_status ,['delivered' ])): ?>

                                    <span class="badge badge-soft-success">

                                    <?php elseif(in_array($con?->order?->order_status ,['refund_requested', 'refunded', 'refund_request_canceled','canceled','failed' ])): ?>

                                    <span class="badge badge-soft-danger">

                                        <?php endif; ?>

                                        <?php echo e(translate($con?->order?->order_status)); ?>

                                        </span>
                                </div>
                                <!-- Total Amount -->
                                <p class="text-success font-weight-bold"><?php echo e(translate('Total')); ?>: <?php echo e(\App\CentralLogics\Helpers::format_currency($con?->order?->order_amount)); ?></p>
                            </div>
                            <!-- Order Date -->
                                <p class="text-muted mb-2 text-right text-dark"> <span class="text-muted fs-12"><?php echo e(translate('Order Placed')); ?></span> <br> <?php echo e(\App\CentralLogics\Helpers::date_format($con?->order?->created_at)); ?></p>
                            </div>
                            <br />
                    <div class="d-flex justify-content-betweeen align-items-center">
                        <div class="w-0 flex-grow-1">
                            <!-- Delivery Address -->
                            <h6 class="font-weight-bold"> <?php echo e(translate('Delivery Address')); ?>  </h6>
                            <?php
                                $delivery_address = json_decode($con?->order?->delivery_address,true);
                            ?>
                            <p class="mb-1"><?php echo e(data_get($delivery_address ,'contact_person_number')); ?></p>
                            <p><?php echo e(data_get($delivery_address ,'address')); ?></p>
                        </div>
                            <!-- Items count -->
                            <?php if($con?->order?->details_count > 0): ?>
                                <div class="d-flex justify-content-end">
                                    <div class="border rounded p-2 text-center">
                                        <p class="mb-0 font-weight-bold"><?php echo e(translate('Items')); ?></p>
                                        <h5 class="mb-0"> <?php echo e($con?->order?->details_count); ?></h5>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

                <?php endif; ?>
                    <div class="pt1 pb-1">
                        <div class="conv-reply-1">
                                <h6><?php echo e($con->message); ?></h6>
                                <?php if($con->file!=null): ?>
                                <?php $__currentLoopData = $con->file_full_url; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <br>
                                    <img class="w-100 mb-3"

                                    src="<?php echo e($img); ?>"
                                    >
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                        </div>
                        <div class="pl-1">
                            <small><?php echo e(date('d M Y',strtotime($con->created_at))); ?> <?php echo e(date(config('timeformat'),strtotime($con->created_at))); ?></small>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="pt-1 pb-1">
                        <div class="conv-reply-2">
                            <h6><?php echo e($con->message); ?> </h6>
                            <?php if($con->file!=null): ?>
                            <?php $__currentLoopData = $con->file_full_url; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <br>
                                <img class="w-100 mb-3"

                                src="<?php echo e($img); ?>"
                                >
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="text-right pr-1">
                            <small><?php echo e(date('d M Y',strtotime($con->created_at))); ?> <?php echo e(date(config('timeformat'),strtotime($con->created_at))); ?></small>
                            <?php if($con->is_seen == 1): ?>
                            <span class="text-primary"><i class="tio-checkmark-circle"></i></span>
                            <?php else: ?>
                            <span><i class="tio-checkmark-circle-outlined"></i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div id="scroll-here"></div>
        </div>

    </div>
    <!-- Body -->
    <div class="card-footer border-0 conv-reply-form">

        <form action="javascript:" method="post" id="reply-form" enctype="multipart/form-data" class="conv-txtarea">
            <?php echo csrf_field(); ?>
            <div class="quill-custom_">
                <!-- <label for="msg" class="layer-msg"></label> -->
                <textarea id="conv-textarea" class="form-control pr--180" id="msg" rows = "1" name="reply" placeholder="<?php echo e(translate('Start a new message')); ?>"></textarea>
                <div class="upload__box">
                    <div class="upload__img-wrap"></div>
                    <div id="file-upload-filename" class="upload__file-wrap"></div>
                    <div class="upload-btn-grp">
                        <label class="m-0">
                            <img src="<?php echo e(asset('/public/assets/admin/img/gallery.png')); ?>" alt="">
                            <input type="file" name="images[]" class="d-none upload_input_images" data-max_length="2"  multiple="" accept="image/jpeg, image/png">
                        </label>
                        <label class="m-0 emoji-icon-hidden">
                            <img src="<?php echo e(asset('/public/assets/admin/img/emoji.png')); ?>" alt="">
                        </label>
                    </div>
                </div>

                <button type="submit"
                        class="btn btn-primary btn--primary con-reply-btn"><?php echo e(translate('messages.send')); ?>

                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<!-- Emoji Conv -->
<script>
    "use strict";
    $(document).ready(function() {
        $("#conv-textarea").emojioneArea({
            pickerPosition: "top",
            tonesStyle: "bullet",
                events: {
                    keyup: function (editor, event) {
                        console.log(editor.html());
                        console.log(this.getText());
                    }
                }
            });
    });

    // Image Upload
    jQuery(document).ready(function () {
        ImgUpload();
    });
    function ImgUpload() {
    let imgWrap = "";
    let imgArray = [];

    $('.upload_input_images').each(function () {
        $(this).on('change', function (e) {
        imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
        let maxLength = $(this).attr('data-max_length');

        let files = e.target.files;
        let filesArr = Array.prototype.slice.call(files);
        console.log(filesArr);
        let iterator = 0;
        filesArr.forEach(function (f, index) {

            if (!f.type.match('image.*')) {
            return;
            }

            if (imgArray.length > maxLength) {
            return false
            } else {
            let len = 0;
            for (let i = 0; i < imgArray.length; i++) {
                if (imgArray[i] !== undefined) {
                len++;
                }
            }
            if (len > maxLength) {
                return false;
            } else {
                imgArray.push(f);

                let reader = new FileReader();
                reader.onload = function (e) {
                let html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                imgWrap.append(html);
                iterator++;
                }
                reader.readAsDataURL(f);
            }
            }
        });
        });
    });

    $('body').on('click', ".upload__img-close", function (e) {
        let file = $(this).parent().data("file");
        for (let i = 0; i < imgArray.length; i++) {
        if (imgArray[i].name === file) {
            imgArray.splice(i, 1);
            break;
        }
        }
        $(this).parent().parent().remove();
    });
    }

    //File Upload
    $('#file-upload').change(function(e){
        let fileName = e.target.files[0].name;
        $('#file-upload-filename').text(fileName)
    });


    $(document).ready(function () {
        $('.scroll-down').animate({
            scrollTop: $('#scroll-here').offset().top
        },0);
    });


    $(function() {
        $("#coba").spartanMultiImagePicker({
            fieldName: 'images[]',
            maxCount: 3,
            rowHeight: '55px',
            groupClassName: 'attc--img border-0',
            maxFileSize: '',
            placeholderImage: {
                image: '<?php echo e(asset('public/assets/admin/img/gallery.png')); ?>',
                width: '100%'
            },
            dropFileLabel: "Drop Here",
            onAddRow: function(index, file) {

            },
            onRenderedPreview: function(index) {

            },
            onRemoveRow: function(index) {

            },
            onExtensionErr: function(index, file) {
                toastr.error('<?php echo e(translate('messages.please_only_input_png_or_jpg_type_file')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
            },
            onSizeErr: function(index, file) {
                toastr.error('<?php echo e(translate('messages.file_size_too_big')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });
    });


    $('#reply-form').on('submit', function() {
        $('button[type=submit], input[type=submit]').prop('disabled',true);
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.message.store', [$user->user_id])); ?>',
                data: $('reply-form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    if (data.errors && data.errors.length > 0) {
                        $('button[type=submit], input[type=submit]').prop('disabled',false);
                        toastr.error('Write something to send massage!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }else{

                        toastr.success('Message sent', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        $('#admin-view-conversation').html(data.view);
                        conversationList();
                    }
                },
                error() {
                    toastr.error('Write something to send massage!', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
</script>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/messages/partials/_conversations.blade.php ENDPATH**/ ?>