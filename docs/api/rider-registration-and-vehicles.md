# Shared Rider Registration and Vehicle API

One rider account is shared by restaurant/grocery delivery, parcel delivery,
and Ride Hailing. There is no separate Ride Hailing rider enrollment.

## Public vehicle options

```http
GET /api/v1/ride-hailing/vehicle-options
Accept: application/json
```

No authentication is required. The response contains active `vehicle_types`,
their nested `categories`, supported `fuel_types`, and
`maximum_vehicle_limit` (`2`). Fetch this before rendering registration and
use IDs, not display names, in later requests.

```json
{
  "maximum_vehicle_limit": 2,
  "fuel_types": ["petrol", "electric", "hybrid", "diesel"],
  "vehicle_types": [{
    "id": 2,
    "name": "Car",
    "slug": "car",
    "categories": [{
      "id": 3,
      "name": "Economy",
      "slug": "economy",
      "required_fuel_type": null,
      "passenger_capacity": 4
    }]
  }]
}
```

## Register rider and first vehicle

```http
POST /api/v1/auth/delivery-man/store
Content-Type: multipart/form-data
```

Existing rider fields remain required: `f_name`, `identity_type`,
`identity_number`, `email`, `phone`, `password`, and `zone_id`.
Riders are always created as freelancers; mobile must not display or send an
`earning`, salary, or rider-type choice.
The old client field `vehicle_id` is replaced by the first vehicle fields:

| Field | Type | Required | Notes |
|---|---|---|---|
| `ride_vehicle_type_id` | integer | yes | Active type from options |
| `ride_category_id` | integer | yes | Must belong to selected type |
| `fuel_type` | string | yes | One of the returned fuel types |
| `make` | string | yes | Maximum 100 characters |
| `model` | string | yes | Maximum 100 characters |
| `model_year` | integer | no | 1980 through next calendar year |
| `color` | string | yes | Maximum 50 characters |
| `registration_number` | string | yes | Unique; normalized to uppercase |

Bike category drives Petrol/EV selection. Car category drives Economy,
Business, or Luxury. Render only categories nested under the selected type. If
`required_fuel_type` is non-null, preselect that value.

The rider and first vehicle are created atomically. Both remain pending until
admin approval. Approving the rider also approves and activates the first
vehicle.

## Submit a second vehicle

```http
POST /api/v1/delivery-man/ride-vehicles
Authorization: Bearer RIDER_TOKEN
Content-Type: application/json
```

Use the same vehicle fields as registration. The server derives the rider from
the token and never accepts `delivery_man_id` from mobile.

```json
{
  "ride_vehicle_type_id": 1,
  "ride_category_id": 2,
  "fuel_type": "electric",
  "make": "Evee",
  "model": "C1",
  "model_year": 2026,
  "color": "Black",
  "registration_number": "LEB-1234"
}
```

Success is HTTP `201`. The returned vehicle has `status: "pending"` and
`is_active: false`. It cannot be selected until admin approval. Validation is
HTTP `422`, including incompatible type/category/fuel, duplicate registration
number, or the two-vehicle limit.

## Mobile screens and security

- Registration must select one vehicle before submission.
- Vehicle management shows zero to two vehicles and approval status.
- Show Add vehicle only when `can_register_more` is true.
- Do not allow local activation of pending or rejected vehicles.
- Never trust cached options for validation; display backend errors.
- Registration numbers are personal operational data and must not be logged.

## Backend files

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/RideHailingController.php`
- `app/Http/Controllers/Api/V1/Auth/DeliveryManLoginController.php`
- `app/Http/Controllers/Api/V1/DeliverymanController.php`
- `app/Services/RideVehicleRegistrationService.php`
- `app/Http/Controllers/Admin/DeliveryMan/DeliveryManController.php`
- `resources/views/dm-registration.blade.php`
