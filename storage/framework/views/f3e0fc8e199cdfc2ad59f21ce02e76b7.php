<?php $__env->startSection('title',$store->name."'s ".translate('messages.conversation')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('admin-views.vendor.view.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product">
            <div class="row pt-2">
                <div class="content container-fluid">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-header-title"><?php echo e(translate('messages.conversation_list')); ?></h1>
                    </div>
                    <!-- End Page Header -->

                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <!-- Card -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="input-group input---group">
                                        <div class="input-group-prepend border-inline-end-0">
                                            <span class="input-group-text border-inline-end-0" id="basic-addon1"><i class="tio-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-inline-start-0 pl-1" id="serach" placeholder="<?php echo e(translate('Search')); ?>" aria-label="Username"
                                            aria-describedby="basic-addon1" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" id="vendor_id" value="<?php echo e($store->id); ?>">
                                <!-- Body -->
                                <div class="card-body p-0" style="overflow-y: scroll;height: 600px" id="vendor-conversation-list">
                                    <div class="border-bottom"></div>
                                    <?php echo $__env->make('admin-views.vendor.view.partials._conversation_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </div>
                                <!-- End Body -->
                            </div>
                            <!-- End Card -->
                        </div>
                        <div class="col-lg-8 col-nd-6" id="vendor-view-conversation">
                            <div class="text-center mt-2">
                                <h4 class="initial-29"><?php echo e(translate('messages.view_conversation')); ?>

                                </h4>
                            </div>
                            
                        </div>
                    </div>
                    <!-- End Row -->
                </div>


            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    "use strict";
    $('.view-dm-conv').on('click', function (){
        let url = $(this).data('url');
        let id_to_active = $(this).data('active-id');
        let conv_id = $(this).data('conv-id');
        let sender_id = $(this).data('sender-id');
        viewConvs(url, id_to_active, conv_id, sender_id);
    })
    function viewConvs(url, id_to_active, conv_id, sender_id) {
        $('.customer-list').removeClass('conv-active');
        $('#' + id_to_active).addClass('conv-active');
        let new_url= "<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'conversations'])); ?>" + '?conversation=' + conv_id+ '&user=' + sender_id;
            $.get({
                url: url,
                success: function(data) {
                    window.history.pushState('', 'New Page Title', new_url);
                    $('#vendor-view-conversation').html(data.view);
                }
            });
    }

    let page = 1;
    let user_id =  $('#vendor_id').val();
    $('#vendor-conversation-list').scroll(function() {
        if ($('#vendor-conversation-list').scrollTop() + $('#vendor-conversation-list').height() >= $('#vendor-conversation-list')
            .height()) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page) {
        $.ajax({
                url: "<?php echo e(route('admin.store.message-list')); ?>" + '?page=' + page,
                type: "get",
                data:{"user_id":user_id},
                beforeSend: function() {

                }
            })
            .done(function(data) {
                if (data.html == " ") {
                    return;
                }
                $("#vendor-conversation-list").append(data.html);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('server not responding...');
            });
    };

    function fetch_data(page, query) {
            $.ajax({
                url: "<?php echo e(route('admin.store.message-list')); ?>" + '?page=' + page + "&key=" + query,
                type: "get",
                data:{"user_id":user_id},
                success: function(data) {
                    $('#vendor-conversation-list').empty();
                    $("#vendor-conversation-list").append(data.html);
                }
            })
        };

        $(document).on('keyup', '#serach', function() {
            let query = $('#serach').val();
            fetch_data(page, query);
        });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/vendor/view/conversations.blade.php ENDPATH**/ ?>