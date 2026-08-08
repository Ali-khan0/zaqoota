# Ride Booking And Bidding API

Backend status: first booking and negotiation milestone implemented.

This contract covers server fare estimation, customer ride requests, eligible
Captain discovery, Captain offers, and customer offer selection. It does not
yet cover arrival, Trip PIN, trip execution, post-selection cancellation,
payment collection, wallet posting, live sockets, or push notifications.

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
  "customer_offer": 300
}
```

The offer must be between `minimum_negotiated_fare` and
`maximum_negotiated_fare`. One customer may have only one active passenger
request. Successful creation returns HTTP `201` with `message` and `ride`.

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
