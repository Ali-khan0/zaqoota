# Ride Customer Experience API Enhancements

## Status and scope

Backend proposal for the next customer Ride milestone. The existing customer
Ride list/detail endpoints remain authoritative. No customer `/rides/current`
endpoint is required because Laravel already enforces one active Ride and
returns owned Rides newest-first.

This specification defines additive fields and optional endpoints for:

- assigned Captain image and rating;
- persisted route restoration;
- accepted pickup distance and ETA;
- optional enhanced location telemetry;
- customer rating/feedback;
- optional Ride-history filters.

Safety/SOS, masked calling, secure trip sharing and chat require separate
security/product specifications and are not authorized by this document.

## Implementation progress

Status is updated only after implementation and focused verification. `Pending`
does not mean the item is absent from the proposal; it means the active Laravel
implementation has not yet been verified complete for this milestone.

| Phase | Deliverable | Status |
|---|---|---|
| Context | Repository-owned Markdown and active Ride implementation audit | Done |
| P0 | Enriched owned Ride list/detail response | Done |
| P0 | Captain image and aggregate rating without N+1 queries | Done |
| P0 | Stored route and accepted pickup snapshot restoration | Done |
| P0 | Pre-assignment and legacy-record privacy fallbacks | Done |
| P0 | Focused automated tests and API documentation | Done |
| P1 | Dedicated, idempotent customer Ride rating | Implemented; DB verification pending |
| P1 | Customer-owned status/date history filters | Implemented; DB verification pending |
| P1 | Focused automated tests and API documentation | Tests written; DB execution blocked |
| P2 | Optional Captain heading/speed/accuracy telemetry | Implemented; migration verification pending |
| P2 | Active-assignment privacy, realtime payload and validation tests | Unit verification done; DB execution pending |
| Final | Full Ride regression verification and deployment notes | In progress |

Current verification environment note (2026-08-15): PHP exposes `pdo_mysql`
only. The isolated feature tests intentionally require `pdo_sqlite` so they do
not connect to or mutate the configured backup database. The Ride unit suite
passes, while rating ownership/idempotency and history database tests are
discovered and skipped until `pdo_sqlite` is installed or a dedicated test
database is provided. Do not change these rows to `Done` based only on skipped
tests.

## Authentication and headers

All endpoints use the existing Passport customer token:

```http
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
Content-Type: application/json
```

Captain location updates retain the existing delivery-man authentication.
Never accept a customer/Captain ID from the request to establish ownership.

## 1. Enriched existing Ride list and detail responses (P0)

Existing endpoints:

```http
GET /api/v1/ride-hailing/customer/rides?limit=20&page=1
GET /api/v1/ride-hailing/customer/rides/{ride_id}
```

Keep the current paginator/detail envelopes and add these response fields:

```json
{
  "id": 42,
  "request_number": "ZQR-0000042",
  "status": "captain_arriving",
  "route_polyline": "ENCODED_ROUTE_POLYLINE",
  "pickup": {
    "address": "Pickup address",
    "latitude": 31.4504,
    "longitude": 73.1350
  },
  "destination": {
    "address": "Destination address",
    "latitude": 31.4187,
    "longitude": 73.0791
  },
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
  },
  "vehicle": {
    "id": 6,
    "make": "Toyota",
    "model": "Corolla",
    "color": "White",
    "registration_number": "SAMPLE-001"
  }
}
```

Rules:

1. These are additive fields; keep existing response keys and envelopes.
2. `captain`, `vehicle` and `accepted_pickup` are `null` before assignment.
3. `image_url` is an absolute HTTPS URL or an empty string.
4. `rating` is numeric and `rating_count` is an integer. Return zero values
   only when the Captain genuinely has no ratings.
5. `route_polyline` is the server route stored/snapshotted at quotation. Return
   an empty string only for legacy records without a stored route.
6. Accepted pickup distance/ETA come from the accepted offer snapshot. They are
   estimates, not fare inputs and not live navigation truth.
7. Trip PIN visibility remains governed by `ride-trip-lifecycle.md`.
8. Eager-load category, assigned Captain rating/media, vehicle and accepted
   offer data for list responses to prevent N+1 queries.

No new mutation is required for these fields.

## 2. Optional enhanced Captain location telemetry (P2)

Extend the existing Captain endpoint:

```http
PUT /api/v1/delivery-man/rides/{ride_id}/location
Authorization: Bearer CAPTAIN_TOKEN
```

Backward-compatible request:

```json
{
  "latitude": 31.4504,
  "longitude": 73.1350,
  "heading": 145.5,
  "speed_mps": 8.5,
  "accuracy_meters": 12.0
}
```

Validation:

- `heading`: nullable numeric, `0 <= value < 360`;
- `speed_mps`: nullable numeric, `0 <= value <= 100`;
- `accuracy_meters`: nullable numeric, `0 <= value <= 1000`;
- retain existing coordinate validation, ownership, active-status and throttle
  rules.

Owned Ride detail and `ride.location.updated` may add:

```json
{
  "captain_location": {
    "latitude": 31.4504,
    "longitude": 73.1350,
    "heading": 145.5,
    "speed_mps": 8.5,
    "accuracy_meters": 12.0,
    "updated_at": "2026-08-15T12:10:00+05:00"
  }
}
```

