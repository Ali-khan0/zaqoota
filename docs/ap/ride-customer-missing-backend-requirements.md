# Missing Ride Customer Backend Requirements

> Implementation status (2026-08-10): completed in the backend. The finalized
> mobile contract is `ride-customer-app-integration.md`. Nearby approximate
> markers remain admin-disabled by default until the product/privacy team
> enables them. AssanPay required no new protocol because the existing shared
> `PaymentRequest` hooks already satisfy section 8.

## Purpose

This document defines the backend contracts still required for the requested
customer Ride experience. These features are not present in the current Ride
API specifications and must not be simulated only in Flutter.

Existing booking, lifecycle, realtime, payment, promotion, wallet and receipt
contracts remain unchanged. All new customer endpoints require the existing
Passport bearer token unless explicitly marked public.

## 1. API-controlled customer Ride availability

Extend `GET /api/v1/config` with:

```json
{
  "ride_hailing": {
    "customer_enabled": true,
    "nearby_availability_enabled": false,
    "customer_rebid_enabled": true,
    "offer_rejection_enabled": true
  }
}
```

- `customer_enabled=false` hides the customer Ride entry and prevents new fare
  estimates/bookings server-side with HTTP `403` and code `ride_hailing`.
- Existing active Rides, payment dues, history and receipts must remain
  accessible when new bookings are disabled.
- The object must always be returned. Do not make mobile infer availability
  from realtime configuration or vehicle categories.

Admin needs a Ride Hailing setting for `customer_enabled`. The other capability
flags must reflect whether their backend milestone is deployed.

## 2. Vehicle/category images

Extend the public endpoint:

```http
GET /api/v1/ride-hailing/vehicle-options
Accept: application/json
```

Required additive response fields:

```json
{
  "vehicle_types": [{
    "id": 2,
    "name": "Car",
    "slug": "car",
    "image_url": "https://example.com/storage/ride/vehicle-type/car.webp",
    "categories": [{
      "id": 3,
      "name": "Economy",
      "slug": "economy",
      "image_url": "https://example.com/storage/ride/category/economy.webp",
      "passenger_capacity": 4
    }]
  }]
}
```

- Admin must support upload, replacement and removal for vehicle-type and
  category images.
- Store relative paths; API returns absolute HTTPS URLs or an empty string.
- Validate JPEG, PNG or WebP, maximum 5 MB.
- Existing clients must continue working when images are absent.

## 3. Estimate every selectable category

The requested UI shows category image, name and calculated fare together.
Avoid one Google Routes call per category. Add a batch endpoint:

```http
POST /api/v1/ride-hailing/customer/fare-estimates
Authorization: Bearer CUSTOMER_TOKEN
Content-Type: application/json
```

```json
{
  "pickup_latitude": 31.4504,
  "pickup_longitude": 73.1350,
  "destination_latitude": 31.4187,
  "destination_longitude": 73.0791
}
```

Response:

```json
{
  "zone": {"id": 1, "name": "Faisalabad"},
  "distance_meters": 9200,
  "duration_seconds": 1260,
  "route_polyline": "encoded-polyline",
  "estimates": [{
    "category": {
      "id": 3,
      "name": "Economy",
      "image_url": "https://example.com/economy.webp",
      "passenger_capacity": 4
    },
    "quote_token": "CATEGORY_BOUND_ENCRYPTED_TOKEN",
    "quote_expires_at": "2026-08-10T12:05:00+05:00",
    "base_fare": 50,
    "distance_charge": 230,
    "duration_charge": 42,
    "suggested_fare": 322,
    "minimum_negotiated_fare": 257.6,
    "maximum_negotiated_fare": 483,
    "free_waiting_minutes": 3,
    "waiting_charge_per_minute": 5
  }]
}
```

- Resolve the route once, then calculate every active category available in the
  pickup zone.
- Each quote token must be customer-, route-, zone- and category-bound.
- Creating a Ride continues to use the selected category's `quote_token`.
- Exclude unavailable categories; never return a client-calculated fare.

## 4. Customer price update while bidding

Add:

```http
PUT /api/v1/ride-hailing/customer/rides/{ride_id}/customer-offer
Authorization: Bearer CUSTOMER_TOKEN
Content-Type: application/json
```

```json
{"customer_offer": 340}
```

Allowed only while the Ride is `searching` or `negotiating` and before Captain
selection. Revalidate ownership, quote expiry policy and the snapshotted
minimum/maximum negotiation range under a transaction.

Response:

```json
{
  "message": "Ride offer updated.",
  "ride": {
    "id": 42,
    "status": "negotiating",
    "customer_offer": 340,
    "updated_at": "2026-08-10T12:02:00+05:00"
  }
}
```

Rules:

- Rate-limit updates, recommended maximum one per 10 seconds.
- Do not modify Captain offer amounts.
- Existing Captain offers remain visible until accepted, rejected or expired.
- Notify currently eligible Captains to refresh authoritative REST state.
- Publish `.ride.request.updated` to the same eligible Captain account fan-out
  used for new requests and `.ride.status.updated` to the customer account.
- Concurrent Captain selection wins only if it locks the Ride first; otherwise
  the updated customer offer is persisted before selection.

Errors use HTTP `403` with codes `ride`, `customer_offer` or `action`.

## 5. Reject one Captain offer

Add:

```http
DELETE /api/v1/ride-hailing/customer/rides/{ride_id}/offers/{offer_id}
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
```

Response:

