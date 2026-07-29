<!DOCTYPE html>
<?php
    if (env('APP_MODE') == 'demo') {
        $site_direction = session()->get('site_direction_vendor');
    }else{
        $site_direction = session()->has('vendor_site_direction')?session()->get('vendor_site_direction'):'ltr';
    }
    $country=\App\Models\BusinessSetting::where('key','country')->first();
    $countryCode= strtolower($country?$country->value:'auto');

    $storeId = \App\CentralLogics\Helpers::get_store_id();
    $store = \App\Models\Store::findOrFail($storeId);
    $moduleType = $store?->module?->module_type;
?>

<html dir="<?php echo e($site_direction); ?>" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"  class="<?php echo e($site_direction === 'rtl'?'active':''); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Title -->
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Favicon -->
    <?php ($logo = \App\Models\BusinessSetting::where(['key'=>'icon'])->first()); ?>
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/x-icon" href="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $logo?->value?? '', $logo?->storage[0]?->value ?? 'public','favicon')); ?>">
    <!-- Font -->
    <link href="<?php echo e(asset('public/assets/admin/css/fonts.css')); ?>" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/vendor.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/vendor/icon-set/style.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/theme.minc619.css?v=1.0">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/emogi-area.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/intltelinput/css/intlTelInput.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/owl.min.css')); ?>">
    <?php echo $__env->yieldPushContent('css_or_js'); ?>

    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside-mini-cache.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/toastr.css">
</head>

