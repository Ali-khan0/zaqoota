# Captain Ride vehicle resubmission

## Endpoint

`POST /api/v1/delivery-man/ride-vehicles/{vehicle_id}/resubmit`

Authentication uses the existing `dm.api` Captain token contract. The vehicle
must belong to the authenticated Captain and its current status must be
`rejected`.

## Multipart request

Required fields: `ride_vehicle_type_id`, `ride_category_id`, `fuel_type`,
`make`, `model`, `color`, and `registration_number`.

Optional fields: `model_year`, `vehicle_front_image`, and
`vehicle_back_image`. An omitted image keeps the existing vehicle photo. A new
image replaces the old file only after the database transaction commits.
Images accept JPG, JPEG, PNG or WebP up to 5 MB.

## Success

HTTP 200 returns:

```json
{
  "message": "Ride vehicle corrected and resubmitted for approval.",
  "vehicle": {
    "id": 9,
    "status": "pending",
    "is_active": false,
    "admin_note": null
  }
}
```

Resubmission updates the same record, so it does not consume another slot from
the two-vehicle limit. The previous rejection audit remains and a new
`rejected` → `pending` audit is appended with a null admin actor. Latest review
snapshot fields are cleared until the next admin decision.

## Errors

- 401: invalid Captain token.
- 404: the vehicle does not exist or belongs to another Captain.
- 422: the vehicle is not rejected, validation fails, registration number is
  used by another vehicle, or category/type/fuel selection is incompatible.

## Security and state

- Ownership is resolved from the authenticated Captain; no Captain ID is
  accepted from the client.
- Laravel locks the owned vehicle before checking rejected status and updating
  it.
- Replayed submission after the first success is rejected because the vehicle
  is already pending.
- Pending and rejected vehicles remain inactive.

## Relevant source

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/DeliverymanController.php`
- `app/Services/RideVehicleRegistrationService.php`
- `app/Models/RideVehicle.php`
- `app/Models/RideVehicleReviewAudit.php`

