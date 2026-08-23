# Ride Map Markers, Cancellation Reasons, and Pickup Routing API

## Status

The Laravel contracts in this document are implemented. Unit verification is
passing. Database-isolated integration tests are present but require the
`pdo_sqlite` PHP extension, which is unavailable in the current workspace.
Deployment migrations and provider-backed manual verification remain pending.

## Authentication and common headers

Customer endpoints require the existing Passport customer token. Captain
endpoints require the existing `dm.api` token contract.

```http
Authorization: Bearer CUSTOMER_OR_CAPTAIN_TOKEN
Accept: application/json
X-localization: en
```

`X-localization` is optional and defaults to `en`. Cancellation reason titles
use the requested locale when an admin translation exists and fall back to the
canonical title.

## Anonymous nearby Captain markers

```http
GET /api/v1/ride-hailing/customer/nearby-availability?zone_id=1&ride_category_id=3&latitude=31.45&longitude=73.13
Authorization: Bearer CUSTOMER_TOKEN
```

`ride_category_id` is the canonical category parameter. `category_id` is not
an alias. All four query fields are required. Latitude must be between -90 and
90; longitude must be between -180 and 180.

```json
{
  "available_count": 7,
  "estimated_pickup_minutes": {
    "minimum": 3,
    "maximum": 9
  },
  "approximate_markers": [
    {
      "latitude": 31.45,
      "longitude": 73.13,
      "heading": 145.5
    },
    {
      "latitude": 31.46,
      "longitude": 73.14,
      "heading": null
    }
  ],
  "generated_at": "2026-08-23T16:42:10+05:00",
  "refresh_after_seconds": 20
}
```

The endpoint recalculates eligibility for every response. A Captain must be
approved, active, in Ride mode, in the requested zone, within the configured
pickup radius, have a matching approved active vehicle, and have no conflicting
commerce assignment or active passenger Ride. Results honor the configured
marker limit and the route throttle of 30 requests per minute.

Coordinates are rounded using the admin-configured precision and duplicate
rounded coordinates collapse into one marker. `heading` is display-only and
never changes matching, ordering, ETA, or fare. Laravel normalizes reliable
headings into `0 <= heading < 360`. It returns `null` when heading, speed, or
accuracy is missing; when speed is below 0.5 m/s; when accuracy exceeds 100
metres; or when telemetry is older than 60 seconds.

The Captain heartbeat remains backward compatible:

```http
POST /api/v1/delivery-man/record-location-data
Authorization: Bearer CAPTAIN_TOKEN
Content-Type: application/json

{
  "latitude": 31.4504,
  "longitude": 73.135,
  "location": "POINT (73.135 31.4504)",
  "heading": 145.5,
  "speed_mps": 8.5,
  "accuracy_meters": 12
}
```

The three telemetry fields are optional. Existing clients may continue sending
only their original location fields.

### Nearby errors

- HTTP 401: missing or invalid customer token.
- HTTP 403: invalid query fields, disabled nearby availability, or unavailable
  zone/category fare.
- HTTP 429: throttle exceeded.

## Ride cancellation reasons

Reason definitions belong only to Ride Hailing. Commerce order and parcel
cancellation reason IDs are invalid for these endpoints. Stable actors are
`customer`, `captain`, and `admin`; legacy internal actor `user` maps to
`customer` only at compatibility boundaries.

Admins configure canonical/localized titles, immutable codes, actor scope,
applicable Ride statuses, display order, and active status at:

```text
admin/ride-hailing/cancellation-reasons
```

Supported pre-trip scopes are `searching`, `negotiating`, `rider_selected`,
`captain_arriving`, and `arrived`. No free-text "Other" reason is exposed.

### Customer reason list

```http
GET /api/v1/ride-hailing/customer/cancellation-reasons?ride_status=captain_arriving
Authorization: Bearer CUSTOMER_TOKEN
X-localization: en
```

```json
{
  "reasons": [
    {
      "id": 7,
      "code": "customer_plans_changed",
      "title": "My plans changed"
    }
  ]
}
```

