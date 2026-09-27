# Rider operational zone and nearest-first dispatch

Updated 2026-09-27.

## Rollout status

| Milestone | Status |
|---|---|
| GPS-derived zone during Captain registration | Implemented; runtime verification pending |
| Zone synchronization during rider location heartbeat | Implemented; runtime verification pending |
| Shared commerce discovery/acceptance eligibility | Implemented; runtime verification pending |
| Atomic/idempotent commerce assignment | Implemented; concurrency verification pending |
| Nearest-first commerce visibility/push waves | Implemented; runtime verification pending |
| Nearest-first Ride visibility/realtime/push waves | Implemented; runtime verification pending |
| Admin wave controls and commerce dispatch monitor | Implemented; runtime verification pending |
| Queue Operations health/status/enable controls | Implemented; runtime verification pending |

Zones are retained as service and pricing polygons. They are no longer a rider-selected home restriction. A rider's current GPS location resolves the active operational zone; order and Ride pricing continues to come from the pickup/order zone.

Cross-zone behavior is intentionally pickup-led:

- A passenger Ride may start in Zone A and end in Zone B. Zone A's category fare (base, per-km, per-minute, negotiation limits, waiting and commission) prices the complete route and remains fixed for that Ride.
- A normal store order currently requires the delivery address to be inside the store's zone, so a Zone A store cannot check out to a Zone B address.
- A parcel can use different valid sender and receiver zones. Dispatch/order ownership uses the sender zone; the parcel category/global distance rate prices the route and any surge comes from the sender zone.
- A rider moving into Zone B during an active job has their operational zone synchronized to Zone B, but the accepted job is not repriced. Existing workload rules prevent that active job from being treated as newly available work.

## Registration contract

`POST /api/v1/auth/delivery-man/store` accepts `latitude` and `longitude` in the multipart body. Both coordinates are required for updated clients and Laravel resolves the smallest matching active zone. Registration is allowed when the coordinate is outside every active polygon; the pending rider is created with `zone_id = null`. Login is also allowed without an operational zone and returns empty `topic`/`zone_topic` values. A later GPS heartbeat assigns the current active zone and topics automatically.

For a safe rolling release, `zone_id` remains a temporary fallback when coordinates are absent. The fallback must reference an active zone. The Captain app and `/captain/apply` landing form no longer show or send a manually selected zone.

## Location heartbeat contract

`POST /api/v1/delivery-man/record-location-data` keeps its existing fields and adds this response metadata:

```json
{
  "message": "Location recorded",
  "service_available": true,
  "operational_zone": {"id": 4, "name": "Islamabad"},
  "zone_changed": true,
  "topic": "delivery_man_4_2",
  "zone_topic": "islamabad_deliverymen_push"
}
```

When no active zone contains the coordinates, `service_available` is false, `operational_zone` is null, the stored operational `zone_id` is cleared, and both topic fields are empty. The stored last location still updates, but the rider is ineligible for new zone-wise orders and Rides until GPS resolves into an active zone. Updated Captain clients unsubscribe from stale zone/vehicle topics and subscribe to the returned topics. Websocket location updates also synchronize the server-side zone, while the regular HTTP heartbeat remains authoritative for topic changes.

## Commerce discovery and acceptance

`GET /api/v1/delivery-man/latest-orders` and `PUT /api/v1/delivery-man/accept-order` now use `CommerceOrderEligibilityService`. The shared policy covers online/capacity state, work mode, operational zone or store ownership, self-delivery exclusions, lifecycle, delivery vehicle, digital-payment visibility, schedule window and cash-in-hand capacity.

Acceptance locks the rider and order rows in one database transaction, repeats the policy after acquiring those locks, assigns the order and increments both rider counters together. A retry by the same rider returns HTTP 200 without incrementing counters or sending the customer notification again. An order already assigned to another rider or no longer eligible returns HTTP 409 using the existing `errors` array.

The schedule scope is explicitly nested in the shared query so its internal `OR created_at = schedule_at` branch cannot bypass zone, vehicle, lifecycle or payment constraints.

## Commerce nearest-first waves

`CommerceOrderDispatchService` applies one ranked set to latest-order discovery, direct acceptance and order-request notifications. Restaurant/grocery pickup is the store coordinate. Parcel pickup is the sender coordinate in `orders.delivery_address`. Captains must pass the shared commerce policy and have a GPS heartbeat no older than the configured freshness window.

