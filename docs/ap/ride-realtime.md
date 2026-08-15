# Ride Realtime Channels

Backend status: private mobile channel authentication and immediate Ride
discovery, offer, lifecycle, location, and payment events are implemented.

REST APIs remain authoritative. Realtime reduces latency; it never replaces
ownership checks, state validation, or reconnect reconciliation.

## Configuration

The existing configuration endpoint returns `websocket_status`,
`websocket_url`, `websocket_port`, `websocket_key`, and:

```json
{
  "ride_realtime": {
    "enabled": true,
    "driver": "reverb",
    "key": "public-app-key",
    "host": "socket.example.com",
    "port": 443,
    "scheme": "https",
    "customer_auth_endpoint": "https://example.com/api/v1/ride-hailing/customer/broadcasting/auth",
    "captain_auth_endpoint": "https://example.com/api/v1/delivery-man/ride-broadcasting/auth",
    "customer_channel": "ride.customer.{user_id}",
    "captain_channel": "ride.captain.{captain_id}",
    "trip_channel": "ride.trip.{ride_id}",
    "fallback_poll_seconds": 10
  }
}
```

Use these values with a Pusher-compatible client. Echo-style channel names omit
the `private-` prefix; the protocol adds it during subscription.

## Private Channel Authentication

The client posts `socket_id` and `channel_name` as form fields.

Customer:

```http
POST /api/v1/ride-hailing/customer/broadcasting/auth
Authorization: Bearer CUSTOMER_TOKEN
Content-Type: application/x-www-form-urlencoded
```

Captain:

```http
POST /api/v1/delivery-man/ride-broadcasting/auth
Authorization: Bearer CAPTAIN_TOKEN
Content-Type: application/x-www-form-urlencoded
```

The legacy Captain token body/header remains compatible. Both endpoints are
limited to 60 requests per minute.

## Channels

### Customer Account

```text
ride.customer.{authenticated_user_id}
```

Only that Passport customer can subscribe. This receives offers and account
level assignment/status/payment events before a trip subscription exists.

### Captain Account

```text
ride.captain.{authenticated_captain_id}
```

Only that Captain can subscribe. New requests are sent separately to the
private account channels of up to 100 currently eligible Captains in the pickup
zone/category. Eligibility is recalculated before broadcast: approved, active,
Ride mode, matching approved active vehicle, and no conflicting work. Captains
outside the realtime fan-out still use paginated request polling.

### Assigned Trip

```text
ride.trip.{ride_id}
```

Only the owning customer or assigned Captain can subscribe. Captains cannot
subscribe before assignment. This carries high-frequency location and shared
trip/payment changes.

## Events

With Laravel Echo, listen to custom event names using a leading dot, for example
`.ride.status.updated`.

### `ride.request.created`

Captain account channel. Contains the safe request summary used by the
available-requests API: route endpoints, category/zone, distance/duration,
customer offer, suggested/min/max fares, and offer expiry seconds.

### `ride.offer.updated`

Customer account and trip channels:

```json
{
  "ride_id": 42,
  "status": "negotiating",
  "offer": {
    "id": 81,
    "amount": 510,
    "status": "pending",
    "expires_at": "2026-08-09T14:00:30+05:00",
    "captain_id": 14,
    "vehicle_id": 6
  }
}
```

With a non-sync queue worker, `ExpireRideOffer` publishes the same event with
`offer.status: expired` at timeout. With the default sync queue, the client
countdown plus offer/polling APIs performs expiry reconciliation.

### `ride.status.updated`

Customer, assigned Captain, and trip channels. Contains ride ID, request
number, trip status, payment status, and server update time. Fetch the owned
ride after receiving it; do not reconstruct the full state from this event.

### `ride.location.updated`

Assigned trip channel:

```json
{
  "ride_id": 42,
  "latitude": 31.4504,
  "longitude": 73.135,
  "heading": 145.5,
  "speed_mps": 8.5,
  "accuracy_meters": 12.0,
  "updated_at": "2026-08-09T14:21:11+05:00"
}
```

Telemetry fields are nullable. This private assigned-trip event never includes
Captain identity, phone, image, rating, Trip PIN, or auth data.

### `ride.payment.updated`

Customer, assigned Captain, and trip channels. Contains payment status/method,
payable amount, receipt number, and paid time. Refresh payment summary before
showing final success.

## Connection Lifecycle

Customer app:

1. Connect and authenticate the customer account channel after login.
2. Once a Captain is selected, also subscribe to the assigned trip channel.
3. On reconnect/app resume, fetch the active ride and payment summary, then
   resubscribe.
4. Leave the trip channel after completion/cancellation and final payment sync.

Captain app:

1. Subscribe to the Captain account channel only while active in Ride mode.
2. On `ride.request.created`, fetch available requests before enabling an offer;
   REST eligibility remains final.
3. After assignment, fetch `/delivery-man/rides/current` and subscribe to its
   trip channel.
4. Leave after completion/cancellation and stop location updates.

## Reconnect And Polling Fallback

- Disconnects, duplicated events, missed events, and reordered events are
  normal network behavior.
- Event payloads are hints. Fetch REST state after offer, status, or payment
  events.
- While disconnected, poll every `fallback_poll_seconds` (currently 10).
- Offer countdowns use server `expires_at`, not only a local timer.
- Deduplicate by ride/offer ID and ignore events older than the newest REST
  response.

## Server Operations

Run the configured Pusher-compatible server, for example:

```bash
php artisan reverb:start
```

Run it under Supervisor/systemd in production. For pushed offer-expiry events,
configure a durable non-sync queue and run:

```bash
php artisan queue:work --queue=default --tries=3
```

REST expiry checks remain correct without the worker.

## Security

- Never use the old broad delivery-man location channel for passenger rides.
- Account IDs in channel names are authorization inputs, not identity proof.
- Trip authorization checks database ownership/assignment on subscription.
- Discovery uses recalculated private Captain channels, not a persistent shared
  zone channel.
- Events exclude Trip PIN, internal commission, Captain earnings, auth tokens,
  and gateway secrets.
- Every mutation remains an authenticated REST request.

## Backend Files

- `routes/api/v1/api.php`
- `routes/channels.php`
- `app/Http/Controllers/Api/V1/RideBroadcastController.php`
- `app/Events/RideRealtimeEvent.php`
- `app/Jobs/ExpireRideOffer.php`
- `app/Services/RideRealtimeService.php`
- `app/Services/RideCaptainEligibilityService.php`
- `app/Http/Controllers/Api/V1/CustomerRideController.php`
- `app/Http/Controllers/Api/V1/CaptainRideController.php`
- `app/Services/RidePaymentService.php`
- `app/Http/Controllers/Api/V1/ConfigController.php`
- `tests/Unit/RideRealtimeEventTest.php`
## Customer negotiation events

- `.ride.request.updated` is sent to currently eligible Captain account
  channels after the passenger changes the opening price. It is a REST refresh
  hint and includes the authoritative Ride summary.
- `.ride.offer.updated` is sent to the customer and affected Captain after an
  individual customer rejection. Its offer object includes `id`, `status`,
  `rejected_by`, and `rejected_at`.
- Firebase `ride_request_updated`, `ride_offer_rejected`, and
  `ride_offer_accepted` include `ride_id`; offer events also include
  `offer_id`. None of these payloads contains Trip PIN.
