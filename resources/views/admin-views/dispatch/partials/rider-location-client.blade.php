@php($locationAdmin = auth('admin')->user())
@php($locationDriver = config('broadcasting.default'))
@php($locationConfig = config('broadcasting.connections.'.$locationDriver, []))
@php($locationOptions = $locationConfig['options'] ?? [])
<script src="{{ asset('public/js/admin-dispatch.js') }}"></script>
<script>
    (() => {
        const trackedRiderId = Number(@json((int) $trackedRiderId));
        const riderUrl = @json(route('admin.dispatch.rider', ['id' => (int) $trackedRiderId]));
        const handlerName = @json($onLocationHandler);
        let pollTimer = null;
        let request = null;

        function deliver(rider) {
            if (Number(rider?.id) !== trackedRiderId || typeof window[handlerName] !== 'function') return;
            window[handlerName](rider);
        }

        function poll() {
            if (request) return;
            request = $.get(riderUrl)
                .done((response) => deliver(response.rider))
                .fail((xhr) => {
                    if (xhr.status === 404) deliver({id: trackedRiderId, visible: false});
                })
                .always(() => { request = null; });
        }

        function schedule(milliseconds) {
            if (pollTimer) window.clearInterval(pollTimer);
            pollTimer = window.setInterval(poll, milliseconds);
        }

        window.DispatchRealtimeClient?.connect(@json([
            'enabled' => in_array($locationDriver, ['reverb', 'pusher'], true),
            'key' => $locationConfig['key'] ?? null,
            'host' => $locationOptions['host'] ?? null,
            'port' => $locationOptions['port'] ?? null,
            'scheme' => $locationOptions['scheme'] ?? 'https',
            'cluster' => $locationOptions['cluster'] ?? null,
            'authEndpoint' => route('admin.dispatch.broadcasting.auth'),
            'csrfToken' => csrf_token(),
            'channels' => [],
            'locationChannel' => (int) $locationAdmin->role_id === 1 || ! $locationAdmin->zone_id
                ? 'admin.dispatch.location.all'
                : 'admin.dispatch.location.zone.'.(int) $locationAdmin->zone_id,
        ]), {
            onRiderLocation: deliver,
            onStateChange: (state) => schedule(state === 'connected' ? 60000 : 15000),
            onError: () => schedule(15000),
        });

        poll();
        schedule(15000);
    })();
</script>