REST remains authoritative after reconnect. Do not expose telemetry before
Captain assignment or after the Ride becomes terminal.

## 3. Customer rating and feedback (P1)

New endpoint:

```http
PUT /api/v1/ride-hailing/customer/rides/{ride_id}/rating
```

Request:

```json
{
  "rating": 5,
  "comment": "Safe and professional"
}
```

Response:

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

Rules:

1. The Ride must belong to the authenticated customer.
2. The Ride must be `completed` and have an assigned Captain.
3. `rating` is required integer from 1 through 5.
4. `comment` is optional string, maximum 1000 characters, sanitized for
   display.
5. Use one rating per Ride with an update-or-create/unique constraint so retry
   and repeated submission cannot create duplicates.
6. Rating must not mutate Ride payment or settlement.
7. Define a business retention/moderation policy before exposing comments to
   Captains or administrators.

Errors use the existing HTTP 403 envelope:

```json
{
  "errors": [
    {"code": "rating", "message": "Only a completed Ride can be rated."}
  ]
}
```

Unowned/missing Rides return 404; unauthenticated requests return 401.

The owned Ride list/detail response may add:

```json
{
  "customer_rating": {
    "rating": 5,
    "comment": "Safe and professional",
    "updated_at": "2026-08-15T12:30:00+05:00"
  }
}
```

Return `customer_rating: null` when not rated.

## 4. Optional existing-list filters (P1)

Extend—not replace—the existing endpoint:

```http
GET /api/v1/ride-hailing/customer/rides?limit=20&page=1&status=completed&from=2026-08-01&to=2026-08-31
```

Optional query fields:

| Field | Validation | Behavior |
|---|---|---|
| `status` | one of the documented Ride statuses | Exact status filter |
| `from` | `YYYY-MM-DD` | Customer-timezone start of date |
| `to` | `YYYY-MM-DD`, not before `from` | Customer-timezone end of date |

Filters must remain customer-scoped, newest-first and paginated. Maximum
`limit` remains 50. Invalid filters use the existing validation envelope.

Do not change default behavior when no filters are supplied; active-Ride
recovery depends on the existing newest-first unfiltered list.

## Realtime and Firebase behavior

- The enriched detail fields are fetched through REST after existing
  `.ride.status.updated` and `.ride.location.updated` hints.
- Location events may carry the optional telemetry fields but must not carry
  Captain phone, image, rating, Trip PIN or auth data.
- Rating submission does not require a realtime event. If one is added later,
  it remains a refresh hint.
- Firebase payloads must continue excluding Trip PIN and exact Captain
  location.

## Mobile behavior

1. Hide image/rating/ETA when absent; do not show misleading zero placeholders.
2. Draw the stored route after app restart and reconcile location timestamps.
3. Label pickup ETA as an estimate captured at offer acceptance unless a future
   live ETA contract is introduced.
4. Offer rating after eligible completion without blocking payment, receipt or
   history access.
5. Use server pagination/filters and preserve existing active-Ride recovery.

## Security and privacy

- Every customer query/mutation is scoped to the Passport user.
- Do not expose Captain identity or exact location before assignment.
- Consider masking the Captain phone in a separate communications milestone;
  do not silently change phone behavior without coordinating both apps.
- Reject stale/out-of-order telemetry server-side where practical and always
  return authoritative `updated_at`.
- Sanitize feedback and restrict administrative display by role.
- Never derive fare, settlement or waiting charges from pickup ETA or device
  telemetry.

## Backend implementation surfaces

Expected Laravel files (verify names in the active repository):

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/CustomerRideController.php`
- `app/Http/Controllers/Api/V1/CaptainRideController.php`
- `app/Models/RideRequest.php`
- `app/Models/RideOffer.php`
- `app/Models/RideRating.php` or the approved existing rating model
- `app/Models/DeliveryMan.php`
- `app/Services/RideTripService.php`
- `app/Services/RideRealtimeService.php`
- additive migrations for missing route/telemetry/rating storage only

## Required backend tests

1. Owned list/detail returns Captain image/rating, route and accepted pickup
   snapshot after assignment.
2. Pre-assignment responses return nullable assigned fields without identity
   leakage.
3. List query count does not grow per Ride due to relationship N+1 loading.
4. Legacy Ride without route/accepted offer data returns safe empty/null values.
5. Location telemetry validation, ownership, throttle and active-status rules.
6. Completed owned Ride rating create/update is idempotent and unique per Ride.
7. Unowned, incomplete and unassigned Ride rating is rejected.
8. Status/date filters remain customer-scoped, newest-first and paginated.
9. Existing booking, Trip PIN, payment, receipt and realtime tests remain green.

## Deployment order

1. Implement/test additive P0 response fields.
2. Deploy Laravel and verify authenticated JSON.
3. Release defensive Flutter parsing/UI.
4. Implement rating and filters as separate P1 migrations/routes.
5. Implement enhanced telemetry only after Captain/customer app coordination.
6. Specify safety/communications separately before backend or mobile work.