Only active customer reasons applicable to `ride_status` are returned, ordered
by admin display order and then ID.

### Captain reason list

```http
GET /api/v1/delivery-man/ride-cancellation-reasons?ride_status=captain_arriving
Authorization: Bearer CAPTAIN_TOKEN
```

The response uses the same `reasons` shape but returns only active Captain
reasons applicable to the requested status.

### Customer cancellation

```http
DELETE /api/v1/ride-hailing/customer/rides/42
Authorization: Bearer CUSTOMER_TOKEN
Content-Type: application/json

{
  "cancellation_reason_id": 7
}
```

### Captain cancellation

```http
DELETE /api/v1/delivery-man/rides/42
Authorization: Bearer CAPTAIN_TOKEN
Content-Type: application/json

{
  "cancellation_reason_id": 12
}
```

Both mutations require a numeric definition ID. Laravel locks and revalidates
the owned/assigned Ride, its cancellable status, the definition's active flag,
actor, and lifecycle scope. It resolves the title server-side and never trusts
client text. Admin cancellation uses the same rules through the Ride Operations
form with an `admin` reason.

Cancellation snapshots remain readable if a definition is later renamed,
translated, disabled, or deleted:

```json
{
  "status": "cancelled",
  "cancelled_by": "customer",
  "cancellation_reason": {
    "id": 7,
    "code": "customer_plans_changed",
    "title": "My plans changed",
    "user_type": "customer"
  },
  "cancellation_charge_amount": 0
}
```

Legacy Rides cancelled before this contract return the same object with a
nullable ID/code and their stored free-text title.

Existing financial behavior is unchanged. Customer cancellation after Captain
assignment may create the snapshotted cancellation charge, immediately credit
the Captain through the wallet ledger and admin expense, and leave the customer
due for recovery. Searching/negotiating, Captain, and admin cancellations do
not create that customer charge.

### Cancellation errors

- HTTP 401: actor token is missing or invalid.
- HTTP 404: customer does not own the Ride, Captain is not assigned to it, or
  the Ride ID is missing.
- HTTP 422 with `code=cancellation_reason_id`: missing, inactive, wrong-actor,
  wrong-domain, or lifecycle-inapplicable reason.
- Existing non-cancellable lifecycle errors retain the endpoint's Ride error
  envelope.

## Assigned Captain-to-pickup route

The existing `route_polyline` remains the booked pickup-to-destination road
route. Owned Ride detail and Captain active/detail responses add a separate
approach route after assignment:

```json
{
  "route_polyline": "PICKUP_TO_DESTINATION_POLYLINE",
  "captain_pickup_route": {
    "route_polyline": "CAPTAIN_TO_PICKUP_POLYLINE",
    "distance_meters": 1850,
    "duration_seconds": 310,
    "generated_at": "2026-08-23T16:42:10+05:00"
  }
}
```

`captain_pickup_route` is present as an object only for `rider_selected`,
`captain_arriving`, and `arrived` with an assigned Captain and valid cached
route. It is `null` before assignment, after trip start, after cancellation or
completion, when no Captain location exists, or until the route provider first
succeeds.

Laravel computes the route using the server-only configured Google Routes key.
The cache refreshes when the Captain moves at least 75 metres from its route
origin or the route reaches 15 seconds old. A fresh route is reused. Provider
failure retains the last valid cache and does not fail Captain location update
or owned Ride detail.

The customer's detail query remains owner-scoped:

```http
GET /api/v1/ride-hailing/customer/rides/{ride_id}
Authorization: Bearer CUSTOMER_TOKEN
```

The Captain's assigned endpoints remain assignment-scoped:

```http
GET /api/v1/delivery-man/rides/current
GET /api/v1/delivery-man/rides/{ride_id}
Authorization: Bearer CAPTAIN_TOKEN
```

No route-provider key is returned to mobile clients.

## Realtime and REST behavior

REST is authoritative. Private websocket events are refresh hints:

- `.ride.location.updated`: newest committed assigned-Captain telemetry;
- `.ride.status.updated`: assignment, lifecycle, cancellation, or payment-state
  refresh;
