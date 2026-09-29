@extends('layouts.admin.app')

@section('title', \App\Models\BusinessSetting::where(['key' => 'business_name'])->first()->value ?? translate('messages.dashboard'))

@php($dispatchAdmin = auth('admin')->user())
@php($dispatchPermissions = json_decode((string) $dispatchAdmin->role?->modules, true) ?: [])
@php($dispatchCanOrder = (int) $dispatchAdmin->role_id === 1 || in_array('order', $dispatchPermissions, true))
@php($dispatchCanRide = (int) $dispatchAdmin->role_id === 1 || in_array('settings', $dispatchPermissions, true))
@php($dispatchModuleLabels = array_filter([
    'food' => $dispatchCanOrder ? translate('Food') : null,
    'grocery' => $dispatchCanOrder ? translate('Grocery') : null,
    'pharmacy' => $dispatchCanOrder ? translate('Medicine') : null,
    'ecommerce' => $dispatchCanOrder ? translate('Ecommerce') : null,
    'parcel' => $dispatchCanOrder ? translate('Parcel') : null,
    'ride_hailing' => $dispatchCanRide ? translate('Ride Hailing') : null,
]))
@php($dispatchInitialModule = array_key_first($dispatchModuleLabels) ?: 'food')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex flex-wrap gap-2 justify-content-between py-2">
                <div class="d-flex align-items-center flex-grow-1">
                    <img src="{{asset('/public/assets/admin/img/new-img/users.svg')}}" alt="img">
                    <div class="w-0 flex-grow pl-3">
                        <h1 class="page-header-title mb-1">{{translate('Dispatch Overview')}}</h1>
                        <p class="page-header-text text-dark m-0">
                            {{translate('Monitor your')}}
                            <span class="font-semibold">{{translate('Dispatch Management')}}</span>
                            {{translate('statistics by zone')}}
                        </p>
                    </div>
                </div>
                <div class="alert bg--10 font-bold fs-14" role="alert">
                    {{ translate('This_section_only_contains_Order_Data') }}
                </div>
            </div>
        </div>

        <div class="row g-1">
            <div class="col-lg-8">
                <div class="row gap__10 __customer-statistics-card-wrap-2">
                    <div class="col-sm-6">
                        <div class="__customer-statistics-card h-100">
                            <div class="title">
                                <img src="{{asset('public/assets/admin/img/new-img/deliveryman/active.svg')}}"
                                    alt="new-img">
                                <h4>{{$active_deliveryman}}</h4>
                            </div>
                            <h4 class="subtitle text-capitalize mt-2">{{translate('messages.active_delivery_man')}}</h4>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="__customer-statistics-card h-100 d-flex gap-3" style="--clr:#FF5A54">
                            <div>
                                <img width="48" height="48"
                                    src="{{asset('public/assets/admin/img/new-img/deliveryman/newly.svg')}}" alt="new-img">
                            </div>
                            <div class="d-flex justify-content-around gap-3 flex-grow-1">
                                <div>
                                    <h4 class="title">{{ $inactive_deliveryman }}</h4>
                                    <h4 class="subtitle text-capitalize">{{translate('messages.in_Active')}}</h4>
                                </div>
                                <div>
                                    <h4 class="title">{{ $suspend_deliveryman }}</h4>
                                    <h4 class="subtitle text-capitalize">{{ translate('suspended')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="__customer-statistics-card h-100">
                            <div class="title">
                                <img src="{{asset('public/assets/admin/img/new-img/deliveryman/active.svg')}}"
                                    alt="new-img">
                                <h4>{{ $unavailable_deliveryman }}</h4>
                            </div>
                            <h4 class="subtitle text-capitalize mt-2">{{ translate('Fully Booked Delivery Man')}}</h4>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="__customer-statistics-card h-100" style="--clr:#FF5A54">
                            <div class="title">
                                <img src="{{asset('public/assets/admin/img/new-img/deliveryman/in-active.svg')}}"
                                    alt="new-img">
                                <h4>{{$available_deliveryman}}</h4>
                            </div>
                            <h4 class="subtitle text-capitalize mt-2">{{translate('Available to assign more order')}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="shadow--order-card">
                    <div class="row m-0">
                        <div class="col-12 p-0">
                            <a class="order--card h-100" href="#">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="{{asset('public/assets/admin/img/dashboard/food/unassigned.svg')}}"
                                            alt="dashboard" class="oder--card-icon">
                                        <span>{{translate('messages.unassigned_orders')}}</span>
                                    </h6>
                                    <span class="card-title text-00A3FF">
                                        {{$data['searching_for_dm']}}
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 p-0">
                            <a class="order--card h-100" href="#">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="{{asset('public/assets/admin/img/dashboard/food/accepted.svg')}}"
                                            alt="dashboard" class="oder--card-icon">
                                        <span>{{translate('Accepted by Delivery Man')}}</span>
                                    </h6>
                                    <span class="card-title text-success">
                                        {{$data['accepted_by_dm']}}
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 p-0">
                            <a class="order--card h-100" href="#">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="{{asset('public/assets/admin/img/dashboard/food/out-for.svg')}}"
                                            alt="dashboard" class="oder--card-icon">
                                        <span>{{translate('Out for Delivery')}}</span>
                                    </h6>
                                    <span class="card-title text-success">
                                        {{$data['picked_up']}}
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="__map-wrapper-2 mt-3">
                    <div class="map-pop-deliveryman">
                        <form action="javascript:" id="search-form" class="map-pop-deliveryman-inner">
                            <label>{{ translate('Currently Active Delivery Men') }} <small id="dispatch-map-status" class="text-muted"></small></label>
                            <div class="position-relative mx-auto">
                                <i class="tio-search"></i>
                                <input type="text" name="search" class="form-control"
                                    placeholder="{{translate('Search Delivery Man ...')}}">
                            </div>
                            <a href="{{ route('admin.users.delivery-man.list') }}"
                                class="link font-semibold">{{ translate('View All Delivery Men') }}</a>
                        </form>
                    </div>
                    <div class="map-warper map-wrapper-2 rounded">
                        <div id="map-canvas" width="900px" class="rounded"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="card" id="dispatch-live-orders">
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <h4 class="mb-1">{{ translate('Live Dispatch Requests') }}</h4>
                            <small id="dispatch-connection-state" class="text-muted">{{ translate('Connecting to realtime updates...') }}</small>
                        </div>
                        <span class="badge badge-soft-success">{{ translate('Map stays loaded while this list updates') }}</span>
                    </div>
                    <div class="card-body border-bottom py-2">
                        <div class="d-flex flex-wrap gap-2" id="dispatch-module-tabs">
                            @foreach($dispatchModuleLabels as $key => $label)
                                <button type="button" class="btn btn-sm {{ $key === $dispatchInitialModule ? 'btn-primary' : 'btn-outline-primary' }} dispatch-module-tab" data-module="{{ $key }}">
                                    {{ $label }} <span class="badge badge-light ml-1 dispatch-module-count" data-module-count="{{ $key }}">0</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div id="dispatch-feed-content" class="position-relative">
                        <div class="text-center py-5"><span class="spinner-border spinner-border-sm"></span> {{ translate('Loading requests...') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dispatch-detail-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ translate('Dispatch Request Details') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" id="dispatch-detail-content"></div>
            </div>
        </div>
    </div>

    <audio id="dispatch-new-order-audio" preload="auto">
        <source src="{{ asset('public/assets/admin/sound/customer-notification.wav') }}" type="audio/wav">
    </audio>

@endsection

@push('script_2')
<script src="{{ asset('public/js/admin-dispatch.js') }}"></script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&callback=initialize&libraries=drawing,places,marker&v=3.61"></script>

<script>
    "use strict";
    let map; // Global declaration of the map
    const dispatchAdminZoneId = @json($dispatchAdmin->zone_id ? (int) $dispatchAdmin->zone_id : null);
    const initialDispatchRiders = @json($deliveryMen);
    const dmMarkers = new Map();
    const pendingRiderUpdates = new Map();
    let markerFlushTimer = null;
    let dispatchInfoWindow = null;
    let dispatchMarkerClass = null;
    let activeRiderSearch = '';

    function markerContent(rider) {
        const wrapper = document.createElement('div');
        wrapper.style.width = '42px';
        wrapper.style.height = '42px';
        wrapper.style.padding = '2px';
        wrapper.style.borderRadius = '50%';
        wrapper.style.background = rider.work_mode === 'ride' ? '#7c3aed' : '#00a3ff';
        wrapper.style.boxShadow = '0 2px 8px rgba(0,0,0,.3)';
        wrapper.style.transform = rider.heading === null || rider.heading === undefined ? '' : `rotate(${Number(rider.heading)}deg)`;

        const image = document.createElement('img');
        image.src = rider.image_url || "{{ asset('public/assets/admin/img/delivery_boy_active.png') }}";
        image.alt = rider.name || 'Captain';
        image.style.width = '100%';
        image.style.height = '100%';
        image.style.objectFit = 'cover';
        image.style.borderRadius = '50%';
        wrapper.appendChild(image);

        return wrapper;
    }

    function infoWindowContent(rider) {
        const wrapper = document.createElement('div');
        wrapper.style.minWidth = '220px';

        const name = document.createElement('strong');
        name.textContent = rider.name || `Captain #${rider.id}`;
        wrapper.appendChild(name);

        [
            rider.location || '',
            `${@json(translate('Mode'))}: ${rider.work_mode === 'ride' ? @json(translate('Ride')) : @json(translate('Delivery'))}`,
            `${@json(translate('Assigned Order'))}: ${Number(rider.assigned_order_count || 0)}`,
        ].forEach((value) => {
            const line = document.createElement('div');
            line.textContent = value;
            wrapper.appendChild(line);
        });

        return wrapper;
    }

    function riderMatchesSearch(rider) {
        if (!activeRiderSearch) return true;
        return [rider.id, rider.name, rider.location, rider.work_mode]
            .join(' ')
            .toLowerCase()
            .includes(activeRiderSearch);
    }

    function removeRiderMarker(id) {
        const entry = dmMarkers.get(String(id));
        if (!entry) return;
        entry.marker.map = null;
        dmMarkers.delete(String(id));
        updateMapStatus();
    }

    function upsertRiderMarker(rider) {
        const id = String(rider.id);
        const updatedAt = Date.parse(rider.updated_at || '') || Date.now();
        const existing = dmMarkers.get(id);
        const belongsToZone = !dispatchAdminZoneId || Number(rider.zone_id) === Number(dispatchAdminZoneId);
        if (!rider.visible || !belongsToZone || !Number.isFinite(Number(rider.latitude)) || !Number.isFinite(Number(rider.longitude))) {
            removeRiderMarker(id);
            return;
        }
        if (existing && updatedAt < existing.updatedAt) return;

        const position = {lat: Number(rider.latitude), lng: Number(rider.longitude)};
        if (existing) {
            existing.data = rider;
            existing.updatedAt = updatedAt;
            existing.marker.position = position;
            existing.marker.content = markerContent(rider);
            existing.marker.map = riderMatchesSearch(rider) ? map : null;
        } else if (map && dispatchMarkerClass) {
            const entry = {
                data: rider,
                updatedAt,
                marker: new dispatchMarkerClass({
                    position,
                    map: riderMatchesSearch(rider) ? map : null,
                    title: rider.name || `Captain #${id}`,
                    content: markerContent(rider),
                }),
            };
            entry.marker.addListener('click', () => {
                dispatchInfoWindow.setContent(infoWindowContent(entry.data));
                dispatchInfoWindow.open({map, anchor: entry.marker});
            });
            dmMarkers.set(id, entry);
        }
        updateMapStatus();
    }

    function updateMapStatus() {
        $('#dispatch-map-status').text(`(${dmMarkers.size} ${@json(translate('live'))})`);
    }

    function flushRiderUpdates() {
        markerFlushTimer = null;
        const updates = Array.from(pendingRiderUpdates.values());
        pendingRiderUpdates.clear();
        updates.forEach(upsertRiderMarker);
    }

    window.handleDispatchRiderLocation = (rider) => {
        if (!rider?.id) return;
        pendingRiderUpdates.set(String(rider.id), rider);
        if (!markerFlushTimer) {
            markerFlushTimer = window.setTimeout(flushRiderUpdates, 250);
        }
    };

    window.reconcileDispatchRiders = (riders) => {
        const incomingIds = new Set((riders || []).map((rider) => String(rider.id)));
        dmMarkers.forEach((entry, id) => {
            if (!incomingIds.has(id)) removeRiderMarker(id);
        });
        (riders || []).forEach(window.handleDispatchRiderLocation);
    };

    function initialize() {
        if (map) {
            return;
        }
        @php($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first())
        @php($default_location = $default_location->value ? json_decode($default_location->value, true) : 0)
        var myLatlng = {
            lat: {{ $default_location ? $default_location['lat'] : '23.757989' }},
            lng: {{ $default_location ? $default_location['lng'] : '90.360587' }}
            };
        const dmbounds = new google.maps.LatLngBounds();
        const mapId = "{{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}"

        var myOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapId: mapId,
        }
        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
        dispatchInfoWindow = new google.maps.InfoWindow();
        dispatchMarkerClass = google.maps.marker.AdvancedMarkerElement;
        initialDispatchRiders.forEach((rider) => {
            upsertRiderMarker(rider);
            if (rider.visible && Number.isFinite(Number(rider.latitude)) && Number.isFinite(Number(rider.longitude))) {
                dmbounds.extend({lat: Number(rider.latitude), lng: Number(rider.longitude)});
            }
        });
        if (!dmbounds.isEmpty()) map.fitBounds(dmbounds);
        flushRiderUpdates();

    }

    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        activeRiderSearch = String($(this).find('[name="search"]').val() || '').trim().toLowerCase();
        let firstMatch = null;
        dmMarkers.forEach((entry) => {
            const matches = riderMatchesSearch(entry.data);
            entry.marker.map = matches ? map : null;
            if (matches && !firstMatch) firstMatch = entry;
        });
        if (firstMatch && activeRiderSearch) {
            map.panTo(firstMatch.marker.position);
            map.setZoom(16);
        } else if (activeRiderSearch) {
            toastr.error(@json(translate('Delivery Man not found')), '', {CloseButton: true, ProgressBar: true});
        }
    });

    window.setInterval(() => {
        const now = Date.now();
        dmMarkers.forEach((entry, id) => {
            const staleAt = Date.parse(entry.data.stale_at || '');
            if (Number.isFinite(staleAt) && staleAt <= now) removeRiderMarker(id);
        });
    }, 15000);
</script>

@php($dispatchBroadcastDriver = config('broadcasting.default'))
@php($dispatchBroadcastConfig = config('broadcasting.connections.'.$dispatchBroadcastDriver, []))
@php($dispatchBroadcastOptions = $dispatchBroadcastConfig['options'] ?? [])
@php($dispatchRealtimeChannels = array_map(
    fn ($module) => (int) $dispatchAdmin->role_id === 1 || ! $dispatchAdmin->zone_id
        ? 'admin.dispatch.module.'.$module
        : 'admin.dispatch.zone.'.(int) $dispatchAdmin->zone_id.'.module.'.$module,
    array_keys($dispatchModuleLabels),
))
<script>
    "use strict";
    window.ZaqootaDispatchPageActive = true;

    (() => {
        const feedUrl = @json(route('admin.dispatch.feed'));
        const riderSnapshotUrl = @json(route('admin.dispatch.riders', is_numeric($params['zone_id'] ?? null) ? ['zone_id' => (int) $params['zone_id']] : []));
        const realtimeConfig = @json([
            'enabled' => in_array($dispatchBroadcastDriver, ['reverb', 'pusher'], true),
            'key' => $dispatchBroadcastConfig['key'] ?? null,
            'host' => $dispatchBroadcastOptions['host'] ?? null,
            'port' => $dispatchBroadcastOptions['port'] ?? null,
            'scheme' => $dispatchBroadcastOptions['scheme'] ?? 'https',
            'cluster' => $dispatchBroadcastOptions['cluster'] ?? null,
            'authEndpoint' => route('admin.dispatch.broadcasting.auth'),
            'csrfToken' => csrf_token(),
            'channels' => $dispatchRealtimeChannels,
            'locationChannel' => (int) $dispatchAdmin->role_id === 1 || ! $dispatchAdmin->zone_id
                ? 'admin.dispatch.location.all'
                : 'admin.dispatch.location.zone.'.(int) $dispatchAdmin->zone_id,
        ]);
        const audio = document.getElementById('dispatch-new-order-audio');
        const canAccessDispatchFeed = @json(! empty($dispatchModuleLabels));
        let activeModule = @json($dispatchInitialModule);
        let pollingTimer = null;
        let riderReconcileTimer = null;
        let riderSnapshotRequest = null;
        let initialFeedLoaded = false;
        let previousCounters = {};
        let lastEventKey = null;

        function setConnectionState(state) {
            const labels = {
                connected: @json(translate('Realtime connected')),
                connecting: @json(translate('Connecting to realtime updates...')),
                unavailable: @json(translate('Realtime unavailable — safe polling is active')),
                failed: @json(translate('Realtime failed — safe polling is active')),
                disconnected: @json(translate('Realtime disconnected — safe polling is active')),
            };
            $('#dispatch-connection-state').text(labels[state] || state);

            if (state === 'connected') {
                stopPolling();
                startRiderReconciliation(60000);
            } else if (['unavailable', 'failed', 'disconnected'].includes(state)) {
                startPolling();
                startRiderReconciliation(15000);
            }
        }

        function loadRiderSnapshot() {
            if (riderSnapshotRequest) return riderSnapshotRequest;
            riderSnapshotRequest = $.get(riderSnapshotUrl)
                .done((response) => window.reconcileDispatchRiders?.(response.riders || []))
                .always(() => { riderSnapshotRequest = null; });
            return riderSnapshotRequest;
        }

        function startRiderReconciliation(intervalMs) {
            if (riderReconcileTimer) window.clearInterval(riderReconcileTimer);
            riderReconcileTimer = window.setInterval(loadRiderSnapshot, intervalMs);
        }

        function ringAndNotify(message) {
            if (!window.ZaqootaDispatchPageActive || document.hidden) {
                return;
            }
            audio.currentTime = 0;
            audio.play().catch(() => {});
            toastr.success(message || @json(translate('A new dispatch request has arrived.')), '', {
                CloseButton: true,
                ProgressBar: true,
            });
        }

        function applyCounters(counters, notifyIncrease = false) {
            if (notifyIncrease && initialFeedLoaded) {
                const increased = Object.keys(counters).some((key) => Number(counters[key]) > Number(previousCounters[key] || 0));
                if (increased) {
                    ringAndNotify();
                }
            }
            Object.entries(counters).forEach(([key, value]) => {
                $(`[data-module-count="${key}"]`).text(value);
            });
            previousCounters = {...counters};
        }

        function loadFeed(url = null, notifyIncrease = false) {
            const requestUrl = url || `${feedUrl}?module=${encodeURIComponent(activeModule)}`;
            return $.get(requestUrl).done((response) => {
                $('#dispatch-feed-content').html(response.html);
                applyCounters(response.counters || {}, notifyIncrease);
                initialFeedLoaded = true;
            }).fail(() => {
                $('#dispatch-feed-content').html(`<div class="alert alert-danger m-3">${@json(translate('Could not load dispatch requests. Retrying automatically.'))}</div>`);
                startPolling();
            });
        }

        function startPolling() {
            if (pollingTimer) return;
            pollingTimer = window.setInterval(() => loadFeed(null, true), 15000);
        }

        function stopPolling() {
            if (!pollingTimer) return;
            window.clearInterval(pollingTimer);
            pollingTimer = null;
        }

        window.handleDispatchOrderHint = (payload) => {
            if (!payload) return;
            const eventKey = `${payload.source || 'commerce'}:${payload.id || payload.order_id}`;
            if (eventKey === lastEventKey) return;
            lastEventKey = eventKey;
            ringAndNotify(@json(translate('A new dispatch request has arrived.')));
            loadFeed();
        };

        $('#dispatch-module-tabs').on('click', '.dispatch-module-tab', function () {
            activeModule = $(this).data('module');
            $('.dispatch-module-tab').removeClass('btn-primary').addClass('btn-outline-primary');
            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            $('#dispatch-feed-content').html('<div class="text-center py-5"><span class="spinner-border spinner-border-sm"></span></div>');
            loadFeed();
        });

        $('#dispatch-feed-content').on('click', '.dispatch-feed-pagination a', function (event) {
            event.preventDefault();
            loadFeed($(this).attr('href'));
        });

        $('#dispatch-feed-content').on('click', '.dispatch-item-detail', function () {
            $('#dispatch-detail-content').html('<div class="text-center py-5"><span class="spinner-border"></span></div>');
            $('#dispatch-detail-modal').modal('show');
            $.get($(this).data('url')).done((response) => {
                $('#dispatch-detail-content').html(response.html);
            }).fail(() => {
                $('#dispatch-detail-content').html(`<div class="alert alert-danger">${@json(translate('Could not load request details.'))}</div>`);
            });
        });

        if (!canAccessDispatchFeed) {
            $('#dispatch-feed-content').html(`<div class="alert alert-warning m-3">${@json(translate('You do not have permission to view dispatch requests.'))}</div>`);
            setConnectionState('unavailable');
            return;
        }

        loadFeed();
        startPolling();
        loadRiderSnapshot();
        startRiderReconciliation(15000);
        window.DispatchRealtimeClient?.connect(realtimeConfig, {
            onOrder: window.handleDispatchOrderHint,
            onRiderLocation: (payload) => window.handleDispatchRiderLocation?.(payload),
            onStateChange: setConnectionState,
            onError: () => setConnectionState('failed'),
        });
    })();
</script>

@endpush
