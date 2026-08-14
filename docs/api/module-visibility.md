# Customer Home Module Visibility

## Endpoint

```http
GET /api/v1/module
```

This public endpoint supplies the customer application's home module grid. It
returns active modules available in any zone identified by the `zoneId` header.

## Authentication

No authentication is required.

## Headers

| Header | Required | Description |
|---|---|---|
| `Accept: application/json` | Recommended | Requests a JSON response. |
| `zoneId` | Optional | JSON-encoded zone ID or array of zone IDs, for example `[1]`. |

There are no request body fields and the endpoint is not paginated.

## Zone-aware visibility

When `zoneId` is supplied, a module is returned only when both conditions hold:

1. its `status` is active;
2. it is connected through `module_zone` to at least one supplied zone.

This rule includes `ride_hailing`. An active Ride Hailing module connected to
zone `1` is therefore included for `zoneId: [1]`; it is excluded when inactive
or disconnected from that zone. Existing connected commerce and parcel modules
continue to use the same rules.

Requests without the `zoneId` header retain the existing discovery behavior,
which excludes Ride Hailing.

## Response

The response is a JSON array. Each element is the existing module resource and
includes module identity, status, media URLs, translations/storage data, and
the calculated `items_count` and zone-filtered `stores_count`. Existing keys are
preserved for backward compatibility.

```json
[
  {
    "id": 7,
    "module_name": "Ride Hailing",
    "module_type": "ride_hailing",
    "status": "1",
    "items_count": 0,
    "stores_count": 0,
    "zones": [
      {
        "id": 1,
        "name": "Central Zone"
      }
    ]
  }
]
```

Ride Hailing is not a store/item commerce module, so its item and store counts
are expected to be zero.

## Errors

The endpoint has no feature-specific validation error envelope. Clients should
treat a non-2xx response as a failed refresh and retain/retry their last known
module state according to the app's normal networking policy. A valid request
with no matching modules returns an empty array:

```json
[]
```

## Mobile behavior

The customer app should render the returned modules in its location-specific
home grid. Selecting `module_type: ride_hailing` opens the Ride home flow; it
must not load commerce stores, items, or cart state for that module. The API is
the authority for zone and active-state visibility.

## Security and data constraints

- Zone membership and active status are enforced by the server query.
- The endpoint is read-only and public and returns no customer data.
- Clients must not infer Ride availability for a zone when Ride Hailing is
  absent from the response.
- Clients must not bypass the response by locally forcing hidden or inactive
  modules into the grid.

## Relevant backend files

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/ModuleController.php`
- `app/Models/Module.php`
- `app/Models/Zone.php`
- `tests/Feature/Api/V1/ModuleVisibilityTest.php`
