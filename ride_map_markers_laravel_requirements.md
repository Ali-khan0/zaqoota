# Laravel Requirements: Ride Map Availability Markers

Give this document to the Laravel Ride Hailing project. It is the maintained
backend handoff for customer-map pickup/destination clarity, nearby vehicle
assets, and vehicle direction.

## Current Flutter behavior

- Pickup is rendered with the app primary color.
- Destination is rendered in red.
- Before assignment, the selected category uses one of the bundled top-view
  `car`, `bike`, `rikshaw`, or `ev` assets.
- Flutter calls nearby availability only when
  `ride_hailing.nearby_availability_enabled` is true.
- After assignment, the customer tracks only the assigned Captain through the
  private trip channel plus authoritative REST reconciliation and renders the
  same bundled car/bike/rikshaw/EV top-view asset selected from Ride metadata.

## Existing capability flag

`GET /api/v1/config` must expose:

```json
{
  "ride_hailing": {
    "nearby_availability_enabled": true,
    "nearby_refresh_seconds": 20
  }
}
```

When disabled, the customer app intentionally does not request or display
pre-booking vehicle markers.

## Nearby availability endpoint

```http
GET /api/v1/ride-hailing/customer/nearby-availability
    ?zone_id=1
    &ride_category_id=3
    &latitude=31.4504
    &longitude=73.1350
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
```

Laravel remains authoritative for all eligibility. Include only Captains who
are approved, online/active, in Ride mode, in the pickup zone, within the
configured pickup radius, using an approved active vehicle matching the
requested category, and free from conflicting work.

## Required response and optional heading

Keep the existing privacy-preserving response and add optional `heading` to an
approximate marker when reliable location telemetry provides it:

```json
{
  "available_count": 2,
  "estimated_pickup_minutes": {
    "minimum": 3,
    "maximum": 7
  },
  "approximate_markers": [
    {
      "latitude": 31.4504,
      "longitude": 73.1350,
      "heading": 42.5
    },
    {
      "latitude": 31.4510,
      "longitude": 73.1360,
      "heading": null
    }
  ],
  "generated_at": "2026-08-23T12:00:00+05:00",
  "refresh_after_seconds": 20
}
```

`heading` rules:

- Optional number in degrees clockwise from true north.
- Normalize to `0 <= heading < 360`.
- Return `null` when telemetry is missing, stale, inaccurate, or stationary.
- Flutter keeps the upward-facing asset at zero rotation when absent.
- Heading is visual guidance only and must not influence eligibility, pricing,
  offer ordering, or assignment.

## Privacy and security requirements

- Continue rounding, bucketing, or adding server-controlled jitter to nearby
  coordinates.
- Do not expose Captain ID, name, phone, vehicle registration, exact location,
  Firebase token, or private channel before assignment.
- Do not allow clients to derive or subscribe to a Captain channel from a
  nearby marker.
- Return no more than the configured marker limit and rate-limit the endpoint.
- Validate `zone_id`, category, latitude, and longitude server-side; never trust
  them as eligibility proof.
- Recalculate online, zone, category, radius, approval, and conflicting-work
  eligibility for every response.

## Assigned Captain location

The existing assigned-trip response/realtime payload should continue providing
authoritative Captain coordinates and optional heading:

```json
{
  "ride_id": 42,
  "latitude": 31.4504,
  "longitude": 73.1350,
  "heading": 42.5,
  "updated_at": "2026-08-23T12:01:05+05:00"
}
```

This payload belongs only on the authorized private trip channel after offer
acceptance. REST Ride details remain authoritative after each realtime signal
and during fallback polling.

## Backend verification checklist

1. Capability flag is enabled only where nearby markers are approved.
2. Same-zone, matching-category, online, radius, approval, and work-conflict
   filters are covered by feature tests.
3. Marker coordinates remain privacy-rounded/jittered after adding heading.
4. Heading accepts `0`, decimals, and values near `360`; invalid values become
   `null`.
