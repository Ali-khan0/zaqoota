# Zaqoota Ride: Rider App Integration Handoff

Give this document to the coding agent working on the Zaqoota rider mobile
application. It describes the Ride Hailing backend that exists now, the exact
mobile work required now, and the ride/trip functions that must not be invented
until their backend APIs are implemented.

## 1. Integration scope

The same authenticated rider account is used for food/grocery delivery and
Ride Hailing. The rider selects exactly one work mode:

- `delivery`: receives restaurant/grocery and parcel delivery orders.
- `ride`: receives parcel orders and eligible passenger ride requests.

This backend release currently supports:

- reading the rider's current `work_mode` from the existing profile endpoint;
- switching between Delivery and Ride modes;
- listing up to two registered ride vehicles;
- registering the first vehicle with the rider account and submitting a second
  vehicle later;
- selecting one approved ride vehicle as active;
- preventing Ride-mode riders from discovering or accepting restaurant and
  grocery orders while preserving parcel work;
- returning vehicle type, ride category, fuel, approval, and identity details;
- discovering eligible passenger ride requests and submitting or replacing a
  fare offer. See `docs/api/ride-booking-and-bidding.md` for those endpoints.

It does **not** currently provide the post-acceptance trip lifecycle, live trip
tracking, PIN verification, ride payments, or ride earnings APIs. Do not create
fake local versions of those workflows in the rider app.

## 2. Base URL and authentication

```text
https://YOUR-DOMAIN.example/api/v1
```

All endpoints in this document use the existing rider authentication middleware
`dm.api`.

Preferred headers:

```http
Authorization: Bearer RIDER_TOKEN
Accept: application/json
Content-Type: application/json
```

For backward compatibility, the backend also accepts the token in a `token`
request field or `token` header. New mobile code should use Bearer auth.

Never send a rider ID. The backend resolves the rider from the authenticated
token.

## 3. Mobile data models

Use enums rather than translated display strings for decisions.

```text
RiderWorkMode: delivery | ride
RideVehicleStatus: pending | approved | rejected
RideVehicleFuel: petrol | electric | hybrid | diesel
```

Suggested mobile models:

```text
RideVehicleType
  id: int
  name: string
  slug: string

RideCategory
  id: int
  name: string
  slug: string
  passengerCapacity: int

RideVehicle
  id: int
  vehicleType: RideVehicleType
  category: RideCategory
  fuelType: string
  make: string
  model: string
  modelYear: int?
  color: string
  registrationNumber: string
  status: RideVehicleStatus
  isActive: bool
  adminNote: string?
```

Unknown enum values must not crash parsing. Treat an unknown status as
unavailable and require a fresh profile/vehicle fetch.

## 4. Existing profile endpoint

```http
GET /api/v1/delivery-man/profile
```

The existing profile response retains all previous fields and now additionally
contains:

| Field | Type | Meaning |
|---|---|---|
| `work_mode` | string | Current `delivery` or `ride` mode |
| `ride_vehicles` | array | Up to two registered ride vehicles |
| `active_ride_vehicle` | object/null | Approved active vehicle |

Old rider apps can ignore these additive fields and remain in the default
Delivery mode.

The dedicated vehicle endpoint below is the stable source for the vehicle
management screen. Use profile fields for initial mode rendering, then refresh
the dedicated endpoint when entering the vehicle screen.

## 5. List rider vehicles

```http
GET /api/v1/delivery-man/ride-vehicles
```

### Success response: HTTP 200

```json
{
  "vehicles": [
    {
      "id": 18,
      "vehicle_type": {
        "id": 2,
        "name": "Car",
        "slug": "car"
      },
      "category": {
        "id": 4,
        "name": "Business",
        "slug": "business",
        "passenger_capacity": 4
      },
      "fuel_type": "petrol",
      "make": "Toyota",
      "model": "Corolla",
      "model_year": 2024,
      "color": "White",
      "registration_number": "ABC-123",
      "status": "approved",
      "is_active": true,
      "admin_note": null
    }
  ],
  "maximum_vehicle_limit": 2,
  "registered_vehicle_count": 1,
  "can_register_more": true
}
```

