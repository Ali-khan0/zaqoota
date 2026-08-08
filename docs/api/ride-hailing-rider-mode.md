# Ride Hailing Rider Work Mode API

This contract lets the existing delivery-man application switch the same rider
account between commerce delivery work and Ride Hailing work. A rider receives
only one workload type at a time.

## Authentication and headers

All endpoints use the existing `dm.api` middleware. Send the existing rider
token using the app's current token transport, preferably:

```http
Authorization: Bearer RIDER_TOKEN
Accept: application/json
Content-Type: application/json
```

The legacy `token` request field/header remains supported by the middleware and
controller.

## Change work mode

```http
PUT /api/v1/delivery-man/work-mode
```

### Request

| Field | Type | Required | Values |
|---|---:|---:|---|
| `work_mode` | string | yes | `delivery`, `ride` |

```json
{
  "work_mode": "ride"
}
```

### Success response

```json
{
  "message": "Rider work mode updated successfully.",
  "work_mode": "ride",
  "receives_delivery_orders": false,
  "receives_ride_requests": true,
  "active_ride_vehicle_id": 18
}
```

### Rules and errors

- A rider cannot switch to `ride` while `current_orders` is greater than zero.
- A rider needs an approved active ride vehicle before switching to `ride`.
- A rider can register at most two ride vehicles. Vehicle registration and
  approval are currently administered from the Ride Hailing admin panel.
- While in `ride` mode, the delivery latest-orders endpoint returns an empty
  array and accepting a delivery order returns HTTP `409`.
- Existing admin assignment lists use the `DeliveryMan::available()` scope and
  therefore include only riders in `delivery` mode.

Validation failure uses HTTP `422`. An active-delivery conflict uses HTTP `409`:

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

## Rider profile additions

```http
GET /api/v1/delivery-man/profile
```

The existing profile response now includes:

- `work_mode`: `delivery` or `ride`.
- `ride_vehicles`: up to two registered vehicles with their vehicle type and
  ride category.
- `active_ride_vehicle`: the approved vehicle currently used for rides, or
  `null`.

Mobile should show a Delivery/Ride segmented control. Disable Ride mode and
show the backend error when no approved active vehicle exists. Switching modes
must not silently change the rider's online/offline `active` status.

## Rider vehicle list and selection

List the authenticated rider's registered vehicles:

```http
GET /api/v1/delivery-man/ride-vehicles
```

The response is an array containing at most two vehicles. Each vehicle includes
its `vehicle_type`, `category`, approval `status`, and `is_active` flag.

Select an approved vehicle for Ride mode:

```http
PUT /api/v1/delivery-man/ride-vehicles/{vehicle_id}/activate
```

```json
{
  "message": "Active ride vehicle updated.",
  "active_ride_vehicle_id": 18
}
```

The backend verifies that the vehicle belongs to the authenticated rider and
is approved. Selecting it deactivates that rider's other ride vehicle.

## Security

- Never accept a rider ID from the mobile client; resolve the rider from the
  authenticated token.
- Do not expose vehicle records belonging to another rider.
- Server-side assignment and acceptance checks are authoritative; hiding an
  order in the app is not sufficient access control.
- Registration numbers and future vehicle documents are personal operational
  data and must not be logged or exposed outside authorized ride workflows.

## Backend files

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/DeliverymanController.php`
- `app/Models/DeliveryMan.php`
- `app/Models/RideVehicle.php`
- `database/migrations/2026_08_08_000008_create_ride_hailing_foundation_tables.php`

This foundation does not yet define ride discovery, matching, acceptance, trip,
fare-estimation, or payment APIs.
