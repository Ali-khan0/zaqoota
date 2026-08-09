# Ride Booking And Bidding API

## Captain pickup priority

Available requests are personalized using the Captain's latest stored location. The backend calculates straight-line pickup distance, excludes requests beyond `ride_hailing_maximum_pickup_radius_km`, and returns the remaining requests nearest-first. Responses include `pickup_distance_meters` and `pickup_eta_seconds`; ETA uses `ride_hailing_pickup_eta_speed_kmh` and does not affect fare calculations. Captains without a stored location cannot discover or offer on passenger Rides.

The realtime creation event only tells the Captain app to refresh. The same eligible Captain collection also receives a stored in-app message and Firebase `type=ride_request` push when a token is available. REST remains authoritative for personalized ordering and eligibility. The offer write path repeats the radius check to prevent bypassing discovery with a Ride ID.

Pickup distance and ETA are snapshotted on every submitted offer. `GET /api/v1/ride-hailing/customer/rides/{ride_id}/offers` returns offers nearest-first and includes both fields, allowing the passenger app to show proximity beside the Captain's price and rating. `ride.offer.updated` carries the same fields; refresh the REST list after the event to preserve authoritative ordering.

Backend status: first booking and negotiation milestone implemented.

This contract covers server fare estimation, customer ride requests, eligible
Captain discovery, Captain offers, and customer offer selection. It does not
yet cover arrival, Trip PIN, trip execution, post-selection cancellation,
payment collection or wallet posting. Live sockets and new-request push
discovery are implemented as latency improvements over authoritative polling.

## Authentication And Headers

Base URL:

```text
https://YOUR-DOMAIN.example/api/v1
```

Customer endpoints require a Passport token:

```http
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
Content-Type: application/json
```

Captain endpoints use the shared delivery-man token. Bearer transport is
preferred; the legacy `token` body/query/header value remains supported:

```http
Authorization: Bearer CAPTAIN_TOKEN
Accept: application/json
Content-Type: application/json
```

## Statuses In This Milestone

| Status | Meaning |
|---|---|
| `searching` | Customer request exists and no Captain has offered yet |
| `negotiating` | At least one Captain offer has been submitted |
| `rider_selected` | Customer accepted one non-expired Captain offer |
| `cancelled` | Customer cancelled before selecting a Captain |

Future lifecycle statuses are intentionally deferred.

## Fare Rules

The server calls Google Routes with the configured server map key. Mobile must
never calculate an authoritative distance, duration, or fare.

```text
calculated = base fare
           + trip kilometres * per-kilometre charge
           + trip minutes * per-minute charge

suggested fare = max(minimum fare, calculated)
```

There is no surge pricing. The configured negotiation percentages produce the
minimum and maximum customer/Captain price. All calculations round through
integer currency cents. Pickup determines the zone and zone/category fare.
The configured pickup-distance charge is not part of the initial estimate
because no Captain is assigned at that point; Captains may account for their
pickup distance in the negotiated offer. Formal pickup-distance settlement is
deferred to the trip lifecycle milestone.

The fare-estimate response contains an encrypted `quote_token` valid for five
minutes. The create request must return this token. This prevents a client from
changing route metrics or fare snapshots.

When an offer is accepted:

```text
platform commission = final accepted offer * platform commission percentage
rider earning        = final accepted offer - platform commission
```

These values are snapshotted but are not posted to wallets in this milestone.

## Customer Endpoints

### Estimate Fare

```http
POST /ride-hailing/customer/fare-estimate
```

Request:

```json
{
  "ride_category_id": 3,
  "pickup_latitude": 31.4504,
  "pickup_longitude": 73.1350,
  "destination_latitude": 31.4187,
  "destination_longitude": 73.0791
}
```

Response:

