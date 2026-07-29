<?php $__env->startSection('title', translate('Add new zone')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php ($zone_instruction = session()?->get('zone-instruction') ?? '0'); ?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">

            <span>
                <?php echo e(translate('messages.Zone_setup')); ?>

            </span>
        </h1>
    </div>

    <div class="bg-opacity-primary-10 rounded py-2 px-3 d-flex flex-wrap gap-1 align-items-center mb-20">
        <div class="gap-1 d-flex align-items-center">
            <i class="tio-light-on theme-clr-dark fs-16"></i>
            <p class="m-0 fs-12"><?php echo e(translate('After you create a new zone, use this')); ?></p>
        </div>
        <p class="m-0">
            <img src="<?php echo e(asset('public/assets/admin/img/icons/path-icon.svg')); ?>" alt=""> <?php echo e(translate('button to.')); ?> <a
                href="#0" class="font-semibold text-title"><?php echo e(translate('Connect Module.')); ?></a>
            <?php echo e(translate('If you don’t connect a module, it won’t show in the zone')); ?>.
        </p>
    </div>

    <!-- End Page Header -->
    <div class="row g-3">
        <div class="col-12">
            <form action="javascript:" method="post" id="zone_form" class="shadow--card">
                <div class="card-header flex-wrap gap-1 pt-0 mb-20">
                    <h4 class="mb-0"><?php echo e(translate('Add New Zone')); ?></h4>
                    <a href="#0"
                        class="border-primary py-2 px-3 border d-flex align-items-center gap-2 fs-14 font-semibold theme-clr-dark bg-opacity-primary-10 rounded-pill offcanvas-trigger"
                        data-target="#instruction__customBtn2">
                        <?php echo e(translate('View Demo')); ?> <i class="tio-info-outined"></i>
                    </a>
                </div>
                <?php echo csrf_field(); ?>
                <div class="row g-3 justify-content-between">
                    <div class="col-md-6">
                        <div class="bg-light rounded p-20">
                            <?php if($language): ?>
                                <ul class="nav nav-tabs mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link lang_link active" href="#"
                                            id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                    </li>
                                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item">
                                            <a class="nav-link lang_link" href="#"
                                                id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <span class="form-label-secondary text-danger" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Choose_your_preferred_language_&_set_your_zone_name.')); ?>"><img
                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="<?php echo e(translate('messages.veg_non_veg')); ?>"></span>
                                </ul>
                                <div class="tab-content">
                                    <div class="row g-3 lang_form" id="default-form">
                                        <div class="form-group col-12 mb-0">
                                            <label class="input-label"
                                                for="exampleFormControlInput1"><?php echo e(translate('messages.business_Zone_name')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)</label>
                                            <input type="text" name="name[]" class="form-control"
                                                placeholder="<?php echo e(translate('messages.Write_a_New_Business_Zone_Name')); ?>"
                                                maxlength="191">
                                        </div>
                                        <div class="form-group col-12 mb-0">
                                            <label class="input-label"
                                                for="exampleFormControlInput1"><?php echo e(translate('messages.display_name')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)</label>
                                            <input type="text" name="display_name[]" class="form-control"
                                                placeholder="<?php echo e(translate('messages.Write_a_New_Display_Zone_Name')); ?>"
                                                maxlength="191">
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row g-3 lang_form d-none" id="<?php echo e($lang); ?>-form">
                                            <div class="form-group col-12 mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.business_Zone_name')); ?>

                                                    (<?php echo e(strtoupper($lang)); ?>)</label>
                                                <input type="text" name="name[]" class="form-control"
                                                    placeholder="<?php echo e(translate('messages.Write_a_New_Business_Zone_Name')); ?>"
                                                    maxlength="191">
                                            </div>
                                            <div class="form-group col-12 mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.display_name')); ?>

                                                    (<?php echo e(strtoupper($lang)); ?>)</label>
                                                <input type="text" name="display_name[]" class="form-control"
                                                    placeholder="<?php echo e(translate('messages.Write_a_New_Display_Zone_Name')); ?>"
                                                    maxlength="191">
                                            </div>
                                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-15">
                            <h5 class="mb-0"><?php echo e(translate('Select Area')); ?></h5>
                            <p class="fs-12 m-0">
                                <?php echo e(translate('To select an area click on map and connect the dots together')); ?>

                            </p>
                        </div>
                        <div class="form-group mb-3 d-none">
                            <label class="input-label"
                                for="exampleFormControlInput1"><?php echo e(translate('Coordinates')); ?><span
                                    class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.draw_your_zone_on_the_map')); ?>"><?php echo e(translate('messages.draw_your_zone_on_the_map')); ?></span></label>
                            <textarea type="text" rows="8" name="coordinates" id="coordinates" class="form-control"
                                readonly></textarea>
                        </div>
                        <div class="map-warper map-controler rounded mt-0">
                            <input id="pac-input" class="controls rounded"
                                title="<?php echo e(translate('messages.search_your_location_here')); ?>" type="text"
                                placeholder="<?php echo e(translate('messages.search_here')); ?>" />
                            <div id="map-canvas" class="rounded"></div>
                        </div>
                    </div>
                </div>
                <div class="btn--container mt-3 justify-content-end">
                    <button id="reset_btn" type="reset"
                        class="btn min-w-120 btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                    <button type="submit" class="btn min-w-120 btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                </div>
            </form>
        </div>



        <div class="col-12">
            <div class="card">
                <div class="card-header py-2 border-0">
                    <div class="search--button-wrapper">
                        <h5 class="card-title">
                            <?php echo e(translate('messages.zone_list')); ?><span class="badge badge-soft-dark ml-2"
                                id="itemCount"><?php echo e($zones->total()); ?></span>
                        </h5>
                        <form class="search-form">
                            <!-- Search -->
                            <div class="input-group input--group">
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    placeholder="<?php echo e(translate('messages.Search_Business_Zone')); ?>"
                                    value="<?php echo e(request()?->search ?? null); ?>"
                                    aria-label="<?php echo e(translate('messages.search')); ?>" required>
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                            <!-- End Search -->
                        </form>
                        <!-- Unfold -->
                        <div class="hs-unfold mr-2">
                            <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                                href="javascript:;" data-hs-unfold-options='{
                                            "target": "#usersExportDropdown",
                                            "type": "css-animation"
                                        }'>
                                <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                            </a>
                            <div id="usersExportDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                <a id="export-excel" class="dropdown-item"
                                    href="<?php echo e(route('admin.business-settings.zone.export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                        alt="Image Description">
                                    <?php echo e(translate('messages.excel')); ?>

                                </a>
                                <a id="export-csv" class="dropdown-item"
                                    href="<?php echo e(route('admin.business-settings.zone.export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                        alt="Image Description">
                                    .<?php echo e(translate('messages.csv')); ?>

                                </a>
                            </div>
                        </div>
                        <!-- End Unfold -->
                    </div>
                </div>
                <!-- Table -->
                <?php if ($__env->exists('admin-views.zone.partials._table', ['zones' => $zones])) echo $__env->make('admin-views.zone.partials._table', ['zones' => $zones], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <!-- End Table -->
    </div>
</div>
<?php if($zone_instruction == '0'): ?>

    <div class="modal fade" id="warning-modal">
        <div class="modal-dialog modal-lg warning-modal">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h3 class="modal-title mb-3"><?php echo e(translate('New_Business_Zone_Created_Successfully!')); ?></h3>
                        <span class="text-danger">
                            <?php echo e(translate('NEXT_IMPORTANT_STEP:')); ?>

                        </span>
                        <?php echo e(translate('You need to select')); ?> <span class="text-dark text-bold text-capitalize">
                            ‘<?php echo e(translate('Payment Method')); ?>’
                        </span> <span class="text-lowercase"> <?php echo e(translate('and add')); ?></span>
                        <span class="text-dark text-capitalize text-bold">‘<?php echo e(translate('Business Modules')); ?>’ </span>
                        <span class="text-lowercase">
                            <?php echo e(translate('with other details from the.')); ?>

                        </span>
                        <a href="#" class="" id="module-setup-modal-button-2"><?php echo e(translate('Connect Module')); ?> </a>.
                        <span>
                            <?php echo e(translate('If you don’t finish the setup the Zone you created won’t function properly.')); ?>

                        </span>
                    </div>
                    <img src="<?php echo e(asset('/public/assets/admin/img/zone-settings-popup-arro.gif')); ?>" alt="admin/img"
                        class="w-100">
                    <div class="mt-3 d-flex flex-wrap align-items-center justify-content-between">
                        <label class="form-check form--check m-0">
                            <input type="checkbox" class="form-check-input rounded redirect-url"
                                data-url="<?php echo e(route('admin.business-settings.zone.instruction')); ?>">
                            <span class="form-check-label"><?php echo e(translate("Don't show this anymore")); ?></span>
                        </label>
                        <div class="btn--container justify-content-end">
                            <button id="reset_btn" type="reset" class="btn btn--reset"
                                data-dismiss="modal"><?php echo e(translate("I will do it later")); ?></button>
                            <a id="module-setup-modal-button"
                                data-url="<?php echo e(route('admin.business-settings.zone.go-module-setup')); ?>"
                                class="btn btn--primary redirect-url"><?php echo e(translate('Go_to_zone_Settings')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" id="status-warning-modal">
    <div class="modal-dialog status-warning-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="tio-clear"></span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <div class="text-center mb-20">
                    <img src="<?php echo e(asset('/public/assets/admin/img/zone-status-on.png')); ?>" alt="" class="mb-20">
                    <h5 class="modal-title">
                        <?php echo e(translate('By switching the status to “ON”,  this zone and under all the functionality of this zone will be turned on')); ?>

                    </h5>
                    <p class="txt">
                        <?php echo e(translate("In the user app & website all stores & products  already assigned under this zone will show to the customers")); ?>

                    </p>
                </div>
                <div class="btn--container justify-content-center">
                    <button type="submit" class="btn btn--primary min-w-120"
                        data-dismiss="modal"><?php echo e(translate('Ok')); ?></button>
                    <button id="reset_btn" type="reset" class="btn btn--cancel min-w-120"
                        data-dismiss="modal"><?php echo e(translate("Cancel")); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="offcanvasOverlay" class="offcanvas-overlay"></div>
<div id="instruction__customBtn2" class="custom-offcanvas d-flex flex-column justify-content-between">
    <div class="offcanvas-inner">
        <div class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
            <h3 class="mb-0 theme-clr-dark"><?php echo e(translate('Instructions')); ?></h2>
                <button type="button"
                    class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"
                    aria-label="Close">&times;</button>
        </div>
        <div class="custom-offcanvas-body p-20">
            <div class="zone-setup-instructions">
                <div class="zone-setup-top">
                    <p>
                        <?php echo e(translate('Create_&_connect_dots_in_a_specific_area_on_the_map_to_add_a_new_business_zone.')); ?>

                    </p>
                </div>
                <div class="zone-setup-item">
                    <div class="zone-setup-icon">
                        <i class="tio-hand-draw"></i>
                    </div>
                    <div class="info">
                        <?php echo e(translate('Use_this_‘Hand_Tool’_to_find_your_target_zone.')); ?>

                    </div>
                </div>
                <div class="zone-setup-item">
                    <div class="zone-setup-icon">
                        <i class="tio-free-transform"></i>
                    </div>
                    <div class="info">
                        <?php echo e(translate('Use_this_‘Shape_Tool’_to_point_out_the_areas_and_connect_the_dots._Minimum_3_points/dots_are_required.')); ?>

                    </div>
                </div>
                <div class="instructions-image mt-4">
                    <img src="<?php echo e(asset('public/assets/admin/img/instructions.gif')); ?>" alt="instructions">
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer p-3 d-flex align-items-center justify-content-center gap-3">

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>&callback=initialize&libraries=drawing,places,marker&v=3.61"></script>
<script>
    "use strict";
    $(".popover-wrapper").click(function () {
        $(".popover-wrapper").removeClass("active");
    });

    $('.status_form_alert').on('click', function (event) {
        let id = $(this).data('id');
        let title = $(this).data('title');
        let message = $(this).data('message');
        status_form_alert(id, title, message, event)
    })

    function status_form_alert(id, title, message, e) {
        e.preventDefault();
        Swal.fire({
            title: title,
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
                $('#' + id).submit()
            }
        })
    }
    auto_grow();
    function auto_grow() {
        let element = document.getElementById("coordinates");
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
    }


    $(document).on('ready', function () {
        // INITIALIZATION OF DATATABLES
        // =======================================================
        let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

        $('#column1_search').on('keyup', function () {
            datatable
                .columns(1)
                .search(this.value)
                .draw();
        });


        $('#column3_search').on('change', function () {
            datatable
                .columns(2)
                .search(this.value)
                .draw();
        });


        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
            let select2 = $.HSCore.components.HSSelect2.init($(this));
        });

        $("#zone_form").on('keydown', function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }
        })
    });

    let map; // Global declaration of the map
    let drawingManager;
    let lastpolygon = null;
    let polygons = [];

    function resetMap(controlDiv) {
        // Set CSS for the control border.
        const controlUI = document.createElement("div");
        controlUI.style.backgroundColor = "#fff";
        controlUI.style.border = "2px solid #fff";
        controlUI.style.borderRadius = "3px";
        controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        controlUI.style.cursor = "pointer";
        controlUI.style.marginTop = "8px";
        controlUI.style.marginBottom = "22px";
        controlUI.style.textAlign = "center";
        controlUI.title = "Reset map";
        controlDiv.appendChild(controlUI);
        // Set CSS for the control interior.
        const controlText = document.createElement("div");
        controlText.style.color = "rgb(25,25,25)";
        controlText.style.fontFamily = "Roboto,Arial,sans-serif";
        controlText.style.fontSize = "10px";
        controlText.style.lineHeight = "16px";
        controlText.style.paddingLeft = "2px";
        controlText.style.paddingRight = "2px";
        controlText.innerHTML = "X";
        controlUI.appendChild(controlText);
        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener("click", () => {
            lastpolygon.setMap(null);
            $('#coordinates').val('');

        });
    }

    function initialize() {
        <?php ($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first()); ?>
        <?php ($default_location = $default_location->value ? json_decode($default_location->value, true) : 0); ?>
        let myLatlng = { lat: <?php echo e($default_location ? $default_location['lat'] : '23.757989'); ?>, lng: <?php echo e($default_location ? $default_location['lng'] : '90.360587'); ?> };
        const mapId = "<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>"

        let myOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapId: mapId

        }
        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            },
            polygonOptions: {
                editable: true
            }
        });
        drawingManager.setMap(map);


        //get current location block
        // infoWindow = new google.maps.InfoWindow();
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    map.setCenter(pos);
                });
        }

        drawingManager.addListener("overlaycomplete", function (event) {
            if (lastpolygon) {
                lastpolygon.setMap(null);
            }
            $('#coordinates').val(event.overlay.getPath().getArray());
            lastpolygon = event.overlay;
            auto_grow();
        });

        const resetDiv = document.createElement("div");
        resetMap(resetDiv, lastpolygon);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);

        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });
        let markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                const { AdvancedMarkerElement } = google.maps.marker;

                // Create a marker for each place.
                markers.push(
                    new AdvancedMarkerElement({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    // initialize();


    function set_all_zones() {
        $.get({
            url: '<?php echo e(route('admin.zone.zoneCoordinates')); ?>',
            dataType: 'json',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    polygons.push(new google.maps.Polygon({
                        paths: data[i],
                        strokeColor: "#FF0000",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "#FF0000",
                        fillOpacity: 0.1,
                    }));
                    polygons[i].setMap(map);
                }

            },
        });
    }
    $(document).on('ready', function () {
        set_all_zones();
    });


    $('#zone_form').on('submit', function () {
        let formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '<?php echo e(route('admin.business-settings.zone.store')); ?>',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (index, value) {
                        toastr.error(value.message);
                    });
                }
                else {
                    $('.tab-content').find('input:text').val('');
                    $('input[name="name"]').val(null);
                    lastpolygon.setMap(null);
                    $('#coordinates').val(null);
                    toastr.success("<?php echo e(translate('messages.zone_added_successfully')); ?>", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.total);
                    $("#module-setup-modal-button").prop("href", '<?php echo e(url('/')); ?>/admin/business-settings/zone/module-setup/' + data.id)
                    $("#module-setup-modal-button-2").prop("href", '<?php echo e(url('/')); ?>/admin/business-settings/zone/module-setup/' + data.id)
                    $("#warning-modal").modal("show");
                }
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    });

    $('#reset_btn').click(function () {
        $('.tab-content').find('input:text').val('');

        lastpolygon.setMap(null);
        $('#coordinates').val(null);
    })
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/zone/index.blade.php ENDPATH**/ ?>