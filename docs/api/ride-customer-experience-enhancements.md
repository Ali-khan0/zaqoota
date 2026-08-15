# Customer Ride Experience Enhancements API

## Status

P0 response enrichment is implemented. P1 customer ratings/history filters and
P2 enhanced location telemetry are implemented pending final endpoint-level
verification. Progress is tracked in
[`docs/ride-customer-experience-enhancements.md`](../ride-customer-experience-enhancements.md)
and will be documented here as each phase becomes active.

## Authentication and headers

Both endpoints require the existing Passport customer token:

```http
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
```

## Enriched owned Ride endpoints

```http
GET /api/v1/ride-hailing/customer/rides?limit=20&page=1
GET /api/v1/ride-hailing/customer/rides/{ride_id}
```

The list remains newest-first and uses the existing Laravel paginator. `limit`
defaults to 20 and is capped at 50. Detail retains the existing `{ "ride":
... }` envelope. No request body is accepted.

Each existing Ride resource now also includes:

```json
{
  "route_polyline": "ENCODED_ROUTE_POLYLINE",
  "accepted_pickup": {
    "distance_meters": 2400,
    "eta_seconds": 420,
    "calculated_at": "2026-08-15T12:05:00+05:00"
  },
  "captain": {
    "id": 14,
    "name": "Sample Captain",
    "phone": "+00000000000",
    "image_url": "https://example.com/storage/delivery-man/captain.webp",
    "rating": 4.8,
    "rating_count": 91
  }
}
```

Existing `pickup`, `destination`, `vehicle`, lifecycle, payment, coupon and
Trip PIN fields are unchanged.

## Null and legacy behavior

- `captain`, `vehicle`, and `accepted_pickup` are `null` before assignment.
- `route_polyline` is an empty string for a legacy Ride without a stored route.
- `image_url` is an absolute URL when a Captain image exists and an empty
  string otherwise.
- Captain rating values are numeric; a Captain with no ratings returns `0.0`
  and `rating_count: 0`.
- Accepted pickup metrics are the accepted offer snapshot. They are estimates,
  never live navigation data or fare inputs.

## Errors

- Unauthenticated requests return HTTP 401 through Passport.
- Missing or customer-unowned Ride IDs return HTTP 404.
- The list returns an empty paginator when the customer has no Rides.

The endpoint introduces no new mutation or validation errors.

## Mobile behavior

Restore the server polyline after restart, show accepted pickup ETA as an
offer-time estimate, and hide Captain/vehicle/ETA UI while its object is null.
REST remains authoritative after realtime refresh hints. Existing Trip PIN,
payment, receipt, cancellation and pagination behavior remains unchanged.

## Security constraints

- Every query remains scoped to the authenticated Passport customer.
- Captain identity and location are absent before assignment.
- Exact location, Trip PIN, internal commission and Captain earning are not
  added to realtime or Firebase payloads by P0.
- Relationships are eager-loaded for list responses to avoid identity/rating
  N+1 queries.

## Relevant backend files

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/CustomerRideController.php`
- `app/Models/RideRequest.php`
- `app/Models/RideOffer.php`
- `app/Models/DeliveryMan.php`
- `tests/Unit/RideCustomerResponseTest.php`

## Customer Ride rating

```http
PUT /api/v1/ride-hailing/customer/rides/{ride_id}/rating
Content-Type: application/json
```

```json
{
  "rating": 5,
  "comment": "Safe and professional"
}
```

`rating` is an integer from 1 through 5. `comment` is optional, stripped of
HTML, trimmed, and limited to 1,000 characters. The Ride must belong to the
authenticated customer, be completed, and have an assigned Captain. Repeated
requests update the same unique-per-Ride record.

```json
{
  "message": "Ride rating saved.",
  "rating": {
    "ride_id": 42,
    "captain_id": 14,
    "rating": 5,
    "comment": "Safe and professional",
    "updated_at": "2026-08-15T12:30:00+05:00"
  }
}
```

Owned list/detail resources include the same object as `customer_rating`, or
`null` when unrated. Ride ratings contribute to the Captain aggregate together
with existing delivery ratings. Comments are visible only to the customer who
submitted them; Captain/admin comment display is not authorized. A rating is
retained with its Ride and is cascade-deleted if the Ride, customer, or Captain
is deleted. Rating does not affect payment or settlement.

Incomplete or unassigned Rides return HTTP 403 with `code=rating`; missing or
unowned Ride IDs return 404; authentication failures return 401.

## Ride history filters

```http
GET /api/v1/ride-hailing/customer/rides?limit=20&page=1&status=completed&from=2026-08-01&to=2026-08-31
```

`status` accepts an exact documented Ride status. `from` and `to` use
`YYYY-MM-DD`; when both are supplied, `to` cannot precede `from`. Date bounds
use the Laravel application's configured timezone and include the full boundary
days. Filtering remains owner-scoped, newest-first and paginated. Omitting all
filters preserves active-Ride recovery behavior.

Invalid filters return HTTP 403 using the existing `errors[]` validation
envelope.

## Enhanced Captain location telemetry

The existing Captain-authenticated endpoint accepts optional telemetry:

```http
PUT /api/v1/delivery-man/rides/{ride_id}/location
Authorization: Bearer CAPTAIN_TOKEN
Content-Type: application/json

{
  "latitude": 31.4504,
  "longitude": 73.1350,
  "heading": 145.5,
  "speed_mps": 8.5,
  "accuracy_meters": 12.0
}
```

- `heading`: nullable, `0 <= value < 360`;
- `speed_mps`: nullable, `0 <= value <= 100`;
- `accuracy_meters`: nullable, `0 <= value <= 1000`.

The existing assignment, active Ride status, Captain ownership and 120/minute
throttle protections remain. The response, owned active-Ride detail, and
private `ride.location.updated` event expose the server timestamp and nullable
telemetry fields. Telemetry is not exposed before assignment or after a Ride is
completed/cancelled. It never changes fare, waiting, payment, or settlement.

Additional backend files:

- `app/Http/Controllers/Api/V1/CaptainRideController.php`
- `app/Models/RideRating.php`
- `app/Services/RideTripService.php`
- `app/Services/RideRealtimeService.php`
- `database/migrations/2026_08_15_000001_create_ride_ratings_table.php`
- `database/migrations/2026_08_15_000002_add_ride_location_telemetry.php`
- `tests/Unit/RideRealtimeEventTest.php`