5. No pre-assignment response contains Captain identity or exact coordinates.
6. Assigned-trip heading is available through REST and realtime when known.
7. The endpoint returns an empty marker list safely when no Captain qualifies.

## Required Ride cancellation reasons API

The customer app no longer accepts a typed cancellation reason. Laravel must
provide active customer-facing reasons and require the selected reason ID for
every customer Ride cancellation, including cancellation while searching or
negotiating.

### Three cancellation actors

Ride Hailing has exactly three cancellation actor types:

| Actor | Canonical API value | Who selects the reason | Charge rule |
|---|---|---|---|
| Customer/user | `customer` | Zaqoota customer Flutter app | Apply the configured customer cancellation fee/dues policy |
| Captain | `captain` | Captain app | Do not charge the customer for a Captain cancellation |
| Administrator | `admin` | Laravel admin panel | Do not charge either party unless a future explicit policy says otherwise |

Cancellation reasons must be scoped by `user_type` (or an equivalent canonical
actor column) and Laravel must never allow one actor to submit another actor's
reason. Treat legacy `user` as `customer` when reading old data, but return
`customer`, `captain`, or `admin` consistently in new API responses.

The customer app requests only customer reasons:

```http
GET /api/v1/ride-hailing/customer/cancellation-reasons
    ?ride_status=captain_arriving
    &user_type=customer
```

Every item should include `user_type: "customer"`. The customer Flutter app
also defensively removes `captain` and `admin` reasons if a mixed response is
returned. Captain reason selection belongs only in the Captain API/app, and
admin reason selection belongs only in the authenticated admin cancellation
action—not in the customer app.

All three cancellation flows must snapshot and return:

```json
{
  "status": "cancelled",
  "cancelled_by": "customer",
  "cancellation_reason": {
    "id": 7,
    "code": "plans_changed",
    "title": "My plans changed",
    "user_type": "customer"
  },
  "cancellation_charge_amount": 0
}
```

`cancelled_by` changes to `captain` or `admin` for those flows. The owned Ride
detail/history response must contain these fields regardless of which actor
cancelled. Flutter displays the actor and localized reason as read-only data
for Captain/admin cancellations. Every flow publishes `ride.status.updated`
only after commit and sends the appropriate stored/Firebase notification to
the affected customer and Captain.

### List reasons

```http
GET /api/v1/ride-hailing/customer/cancellation-reasons?ride_status=captain_arriving
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
```

Example response:

```json
{
  "reasons": [
    {
      "id": 7,
      "code": "plans_changed",
      "title": "My plans changed"
    },
    {
      "id": 8,
      "code": "captain_too_far",
      "title": "Captain is too far away"
    }
  ]
}
```

The app also accepts the array under `data`, but `reasons` is preferred.

Reason rules:

- Return only active reasons intended for `user_type=customer` and Ride Hailing.
- Return a localized `title` using the request language/header convention
  already used by the API.
- Allow status/lifecycle scoping. At minimum support `searching`, `negotiating`,
  `rider_selected`, `captain_arriving`, and `arrived`.
- Keep `code` stable for reporting, but Flutter submits the numeric ID.
- Sort by the admin-configured display order.
- Do not return an "Other" reason requiring free text unless the product later
  adds a separate, explicitly validated comment field.

### Cancel with required reason ID

Keep the existing cancellation endpoint and require the selected reason:

```http
DELETE /api/v1/ride-hailing/customer/rides/42
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
Content-Type: application/json

{
  "cancellation_reason_id": 7
}
```

Laravel must:

- reject a missing, inactive, non-customer, non-Ride, or lifecycle-inapplicable
  reason with HTTP `422`;
- resolve the title server-side rather than trusting text from Flutter;
- snapshot both reason ID/code and the localized or canonical reason text on
  the Ride for history, notifications, reports, and dispute review;