<body class="footer-offset">
    <?php if(env('APP_MODE')=='demo'): ?>
    <div class="direction-toggle">
        <i class="tio-settings"></i>
        <span></span>
    </div>
    <?php endif; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" class="initial-hidden">
                <div class="loading-inner">
                    <img width="200" src="<?php echo e(asset('public/assets/admin/img/loader.gif')); ?>">
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Builder -->
<?php echo $__env->make('layouts.vendor.partials._front-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- End Builder -->

<!-- JS Preview mode only -->
<?php echo $__env->make('layouts.vendor.partials._header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if( isset($moduleType) && $moduleType == 'rental'): ?>
        <?php echo $__env->make("rental::provider.partials._sidebar_{$moduleType}", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('layouts.vendor.partials._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<!-- END ONLY DEV -->

<main id="content" role="main" class="main pointer-event">
    <!-- Content -->
<?php echo $__env->yieldContent('content'); ?>

<!-- End Content -->

    <!-- Footer -->
<?php echo $__env->make('layouts.vendor.partials._footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!-- End Footer -->

    <div class="d-none" id="text-validate-translate"
        data-required="<?php echo e(translate('this_field_is_required')); ?>"
        data-something-went-wrong="<?php echo e(translate('something_went_wrong!')); ?>"
        data-max-limit-crossed="<?php echo e(translate('max_limit_crossed')); ?>"
        data-file-size-larger="<?php echo e(translate('file_size_is_larger')); ?>"
        data-passwords-do-not-match="<?php echo e(translate('passwords_do_not_match')); ?>"
        data-valid-email="<?php echo e(translate('please_enter_a_valid_email')); ?>"
        data-password-validation="<?php echo e(translate('password_must_be_8+_chars_with_upper,_lower,_number_&_symbol')); ?>"
    ></div>


    <div class="modal fade" id="toggle-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img id="toggle-image" alt="" class="mb-20">
                                <h5 class="modal-title" id="toggle-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-message">
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="button" id="toggle-ok-button" class="btn btn--primary min-w-120 confirm-Toggle" data-dismiss="modal"><?php echo e(translate('Ok')); ?></button>
                            <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">
                                <?php echo e(translate("Cancel")); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="toggle-status-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img id="toggle-status-image" alt="" class="mb-20">
                                <h5 class="modal-title" id="toggle-status-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-status-message">
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button type="button" id="toggle-status-ok-button" class="btn btn--primary min-w-120 confirm-Status-Toggle" data-dismiss="modal"><?php echo e(translate('Ok')); ?></button>
                            <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120" data-dismiss="modal">
                                <?php echo e(translate("Cancel")); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">

                                <h2 class="update_notification_text">
                                    <i class="tio-shopping-cart-outlined"></i> <?php echo e(translate('messages.You have new order, Check Please.')); ?>

                                </h2>
                                <hr>
                                <button  class="btn btn-primary check-order"><?php echo e(translate('messages.Ok, let me check')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="new-dynamic-submit-model">
        <div class="modal-dialog modal-dialog-centered status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img id="image-src" class="mb-20">
                                <h5 class="modal-title" id="toggle-title"></h5>
                            </div>
                            <div class="text-center" id="toggle-message">
                                <h3 id="modal-title"></h3>
                                <div id="modal-text"></div>
                            </div>

                            </div>
                            <div class="mb-4 d-none" id="note-data">
                                <textarea class="form-control" placeholder="<?php echo e(translate('your_note_here')); ?>" id="get-text-note" cols="5" ></textarea>
                            </div>
                        <div class="btn--container justify-content-center">
                            <div id="hide-buttons">
                                <div class="d-flex justify-content-center flex-wrap gap-3">
                                    <button data-dismiss="modal" id="cancel_btn_text" class="btn btn--cancel min-w-120" ><?php echo e(translate("Not_Now")); ?></button>
                                    <button type="button" id="new-dynamic-ok-button" class="btn btn-primary confirm-model min-w-120"><?php echo e(translate('Yes')); ?></button>
                                </div>
                            </div>

                            <button data-dismiss="modal"  type="button" id="new-dynamic-ok-button-show" class="btn btn--primary  d-none min-w-120"><?php echo e(translate('Okay')); ?></button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== END SECONDARY CONTENTS ========== -->
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/custom.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/firebase.min.js"></script>
<!-- JS Implementing Plugins -->

<?php echo $__env->yieldPushContent('script'); ?>

<!-- JS Front -->
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/vendor.min.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/theme.min.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/sweet_alert.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/toastr.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/emogi-area.js"></script>
<script src="<?php echo e(asset('public/assets/admin/js/owl.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/admin/js/app-blade/vendor.js')); ?>"></script>
<?php echo Toastr::message(); ?>

<script src="<?php echo e(asset('public/assets/admin/intltelinput/js/intlTelInput.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/admin/js/form-validate.js')); ?>"></script>

<?php if($errors->any()): ?>

<script>
    "use strict";
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    toastr.error('<?php echo e(translate($error)); ?>', Error, {
        CloseButton: true,
        ProgressBar: true
    });
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</script>
<?php endif; ?>

<?php echo $__env->yieldPushContent('script_2'); ?>
<audio id="myAudio">
    <source src="<?php echo e(asset('public/assets/admin/sound/notification.mp3')); ?>" type="audio/mpeg">
</audio>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/common.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin/js/keyword-highlighted.js')); ?>"></script>

<script>
    var audio = document.getElementById("myAudio");

    function playAudio() {
        audio.play();
    }

    function pauseAudio() {
        audio.pause();
    }
"use strict";


    $(window).on('load', function(){
        $('main > .container-fluid.content').prepend($('#renew-badge'));
    })



    $(document).on('ready', function(){
        // $('body').css('overflow','')
        $(".direction-toggle").on("click", function () {
            if($('html').hasClass('active')){
                $('html').removeClass('active')
                setDirection(1);
            }else {
                setDirection(0);
                $('html').addClass('active')
            }
        });
        if ($('html').attr('dir') === "rtl") {
            $(".direction-toggle").find('span').text('Toggle LTR')
        } else {
            $(".direction-toggle").find('span').text('Toggle RTL')
        }

        function setDirection(status) {
            if (status === 1) {
                $("html").attr('dir', 'ltr');
                $(".direction-toggle").find('span').text('Toggle RTL')
            } else {
                $("html").attr('dir', 'rtl');
                $(".direction-toggle").find('span').text('Toggle LTR')
            }
            $.get({
                    url: '<?php echo e(route('vendor.site_direction')); ?>',
                    dataType: 'json',
                    data: {
                        status: status,
                    },
                    success: function() {
                    },

                });
            }
        });


    function route_alert(route, message) {
        Swal.fire({
            title: '<?php echo e(translate('messages.Are you sure?')); ?>',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
            confirmButtonText: '<?php echo e(translate('messages.Yes')); ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href = route;
            }
        })
    }

    $('.form-alert').on('click',function (){
        let id = $(this).data('id')
        let message = $(this).data('message')
        Swal.fire({
            title: '<?php echo e(translate('messages.Are you sure?')); ?>',
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
            confirmButtonText: '<?php echo e(translate('messages.Yes')); ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#'+id).submit()
            }
        })
    })


    function set_filter(url, id, filter_by) {
        let nurl = new URL(url);
        nurl.searchParams.set(filter_by, id);
        location.href = nurl;
    }

    <?php ($fcm_credentials = \App\CentralLogics\Helpers::get_business_settings('fcm_credentials')); ?>
    let firebaseConfig = {
        apiKey: "<?php echo e(isset($fcm_credentials['apiKey']) ? $fcm_credentials['apiKey'] : ''); ?>",
        authDomain: "<?php echo e(isset($fcm_credentials['authDomain']) ? $fcm_credentials['authDomain'] : ''); ?>",
        projectId: "<?php echo e(isset($fcm_credentials['projectId']) ? $fcm_credentials['projectId'] : ''); ?>",
        storageBucket: "<?php echo e(isset($fcm_credentials['storageBucket']) ? $fcm_credentials['storageBucket'] : ''); ?>",
        messagingSenderId: "<?php echo e(isset($fcm_credentials['messagingSenderId']) ? $fcm_credentials['messagingSenderId'] : ''); ?>",
        appId: "<?php echo e(isset($fcm_credentials['appId']) ? $fcm_credentials['appId'] : ''); ?>",
        measurementId: "<?php echo e(isset($fcm_credentials['measurementId']) ? $fcm_credentials['measurementId'] : ''); ?>"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function startFCM() {
        messaging
            .requestPermission()
            .then(function() {
                return messaging.getToken();
            })
            .then(function(token) {
                <?php ($store_id=\App\CentralLogics\Helpers::get_store_id()); ?>
                // Send the token to your backend to subscribe to topic
                subscribeTokenToBackend(token, 'store_panel_<?php echo e($store_id); ?>_message');
            }).catch(function(error) {
            console.error('Error getting permission or token:', error);
        });
    }

    function subscribeTokenToBackend(token, topic) {
        fetch('<?php echo e(url('/')); ?>/subscribeToTopic', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ token: token, topic: topic })
        }).then(response => {
            if (response.status < 200 || response.status >= 400) {
                return response.text().then(text => {
                    throw new Error(`Error subscribing to topic: ${response.status} - ${text}`);
                });
            }
            console.log(`Subscribed to "${topic}"`);
        }).catch(error => {
            console.error('Subscription error:', error);
        });
    }
    function getUrlParameter(sParam) {
            let sPageURL = window.location.search.substring(1);
            let sURLletiables = sPageURL.split('&');
            for (let i = 0; i < sURLletiables.length; i++) {
                let sParameterName = sURLletiables[i].split('=');
                if (sParameterName[0] === sParam) {
                    return sParameterName[1];
                }
            }
        }

        function conversationList() {
            $.ajax({
                url: "<?php echo e(route('vendor.message.list')); ?>",
                success: function(data) {
                    $('#conversation-list').empty();
                    $("#conversation-list").append(data.html);
                    let user_id = getUrlParameter('user');
                    $('.customer-list').removeClass('conv-active');
                    $('#customer-' + user_id).addClass('conv-active');
                }
            })
        }

        function conversationView() {
            let conversation_id = getUrlParameter('conversation');
            let user_id = getUrlParameter('user');
            let url= '<?php echo e(url('/')); ?>/vendor-panel/message/view/'+conversation_id+'/' + user_id;
            $.ajax({
                url: url,
                success: function(data) {
                    $('#view-conversation').html(data.view);
                }
            })
        }
        <?php ($order_notification_type = \App\Models\BusinessSetting::where('key', 'order_notification_type')->first()); ?>
        <?php ($order_notification_type = $order_notification_type ? $order_notification_type->value : 'firebase'); ?>
        let order_type = 'all';
        let is_trip =false;
        messaging.onMessage(function (payload) {
            if(payload.data.order_id && payload.data.type === 'new_order'){
                <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('order') && $order_notification_type == 'firebase'): ?>
                    order_type = payload.data.order_type
                    if(order_type === 'trip'){
                        document.querySelector('.update_notification_text').textContent = "<?php echo e(translate('messages.You have new trip, Check Please.')); ?>";
                        is_trip= true;
                    }
                    playAudio();
                    $('#popup-modal').appendTo("body").modal('show');
                <?php endif; ?>
            }else if(payload.data.type === 'message'){
                if (window.location.href.includes('message/list?conversation')) {
                    let conversation_id = getUrlParameter('conversation');
                    let user_id = getUrlParameter('user');
                    let url = '<?php echo e(url('/')); ?>/vendor-panel/message/view/' + conversation_id + '/' + user_id;
                    $.ajax({
                        url: url,
                        success: function (data) {
                            $('#view-conversation').html(data.view);
                        }
                    })
                }
                toastr.success('<?php echo e(translate('messages.New message arrived')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
                if($('#conversation-list').scrollTop() === 0){
                    conversationList();
                }
            }
        });

        <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('order') && $order_notification_type == 'manual'): ?>
        setInterval(function () {
            $.get({
                url: '<?php echo e(route('vendor.get-store-data')); ?>',
                dataType: 'json',
                success: function (response) {
                    let data = response.data;

                    if(data.order_type === 'trip'){
                        document.querySelector('.update_notification_text').textContent = "<?php echo e(translate('messages.You have new trip, Check Please.')); ?>";
                        is_trip= true;
                    }

                    if (data.new_pending_order > 0) {
                        order_type = 'pending';
                        playAudio();
                        $('#popup-modal').appendTo("body").modal('show');
                    }
                    else if(data.new_confirmed_order > 0)
                    {
                        order_type = 'confirmed';
                        playAudio();
                        $('#popup-modal').appendTo("body").modal('show');
                    }
                },
            });
        }, 10000);
        <?php endif; ?>

        $('.check-order').on('click',function (){
            if(order_type){
                if(is_trip === true){
                    location.href = '<?php echo e(url('/')); ?>/vendor-panel/trip?status=all';
                } else{
                    location.href = '<?php echo e(url('/')); ?>/vendor-panel/order/list/'+order_type;

                }
            }
        });
        startFCM();
        conversationList();
        if(getUrlParameter('conversation')){
            conversationView();
        }


    const inputs = document.querySelectorAll('input[type="tel"]');
            inputs.forEach(input => {
                window.intlTelInput(input, {
                    initialCountry: "<?php echo e($countryCode); ?>",
                    utilsScript: "<?php echo e(asset('public/assets/admin/intltelinput/js/utils.js')); ?>",
                    autoInsertDialCode: true,
                    nationalMode: false,
                    formatOnDisplay: false,
                });
            });


            function keepNumbersAndPlus(inputString) {
                let regex = /[0-9+]/g;
                let filteredString = inputString.match(regex);
            return filteredString ? filteredString.join('') : '';
            }

            $(document).on('keyup', 'input[type="tel"]', function () {
                $(this).val(keepNumbersAndPlus($(this).val()));
                });

    //search option
    $(document).ready(function () {
        $('#searchForm input[name="search"]').keyup(function () {
            var searchKeyword = $(this).val().trim();

            if (searchKeyword.length >= 1) {
                $.ajax({
                    type: 'POST',
                    url: $('#searchForm').attr('action'),
                    data: {search: searchKeyword, _token: $('input[name="_token"]').val()},
                    success: function (response) {
                        if (response.length === 0) {
                            $('#searchResults').html('<div class="fs-16 fw-500 mb-2">' + <?php echo json_encode(translate('Search Result'), 15, 512) ?> + '</div>' +
                                '<div class="search-list h-300 d-flex flex-column gap-2 justify-content-center align-items-center fs-16">' +
                                '<img width="30" src="' + <?php echo json_encode(asset('/public/assets/admin/img/no-search-found.png'), 15, 512) ?> + '" alt="">' + ' ' +
                                <?php echo json_encode(translate('No result found'), 15, 512) ?> +
                                    '</div>');

                        } else {
                            var resultHtml = '';
                            response.forEach(function (route) {
                                var separator = route.fullRoute.includes('?') ? '&' : '?';
                                    var fullRouteWithKeyword = route.fullRoute + separator + 'keyword=' + encodeURIComponent(searchKeyword);

                                    var keywordRegex = searchKeyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                                         keywordRegex = new RegExp('(' + keywordRegex + ')', 'gi');
                                    var highlightedRouteName = route.routeName.replace(keywordRegex, '<mark>$1</mark>');
                                    var highlightedURI = route.URI.replace(keywordRegex, '<mark>$1</mark>');
                                    resultHtml += '<a href="' + fullRouteWithKeyword + '" class="search-list-item d-flex flex-column" data-route-name="' + route.routeName + '" data-route-uri="' + route.URI + '" data-route-full-url="' + route.fullRoute + '" aria-current="true">';
                                    resultHtml += '<h5>' + highlightedRouteName + '</h5>';
                                    resultHtml += '<p class="text-muted fs-12 mb-0">' + highlightedURI + '</p>';
                                    resultHtml += '</a>';
                            });
                            $('#searchResults').html('<div class="fs-16 fw-500 mb-2">' + <?php echo json_encode(translate('Search Result'), 15, 512) ?> + '</div>' + '<div class="search-list d-flex flex-column">' + resultHtml + '</div>');

                            $('.search-list-item').click(function () {
                                var routeName = $(this).data('route-name');
                                var routeUri = $(this).data('route-uri');
                                var routeFullUrl = $(this).data('route-full-url');

                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo e(route('vendor.store.clicked.route')); ?>',
                                    data: {
                                        routeName: routeName,
                                        routeUri: routeUri,
                                        routeFullUrl: routeFullUrl,
                                        searchKeyword: searchKeyword,
                                        _token: $('input[name="_token"]').val()
                                    },
                                    success: function (response) {
                                        console.log(response.message);
                                    },
                                    error: function (xhr, status, error) {
                                        console.error(xhr.responseText);
                                    }
                                });
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#searchResults').html('<div class="text-center text-muted py-5"><?php echo e(translate('Write something to search.')); ?>.</div>');
            }
        });
    });

    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.key === 'k') {
            event.preventDefault();
            document.getElementById('modalOpener').click();
        }
    });

    $(document).ready(function () {
        $("#staticBackdrop").on("shown.bs.modal", function () {
            $(this).find("#searchForm input[type=search]").val('');
            $('#searchResults').html('<div class="text-center text-muted py-5"><?php echo e(translate('Loading recent searches')); ?>...</div>');
            $(this).find("#searchForm input[type=search]").focus();

            $.ajax({
                type: 'GET',
                url: '<?php echo e(route('vendor.recent.search')); ?>',
                success: function (response) {
                    if (response.length === 0) {
                        $('#searchResults').html('<div class="text-center text-muted py-5"><?php echo e(translate('It appears that you have not yet searched.')); ?>.</div>');
                    } else {
                        var resultHtml = '';
                        response.forEach(function (route) {
                            resultHtml += '<a href="' + route.route_full_url + '" class="search-list-item d-flex flex-column" data-route-name="' + route.route_name + '" data-route-uri="' + route.route_uri + '" data-route-full-url="' + route.route_full_url + '" aria-current="true">';
                            resultHtml += '<h5>' + route.route_name + '</h5>';
                            resultHtml += '<p class="text-muted fs-12  mb-0">' + route.route_uri + '</p>';
                            resultHtml += '</a>';
                        });
                        $('#searchResults').html('<div class="recent-search fs-16 fw-500 animate">' +
                            <?php echo json_encode(translate('Recent Search'), 15, 512) ?> + '<div class="search-list d-flex flex-column mt-2">' + resultHtml + '</div></div>');

                        $('.search-list-item').click(function () {
                            var routeName = $(this).data('route-name');
                            var routeUri = $(this).data('route-uri');
                            var routeFullUrl = $(this).data('route-full-url');
                            var searchKeyword = $('input[type=search]').val().trim();

                            $.ajax({
                                type: 'POST',
                                url: '<?php echo e(route('vendor.store.clicked.route')); ?>',
                                data: {
                                    routeName: routeName,
                                    routeUri: routeUri,
                                    routeFullUrl: routeFullUrl,
                                    searchKeyword: searchKeyword,
                                    _token: $('input[name="_token"]').val()
                                },
                                success: function (response) {
                                    console.log(response.message);
                                },
                                error: function (xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#searchResults').html('<div class="text-center text-muted py-5"><?php echo e(translate('Error loading recent searches')); ?>.</div>');
                }
            });
        });
    });

    $("#staticBackdrop").on("hidden.bs.modal", function () {
        $('#searchResults').empty();
    });

    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('search', function() {
        if (!this.value.trim()) {
            $('#searchResults').html('<div class="text-center text-muted py-5"></div>');
        }
    });

    $('#searchForm').submit(function (event) {
        event.preventDefault();
    });


</script>

<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>
<?php /**PATH /var/www/zaqoota/resources/views/layouts/vendor/app.blade.php ENDPATH**/ ?>