```json
{
  "message": "Captain offer rejected.",
  "offer": {
    "id": 81,
    "status": "rejected",
    "rejected_by": "customer",
    "rejected_at": "2026-08-10T12:03:00+05:00"
  }
}
```

Rules:

- Lock the owned Ride and offer transactionally.
- Allow only pending, non-expired offers on `searching` or `negotiating` Rides.
- Rejecting one offer must not cancel the Ride or affect other offers.
- A Captain whose offer was explicitly customer-rejected cannot submit another
  offer for that Ride unless a future specification explicitly allows it.
- Publish `.ride.offer.updated` to customer and affected Captain channels.
- Store/send a Captain notification with `type=ride_offer_rejected`.

Do not confuse this with the existing behavior that automatically rejects all
competing offers when one Captain is accepted.

## 6. Nearby Captain availability on the pre-booking map

Do not expose exact Captain coordinates, IDs, names, phones or vehicles before
assignment. If the product requires availability markers, add an aggregate,
privacy-preserving endpoint:

```http
GET /api/v1/ride-hailing/customer/nearby-availability?zone_id=1&ride_category_id=3&latitude=31.45&longitude=73.13
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
```

Example:

```json
{
  "available_count": 7,
  "estimated_pickup_minutes": {"minimum": 3, "maximum": 9},
  "approximate_markers": [
    {"latitude": 31.45, "longitude": 73.13, "heading": 145.5}
  ],
  "generated_at": "2026-08-10T12:00:00+05:00",
  "refresh_after_seconds": 20
}
```

Security requirements:

- Include only approved, online Captains in Ride mode with an eligible active
  vehicle and no conflicting work.
- Round, bucket or add server-controlled jitter to marker coordinates.
- Return at most 20 approximate markers and rate-limit requests.
- Never provide a realtime Captain channel before assignment.
- This endpoint is optional. Prefer an availability count/ETA without markers
  if privacy review rejects approximate locations.

## 7. Notification contracts

Add or confirm these Firebase/stored notification payload types:

| Event | Audience | `type` | Required fields |
|---|---|---|---|
| Customer changes opening price | eligible Captains | `ride_request_updated` | `ride_id` |
| Customer rejects Captain offer | affected Captain | `ride_offer_rejected` | `ride_id`, `offer_id` |
| Customer accepts Captain | selected Captain | `ride_offer_accepted` | `ride_id`, `offer_id` |
| Captain cancels/rejects assignment | customer | `ride_status` | `ride_id`, `status=cancelled` |
| Captain arrives | customer | `ride_status` | `ride_id`, `status=arrived` |

All push events are refresh hints. Mobile fetches REST after opening them.

Do **not** include `trip_pin` in Firebase, notification title/body, stored
notification JSON, analytics or logs. Lock-screen notifications can expose it.
The arrival notification should say to open the Ride screen; the authenticated
Ride details endpoint remains the only customer source for the PIN.

Add notification-template conditions and localized admin-managed titles/bodies
for the new events. Push failure must not roll back a successful mutation.

## 8. AssanPay Ride payment compatibility

Ride payments must reuse the existing AssanPay/`PaymentRequest` gateway layer.
The existing Ride endpoint remains:

```http
POST /api/v1/ride-hailing/customer/rides/{ride_id}/payments
```

```json
{
  "payment_method": "digital",
  "payment_gateway": "assan_pay",
  "payment_platform": "app",
  "callback_url": "zaqoota://ride-payment-result",
  "use_wallet": true
}
```

Backend requirements:

- Return the normal AssanPay `redirect_link` used by the in-app WebView.
- Use the server-side `ride_payment_success`/`ride_payment_fail` hooks.
- Redirect success/failure through the established mobile payment result flow.
- Treat the callback/deep link only as navigation; REST payment summary remains
  authoritative.
- Preserve one-pending-attempt and idempotent settlement guarantees.

If the existing food/order WebView uses a different documented HTTPS callback,
standardize the Ride response to that shared callback before mobile work. Do
not create a second AssanPay protocol only for Ride.

## 9. Admin requirements

Add admin controls for:

1. Customer Ride enabled/disabled.
2. Vehicle-type and category image upload/removal.
3. Customer rebidding enabled/disabled and update cooldown.
4. Individual offer rejection enabled/disabled.
5. Nearby availability enabled/disabled and privacy parameters.
6. New notification templates and Push/In-App toggles.

Audit all setting changes. Validate uploads and preserve existing Ride records
when a category or capability is disabled.

## 10. Required backend tests

Add feature/unit tests for:

1. Config flags and disabled-booking enforcement while history/payment remain accessible.
2. Image validation and absolute API URLs.
3. Batch estimates sharing route metrics but producing category-bound tokens.
4. Rebid ownership, state, bounds, cooldown, locking and realtime fan-out.
5. Individual rejection ownership, state, idempotency and Captain re-offer prevention.
6. Nearby availability eligibility, privacy rounding, limits and throttling.
7. Notification audience/payloads with explicit proof that Trip PIN is absent.
8. AssanPay success/failure callbacks and duplicate-callback settlement safety.

## 11. Mobile handoff acceptance criteria

Backend handoff is complete only when:

- this document is updated with final implemented request/response examples;
- routes appear in the development environment;
- configuration advertises capability flags accurately;
- realtime event names and payloads are finalized;
- migrations, seed/default settings and admin screens are deployed;
- automated backend tests pass; and
- dedicated customer and Captain development accounts are provided for mobile
  end-to-end testing.