```json
{
  "quote_token": "ENCRYPTED_OPAQUE_VALUE",
  "quote_expires_at": "2026-08-09T12:05:00+05:00",
  "zone": {"id": 1, "name": "Faisalabad"},
  "category": {"id": 3, "name": "Economy"},
  "distance_meters": 9200,
  "duration_seconds": 1260,
  "route_polyline": "encoded-polyline",
  "base_fare": 50,
  "distance_charge": 230,
  "duration_charge": 42,
  "suggested_fare": 322,
  "minimum_negotiated_fare": 257.6,
  "maximum_negotiated_fare": 483,
  "free_waiting_minutes": 3,
  "waiting_charge_per_minute": 5
}
```

### Create Ride Request

```http
POST /ride-hailing/customer/rides
```

```json
{
  "quote_token": "ENCRYPTED_OPAQUE_VALUE",
  "pickup_address": "Pickup display address",
  "destination_address": "Destination display address",
  "customer_offer": 300,
  "coupon_code": "ZAQOOTA20"
}
```

The offer must be between `minimum_negotiated_fare` and
`maximum_negotiated_fare`. One customer may have only one active passenger
request. `coupon_code` is optional; preview and final revalidation are defined
in `ride-coupons.md`. Successful creation returns HTTP `201` with `message` and
`ride`.

### List Customer Rides

```http
GET /ride-hailing/customer/rides?limit=20&page=1
```

Returns Laravel pagination. Maximum `limit` is 50.

### Ride Details

```http
GET /ride-hailing/customer/rides/{ride_id}
```

The customer can read only their own ride. Once selected, the response includes
the Captain and vehicle plus `final_accepted_fare`. Internal commission and
rider earning snapshots are not exposed.

### Current Captain Offers

```http
GET /ride-hailing/customer/rides/{ride_id}/offers
```

```json
{
  "offers": [
    {
      "id": 81,
      "amount": 310,
      "expires_at": "2026-08-09T12:00:30+05:00",
      "captain": {"id": 14, "name": "Sample Captain", "rating": 4.8, "rating_count": 91},
      "vehicle": {"id": 6, "make": "Toyota", "model": "Corolla", "color": "White", "registration_number": "SAMPLE-001"}
    }
  ]
}
```

Expired offers are marked expired and excluded.

### Cancel Before Captain Selection

```http
DELETE /ride-hailing/customer/rides/{ride_id}
```

Only `searching` and `negotiating` requests can be cancelled in this milestone.
There is no fee. Pending Captain offers are rejected. Cancellation after Captain
selection belongs to the next lifecycle and cancellation-settlement milestone.

### Select Captain Offer

```http
POST /ride-hailing/customer/rides/{ride_id}/offers/{offer_id}/accept
```

No body is required. Selection locks the ride and offer transactionally,
rechecks Captain eligibility, accepts exactly one offer, rejects other pending
offers, snapshots final commission/earning, and changes the ride to
`rider_selected`.

## Captain Endpoints

### Discover Eligible Requests

```http
GET /delivery-man/ride-requests?limit=20&page=1
```

A Captain receives requests only when all conditions are true:

- approved Captain account;
- currently online/active and in `ride` mode;
- same zone as pickup;
- approved active vehicle matching the requested category;
- no active passenger ride;
- no active non-parcel commerce order.

Parcel assignments are not treated as a conflicting commerce order, matching
the shared work-mode rule. Requests with a current offer from this Captain are
excluded until that offer expires.

### Submit Or Replace Offer

```http
POST /delivery-man/ride-requests/{ride_id}/offers
```

```json
{"amount": 310}
```

The amount must be inside the request negotiation range. Eligibility is
rechecked under a database transaction. The offer expires after the fare's
configured `offer_expiry_seconds`. Before selection, submitting again replaces
the Captain's previous offer and resets its expiry.

### Captain Offer History

```http
GET /delivery-man/ride-offers?limit=20&page=1
```

Returns paginated offers with status and the associated ride summary. Pending
offers past `expires_at` are normalized to `expired` before the response.

## Errors

Validation/business errors use the existing envelope, normally HTTP `403`:

```json
{
  "errors": [
    {"code": "customer_offer", "message": "The customer offer must be inside the allowed negotiation range."}
  ]
}
```