- preserve the existing cancellation-charge calculation and lifecycle locking;
- revalidate Ride ownership and cancellable status transactionally;
- publish the existing `ride.status.updated` signal only after commit;
- include the authoritative `cancellation_reason` and `cancelled_by=customer`
  in subsequent Ride details.

Suggested validation error:

```json
{
  "errors": [
    {
      "code": "cancellation_reason_id",
      "message": "Please select a valid cancellation reason."
    }
  ]
}
```

### Cancellation reason backend tests

1. Authenticated customers receive only active customer Ride reasons.
2. Status-scoped reasons are excluded from incompatible Ride states.
3. Cancellation fails when the reason ID is missing or invalid.
4. A valid reason ID is snapshotted with reason code/text.
5. Existing cancellation fees and dues remain unchanged.
6. Searching/negotiating and assigned pre-trip cancellations both work.
7. Customer cannot use a Captain/admin/order/parcel cancellation reason.

## Required assigned Captain-to-pickup road route

The existing `route_polyline` is the booked pickup-to-destination route. It
must not be reused for the Captain's approach. Include a separate,
road-snapped route in the owned Ride details while the Ride is assigned and has
not started:

```json
{
  "captain_pickup_route": {
    "route_polyline": "ENCODED_GOOGLE_POLYLINE",
    "distance_meters": 1850,
    "duration_seconds": 310,
    "generated_at": "2026-08-23T16:42:10+05:00"
  }
}
```

Laravel requirements:

- Build the route from the latest authoritative assigned Captain coordinates
  to the Ride pickup coordinates using the configured road-routing provider.
- Return it through the existing owned Ride detail/active-Ride response; a new
  mobile endpoint is not required.
- Include it for `rider_selected`, `captain_arriving`, and `arrived`. Omit or
  clear it after `in_progress`, cancellation, or completion.
- Recalculate when the Captain has moved materially (suggested 50-100 metres)
  or the cached route is stale (suggested 10-20 seconds). Cache the result so a
  paid routing request is not made for every location ping.
- Generate it server-side. Flutter must not hold routing-provider secrets or
  treat a locally calculated straight line as the authoritative road route.
- Keep Captain coordinates and this route restricted to the Ride owner after
  assignment. Pre-assignment nearby markers remain anonymous and approximate.
- Continue emitting the existing private location-update hint. The app will
  refetch authoritative Ride details through realtime handling and REST
  fallback, then move the assigned vehicle and replace the solid route.

Backend tests must cover ownership, lifecycle visibility, valid encoded route,
movement/staleness refresh thresholds, cache reuse, cleanup after trip start,
and absence of assigned-Captain data from pre-assignment availability.

## Realtime and REST paths for map updates

These are not separate "realtime APIs." REST remains authoritative and private
WebSocket events are lightweight invalidation hints that tell Flutter to fetch
the latest REST representation.

### Assigned Captain movement and pickup route: realtime required

Authoritative REST path:

```http
GET /api/v1/ride-hailing/customer/rides/{ride_id}
```

Private broadcast authorization path:

```http
POST /api/v1/ride-hailing/customer/broadcasting/auth
```

Private channel and event:

```text
Channel: ride.trip.{ride_id}
Event:   ride.location.updated
```

Laravel must broadcast `ride.location.updated` after accepting and persisting
an assigned Captain location update. It must be available only to the Ride
owner and assigned Captain. The event should contain at least `ride_id` and an
update/version timestamp; it may contain location data, but Flutter will still
refetch the owned Ride detail so REST is authoritative.

The Ride detail response must then contain the newest `captain_location` and
the newest cached `captain_pickup_route`. This makes both the vehicle marker
and solid road route update after each realtime hint. A practical broadcast
cadence is every 2-5 seconds while the Captain is approaching or moving,
subject to server throttling and meaningful movement. Do not wait for a Ride
status change before broadcasting movement.

