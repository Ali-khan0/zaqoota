# Ride Hailing Customer App Integration

## Scope

This is the authoritative customer-app handoff for Zaqoota Ride. It covers
capability discovery, vehicle/category presentation, batch estimates, booking,
price negotiation, Captain offers, lifecycle, nearby availability, coupons,
payments, promotions, realtime refresh and notifications. Existing food,
grocery, parcel, wallet and payment flows remain unchanged.

## Authentication and common headers

Customer Ride endpoints use the existing Passport customer token:

```http
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
Content-Type: application/json
zoneId: 1
latitude: 31.4504
longitude: 73.1350
```

Use the app's existing API client and authentication refresh behavior. Never
store or log quote tokens, Trip PINs, payment callback data or exact Captain
locations outside the active Ride state.

## 1. Capability discovery

`GET /api/v1/config` always includes:

```json
{
  "ride_hailing": {
    "customer_enabled": true,
    "nearby_availability_enabled": false,
    "customer_rebid_enabled": true,
    "offer_rejection_enabled": true,
    "customer_rebid_cooldown_seconds": 10,
    "nearby_refresh_seconds": 20
  }
}
```

Hide the Ride entry only when `customer_enabled` is false. Active Ride detail,
history, receipts and cancellation-due payment remain accessible. New estimate
and booking calls return HTTP 403 with `errors[0].code=ride_hailing` while
disabled.

## 2. Vehicle options and images

```http
GET /api/v1/ride-hailing/vehicle-options
```

```json
{
  "maximum_vehicle_limit": 2,
  "fuel_types": ["petrol", "electric", "hybrid", "diesel"],
  "vehicle_types": [{
    "id": 2,
    "name": "Car",
    "slug": "car",
    "image_url": "https://example.com/storage/ride-category/car.webp",
    "categories": [{
      "id": 3,
      "name": "Economy",
      "slug": "economy",
      "image_url": "https://example.com/storage/ride-category/economy.webp",
      "required_fuel_type": null,
      "passenger_capacity": 4
    }]
  }]
}
```

An image URL may be an empty string. Use the existing app placeholder in that
case.

## 3. Batch fare estimates

```http
POST /api/v1/ride-hailing/customer/fare-estimates
```

```json
{
  "pickup_latitude": 31.4504,
  "pickup_longitude": 73.1350,
  "destination_latitude": 31.4187,
  "destination_longitude": 73.0791
}
```

The backend resolves Google Routes once and calculates all active categories
configured for the pickup zone:

```json
{
  "zone": {"id": 1, "name": "Faisalabad"},
  "distance_meters": 9200,
  "duration_seconds": 1260,
  "route_polyline": "encoded-polyline",
  "estimates": [{
    "category": {"id": 3, "name": "Economy", "slug": "economy", "image_url": "", "passenger_capacity": 4},
    "quote_token": "ENCRYPTED_CATEGORY_BOUND_TOKEN",
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

Keep `POST .../fare-estimate` for backward compatibility. New UI should use
the batch endpoint and pass the selected category's unmodified `quote_token`
to `POST .../rides`.

## 4. Booking and customer price updates

Create a Ride with the existing endpoint:

```http
POST /api/v1/ride-hailing/customer/rides
```

```json
{
  "quote_token": "SELECTED_CATEGORY_TOKEN",
  "pickup_address": "Pickup address",
  "destination_address": "Destination address",
  "customer_offer": 340,
  "coupon_code": "RIDE100"
}
```

While `searching` or `negotiating`, and before quote expiry/Captain selection:

```http
PUT /api/v1/ride-hailing/customer/rides/42/customer-offer