### UI behavior

- Display a stable list with capacity for zero, one, or two vehicles.
- Show vehicle type and category separately, for example `Car · Business`.
- Show fuel type for every vehicle. Bike categories currently include Petrol
  Bike and EV Bike.
- Display make/model, year, colour, and registration number.
- Show one of: Pending approval, Approved, or Rejected.
- Show an Active label only when `is_active` is true.
- Disable vehicle selection for `pending` and `rejected` vehicles.
- Show `admin_note` for rejected vehicles when it is non-empty.
- Show Add vehicle when `can_register_more` is true and submit it using
  `POST /delivery-man/ride-vehicles` as documented in
  `rider-registration-and-vehicles.md`.

## 6. Select the active ride vehicle

```http
PUT /api/v1/delivery-man/ride-vehicles/{vehicle_id}/activate
```

No JSON body is required.

### Success response: HTTP 200

```json
{
  "message": "Active ride vehicle updated.",
  "active_ride_vehicle_id": 18
}
```

On success:

1. Update the selected vehicle locally.
2. Clear `is_active` from the other vehicle.
3. Fetch `GET /delivery-man/ride-vehicles` in the background to reconcile with
   the server.

### Errors

Vehicle does not exist or belongs to another rider, HTTP 404:

```json
{
  "errors": [
    {
      "code": "ride_vehicle",
      "message": "Ride vehicle not found."
    }
  ]
}
```

Vehicle is not approved, HTTP 422:

```json
{
  "errors": [
    {
      "code": "ride_vehicle",
      "message": "Only an approved ride vehicle can be activated."
    }
  ]
}
```

Display the backend `message`; do not decide approval only from stale local
data.

## 7. Change rider work mode

```http
PUT /api/v1/delivery-man/work-mode
```

### Request

```json
{
  "work_mode": "ride"
}
```

### Success response: HTTP 200

```json
{
  "message": "Rider work mode updated successfully.",
  "work_mode": "ride",
  "receives_delivery_orders": false,
  "receives_parcel_orders": true,
  "receives_ride_requests": true,
  "active_ride_vehicle_id": 18
}
```

### Server rules

- `work_mode` is required and must be `delivery` or `ride`.
- Switching to Ride mode fails while a restaurant or grocery order is active;
  an active parcel does not block it.
- Switching to Ride mode requires one approved active ride vehicle.
- Switching mode does not change the existing online/offline `active` status.
- Delivery assignment lists, latest-order discovery, and delivery acceptance
  independently enforce Delivery mode.

### Errors

Active delivery conflict, HTTP 409:

```json
{
  "errors": [
    {
      "code": "work_mode",
      "message": "Complete your active deliveries before switching to Ride mode."
    }
  ]
}
```

No approved active vehicle, HTTP 422:

```json
{
  "errors": [
    {
      "code": "ride_vehicle",
      "message": "An approved active ride vehicle is required for Ride mode."
    }
  ]
}
```

Validation errors use the standard `errors` array. Always display the returned
message and keep the previous mode selected.

## 8. Required rider-app screens

### Home work-mode control

Add a compact segmented control or switch near the rider's online status:

```text
[ Delivery ] [ Ride ]
```

Behavior:

1. Initialize from profile `work_mode`; default to `delivery` only when the
   field is absent for backward compatibility.
2. Do not optimistically commit the visual state before the API succeeds.
3. When Ride is tapped, verify locally that an approved active vehicle is
   present, but still call the backend because server validation is final.
4. On success, clear restaurant/grocery offer state, retain parcel work, and
   refresh the home screen.
5. On failure, retain the old mode and show the backend message.
6. The online/offline control remains separate.

### My ride vehicles

Add a screen reachable from the profile/menu:

- list zero to two vehicles;
- status and active indicator;
- vehicle identity details;
- category and passenger capacity;
- select an approved vehicle;
- add one more vehicle when `can_register_more` is true and show its approval
  status.

Do not add an upload or registration form until its API is implemented.

### Ride-mode placeholder state

