<?php $__env->startSection('title',translate('messages.Delivery Man Preview')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/delivery-man.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e($deliveryMan['f_name'].' '.$deliveryMan['l_name']); ?></span>
            </h1>
            <div class="">
                <?php echo $__env->make('admin-views.delivery-man.partials._tab_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="content">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-header-title"><?php echo e(translate('messages.conversation_list')); ?></h1>
            </div>
            <!-- End Page Header -->

            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <!-- Card -->
                    <div class="card h-100">
                        <div class="card-header border-0">
                            <div class="input-group input---group">
                                <div class="input-group-prepend border-inline-end-0">
                                    <span class="input-group-text border-inline-end-0" id="basic-addon1"><i class="tio-search"></i></span>
                                </div>
                                <input type="text" class="form-control border-inline-start-0 pl-1" id="serach" placeholder="<?php echo e(translate('messages.search')); ?>" aria-label="Username"
                                    aria-describedby="basic-addon1" autocomplete="off">
                            </div>
                        </div>
                        <!-- Body -->
                        <div class="card-body p-0 initial-19"  id="dm-conversation-list">
                            <div class="d-flex justify-content-center gap-4 mb-3 tab-button-group">
                                <button id="customer_conversations" data-url="<?php echo e(route('admin.users.delivery-man.preview', ['id'=>$deliveryMan->id, 'tab'=> 'conversation','conversation_with' =>'customer'])); ?>" class="<?php echo e(request()?->conversation_with != 'store' ? 'active' : 'redirect-url'); ?>"><?php echo e(translate('Customer')); ?></button>
                                <button id="store_conversations" data-url="<?php echo e(route('admin.users.delivery-man.preview', ['id'=>$deliveryMan->id, 'tab'=> 'conversation','conversation_with' =>'store'])); ?>" class="<?php echo e(request()?->conversation_with == 'store' ? 'active' : 'redirect-url'); ?>"><?php echo e(translate('Store')); ?></button>
                            </div>
                            <div id="dm-conversation-list-search">
                                <?php echo $__env->make('admin-views.delivery-man.partials._conversation_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </div>
                <div class="col-lg-8 col-nd-6" id="dm-view-conversation">
                    <div class="h-100 d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <div class="empty-conversation-content d-flex flex-column align-items-center gap-3">
                                <img width="128" height="128" src="<?php echo e(asset('/public/assets/admin/img/icons/empty-conversation.png')); ?>" alt="public">
                                <h5 class="text-muted">
                                    <?php echo e(translate('no_conversation_found')); ?>

                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    "use strict";
    let lastPage =<?php echo e(is_object($conversations) ? $conversations?->lastPage() : 1); ?>;

    $(document).on('click', '.view-conv', function () {
    let url = $(this).data('url');
    let id_to_active = $(this).data('active-id');
    let conv_id = $(this).data('conv-id');
    let sender_id = $(this).data('sender-id');
    viewConvs(url, id_to_active, conv_id, sender_id);
});

    function viewConvs(url, id_to_active, conv_id, sender_id) {
        $('.customer-list').removeClass('conv-active');
        $('#' + id_to_active).addClass('conv-active');
        let new_url= "<?php echo e(route('admin.users.delivery-man.preview', ['id'=>$deliveryMan->id, 'tab'=> 'conversation' , 'conversation_with' => request()?->conversation_with  ? request()?->conversation_with : 'customer'  ])); ?>" + '&conversation=' + conv_id+ '&user=' + sender_id;
            $.get({
                url: url,
                success: function(data) {
                    window.history.pushState('', 'New Page Title', new_url);
                    $('#dm-view-conversation').html(data.view);
                }
            });
    }

    let page = 1;
    let user_id =  <?php echo e($deliveryMan->id); ?>;
    $('#dm-conversation-list').scroll(function() {
        if ($('#dm-conversation-list').scrollTop() + $('#dm-conversation-list').height() >= $('#dm-conversation-list').height()  && lastPage > page ) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page) {
        $.ajax({
                url: "<?php echo e(route('admin.users.delivery-man.message-list-search')); ?>" + '?page=' + page + "&conversation_with=" + "<?php echo e(request()->conversation_with  ? request()->conversation_with : 'customer'); ?>",
                type: "get",
                data:{"user_id":user_id},
                beforeSend: function() {

                }
            })
            .done(function(data) {
                if (data.html == " ") {
                    return;
                }
                $("#dm-conversation-list-search").append(data.html);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('server not responding...');
            });
    };

    function fetch_data(page, query) {
            $.ajax({
                url: "<?php echo e(route('admin.users.delivery-man.message-list-search')); ?>" + '?page=' + page + "&key=" + query + "&conversation_with=" + "<?php echo e(request()->conversation_with  ? request()->conversation_with : 'customer'); ?>",
                type: "get",
                data:{"user_id":user_id},
                success: function(data) {
                    $('#dm-conversation-list-search').empty();
                    $("#dm-conversation-list-search").append(data.html);
                }
            })
        };

        $(document).on('keyup', '#serach', function() {
            let query = $('#serach').val();
            fetch_data(page, query);
        });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/delivery-man/view/conversations.blade.php ENDPATH**/ ?>