{"customer_offer": 350}
```

```json
{"message":"Ride offer updated.","ride":{"id":42,"status":"negotiating","customer_offer":350}}
```

Respect `customer_rebid_enabled` and display the server cooldown. Existing
Captain offers do not change when the passenger changes their price.

## 5. Captain offers

Poll or refresh after realtime events:

```http
GET /api/v1/ride-hailing/customer/rides/42/offers
```

Offers are nearest-first and include `pickup_distance_meters` and
`pickup_eta_seconds`. Accept with:

```http
POST /api/v1/ride-hailing/customer/rides/42/offers/81/accept
```

When `offer_rejection_enabled` is true, reject one offer with:

```http
DELETE /api/v1/ride-hailing/customer/rides/42/offers/81
```

```json
{
  "message": "Captain offer rejected.",
  "offer": {"id": 81, "status": "rejected", "rejected_by": "customer", "rejected_at": "2026-08-10T12:03:00+05:00"}
}
```

The operation is idempotent for an already customer-rejected offer. It does
not cancel the Ride or affect other offers. That Captain cannot offer again on
the same Ride.

## 6. Privacy-preserving nearby availability

Call only when `nearby_availability_enabled` is true:

```http
GET /api/v1/ride-hailing/customer/nearby-availability?zone_id=1&ride_category_id=3&latitude=31.45&longitude=73.13
```

```json
{
  "available_count": 7,
  "estimated_pickup_minutes": {"minimum": 3, "maximum": 9},
  "approximate_markers": [{"latitude": 31.45, "longitude": 73.13}],
  "generated_at": "2026-08-10T12:00:00+05:00",
  "refresh_after_seconds": 20
}
```

Markers are rounded server-side and may represent multiple Captains. Never
treat them as live identity/location data or create Captain channels from them.
The backend returns no Captain ID, name, phone or vehicle before assignment.

## 7. Realtime and notification refresh hints

Use the existing authenticated Pusher/Reverb connection and REST fallback.
Relevant events are:

- `.ride.request.updated`: customer opening price changed; Captain refreshes requests.
- `.ride.offer.updated`: offer created, expired or customer-rejected; customer/Captain refreshes REST.
- `.ride.status.updated`: assignment/lifecycle/cancellation refresh.
- `.ride.location.updated`: assigned Captain location refresh.
- `.ride.payment.updated`: authoritative payment summary refresh.

Firebase types:

- `ride_request_updated` to currently eligible Captains, with `ride_id`.
- `ride_offer_rejected` to the affected Captain, with `ride_id` and `offer_id`.
- `ride_offer_accepted` to the selected Captain, with `ride_id` and `offer_id`.
- `ride_status` for arrival, cancellation, completion and payment lifecycle.

Push payloads are hints. Always fetch REST after opening. The Trip PIN is never
included in Firebase or stored notification JSON. Fetch it only from the
authenticated owned Ride detail while the server exposes it.

## 8. Lifecycle, coupon, payment and receipts

These existing specifications remain authoritative:

- `ride-trip-lifecycle.md`
- `ride-coupons.md`
- `ride-payments-and-settlement.md`
- `ride-promotions.md`
- `ride-realtime.md`

AssanPay uses `payment_gateway=assan_pay` on the existing Ride payment endpoint
and returns the shared `redirect_link`. The deep link is navigation only;
refresh payment summary after return. Cash, wallet, digital and partial payment
continue using the existing shared settings. Cancellation-limit dues require
online payment.

## Errors, pagination and retry behavior

Validation/business errors use HTTP 403:

```json
{"errors":[{"code":"customer_offer","message":"The customer offer must be inside the allowed negotiation range."}]}
```

Common codes are `ride_hailing`, `ride`, `customer_offer`, `offer`, `action`,
`pickup_location`, `ride_category_id`, `route`, `coupon_code`, and `payment`.
Route-provider failure uses HTTP 503. Ride history and payment attempts retain
their Laravel paginator envelope and accept `limit` up to 50. Do not retry a
mutation blindly after timeout; fetch the Ride/offers/payment summary first.

## Backend files

- Routes: `routes/api/v1/api.php`
- Config: `app/Http/Controllers/Api/V1/ConfigController.php`
- Customer APIs: `app/Http/Controllers/Api/V1/CustomerRideController.php`
- Captain APIs: `app/Http/Controllers/Api/V1/CaptainRideController.php`
- Vehicle options: `app/Http/Controllers/Api/V1/RideHailingController.php`
- Settings: `app/Services/RideCustomerSettingService.php`
- Matching: `app/Services/RideCaptainEligibilityService.php`
- Fare/route: `app/Services/RideFareCalculator.php`, `RideRouteService.php`
- Notifications/realtime: `app/Services/RideNotificationService.php`, `RideRealtimeService.php`
- Payments: `app/Services/RidePaymentService.php`
- Admin: `app/Http/Controllers/Admin/RideHailing/*`, `resources/views/admin-views/ride-hailing/*`
- Schema: `database/migrations/2026_08_10_000001_add_customer_ride_capabilities.php`
