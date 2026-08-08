# Vendor Store Registration

## Endpoint

```http
POST /api/v1/auth/vendor/register
```

This public endpoint creates a vendor owner and the owner's first store. It is
available only when store self-registration and the vendor app are enabled.

## Authentication And Headers

No bearer token is required.

```http
Accept: application/json
Content-Type: multipart/form-data
```

The mobile networking library must generate the multipart boundary.

## Request Fields

| Field | Type | Required | Notes |
|---|---|---:|---|
| `f_name` | string | Yes | Owner first name, maximum 100 characters. |
| `l_name` | string | No | Owner last name, maximum 100 characters. |
| `email` | string | Yes | Must be unique among vendors. |
| `phone` | string | Yes | 10-20 characters and unique among vendors. |
| `password` | string | Yes | At least 8 characters with mixed case, letters, numbers, and symbols; compromised passwords are rejected. |
| `latitude` | number/string | Yes | Must fall inside `zone_id`. |
| `longitude` | number/string | Yes | Must fall inside `zone_id`. |
| `zone_id` | integer | Yes | Selected operating zone. |
| `module_id` | integer | Yes | Selected business module. |
| `minimum_delivery_time` | integer | Yes | Minimum preparation/delivery estimate. |
| `maximum_delivery_time` | integer | Yes | Maximum preparation/delivery estimate. |
| `delivery_time_type` | string | Yes | Existing app value such as `min`, `hours`, or `days`. |
| `translations` | JSON string | Yes | Store name and address translation rows; the first/default name becomes the canonical store name. |
| `logo` | image | Yes | Maximum 2 MB; allowed formats follow backend `IMAGE_FORMAT_FOR_VALIDATION`. |
| `cover_photo` | image | No | Maximum 2 MB. |
| `pickup_zone_id` | JSON/array | Rental only | Required for an active Rental module. |
| `business_plan` | string | Configuration-dependent | `commission` or `subscription`. |
| `package_id` | integer | Subscription only | Subscription package identifier. |
| `tin` | string | No | Tax identifier. |
| `tin_expire_date` | date/string | No | Tax document expiry date. |
| `tin_certificate_image` | image | No | Tax certificate upload. |

Example `translations` value:

```json
[
  {"locale":"default","key":"name","value":"Zaqoota Kitchen"},
  {"locale":"default","key":"address","value":"Main Boulevard"}
]
```

## Success Responses

Commission-plan example:

```json
{
  "store_id": 125,
  "type": "commission",
  "message": "Application placed successfully"
}
```

Subscription-plan responses also include `package_id` and set `type` to
`subscription`. The client should retain `store_id`, show `message`, and route
the applicant to the pending-approval experience.

## Errors

Validation and out-of-zone failures normally return HTTP `403` using the common
`errors` array. Self-registration can also return an error when disabled.

```json
{
  "errors": [
    {"code":"email","message":"The email has already been taken."}
  ]
}
```

This endpoint is not paginated.

## Email Side Effects

When mail and notification settings are enabled, registration sends the Store
Registration template to the applicant and a new-store notification to the
admin. `{storeName}` is populated from the created store's canonical `name`,
not from the owner's `f_name`/`l_name`. Later approval and denial emails use the
same store name. Email failures are logged and do not change the API response.

The Store Registration and Store Approval templates can optionally show an
action button. When enabled, Admin must provide both a button label and a valid
absolute URL. This changes email presentation only and does not change the
mobile response contract.

## Mobile Screen Behavior

- Submit once and disable the submit control while awaiting the response.
- Display backend validation `message` values beside their relevant fields.
- On success, show a pending-review state; do not attempt owner login until the
  application is approved.
- Do not infer the store name from the owner name. Use the name supplied in the
  default `translations` entry.

## Security

- Never log the plaintext password or uploaded identity/tax documents.
- Validate image type and size client-side for usability, but treat backend
  validation as authoritative.
- Use HTTPS in production.
- Do not retry automatically after an ambiguous timeout because email/phone
  uniqueness may mean the first request already created the account.

## Backend Files

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/Auth/VendorLoginController.php`
- `app/Models/Vendor.php`
- `app/Models/Store.php`
- `app/Mail/VendorSelfRegistration.php`
- `app/Mail/StoreRegistration.php`
- `resources/views/email-templates/new-email-format-12.blade.php`
- `resources/views/admin-views/business-settings/email-format-setting/`
