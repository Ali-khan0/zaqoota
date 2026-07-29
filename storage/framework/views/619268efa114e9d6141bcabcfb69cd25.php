<?php $__env->startSection('title', translate('messages.POS Orders')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php ($store_data = \App\CentralLogics\Helpers::get_store_data()); ?>
    <section class="section-content padding-y-sm bg-default mt-1">
        <div class="content container-fluid">
            <div class="d-flex flex-wrap">
                <div class="order--pos-left">
                    <div class="card h-100">
                        <div class="card-header bg-light border-0">
                            <h5 class="card-title">
                                <span class="card-header-icon">
                                    <i class="tio-incognito"></i>
                                </span>
                                <span>
                                    <?php echo e(translate('products')); ?>

                                </span>
                            </h5>
                        </div>
                        <div class="card-header d-flex flex-wrap justify-content-between ">
                            <div class="w-100">
                                <div class="row g-2 justify-content-around">
                                    <div class="col-sm-6">
                                        <form id="search-form" class="search-form m-0">
                                            <!-- Search -->
                                            <div class="input-group input--group">
                                                <input id="datatableSearch" type="search"
                                                    value="<?php echo e($keyword ?? ''); ?>" name="search"
                                                    class="form-control h--45px"
                                                    placeholder="<?php echo e(translate('messages.ex_:_search_here')); ?>"
                                                    aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                                <button class="btn btn--secondary h--45px" type="submit"><i
                                                        class="tio-search"></i></button>
                                            </div>
                                            <!-- End Search -->
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <select name="category" id="category" class="form-control js-select2-custom set-filter"
                                                title="<?php echo e(translate('messages.select_category')); ?>"
                                                    data-url="<?php echo e(url()->full()); ?>"
                                                    data-filter="category_id">
                                                <option value=""><?php echo e(translate('messages.all_categories')); ?></option>
                                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>"
                                                        <?php echo e($category == $item->id ? 'selected' : ''); ?>>
                                                        <?php echo e(Str::limit($item->name, 20, '...')); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column" id="items">
                            <div class="row g-3 mb-auto">
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="order--item-box item-box">
                                        <?php echo $__env->make('vendor-views.pos._single_product', [
                                            'product' => $product,
                                            'store' => $store_data,
                                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php if(count($products) >= 13): ?>
                                <hr>
                            <?php endif; ?>
                            <div class="page-area mt-2">
                                <?php echo $products->withQueryString()->links(); ?>

                            </div>
                            <?php if(count($products) === 0): ?>
                                <div class="search--no-found">
                                    <img src="<?php echo e(asset('public/assets/admin/img/search-icon.png')); ?>" alt="img">
                                    <p>
                                        <?php echo e(translate('messages.no_products_on_store_pos_search')); ?>

                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="order--pos-right">
                    <div class="card">
                        <div class="card-header bg-light border-0 m-1">
                            <h5 class="card-title">
                                <span>
                                    <?php echo e(translate('messages.Billing Section')); ?>

                                </span>
                            </h5>
                        </div>
                        <div class="w-100">
                            <div class="d-flex flex-wrap flex-row p-2 add--customer-btn">
                                <select id='customer' name="customer_id"
                                    data-placeholder="<?php echo e(translate('messages.walk_in_customer')); ?>"
                                    class="js-data-example-ajax form-control"></select>
                                <button class="btn btn--primary" data-toggle="modal"
                                    data-target="#add-customer"><?php echo e(translate('messages.add_new_customer')); ?></button>
                            </div>
                            <?php if($store_data->sub_self_delivery == 1): ?>
                                <div class="pos--delivery-options">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title">
                                            <span class="card-title-icon">
                                                <i class="tio-user"></i>
                                            </span>
                                            <span><?php echo e(translate('messages.Delivery Information')); ?></span>
                                        </h5>
                                        <span class="delivery--edit-icon text-primary" id="delivery_address"
                                            data-toggle="modal" data-target="#paymentModal"><i class="tio-edit"></i></span>
                                    </div>
                                    <div class="pos--delivery-options-info d-flex flex-wrap" id="del-add">
                                        <?php echo $__env->make('vendor-views.pos._address', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>


                        <div class='w-100' id="cart">
                            <?php echo $__env->make('vendor-views.pos._cart', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- container //  -->
    </section>

    <div class="modal fade" id="add-customer" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(translate('messages.add_new_customer')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('vendor.pos.customer-store')); ?>" method="post" id="product_form">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="f_name" class="input-label"><?php echo e(translate('first_name')); ?> <span
                                            class="input-label-secondary text-danger">*</span></label>
                                    <input type="text" id="f_name" name="f_name" class="form-control"
                                        placeholder="<?php echo e(translate('first_name')); ?>" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="l_name" class="input-label"><?php echo e(translate('last_name')); ?> <span
                                            class="input-label-secondary text-danger">*</span></label>
                                    <input type="text" id="l_name" name="l_name" class="form-control"
                                        placeholder="<?php echo e(translate('last_name')); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="email" class="input-label"><?php echo e(translate('email')); ?><span
                                            class="input-label-secondary text-danger">*</span></label>
                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="<?php echo e(translate('Ex_:_ex@example.com')); ?>" required>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="phone" class="input-label"><?php echo e(translate('phone')); ?>

                                        (<?php echo e(translate('with_country_code')); ?>)<span
                                            class="input-label-secondary text-danger">*</span></label>
                                    <input id="phone" type="text" name="phone" class="form-control"
                                        placeholder="<?php echo e(translate('phone')); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end">
                            <button type="reset" class="btn btn--reset"><?php echo e(translate('reset')); ?></button>
                            <button type="submit" id="submit_new_customer"
                                class="btn btn--primary"><?php echo e(translate('submit')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
    <div class="modal fade" id="quick-view" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" id="quick-view-modal">

            </div>
        </div>
    </div>

    <?php ($order = \App\Models\Order::find(session('last_order'))); ?>
    <?php if($order): ?>
        <?php (session(['last_order' => false])); ?>
        <div class="modal fade" id="print-invoice" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e(translate('messages.print_invoice')); ?>

                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row ff-emoji">
                        
                        <div class="row m-auto" id="print-modal-content">
                            <?php echo $__env->make('vendor-views.pos.invoice', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>&libraries=places,marker&callback=initMap&v=3.61">
    </script>

    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/pos.js')); ?>"></script>
    <script>
        "use strict";
        $(document).on('click', '.place-order-submit', function (event) {
            event.preventDefault();
            let customer_id = document.getElementById('customer');
            if(customer_id.value)
            {
                document.getElementById('customer_id').value = customer_id.value;
            }
                let form = document.getElementById('order_place');
                form.submit();
        });




        function initMap() {
        const mapId = "<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>"

            let map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: {
                    lat: <?php echo e($store_data ? $store_data['latitude'] : '23.757989'); ?>,
                    lng: <?php echo e($store_data ? $store_data['longitude'] : '90.360587'); ?>

                },
                mapId: mapId
            });

            let zonePolygon = null;

            //get current location block
            let infoWindow = new google.maps.InfoWindow();
            // Try HTML5 geolocation.

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                      let  myLatlng = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        infoWindow.setPosition(myLatlng);
                        infoWindow.setContent("Location found.");
                        infoWindow.open(map);
                        map.setCenter(myLatlng);
                    },
                    () => {
                        handleLocationError(true, infoWindow, map.getCenter());
                    }
                );
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
            //-----end block------
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            let markers = [];
            const bounds = new google.maps.LatLngBounds();
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {

                        return;
                    }
                    if (!google.maps.geometry.poly.containsLocation(
                            place.geometry.location,
                            zonePolygon
                        )) {
                        toastr.error('<?php echo e(translate('messages.out_of_coverage')); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        return false;
                    }

                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();
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
            <?php if($store_data): ?>
                $.get({
                    url: '<?php echo e(url('/')); ?>/admin/zone/get-coordinates/<?php echo e($store_data->zone_id); ?>',
                    dataType: 'json',
                    success: function(data) {
                        zonePolygon = new google.maps.Polygon({
                            paths: data.coordinates,
                            strokeColor: "#FF0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: 'white',
                            fillOpacity: 0,
                        });
                        zonePolygon.setMap(map);
                        zonePolygon.getPaths().forEach(function(path) {
                            path.forEach(function(latlng) {
                                bounds.extend(latlng);
                                map.fitBounds(bounds);
                            });
                        });
                        map.setCenter(data.center);
                        google.maps.event.addListener(zonePolygon, 'click', function(mapsMouseEvent) {
                            infoWindow.close();
                            // Create a new InfoWindow.
                            infoWindow = new google.maps.InfoWindow({
                                position: mapsMouseEvent.latLng,
                                content: JSON.stringify(mapsMouseEvent.latLng.toJSON(), null,
                                    2),
                            });
                            let coordinates;
                             coordinates = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
                             coordinates = JSON.parse(coordinates);

                            document.getElementById('latitude').value = coordinates['lat'];
                            document.getElementById('longitude').value = coordinates['lng'];
                            infoWindow.open(map);

                            let geocoder  = new google.maps.Geocoder();
                            let latlng = new google.maps.LatLng(coordinates['lat'], coordinates['lng']);

                            geocoder.geocode({
                                'latLng': latlng
                            }, function(results, status) {
                                if (status === google.maps.GeocoderStatus.OK) {
                                    if (results[1]) {
                                        let address = results[1].formatted_address;
                                        // initialize services
                                        const geocoder = new google.maps.Geocoder();
                                        const service = new google.maps.DistanceMatrixService();
                                        // build request
                                        const origin1 = {
                                            lat: <?php echo e($store_data['latitude']); ?>,
                                            lng: <?php echo e($store_data['longitude']); ?>

                                        };
                                        const origin2 = "<?php echo e($store_data->address); ?>";
                                        const destinationA = address;
                                        const destinationB = {
                                            lat: coordinates['lat'],
                                            lng: coordinates['lng']
                                        };
                                        const request = {
                                            origins: [origin1, origin2],
                                            destinations: [destinationA, destinationB],
                                            travelMode: google.maps.TravelMode.DRIVING,
                                            unitSystem: google.maps.UnitSystem.METRIC,
                                            avoidHighways: false,
                                            avoidTolls: false,
                                        };

                                        // get distance matrix response
                                        service.getDistanceMatrix(request).then((response) => {
                                            // put response
                                            let distancMeter = response.rows[0]
                                                .elements[0].distance['value'];

                                            let distanceMile = distancMeter / 1000;
                                            let distancMileResult = Math.round((
                                                    distanceMile + Number.EPSILON) *
                                                100) / 100;

                                            document.getElementById('distance').value = distancMileResult;
                                            document.getElementById('address').value =response.destinationAddresses[1];


                                        <?php
                                        $module_wise_delivery_charge = $store_data->zone->modules()->where('modules.id', $store_data->module_id)->first();

                                        if($store_data->sub_self_delivery ){
                                                $per_km_shipping_charge = $store_data?->per_km_shipping_charge ?? 0;
                                                $minimum_shipping_charge = $store_data?->minimum_shipping_charge ?? 0;
                                                $maximum_shipping_charge = $store_data?->maximum_shipping_charge?? 0;

                                                $self_delivery_status = 1;
                                        } else{
                                                $self_delivery_status = 0;

                                            if ($module_wise_delivery_charge) {
                                                $per_km_shipping_charge = $module_wise_delivery_charge->pivot->delivery_charge_type == 'distance' ? $module_wise_delivery_charge->pivot->per_km_shipping_charge ?? 0 : $module_wise_delivery_charge->pivot->fixed_shipping_charge ?? 0;
                                                $minimum_shipping_charge = $module_wise_delivery_charge->pivot->delivery_charge_type == 'distance' ? $module_wise_delivery_charge->pivot->minimum_shipping_charge ?? 0 : $module_wise_delivery_charge->pivot->fixed_shipping_charge ?? 0;
                                                $maximum_shipping_charge = $module_wise_delivery_charge->pivot->delivery_charge_type == 'distance' ? $module_wise_delivery_charge->pivot->maximum_shipping_charge ?? 0 : $module_wise_delivery_charge->pivot->fixed_shipping_charge ?? 0;
                                            } else {
                                                $per_km_shipping_charge = (float)\App\Models\BusinessSetting::where(['key' => 'per_km_shipping_charge'])->first()->value;
                                                $minimum_shipping_charge = (float)\App\Models\BusinessSetting::where(['key' => 'minimum_shipping_charge'])->first()->value;
                                                $maximum_shipping_charge = 0;
                                            }
                                        }


                                        ?>

                                        $.get({
                                                url: '<?php echo e(route('vendor.pos.extra_charge')); ?>',
                                                dataType: 'json',
                                                data: {
                                                    distancMileResult: distancMileResult,
                                                    self_delivery_status: <?php echo e($self_delivery_status); ?>,
                                                },
                                                success: function(data) {
                                                   let extra_charge = data;
                                                    let original_delivery_charge =  (distancMileResult * <?php echo e($per_km_shipping_charge); ?> > <?php echo e($minimum_shipping_charge); ?>) ? distancMileResult * <?php echo e($per_km_shipping_charge); ?> : <?php echo e($minimum_shipping_charge); ?>;
                                                    let delivery_amount = (<?php echo e($maximum_shipping_charge); ?> > <?php echo e($minimum_shipping_charge); ?> && original_delivery_charge + extra_charge > <?php echo e($maximum_shipping_charge); ?> ? <?php echo e($maximum_shipping_charge); ?> : original_delivery_charge + extra_charge);
                                                    let delivery_charge =Math.round(( delivery_amount + Number.EPSILON) * 100) / 100;
                                                document.getElementById('delivery_fee').value = delivery_charge;
                                                $('#delivery_fee').siblings('strong').html(delivery_charge + '<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>');

                                                },
                                                error:function(){
                                                    let original_delivery_charge =  (distancMileResult * <?php echo e($per_km_shipping_charge); ?> > <?php echo e($minimum_shipping_charge); ?>) ? distancMileResult * <?php echo e($per_km_shipping_charge); ?> : <?php echo e($minimum_shipping_charge); ?>;

                                                    let delivery_charge =Math.round((
                                                (<?php echo e($maximum_shipping_charge); ?> > <?php echo e($minimum_shipping_charge); ?> && original_delivery_charge  > <?php echo e($maximum_shipping_charge); ?> ? <?php echo e($maximum_shipping_charge); ?> : original_delivery_charge)
                                                + Number.EPSILON) * 100) / 100;
                                                document.getElementById('delivery_fee').value = delivery_charge;
                                                $('#delivery_fee').siblings('strong').html(delivery_charge + '<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>');
                                                }
                                            });
                                        });

                                    }
                                }
                            });
                        });
                    },
                });
            <?php endif; ?>

        }

        $(document).on('ready', function() {
            <?php if($order): ?>
                $('#print-invoice').modal('show');
            <?php endif; ?>
        });


        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            let keyword = $('#datatableSearch').val();
            let nurl = new URL('<?php echo url()->full(); ?>');
            nurl.searchParams.set('keyword', keyword);
            location.href = nurl;
        });


        $(document).on('click', '.quick-View', function () {
            $.get({
                url: '<?php echo e(route('vendor.pos.quick-view')); ?>',
                dataType: 'json',
                data: {
                    product_id: $(this).data('id')
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#quick-view').modal('show');
                    $('#quick-view-modal').empty().html(data.view);
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        });

        $(document).on('click', '.quick-View-Cart-Item', function () {
            $.get({
                url: '<?php echo e(route('vendor.pos.quick-view-cart-item')); ?>',
                dataType: 'json',
                data: {
                    product_id:  $(this).data('product-id'),
                    item_key:  $(this).data('item-key'),
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#quick-view').modal('show');
                    $('#quick-view-modal').empty().html(data.view);
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        });

        function checkAddToCartValidity() {
            let names = {};
            $('#add-to-cart-form input:radio').each(function() {
                names[$(this).attr('name')] = true;
            });
            let count = 0;
            $.each(names, function() {
                count++;
            });
            if ($('input:radio:checked').length === count) {
                return true;
            }
            return true;
        }

        function getVariantPrice() {
            if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '<?php echo e(route('vendor.pos.variant_price')); ?>',
                    data: $('#add-to-cart-form').serializeArray(),
                    success: function(data) {
                        $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                        $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                    }
                });
            }
        }

        $(document).on('click', '.add-To-Cart', function () {
            if (checkAddToCartValidity()) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                let form_id = 'add-to-cart-form'
                $.post({
                    url: '<?php echo e(route('vendor.pos.add-to-cart')); ?>',
                    data: $('#' + form_id).serializeArray(),
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(data) {

                        if (data.data === 1) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Cart',
                                text: "<?php echo e(translate('messages.product_already_added_in_cart')); ?>"
                            });
                            return false;
                        } else if (data.data === 2) {
                            updateCart();
                            Swal.fire({
                                icon: 'info',
                                title: 'Cart',
                                text: "<?php echo e(translate('messages.product_has_been_updated_in_cart')); ?>"
                            });

                            return false;
                        } else if (data.data === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Cart',
                                text: '<?php echo e(translate('messages.Sorry, product out of stock')); ?>'
                            });
                            return false;
                        } else if (data.data === 'letiation_error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Cart',
                                text: data.message
                            });
                            return false;
                        }
                        $('.call-when-done').click();

                        toastr.success('<?php echo e(translate('messages.product_has_been_added_in_cart')); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });

                        updateCart();
                    },
                    complete: function() {
                        $('#loading').hide();
                    }
                });
            } else {
                Swal.fire({
                    type: 'info',
                    title: '<?php echo e(translate('Cart')); ?>',
                    text: '<?php echo e(translate('Please choose all the options')); ?>'
                });
            }

        });

        $(document).on('click', '.remove-From-Cart', function () {
            let key=  $(this).data('product-id');
            $.post('<?php echo e(route('vendor.pos.remove-from-cart')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>',
                key: key
            }, function(data) {
                if (data.errors) {
                    for (let i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    updateCart();
                    toastr.info('<?php echo e(translate('messages.item_has_been_removed_from_cart')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }

            });
        });

        $(document).on('click', '.empty-Cart', function () {
            $.post('<?php echo e(route('vendor.pos.emptyCart')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>'
            }, function() {
                $('#del-add').empty();
                updateCart();
                toastr.info('<?php echo e(translate('messages.item_has_been_removed_from_cart')); ?>', {
                    CloseButton: true,
                    ProgressBar: true
                });
            });
        });

        function updateCart() {
            $.post('<?php echo e(route('vendor.pos.cart_items')); ?>', {
                _token: '<?php echo e(csrf_token()); ?>'
            }, function(data) {
                $('#cart').empty().html(data);
            });
        }

        $(document).on('click', '.delivery-Address-Store', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            let form_id = 'delivery_address_store';
            $.post({
                url: '<?php echo e(route('vendor.pos.add-delivery-info')); ?>',
                data: $('#' + form_id).serializeArray(),
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        $('#del-add').empty().html(data.view);
                    }
                    updateCart();
                    $('.call-when-done').click();
                },
                complete: function() {
                    $('#loading').hide();
                    $('#paymentModal').modal('hide');
                }
            });
        });

        $(document).on('click', '.payable-amount', function (event) {
           let form_id = 'payable_store_amount';

                if($('#paid').val() < 0){
                    toastr.error('<?php echo e(translate('Amount_must_be_grater_then_0')); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        event.preventDefault();
                        return;
                }
                if($('#paid').val() < $('#total_order_amount').val() ){
                    toastr.error('<?php echo e(translate('This_amount_must_grater_then_order_amount')); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        event.preventDefault();
                        return;
                }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('vendor.pos.paid')); ?>',
                data: $('#' + form_id).serializeArray(),
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function() {

                    updateCart();
                    $('.call-when-done').click();
                },
                complete: function() {
                    $('#loading').hide();
                    $('#insertPayableAmount').modal('hide');
                }
            });

        });

        $(function() {
            $(document).on('click', 'input[type=number]', function() {
                this.select();
            });
        });

        $(document).on('change', '.update-Quantity', function (e) {
            let element = $(e.target);
            let minValue = parseInt(element.attr('min'));
            let maxValue = parseInt(element.attr('max'));
            let valueCurrent = parseInt(element.val());
            let key = element.data('key');


            if (valueCurrent >= minValue && valueCurrent <= maxValue) {
                $.post('<?php echo e(route('vendor.pos.updateQuantity')); ?>', {
                    _token: '<?php echo e(csrf_token()); ?>',
                    key: key,
                    quantity: valueCurrent
                }, function() {
                    updateCart();
                });
            } else if(valueCurrent > maxValue){
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, cart limit exceeded.'
                });
                element.val(element.data('oldValue'));
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: '<?php echo e(translate('Sorry, the minimum value was reached')); ?>'
                });
                element.val(element.data('oldValue'));
            }

            // Allow: backspace, delete, tab, escape, enter and .
            if (e.type === 'keydown') {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode === 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            }

        });

        $('.js-data-example-ajax').select2({
            ajax: {
                url: '<?php echo e(route('vendor.pos.customers')); ?>',
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                __port: function(params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/pos/index.blade.php ENDPATH**/ ?>