<?php $__env->startSection('title', 'Messages'); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

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
                    <!-- Body -->
                    <div class="card-body p-0 initial--11"  id="conversation-list">
                        <div class="border-bottom"></div>
                        <?php echo $__env->make('vendor-views.messages.data', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
            <div class="col-lg-8 col-nd-6" id="view-conversation">
                <div class="text-center view_conversation-style">
                    <h4 class="view_conversation-h4-style"><?php echo e(translate('messages.view_conversation')); ?>

                    </h4>
                </div>
                
            </div>
        </div>
        <!-- End Row -->
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
    <script>
        "use strict";
        function viewConvs(url, id_to_active, conv_id, sender_id) {
            $('.customer-list').removeClass('conv-active');
            $('#' + id_to_active).addClass('conv-active');
            let new_url= "<?php echo e(route('vendor.message.list')); ?>" + '?conversation=' + conv_id+ '&user=' + sender_id;
            $.get({
                url: url,
                success: function(data) {
                    window.history.pushState('', 'New Page Title', new_url);
                    $('#view-conversation').html(data.view);
                    conversationList();
                }
            });

        }

        let page = 1;
        $('#conversation-list').scroll(function() {
            if ($('#conversation-list').scrollTop() + $('#conversation-list').height() >= $('#conversation-list')
                .height()) {
                page++;
                loadMoreData(page);
            }
        });

        function loadMoreData(page) {
            $.ajax({
                    url: "<?php echo e(route('vendor.message.list')); ?>" + '?page=' + page,
                    type: "get",
                    beforeSend: function() {

                    }
                })
                .done(function(data) {
                    if (data.html === " ") {
                        return;
                    }
                    $("#conversation-list").append(data.html);
                })
                .fail(function() {
                    alert('server not responding...');
                });
        }

        function fetch_data(page, query) {
            $.ajax({
                url: "<?php echo e(route('vendor.message.list')); ?>" + '?page=' + page + "&key=" + query,
                success: function(data) {
                    $('#conversation-list').empty();
                    $("#conversation-list").append(data.html);
                }
            })
        }

        $(document).on('keyup', '#serach', function() {
            let query = $('#serach').val();
            fetch_data(page, query);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/messages/index.blade.php ENDPATH**/ ?>