Important codes include `ride_category_id`, `pickup_location`, `route`,
`quote_token`, `customer_offer`, `ride`, `captain`, and `offer`. Google routing
failure returns HTTP `503`. Invalid authentication returns `401`. Missing or
unowned route records return `404`.

## Mobile Screen Behavior

Customer app:

1. Select category and map locations.
2. Request an estimate and retain `quote_token` only until its expiry.
3. Show suggested/min/max fare and let the customer enter a valid offer.
4. Create the ride, then poll offers while status is `searching` or
   `negotiating`.
5. Display an offer countdown from `expires_at`; remove expired rows.
6. Selecting a Captain must disable repeated taps until the API responds.
7. On `rider_selected`, open the trip screen implemented in
   `ride-trip-lifecycle.md`.

Captain app:

1. Poll available requests only while online in Ride mode.
2. Display customer offer, suggested fare, route distance/duration and route
   endpoints.
3. Validate offer input against the returned minimum/maximum.
4. Show offer expiry and use offer history to detect acceptance.

Private account/trip events and authoritative polling fallback are documented
in `ride-realtime.md`.

## Security And Concurrency

- Never accept distance, duration, zone, fare rates, or negotiation bounds from
  an unsigned client field.
- Quote tokens are encrypted, customer-bound, and expire after five minutes.
- Customer ownership is applied to every customer ride query.
- Captain mode, zone, online state, conflicting work and active vehicle are
  checked on discovery, offer submission, and final selection.
- Offer selection uses row locks; concurrent selections cannot assign two
  Captains.
- Only the final accepted price is the commission base.
- Wallet settlement is defined separately in `ride-payments-and-settlement.md`.

## Backend Files

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/CustomerRideController.php`
- `app/Http/Controllers/Api/V1/CaptainRideController.php`
- `app/Models/RideRequest.php`
- `app/Models/RideOffer.php`
- `app/Models/RideFare.php`
- `app/Services/RideRouteService.php`
- `app/Services/RideFareCalculator.php`
- `app/Services/RideCaptainEligibilityService.php`
- `database/migrations/2026_08_09_000002_create_ride_booking_tables.php`
- `tests/Unit/RideFareCalculatorTest.php`
### New Ride notification delivery audit

When a request is created, the same nearest-first eligible Captain collection
used by realtime discovery receives `type=ride_request` push and/or in-app
notification according to the admin template toggles. Each Captain attempt is
stored by Ride, Captain, and event. In-app records are created once, and a push
already accepted by Firebase is never resent. Captains without an FCM token and
failed Firebase submissions remain visible to administrators. While the Ride
is still searching or negotiating, an administrator may retry; the server
recalculates eligibility and attempts only recipients without an accepted push.

Firebase acceptance means the Firebase API accepted the message for processing.
It does not confirm that the device displayed or the Captain read it.
Push submission is handled by the retryable `SendRideRequestPush` queue job.
Production must use a durable non-sync queue connection with a supervised
worker; the in-app notification record is still created immediately.
## Customer app capability extension

The additive customer-app contract is finalized in
`ride-customer-app-integration.md`. New authenticated endpoints are:

- `POST /api/v1/ride-hailing/customer/fare-estimates`: one Google route and
  category-bound encrypted quotes for every active fare category in the pickup
  zone.
- `PUT /api/v1/ride-hailing/customer/rides/{ride_id}/customer-offer`: update
  the opening price under ownership, state, quote-expiry, bounds, lock and
  configured cooldown checks.
- `DELETE /api/v1/ride-hailing/customer/rides/{ride_id}/offers/{offer_id}`:
  idempotently reject one pending offer without affecting the Ride or other
  offers. A customer-rejected Captain cannot offer again on that Ride.
- `GET /api/v1/ride-hailing/customer/nearby-availability`: optional,
  throttled counts/ETA and rounded anonymous markers. It never returns Captain
  identity or exact position.

`GET /api/v1/config` advertises all capability toggles. New estimates and
booking are rejected with `code=ride_hailing` when customer Ride booking is
disabled, while existing Ride/history/payment APIs remain available.
