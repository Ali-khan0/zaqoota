# Mobile API Documentation

This directory is the handoff point between the Laravel backend and mobile
applications.

## Rules

- Every new mobile-facing feature must have its own Markdown file here.
- An API document must be updated in the same change as its routes,
  controllers, authentication, request fields, or response fields.
- Mobile developers should implement against documented response keys, not raw
  database columns.
- Backward-incompatible response changes require a new API version.
- Examples never contain production tokens, credentials, phone numbers, or
  private documents.

## Available specifications

| Feature | Document | Status |
|---|---|---|
| Fleet-manager mobile routing, riders, payables, commission and withdrawals | [fleet-management.md](fleet-management.md) | Backend implemented |
| Vendor store self-registration and email side effects | [vendor-registration.md](vendor-registration.md) | Backend implemented |
| Ride Hailing rider work mode and vehicle eligibility | [ride-hailing-rider-mode.md](ride-hailing-rider-mode.md) | Backend foundation implemented |
| Complete Ride Hailing rider-app handoff | [ride-hailing-rider-app-integration.md](ride-hailing-rider-app-integration.md) | Current integration contract and future boundary |
| Shared rider registration and first/second vehicle workflow | [rider-registration-and-vehicles.md](rider-registration-and-vehicles.md) | Backend implemented |
| Ride fare estimation, customer booking and Captain bidding | [ride-booking-and-bidding.md](ride-booking-and-bidding.md) | First booking milestone implemented |
| Ride coupon preview, eligibility, reservation, redemption and accounting | [ride-coupons.md](ride-coupons.md) | Backend implemented |
| Ride banners, notification feed and Firebase promotion payload | [ride-promotions.md](ride-promotions.md) | Backend implemented |
| Ride arrival, Trip PIN, waiting, location and completion | [ride-trip-lifecycle.md](ride-trip-lifecycle.md) | Trip lifecycle milestone implemented |
| Ride cash/online/customer-wallet payment, partial payment, cancellation dues, settlement and receipts | [ride-payments-and-settlement.md](ride-payments-and-settlement.md) | Payment milestone implemented |
| Private Ride channels, events, reconnect and polling fallback | [ride-realtime.md](ride-realtime.md) | Realtime milestone implemented |
| Complete customer Ride capability, estimate, bidding, lifecycle and payment handoff | [ride-customer-app-integration.md](ride-customer-app-integration.md) | Backend implemented |
| Customer Ride backend delivery checklist | [ride-customer-backend-implementation-steps.md](ride-customer-backend-implementation-steps.md) | Implementation complete; deployment pending |
| Customer home module visibility by zone | [module-visibility.md](../api/module-visibility.md) | Backend implemented |

## Common conventions

### Base URL

Examples use:

```text
https://YOUR-DOMAIN.example/api/v1
```

Replace the domain for development, staging, or production.

### JSON headers

```http
Accept: application/json
Content-Type: application/json
```

Do not send `Content-Type: application/json` for a multipart upload; the mobile
HTTP library must generate the multipart boundary.

### Token transport

New mobile code should use:

```http
Authorization: Bearer YOUR_TOKEN
```

The backend also accepts `token` as a request field or HTTP header for
compatibility with the existing rider application.

### Localization

Send the locale using the same language header already used by the mobile
application. API messages pass through the backend translation system.

### Validation errors

The legacy API error envelope is:

```json
{
  "errors": [
    {
      "code": "field_name",
      "message": "Human-readable error"
    }
  ]
}
```

Mobile code must display `message` and must not depend on English wording.

### Pagination

Paginated endpoints use Laravel pagination:

```json
{
  "current_page": 1,
  "data": [],
  "first_page_url": "https://YOUR-DOMAIN.example/api/v1/example?page=1",
  "from": 1,
  "last_page": 3,
  "last_page_url": "https://YOUR-DOMAIN.example/api/v1/example?page=3",
  "next_page_url": "https://YOUR-DOMAIN.example/api/v1/example?page=2",
  "path": "https://YOUR-DOMAIN.example/api/v1/example",
  "per_page": 25,
  "prev_page_url": null,
  "to": 25,
  "total": 62
}
```

Treat pagination URLs as optional. The stable fields for mobile paging are
`current_page`, `last_page`, `per_page`, `total`, and `data`.
