import Pusher from 'pusher-js';

window.DispatchRealtimeClient = {
    connect(config, handlers = {}) {
        if (!config || !config.enabled || !config.key) {
            handlers.onStateChange?.('unavailable');
            return null;
        }

        const useTLS = config.scheme === 'https';
        const options = {
            authEndpoint: config.authEndpoint,
            auth: {
                headers: {
                    'X-CSRF-TOKEN': config.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            },
            cluster: config.cluster || 'mt1',
            forceTLS: useTLS,
            enabledTransports: ['ws', 'wss'],
        };

        if (config.host) {
            options.wsHost = config.host;
            options.wsPort = Number(config.port || (useTLS ? 443 : 80));
            options.wssPort = Number(config.port || 443);
        }

        const pusher = new Pusher(config.key, options);
        pusher.connection.bind('state_change', ({current}) => handlers.onStateChange?.(current));
        pusher.connection.bind('error', (error) => handlers.onError?.(error));

        (config.channels || []).forEach((channelName) => {
            const channel = pusher.subscribe(`private-${channelName}`);
            channel.bind('dispatch.order.created', (payload) => handlers.onOrder?.(payload));
            channel.bind('pusher:subscription_error', (error) => handlers.onError?.(error));
        });
        if (config.locationChannel) {
            const locationChannel = pusher.subscribe(`private-${config.locationChannel}`);
            locationChannel.bind('dispatch.rider.location.updated', (payload) => handlers.onRiderLocation?.(payload));
            locationChannel.bind('pusher:subscription_error', (error) => handlers.onError?.(error));
        }

        return pusher;
    },
};
