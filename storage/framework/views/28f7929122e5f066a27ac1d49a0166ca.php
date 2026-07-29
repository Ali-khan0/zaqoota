<?php $__env->startSection('title', translate('messages.social_media')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('/public/assets/admin/img/social.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                     <?php echo e(translate('social_media')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card mb-3">
            <div class="card-body">
                <form class="text-left" action="javascript:">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label"><?php echo e(translate('messages.name')); ?></label>
                                <select class="form-control w-100" name="name" id="name">
                                    <option>---<?php echo e(translate('messages.select')); ?>---</option>
                                    <option value="instagram"><?php echo e(translate('messages.Instagram')); ?></option>
                                    <option value="facebook"><?php echo e(translate('messages.Facebook')); ?></option>
                                    <option value="twitter"><?php echo e(translate('messages.Twitter')); ?></option>
                                    <option value="linkedin"><?php echo e(translate('messages.LinkedIn')); ?></option>
                                    <option value="pinterest"><?php echo e(translate('messages.Pinterest')); ?></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" id="id">
                                <label for="link"
                                    class="form-label <?php echo e(Session::get('direction') === 'rtl' ? 'mr-1' : ''); ?>"><?php echo e(translate('messages.social_media_link')); ?></label>
                                <input type="text" name="link" class="form-control" id="link"
                                    placeholder="<?php echo e(translate('messages.social_media_link')); ?>" required>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" id="id">
                            </div>

                        </div>
                    </div>
                    <div class="btn--container justify-content-end">
                        <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button id="add" class="btn btn--primary"><?php echo e(translate('messages.save')); ?></button>
                        <a href="javascript:" id="update" class="initial-hidden btn btn--primary"><?php echo e(translate('messages.update')); ?></a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0" scope="col"><?php echo e(translate('messages.sl')); ?></th>
                                <th class="border-0" scope="col"><?php echo e(translate('messages.name')); ?></th>
                                <th class="border-0" scope="col"><?php echo e(translate('messages.link')); ?></th>
                                <th class="border-0" scope="col"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0" scope="col"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        fetch_social_media();

        function fetch_social_media() {

            $.ajax({
                url: "<?php echo e(route('admin.business-settings.social-media.fetch')); ?>",
                method: 'GET',
                success: function(data) {
                    if (data.length !== 0) {
                        let html = '';
                        for (let count = 0; count < data.length; count++) {
                            html += '<tr>';
                            html += '<td class="column_name" data-column_name="sl" data-id="' + data[count].id +
                                '">' + (count + 1) + '</td>';
                            html += '<td class="column_name" data-column_name="name" data-id="' + data[count]
                                .id + '">' + data[count].name + '</td>';
                            html += '<td class="column_name" data-column_name="slug" data-id="' + data[count]
                                .id + '">' + data[count].link + '</td>';
                            html += `<td class="column_name" data-column_name="status" data-id="${data[count].id}">
                            <label class="toggle-switch toggle-switch-sm" for="${data[count].id}">
                                    <input type="checkbox" class="toggle-switch-input status" id="${data[count].id}" ${data[count].status === 1 ? "checked" : ""}>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                        </td>`;
                            html += '<td><a type="button" class="btn btn--primary btn-outline-primary edit action-btn" id="' + data[
                                count].id + '"><i class="tio-edit"></i></a> </td></tr>';
                        }
                        $('tbody').html(html);
                    }
                }
            });
        }

        $('#add').on('click', function() {
            // $('#add').attr("disabled", true);
            let name = $('#name').val();
            let link = $('#link').val();
            if (name === "") {
                toastr.error('<?php echo e(translate('messages.social_media_required')); ?>.');
                return false;
            }
            if (link === "") {
                toastr.error('<?php echo e(translate('messages.social_media_required')); ?>.');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(route('admin.business-settings.social-media.store')); ?>",
                method: 'POST',

                data: {
                    name: name,
                    link: link
                },
                success: function(response) {
                    if (response.error === 1) {
                        toastr.error('<?php echo e(translate('messages.social_media_exist')); ?>');
                    } else {
                        toastr.success('<?php echo e(translate('messages.social_media_inserted')); ?>.');
                    }
                    $('#name').val('');
                    $('#link').val('');
                    fetch_social_media();
                }
            });
        });
        $(document).on('click', '.edit', function() {
            $('#update').show();
            $('#add').hide();
            let id = $(this).attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(url('admin/business-settings/pages/social-media')); ?>/" + id,
                method: 'GET',
                success: function(data) {
                    $(window).scrollTop(0);
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#link').val(data.link);
                    fetch_social_media()
                }
            });
        });

        $('#update').on('click', function() {
            $('#update').attr("disabled", true);
            let id = $('#id').val();
            let name = $('#name').val();
            let link = $('#link').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(url('admin/business-settings/pages/social-media')); ?>/" + id,
                method: 'PUT',
                data: {
                    id: id,
                    name: name,
                    link: link,
                },
                success: function() {
                    $('#name').val('');
                    $('#link').val('');

                    toastr.success('<?php echo e(translate('messages.social_media_updated')); ?>');
                    $('#update').hide();
                    $('#add').show();
                    fetch_social_media();

                }
            });
            $('#save').hide();
        });
        $(document).on('click', '.delete', function() {
            let id = $(this).attr("id");
            if (confirm("<?php echo e(translate('messages.are_u_sure_want_to_delete')); ?>?")) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "<?php echo e(url('admin/business-settings/social-media/destroy')); ?>/" + id,
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function() {
                        fetch_social_media();
                        toastr.success('<?php echo e(translate('messages.social_media_deleted')); ?>.');
                    }
                });
            }
        });

        $(document).on('change', '.status', function() {
            let id = $(this).attr("id");
            let status;
            if ($(this).prop("checked") === true) {
                 status = 1;
            } else if ($(this).prop("checked") === false) {
                 status = 0;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(route('admin.business-settings.social-media.status-update')); ?>",
                method: 'get',
                data: {
                    id: id,
                    status: status
                },
                success: function() {
                    toastr.success('<?php echo e(translate('messages.status_updated')); ?>');
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/social-media.blade.php ENDPATH**/ ?>