- `.ride.request.updated`: changed customer opening price for recalculated
  currently eligible Captains;
- `.ride.offer.updated`: offer create, expiry, or rejection refresh.

Every Ride broadcast is registered with `DB::afterCommit`. Rolled-back state is
never intentionally published. After `.ride.location.updated`, the customer
refetches owned detail to obtain the latest location and cached approach route.
Nearby anonymous markers continue using the response's short polling interval;
they do not subscribe to Captain or trip channels.

## Mobile screen behavior

- Home/search map: request nearby availability only when the capability flag is
  enabled; animate only non-null headings and treat all markers as anonymous.
- Cancellation sheet: request reasons for the current exact Ride status and
  submit the selected numeric ID. Refresh reasons if the Ride status changes.
- Assigned map: render `route_polyline` for the booked journey and
  `captain_pickup_route.route_polyline` separately for the Captain approach.
- Reconnect/fallback: refetch owned Ride detail after private realtime hints and
  on the existing REST polling interval.
- Cancelled history: display `cancelled_by` and the stored structured reason as
  read-only data, including Captain/admin cancellations.

## Security and privacy constraints

- Nearby markers never contain Captain ID, name, phone, vehicle/plate, token,
  exact coordinate, or private channel.
- Exact Captain telemetry and approach routes are available only after
  assignment to the owning customer and assigned Captain.
- Heading is visual metadata only and cannot affect matching, fare, ordering,
  or settlement.
- Cancellation text is resolved server-side from an actor/lifecycle-scoped Ride
  definition; order and parcel definitions cannot cross domains.
- Cancellation snapshots support disputes and reporting without allowing later
  configuration edits to rewrite Ride history.
- Realtime uses private authenticated channels and post-commit payloads; REST
  ownership/assignment checks remain authoritative.

## Pagination

Nearby availability and reason lists are intentionally bounded, non-paginated
responses. Existing Ride history pagination remains unchanged (`limit` defaults
to 20 and is capped at 50).

## Relevant backend files

- `routes/api/v1/api.php`
- `routes/admin/routes.php`
- `app/Http/Controllers/Api/V1/CustomerRideController.php`
- `app/Http/Controllers/Api/V1/CaptainRideController.php`
- `app/Http/Controllers/Api/V1/DeliverymanController.php`
- `app/Http/Controllers/Admin/RideHailing/RideOperationController.php`
- `app/Http/Controllers/Admin/RideHailing/RideCancellationReasonController.php`
- `app/Models/DeliveryHistory.php`
- `app/Models/RideCancellationReason.php`
- `app/Models/RideRequest.php`
- `app/Services/RideNearbyMarkerService.php`
- `app/Services/RideCancellationReasonService.php`
- `app/Services/RideCaptainPickupRouteService.php`
- `app/Services/RideRouteService.php`
- `app/Services/RideTripService.php`
- `app/Services/RideRealtimeService.php`
- `database/migrations/2026_08_23_000001_add_telemetry_to_delivery_histories.php`
- `database/migrations/2026_08_23_000002_create_ride_cancellation_reasons.php`
- `database/migrations/2026_08_23_000003_add_captain_pickup_route_to_ride_requests.php`
- `resources/views/admin-views/ride-hailing/cancellation-reasons/index.blade.php`
- `resources/views/admin-views/ride-hailing/rides/show.blade.php`
- `resources/views/layouts/admin/partials/_sidebar_ride_hailing.blade.php`
- `tests/Unit/RideNearbyMarkerServiceTest.php`
- `tests/Unit/RideCancellationReasonTest.php`
- `tests/Unit/RideCaptainPickupRouteServiceTest.php`
- `tests/Feature/Api/V1/RideCancellationReasonFeatureTest.php`
- `tests/Feature/Api/V1/RideCancellationTransactionTest.php`
- `tests/Feature/Api/V1/RideCaptainPickupRouteFeatureTest.php`
- `tests/Feature/Api/V1/RideRealtimeAfterCommitTest.php`