The default rollout is three captains per wave, one additional wave every 20 seconds, and a 180-second GPS freshness window. Admin can change all three values from **Business Setup → Deliveryman**; they are stored in these `business_settings` rows:

- `commerce_dispatch_wave_size`
- `commerce_dispatch_wave_interval_seconds`
- `commerce_dispatch_location_freshness_seconds`

`GET /api/v1/delivery-man/latest-orders` returns only waves currently open to that captain and orders them by `pickup_distance_meters`. It also includes `dispatch_wave`. `PUT /api/v1/delivery-man/accept-order` repeats the same wave check under the existing rider/order locks. A direct request before the captain's wave returns HTTP 409 with code `dispatch_wave_pending`.

Zone-wide freelancer topic broadcasts have been removed from all commerce order-request branches. `DispatchCommerceOrderWave` recalculates the current nearest captains when each wave opens, stores one idempotent recipient record in `commerce_order_notification_deliveries`, creates the captain's in-app notification and queues an individual Firebase push. It stops when the order is assigned. Store-owned self-delivery remains on its private `restaurant_dm_{store}` topic and is not mixed into freelancer dispatch.

Commerce and parcel order-detail pages include a nearest-first dispatch monitor. It shows every contacted rider's wave, pickup distance snapshot, in-app storage result, Firebase status, attempt count, last attempt and error. This data is diagnostic delivery evidence; Firebase `accepted` means the push provider accepted the message, not that the rider accepted the order.

The migration must run before deployment. Delayed waves require a non-`sync` queue connection and a running queue worker; `.env.example` already selects the database queue. List visibility and acceptance remain time-based even if a delayed push worker is unavailable.

Run `php artisan dispatch:health` after migration and configuration caching. The command rejects synchronous/null queues and missing dispatch tables or metadata. The deployment workflow runs this check and `queue:restart`; the host must provide the supervised worker described in [nearest-first-dispatch-rollout.md](nearest-first-dispatch-rollout.md).

Relevant backend files: `app/Services/OperationalZoneService.php`, `app/Services/CommerceOrderEligibilityService.php`, `app/Services/CommerceOrderDispatchService.php`, `app/Jobs/DispatchCommerceOrderWave.php`, `app/Jobs/SendCommerceOrderRequestPush.php`, `app/Http/Controllers/Api/V1/DeliverymanController.php`, `app/CentralLogics/Helpers.php` and `resources/views/dm-registration.blade.php`.

## Passenger Ride nearest-first waves

`RideDispatchService` applies one rank to Captain polling, realtime discovery, stored notifications, Firebase push and offer submission. Ranking retains the existing current operational zone, Ride work mode, approved active vehicle category, no-conflicting-work and maximum pickup-radius requirements. Captains also need GPS newer than the configured freshness window.

The default is three captains immediately and three more every 20 seconds. Admin can change these values from Ride Hailing Setup:

- `ride_hailing_dispatch_wave_size`
- `ride_hailing_dispatch_wave_interval_seconds`
- `ride_hailing_dispatch_location_freshness_seconds`

`GET /api/v1/delivery-man/ride-requests` returns only open waves and includes `dispatch_wave`. A direct `POST /api/v1/delivery-man/ride-requests/{ride_id}/offers` before the captain's wave returns HTTP 403 with code `dispatch_wave_pending`. Price-update realtime/push events go only to waves already open; later wave jobs load the current Ride value when they run.

`DispatchRideRequestWave` recalculates current distance at wave time and sends both the private Captain realtime hint and the idempotent in-app/FCM notification to the same slice. Assigned or cancelled Rides stop dispatching, and `SendRideRequestPush` suppresses queued messages that became obsolete before Firebase submission. Admin notification retry uses the same wave scheduler.

Delayed Ride waves require a non-`sync` queue and a running worker. Polling and offer enforcement remain server-time based if the worker is unavailable.

## Queue Operations admin

**Business Setup → Queue Operations** inventories every concrete application job currently implementing `ShouldQueue`: commerce wave dispatch, commerce request push, Ride wave dispatch, Ride request push, Ride offer expiry and driver live-location broadcast. The page shows connection type, queued/ready/delayed/reserved totals for the database driver, failed jobs when that table exists, a worker/scheduler heartbeat, and per-process processed/failed/skipped metrics and last errors.

Admin can enable or disable every process or use the master queue-processing control. Disabled jobs that reach a worker are safely skipped and recorded; the heartbeat is intentionally independent so worker health remains measurable while business processes are disabled. Re-enabling affects subsequent queued executions; skipped work is not replayed automatically.