Also broadcast:

```text
Event: ride.status.updated
```

when assignment, arrival, trip start, completion, or cancellation commits.
Flutter uses this to remove anonymous vehicles, switch route type, and update
the lifecycle UI. If WebSocket delivery disconnects, Flutter falls back to
polling the same Ride detail REST path and reconciles again after reconnect.

### Pre-assignment nearby vehicles: refreshed REST, not exact realtime

Authoritative REST path:

```http
GET /api/v1/ride-hailing/customer/nearby-availability
    ?latitude={pickup_latitude}
    &longitude={pickup_longitude}
    &zone_id={zone_id}
    &category_id={category_id}
    &radius={configured_radius}
```

Flutter already repeats this request according to `refresh_after_seconds` in
the response/config while selecting a vehicle and while the Ride is
`searching` or `negotiating`. This deliberately remains short-interval REST
refresh rather than per-Captain realtime broadcasts because the markers are
anonymous, rounded/jittered availability indicators—not trackable Captain
locations. Laravel should return a refresh interval of approximately 5-10
seconds and enforce zone, selected category, online/available state, radius,
privacy rounding/jittering, and response limits on every refresh.

Do not publish exact or identity-bearing pre-assignment Captain locations to a
customer channel. If Laravel later adds a nearby-availability invalidation
event, it should contain no coordinates or Captain IDs and should only tell
Flutter to refetch the REST path above.

### Realtime verification tests

1. An assigned Captain location commit broadcasts `ride.location.updated` on
   `ride.trip.{ride_id}` within the configured throttle window.
2. Only the Ride owner and assigned Captain can authorize the trip channel.
3. Ride details return the persisted location and matching refreshed/cached
   `captain_pickup_route` after the event.
4. Status transitions broadcast `ride.status.updated` only after commit.
5. REST fallback produces the same authoritative state when broadcasts are
   delayed, duplicated, out of order, or unavailable.
6. Nearby availability refreshes independently and never leaks exact Captain
   coordinates, IDs, names, phone numbers, or vehicle registration numbers.

## Customer fare negotiation realtime contract

The customer price update is also a hybrid REST plus realtime-hint flow.

Customer write path:

```http
PUT /api/v1/ride-hailing/customer/rides/{ride_id}/customer-offer
Authorization: Bearer CUSTOMER_TOKEN
Content-Type: application/json

{"customer_offer": 340}
```

After the transaction commits, Laravel must publish:

```text
Event: ride.request.updated
Target: every currently eligible Captain account channel for this Ride
```

The event should contain `ride_id`, `customer_offer`, `status`, and
`updated_at` (or a monotonic version). It is a refresh hint: each Captain must
refetch the existing authoritative available-request/Ride endpoint before
displaying or bidding. Captain eligibility must be recalculated using the
Ride's zone, category, radius, availability, approval, and work-conflict rules;
do not broadcast it to every Captain globally.

Also publish `ride.status.updated` or `ride.request.updated` on the owning
customer channel so another signed-in customer device reconciles through:

```http
GET /api/v1/ride-hailing/customer/rides/{ride_id}
```

The initiating Flutter device already waits for the PUT response and refetches
that same Ride detail immediately. Realtime is therefore required mainly to
update eligible Captain apps and the customer's other sessions. Firebase type
`ride_request_updated` should remain a background/offline refresh hint for
eligible Captains, with `ride_id`; REST remains authoritative after opening.

Laravel must allow the update only for the owning customer while status is
`searching` or `negotiating`, before Captain selection. It must transactionally
enforce the snapshotted minimum/maximum range, cooldown/rate limit, quote
policy, and assignment race locking. It must never rewrite existing Captain
bid amounts.

Negotiation realtime tests must verify eligible-only fan-out, post-commit
broadcasting, customer ownership, range/cooldown validation, concurrent
assignment locking, other-device reconciliation, and Firebase fallback.
