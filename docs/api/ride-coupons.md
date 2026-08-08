# Ride Coupons API

Backend status: admin CRUD, customer preview/application, atomic reservation,
trip-start redemption, cancellation release, usage history, and admin-funded
discount accounting are implemented.

## Financial Rule

```text
passenger payable = final accepted fare - coupon discount + waiting charge
Zaqoota commission = percentage of the full final accepted fare
Captain earning = final accepted fare - commission + waiting charge
admin coupon expense = coupon discount
```

Coupons never reduce waiting or cancellation charges. Chargeable cancellation
removes the coupon discount and charges the configured cancellation amount.

## Authentication And Headers

All endpoints use Passport customer authentication.

```http
Authorization: Bearer CUSTOMER_TOKEN
Accept: application/json
Content-Type: application/json
```

## Preview A Coupon

```http
POST /api/v1/ride-hailing/customer/coupons/validate
```

```json
{
  "coupon_code": "ZAQOOTA20",
  "zone_id": 3,
  "ride_category_id": 2,
  "fare": 1000
}
```

```json
{
  "coupon": {
    "code": "ZAQOOTA20",
    "title": "First Ride Offer",
    "discount_amount": 150,
    "fare_after_discount": 850
  }
}
```

This is a preview. The backend revalidates against the accepted Captain offer.

## Create Ride With Coupon

Add optional `coupon_code` to the existing Ride request:

```json
{
  "quote_token": "ENCRYPTED_QUOTE",
  "pickup_address": "Pickup address",
  "destination_address": "Destination address",
  "customer_offer": 900,
  "coupon_code": "ZAQOOTA20"
}
```

The coupon is not consumed at creation. On Captain-offer acceptance the backend
locks and rechecks status/dates, pickup zone, category, minimum accepted fare,
first-Ride eligibility, total limit, and per-passenger limit. Valid usage becomes
`reserved`, then `redeemed` when the Captain starts the trip. Pre-start customer
or Captain cancellation changes it to `released` and frees its limits.

Before a Captain is selected, replace or remove a code without cancelling the
Ride:

```http
PUT /api/v1/ride-hailing/customer/rides/{ride_id}/coupon
```

```json
{"coupon_code": "NEWCODE"}
```

Send `{"coupon_code": null}` to remove it. This is rejected after Captain
selection.

The authoritative Ride response contains:

```json
{
  "coupon": {"code": "ZAQOOTA20", "discount_amount": 150},
  "final_accepted_fare": 1000
}
```

## Payment Restrictions

Coupons allow all methods or a subset of `cash`, `digital`, and `wallet`. Wallet
plus another method requires both methods. Existing global wallet and partial
payment settings remain authoritative. Allowed methods are snapshotted when the
Captain offer is accepted, so later admin edits cannot change an active Ride.

## Errors

Errors use HTTP 403:

```json
{"errors":[{"code":"coupon_code","message":"This Ride coupon usage limit has been reached."}]}
```

Do not calculate eligibility locally. If final offer acceptance reports a
coupon error, keep the Ride request open and use the update endpoint to replace
or remove the code before retrying acceptance.

## Mobile Screen Behavior

1. Show the coupon field after fare estimation and before Ride creation.
2. Call preview when the passenger submits a code.
3. Label preview discount as estimated until an offer is accepted.
4. Use the accepted Ride response as the authoritative discount.
5. Show coupon discount as a separate negative fare line.
6. Never discount waiting or cancellation charges locally.

## Admin Surface

`/admin/ride-hailing/coupons` provides create, edit, status, safe delete,
search, and usage drill-down. Conditions include discount/cap, minimum fare,
zones, categories, payment methods, first Ride, limits, and active dates. Used
coupons cannot be deleted.

## Backend Files

- `routes/admin/routes.php`
- `routes/api/v1/api.php`
- `app/Http/Controllers/Admin/RideHailing/RideCouponController.php`
- `app/Http/Controllers/Api/V1/CustomerRideController.php`
- `app/Models/RideCoupon.php`
- `app/Models/RideCouponUsage.php`
- `app/Services/RideCouponService.php`
- `app/Services/RideSettlementCalculator.php`
- `app/Services/RidePaymentService.php`
- `database/migrations/2026_08_09_000006_create_ride_coupon_tables.php`
- `tests/Unit/RideCouponServiceTest.php`
