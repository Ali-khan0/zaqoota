# Ride Promotions API

## Purpose

The Ride customer experience has dedicated banners and notification history. These records are not commerce banners or order notifications. Admin management is under **Ride Hailing > Promotion Management**.

Base URL: `/api/v1/ride-hailing/customer`

All endpoints require the customer Passport bearer token and `Accept: application/json`. The app must send its current pickup `zone_id`; the server never trusts the client to decide which records are active.

## Active banners

`GET /banners?zone_id=1&ride_category_id=2`

`zone_id` is required. `ride_category_id` is optional and should be supplied after a vehicle category is selected. The response includes currently enabled banners inside their configured start/end window. A global banner and a banner targeting the supplied zone are eligible; category filtering follows the same global-or-selected rule.

```json
{
  "banners": [
    {
      "id": 12,
      "title": "Save on your next Ride",
      "description": "Use ZQRIDE20 before the offer ends.",
      "image_url": "https://example.com/storage/app/public/ride-promotion/banner.webp",
      "action_type": "coupon",
      "action_value": "ZQRIDE20",
      "starts_at": "2026-08-09T08:00:00+05:00",
      "expires_at": "2026-08-16T23:59:00+05:00"
    }
  ]
}
```

## Notification feed

`GET /notifications?zone_id=1&limit=20&page=1`

`zone_id` is required. `limit` is optional (`1-50`, default `20`). Only enabled notifications sent during the last 30 days are returned.

```json
{
  "notifications": [{
    "id": 30,
    "title": "Weekend Ride offer",
    "description": "Open Ride Hailing to book now.",
    "image_url": "",
    "action_type": "ride_home",
    "action_value": null,
    "sent_at": "2026-08-09T14:10:00+05:00"
  }],
  "pagination": {"total": 1, "per_page": 20, "current_page": 1, "last_page": 1}
}
```

Validation errors use the existing `errors[]` format and HTTP `403`.

## Mobile behavior

- `ride_home`: open the Ride booking home screen.
- `coupon`: open Ride booking and prefill `action_value` as the Ride coupon code. Coupon validity must still be checked through `/coupons/validate`.
- `url`: open only an HTTPS URL using the app's safe external-link flow.
- `none` is possible for banners only and performs no navigation.
- Cache banners briefly and refresh when zone/category changes. Do not display expired cached banners offline.
- The notification feed is server history, not proof that FCM reached a device.

## Firebase payload

Admin sends to `all_zone_customer` for all zones or `zone_{zone_id}_customer` for a selected zone. The customer app must subscribe using the existing zone-topic lifecycle. The payload is:

```json
{
  "title": "Weekend Ride offer",
  "body": "Open Ride Hailing to book now.",
  "type": "ride_promotion",
  "image": "https://example.com/image.webp",
  "action_type": "ride_home",
  "action_value": "",
  "zone_id": "1",
  "sound": "notification.wav"
}
```

Treat REST as authoritative. Unknown action types must fall back to the Ride home screen. Never execute `action_value` as code or accept non-HTTPS external URLs.

## Backend files

- `app/Models/RideBanner.php`
- `app/Models/RidePushNotification.php`
- `app/Http/Controllers/Api/V1/RidePromotionController.php`
- `app/Http/Controllers/Admin/RideHailing/RideBannerController.php`
- `app/Http/Controllers/Admin/RideHailing/RidePushNotificationController.php`
- `database/migrations/2026_08_09_000007_create_ride_promotion_tables.php`
- `routes/api/v1/api.php`
- `routes/admin/routes.php`