Until ride matching endpoints are released, Ride mode must show a neutral
availability state and must not simulate ride offers. Suggested product state:

```text
Ride mode is active
Your approved vehicle: Toyota Corolla · Business
```

The application can continue posting the rider's existing location if that is
already part of the online rider workflow, but it must not claim that ride
matching is active until the backend endpoint exists.

## 9. State management requirements

Keep these values in the authenticated rider state:

```text
workMode
rideVehicles
activeRideVehicleId
rideVehicleLoading
workModeUpdating
```

Recommended refresh points:

- after login/profile refresh;
- when opening My ride vehicles;
- after vehicle activation;
- after returning from background if the vehicle was pending approval;
- after a push notification about vehicle approval, once that notification is
  implemented.

Avoid concurrent mode updates. Disable the segmented control while the request
is pending and ignore repeated taps.

## 10. Delivery compatibility

Existing endpoints remain unchanged except for authoritative mode filtering:

```http
GET /api/v1/delivery-man/latest-orders
PUT /api/v1/delivery-man/accept-order
```

In Ride mode:

- `latest-orders` returns an empty JSON array;
- `accept-order` returns HTTP 409 with error code `work_mode`.

The mobile app should stop delivery polling when Ride mode succeeds. The server
checks remain required to protect against old clients and race conditions.

## 11. Loading, offline, and retry behavior

- Use the app's existing authenticated retry/interceptor behavior.
- Do not change mode locally while offline. Explain that a connection is
  required.
- Vehicle-list GET may be retried normally.
- Work-mode and vehicle-activation PUT requests are not queued for later; the
  user's context may have changed by then.
- On HTTP 401, follow the existing rider logout/token-refresh behavior.
- On HTTP 409 or 422, show the first `errors[].message` inline or as the app's
  standard error notification.
- On unexpected 5xx, retain the previous server-confirmed mode and vehicle.

## 12. Security and privacy

- Do not log auth tokens, registration numbers, or future vehicle documents.
- Never expose another rider's vehicle by manipulating `vehicle_id`; the server
  already ownership-checks, and the client must not cache vehicles across
  accounts.
- Clear ride vehicle state on logout/account change.
- Do not use display names such as `Business` for authorization. Use IDs,
  status, and server responses.
- Do not infer approval from the presence of vehicle data.
- Treat `admin_note` as operational information and show it only to its owner.

## 13. Acceptance checklist for the rider app

- Existing riders open in Delivery mode when `work_mode` is absent or
  `delivery`.
- A rider with an active delivery cannot switch to Ride mode.
- A rider without an approved active vehicle cannot switch to Ride mode.
- A rider can view zero, one, or two vehicle records without layout issues.
- Pending and rejected vehicles cannot be activated.
- Activating one approved vehicle clears the other active selection.
- Ride mode stops delivery polling and delivery cards disappear.
- Returning to Delivery mode resumes the existing delivery workflow.
- Network failure never leaves the UI in a mode the server did not confirm.
- Logout clears mode and vehicle state.

## 14. Backend implementation references

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/DeliverymanController.php`
- `app/Models/DeliveryMan.php`
- `app/Models/RideVehicle.php`
- `app/Models/RideVehicleType.php`
- `app/Models/RideCategory.php`
- `database/migrations/2026_08_08_000008_create_ride_hailing_foundation_tables.php`
- `RIDE_HAILING_CONTEXT.md`

## 15. Passenger Ride integration

The passenger Ride backend now has dedicated mobile contracts:

- `ride-booking-and-bidding.md`: discovery and Captain offers;
- `ride-trip-lifecycle.md`: arrival, waiting, PIN, location and completion;
- `ride-payments-and-settlement.md`: cash/digital payment and wallet posting;
- `ride-realtime.md`: private channels, events and polling fallback.

The Captain app should implement those contracts together and continue using
this file for shared account, work-mode, and vehicle behavior.

Scheduled rides, route-deviation handling, ratings, safety, chat, complaints,
refunds/disputes, and detailed Ride earnings history still require separate
backend/API specifications. Do not invent those workflows locally.
