# Fleet Management Mobile API

## Purpose

This API allows one rider application to support two account experiences:

- **Rider:** existing rider functionality plus information about the assigned
  fleet manager.
- **Fleet manager:** dashboard, assigned-rider list, rider details, cash-due
  follow-up, payment-recovery submission, commission earnings, payout methods,
  and withdrawal requests.

Ticketing, direct chat, rider performance scoring, medical benefits, and
medical allowances are not part of this API version.

## Mobile screen flow

```text
Shared login
   |
   +-- account_type = rider
   |      `-- Existing rider home
   |          `-- Profile shows assigned fleet manager
   |
   `-- account_type = fleet_manager
          `-- Fleet dashboard
              +-- Assigned riders
              |    `-- Rider details
              |         `-- Submit payment recovery
              +-- Payment-recovery history
              +-- Commission earnings
              `-- Wallet and withdrawals
                   +-- Payout methods
                   `-- Withdrawal history/status
```

The mobile app should persist both the token and `account_type`. Never infer
the role from the presence of a particular response field.

## Authentication

Fleet managers use the existing delivery-man login endpoint. All subsequent
fleet-manager requests require the returned token.

Recommended header:

```http
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

An inactive or unavailable fleet manager receives HTTP `401`.

---

## 1. Shared rider/fleet-manager login

```http
POST /api/v1/auth/delivery-man/login
```

Authentication: none.

### JSON request

| Field | Type | Required | Description |
|---|---|---:|---|
| `phone` | string | Yes | Rider or fleet-manager phone number |
| `password` | string | Yes | Minimum six characters for the existing login contract |

```json
{
  "phone": "+923001234567",
  "password": "ExamplePassword!1"
}
```

### Fleet-manager success — HTTP 200

```json
{
  "token": "120-character-token",
  "account_type": "fleet_manager",
  "topic": "fleet_manager_17",
  "zone_topic": ""
}
```

### Rider success — HTTP 200

```json
{
  "token": "120-character-token",
  "account_type": "rider",
  "topic": "delivery_man_4_2",
  "zone_topic": "delivery_man_zone_topic_push"
}
```

### Mobile behavior

1. Save `token` securely.
2. Save `account_type`.
3. Subscribe to `topic` when push messaging is enabled.
4. Route `rider` to the existing app.
5. Route `fleet_manager` to the fleet dashboard.
6. Unknown account types must show an upgrade-required error rather than
   opening a privileged screen.

### Common errors

- `401`: incorrect credentials.
- `401`: account suspended, unavailable, or awaiting approval.
- `403`: missing/invalid request fields.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Controller:
  `app/Http/Controllers/Api/V1/Auth/DeliveryManLoginController.php`
- Models: `app/Models/DeliveryMan.php`, `app/Models/FleetManager.php`

---

## 2. Rider profile: assigned fleet manager

```http
GET /api/v1/delivery-man/profile
```

Authentication: rider token through `dm.api`.

This is an existing endpoint. The fleet feature adds:

```json
{
  "account_type": "rider",
  "fleet_manager": {
    "id": 17,
    "name": "Ahmed Khan",
    "phone": "+923001234567",
    "email": "manager@example.com",
    "area": "North Zone",
    "shift_start": "09:00:00",
    "shift_end": "18:00:00"
  }
}
```

`fleet_manager` is `null` when the rider is unassigned.

### Mobile behavior

- Add a “My Fleet Manager” section to the rider profile.
- Hide the section or show “Not assigned” when the value is `null`.
- Do not treat phone/email as always present.
- Ticket/chat actions should remain hidden until their APIs are introduced.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Controller: `app/Http/Controllers/Api/V1/DeliverymanController.php`
- Relationship: `DeliveryMan::fleetManager()`

---

## 3. Fleet-manager profile

```http
GET /api/v1/fleet-manager/profile
```

Authentication: fleet-manager token.

### Success — HTTP 200

```json
{
  "id": 17,
  "account_type": "fleet_manager",
  "employee_id": "FM-0017",
  "name": "Ahmed Khan",
  "f_name": "Ahmed",
  "l_name": "Khan",
  "phone": "+923001234567",
  "email": "manager@example.com",
  "image": null,
  "status": true,
  "on_leave": false,
  "rider_capacity": 50,
  "assigned_riders_count": 31,
  "shift_start": "09:00:00",
  "shift_end": "18:00:00",
  "joining_date": "2026-07-30",
  "contract_type": "employee",
  "commission_percentage": 5,
  "wallet": {
    "total_earning": 12500,
    "total_withdrawn": 7000,
    "pending_withdraw": 1000,
    "available_balance": 4500
  },
  "primary_zone": {
    "id": 4,
    "name": "North Zone",
    "display_name": "North Zone"
  },
  "zones": [
    {
      "id": 4,
      "name": "North Zone",
      "display_name": "North Zone"
    }
  ]
}
```

### Nullable fields

`employee_id`, `l_name`, `email`, `image`, `shift_start`, `shift_end`,
`joining_date`, and `primary_zone` may be `null`.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Middleware: `app/Http/Middleware/FleetManagerTokenIsValid.php`
- Controller: `app/Http/Controllers/Api/V1/FleetManagerController.php`
- Model: `app/Models/FleetManager.php`

---

## 4. Fleet-manager dashboard

```http
GET /api/v1/fleet-manager/dashboard
```

Authentication: fleet-manager token.

### Success — HTTP 200

```json
{
  "assigned_riders": 31,
  "active_riders": 22,
  "offline_riders": 9,
  "riders_with_due": 7,
  "total_due": 18500.5,
  "total_pending_collection_amount": 3000,
  "total_collectable_balance": 15500.5,
  "pending_collections": 3,
  "commission_percentage": 5,
  "wallet": {
    "total_earning": 12500,
    "total_withdrawn": 7000,
    "pending_withdraw": 1000,
    "available_balance": 4500
  }
}
```

### Field meanings

| Field | Meaning |
|---|---|
| `assigned_riders` | Current riders assigned to this manager |
| `active_riders` | Assigned riders currently marked active |
| `offline_riders` | Assigned riders currently marked inactive/offline |
| `riders_with_due` | Assigned riders whose `collected_cash` is greater than zero |
| `total_due` | Total rider cash payable to the business |
| `total_pending_collection_amount` | Current rider due already submitted and waiting for admin approval |
| `total_collectable_balance` | Additional amount that can currently be recovered |
| `pending_collections` | Submitted recoveries awaiting admin reconciliation |
| `commission_percentage` | Current rate for future eligible order earnings |
| `wallet` | Lifetime earnings and withdrawal balance summary |

All monetary values are JSON numbers in the server’s configured currency.
Format them using the app’s normal currency formatter.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Controller: `FleetManagerController::dashboard`
- Due source: `DeliveryManWallet.collected_cash`

---

## 5. Update fleet-manager FCM token

```http
PUT /api/v1/fleet-manager/fcm-token
```

Authentication: fleet-manager token.

### JSON request

| Field | Type | Required |
|---|---|---:|
| `fcm_token` | string | Yes |

```json
{
  "fcm_token": "firebase-device-token"
}
```

### Success — HTTP 200

```json
{
  "message": "FCM token updated successfully."
}
```

Call after login, token refresh, or notification-permission changes.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Controller: `FleetManagerController::updateFcmToken`
- Storage: `fleet_managers.fcm_token`

---

## 6. Assigned-rider list

```http
GET /api/v1/fleet-manager/riders
```

Authentication: fleet-manager token.

### Query parameters

| Parameter | Type | Required | Description |
|---|---|---:|---|
| `search` | string | No | Search by rider first name, last name, or phone |
| `due_only` | boolean/int | No | Use `1` to return only riders with payment due |
| `page` | integer | No | Pagination page |

Example:

```http
GET /api/v1/fleet-manager/riders?due_only=1&search=Ali&page=1
```

### Success data item

```json
{
  "id": 81,
  "name": "Ali Raza",
  "phone": "+923111234567",
  "image_full_url": "https://YOUR-DOMAIN.example/storage/rider.png",
  "zone": "North Zone",
  "active": true,
  "status": true,
  "current_orders": 1,
  "rating": 4.7,
  "payable_balance": 2500,
  "pending_collection_amount": 1000,
  "collectable_balance": 1500
}
```

### Payment-field meanings

- `payable_balance`: current total cash due from the rider.
- `pending_collection_amount`: already submitted for admin approval.
- `collectable_balance`: maximum additional amount that can currently be
  submitted.

The payment form must use `collectable_balance` as its maximum, not
`payable_balance`.

Use `GET /riders?due_only=1` as the recovery work queue. This returns every
assigned rider who still has an unpaid balance, including riders who do not
yet have a recovery-history record. Show the payable amount and a phone/contact
action on each row.

### Security

The backend only returns riders currently assigned to the authenticated fleet
manager. A manager cannot query another manager’s rider by changing parameters.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Controller: `FleetManagerController::riders`
- Models: `FleetManager`, `DeliveryMan`, `DeliveryManWallet`,
  `FleetPaymentCollection`

---

## 7. Assigned-rider details

```http
GET /api/v1/fleet-manager/riders/{rider_id}
```

Authentication: fleet-manager token.

Example:

```http
GET /api/v1/fleet-manager/riders/81
```

### Success — HTTP 200

```json
{
  "id": 81,
  "name": "Ali Raza",
  "f_name": "Ali",
  "l_name": "Raza",
  "phone": "+923111234567",
  "email": "rider@example.com",
  "image_full_url": "https://YOUR-DOMAIN.example/storage/rider.png",
  "zone": {
    "id": 4,
    "name": "North Zone"
  },
  "vehicle": {
    "id": 2,
    "type": "motorbike"
  },
  "active": true,
  "status": true,
  "available": true,
  "current_orders": 1,
  "rating": 4.7,
  "rating_count": 126,
  "orders_count": 640,
  "delivered_orders_count": 621,
  "canceled_orders_count": 12,
  "member_since": "2025-03-15",
  "payable_balance": 2500,
  "pending_collection_amount": 1000,
  "collectable_balance": 1500
}
```

`email`, `zone`, and `vehicle` may be `null`. Vehicle subfields may also be
`null`.

### Errors

- `404`: rider does not exist or is not assigned to this manager.
- `401`: invalid/inactive fleet-manager token.

Use the same UI message for an unavailable rider; do not reveal whether the
rider belongs to another manager.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Controller: `FleetManagerController::rider`

---

## 8. Payment-recovery history

```http
GET /api/v1/fleet-manager/payment-collections
```

Authentication: fleet-manager token.

### Query parameters

| Parameter | Values | Required |
|---|---|---:|
| `status` | `pending`, `approved`, `rejected` | No |
| `page` | positive integer | No |

### Success data item

```json
{
  "id": 402,
  "rider": {
    "id": 81,
    "name": "Ali Raza",
    "phone": "+923111234567"
  },
  "amount": 1000,
  "due_before": 2500,
  "due_after": 1500,
  "payable_balance": 1500,
  "pending_collection_amount": 0,
  "collectable_balance": 1500,
  "payment_method": "cash",
  "reference": "RCPT-8291",
  "note": "Collected at North hub",
  "proof_uploaded": true,
  "status": "approved",
  "submitted_at": "2026-07-30T10:30:00+00:00",
  "reviewed_at": "2026-07-30T11:15:00+00:00",
  "rejection_reason": null
}
```

### Status behavior

| Status | Meaning |
|---|---|
| `pending` | Submitted but rider wallet due has not changed |
| `approved` | Admin approved; rider `collected_cash` was reduced and ledgered |
| `rejected` | Admin rejected; rider due was not reduced |

`due_after` and `reviewed_at` are `null` while pending.
`rejection_reason` is normally populated only for rejected records.

The three current-balance fields are live values and can differ from the
historical `due_before` and `due_after` values:

- `payable_balance`: the rider's current total unpaid balance.
- `pending_collection_amount`: current recovery submissions awaiting admin
  approval for that rider.
- `collectable_balance`: maximum additional recovery that can be submitted.

Show `payable_balance` beside the rider's name and phone. When it is
greater than zero, keep the phone action available so the fleet manager can
contact the rider about the unpaid balance.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Controller: `FleetManagerController::collections`
- Model: `app/Models/FleetPaymentCollection.php`

---

## 9. Submit rider payment recovery

```http
POST /api/v1/fleet-manager/payment-collections
```

Authentication: fleet-manager token.

Content type: `multipart/form-data`.

### Multipart fields

| Field | Type | Required | Rules |
|---|---|---:|---|
| `delivery_man_id` | integer | Yes | Must be assigned to authenticated manager |
| `amount` | decimal | Yes | Minimum `0.01`; cannot exceed `collectable_balance` |
| `payment_method` | string | Yes | `cash`, `bank_transfer`, `mobile_wallet`, or `other` |
| `reference` | string | No | Maximum 191 characters |
| `note` | string | No | Maximum 1,000 characters |
| `proof_file` | image | No | JPG, JPEG, PNG, or WEBP; maximum 5 MB |

### Example logical request

```text
delivery_man_id: 81
amount: 1000.00
payment_method: cash
reference: RCPT-8291
note: Collected at North hub
proof_file: receipt.jpg
```

### Success — HTTP 201

```json
{
  "message": "Payment collection submitted for admin reconciliation.",
  "collection": {
    "id": 402,
    "rider": {
      "id": 81,
      "name": "Ali Raza",
      "phone": "+923111234567"
    },
    "amount": 1000,
    "due_before": 2500,
    "due_after": null,
    "payable_balance": 2500,
    "pending_collection_amount": 1000,
    "collectable_balance": 1500,
    "payment_method": "cash",
    "reference": "RCPT-8291",
    "note": "Collected at North hub",
    "proof_uploaded": true,
    "status": "pending",
    "submitted_at": "2026-07-30T10:30:00+00:00",
    "reviewed_at": null,
    "rejection_reason": null
  }
}
```

### Important financial behavior

- Submission does not reduce the rider’s due.
- Pending amounts reserve part of the due and reduce `collectable_balance`.
- Admin approval performs the actual wallet reconciliation.
- Approval creates an immutable `fleet_payment_recovery` wallet-ledger row.
- If the due changes before approval and becomes too low, approval is blocked.
- Proof images are stored privately and are downloadable only from the
  authenticated admin panel.

### Common errors

- `401`: invalid/inactive manager.
- `404`: rider is not assigned to the manager.
- `422`: invalid fields, unsupported payment method/file, or amount exceeds
  the unreserved due.

Example:

```json
{
  "errors": [
    {
      "code": "amount",
      "message": "Collection amount exceeds the rider’s unreserved payable balance."
    }
  ]
}
```

### Mobile behavior

1. Load rider details immediately before opening the form.
2. Disable submission when `collectable_balance <= 0`.
3. Restrict amount to `collectable_balance`.
4. Prevent double taps while the request is running.
5. On HTTP `201`, show “Pending admin approval,” not “Payment completed.”
6. Refresh rider details and collection history.
7. Show the rejection reason when a record becomes rejected.
8. Keep the rider phone action visible while `payable_balance > 0` so the fleet
   manager can contact the rider about the outstanding payment.

### Backend implementation

- Route: `routes/api/v1/api.php`
- Token middleware: `app/Http/Middleware/FleetManagerTokenIsValid.php`
- Controller: `FleetManagerController::submitCollection`
- Business logic: `app/Services/FleetManagementService.php`
- Models: `FleetPaymentCollection`, `DeliveryManWallet`,
  `DeliveryManWalletLedger`
- Admin review:
  `app/Http/Controllers/Admin/DeliveryMan/FleetManagerController.php`

---

## 10. Update fleet-manager profile

```http
PUT /api/v1/fleet-manager/profile
```

Authentication: fleet-manager token. Content type: `application/json`.

```json
{
  "f_name": "Ahmed",
  "l_name": "Khan",
  "phone": "+923001234567",
  "email": "manager@example.com",
  "password": null
}
```

`f_name` and `phone` are required. `l_name`, `email`, and `password` are
nullable. A supplied password must have at least eight characters and contain
uppercase, lowercase, number, and symbol characters. The manager cannot update
commission, areas, capacity, status, shift, contract type, or rider
assignments; those remain admin-controlled.

Success is HTTP `200` with `{"message":"Profile updated successfully."}`.
Duplicate rider/manager phone or email values return HTTP `422`.

---

## 11. Commission earnings

```http
GET /api/v1/fleet-manager/earnings?from=2026-07-01&to=2026-07-31&status=earned&page=1
```

Authentication: fleet-manager token. `from`, `to`, `status`, and `page` are
optional. `status` accepts `earned` or `reversed`.

```json
{
  "summary": {
    "earned": 500,
    "reversed": 0,
    "orders": 100,
    "wallet": {
      "total_earning": 12500,
      "total_withdrawn": 7000,
      "pending_withdraw": 1000,
      "available_balance": 4500
    }
  },
  "earnings": {
    "current_page": 1,
    "data": [
      {
        "id": 901,
        "order_id": 45001,
        "rider": {
          "id": 81,
          "name": "Ali Raza",
          "phone": "+923111234567"
        },
        "delivery_amount": 100,
        "admin_commission_amount": 10,
        "commission_percentage": 5,
        "amount": 5,
        "status": "earned",
        "created_at": "2026-07-31T10:30:00+00:00",
        "reversed_at": null
      }
    ],
    "total": 1
  }
}
```

The calculation is:

```text
calculated amount = delivery amount × manager percentage / 100
credited amount = minimum(calculated amount, admin commission amount)
```

For delivery value `100`, admin commission pool `10`, and manager rate `5%`,
the manager earns `5`. The percentage and values are snapshotted, so later
settings changes do not rewrite history. One order can create only one earning.
A full delivery-charge reversal marks the earning `reversed` and removes it
from the wallet.

---

## 12. Available withdrawal-method templates

```http
GET /api/v1/fleet-manager/withdrawal-method-templates
```

```json
[
  {
    "id": 3,
    "method_name": "Bank Transfer",
    "method_fields": [
      {
        "input_type": "string",
        "input_name": "account_name",
        "placeholder": "Account name",
        "is_required": 1
      },
      {
        "input_type": "string",
        "input_name": "iban",
        "placeholder": "IBAN",
        "is_required": 1
      }
    ],
    "is_default": 1
  }
]
```

Render these fields dynamically; do not hard-code bank field names.

---

## 13. Saved withdrawal methods

```http
GET /api/v1/fleet-manager/withdrawal-methods
```

```json
[
  {
    "id": 22,
    "withdrawal_method_id": 3,
    "method_name": "Bank Transfer",
    "fields": {
      "account_name": "Ahmed Khan",
      "iban": "PK00EXAMPLE0001"
    },
    "is_default": true
  }
]
```

Only methods owned by the authenticated manager are returned.

---

## 14. Create or update a saved withdrawal method

Create:

```http
POST /api/v1/fleet-manager/withdrawal-methods
```

Update:

```http
PUT /api/v1/fleet-manager/withdrawal-methods/{saved_method_id}
```

```json
{
  "withdrawal_method_id": 3,
  "fields": {
    "account_name": "Ahmed Khan",
    "iban": "PK00EXAMPLE0001"
  },
  "is_default": true
}
```

The backend validates `fields` against the admin template. Missing required
fields, invalid types, inactive templates, and records owned by another
manager are rejected. Create returns HTTP `201`; update returns `200`.

---

## 15. Set default or delete a withdrawal method

```http
PUT /api/v1/fleet-manager/withdrawal-methods/{saved_method_id}/default
DELETE /api/v1/fleet-manager/withdrawal-methods/{saved_method_id}
```

Both are ownership-scoped. Setting a default clears the previous default.
Deleting the default promotes the latest remaining method. Existing withdrawal
requests keep a snapshot of their payout details.

---

## 16. Withdrawal history

```http
GET /api/v1/fleet-manager/withdrawals?status=pending&page=1
```

`status` is optional: `pending`, `approved`, or `rejected`.

```json
{
  "wallet": {
    "total_earning": 12500,
    "total_withdrawn": 7000,
    "pending_withdraw": 1000,
    "available_balance": 4500
  },
  "withdrawals": {
    "current_page": 1,
    "data": [
      {
        "id": 71,
        "amount": 1000,
        "method_name": "Bank Transfer",
        "method_fields": {
          "account_name": "Ahmed Khan",
          "iban": "PK00EXAMPLE0001"
        },
        "manager_note": "July payout",
        "status": "pending",
        "admin_note": null,
        "requested_at": "2026-07-31T12:00:00+00:00",
        "reviewed_at": null
      }
    ],
    "total": 1
  }
}
```

Show `admin_note` for rejected requests and refresh after admin decisions.

---

## 17. Submit withdrawal request

```http
POST /api/v1/fleet-manager/withdrawals
```

```json
{
  "withdrawal_method_id": 22,
  "amount": 1000,
  "note": "July payout"
}
```

`withdrawal_method_id` is the manager-owned saved method ID, not the admin
template ID. Success is HTTP `201` and returns `message`, updated `wallet`, and
the created `withdrawal`.

- Requesting immediately moves the amount from available to pending.
- Approval moves it from pending to `total_withdrawn`.
- Rejection releases it back to available.
- Amounts above `available_balance` return HTTP `422`.
- A request cannot be reviewed twice.

Mobile should prevent double submission, show all three states, display admin
notes, and refresh the wallet/history after each request or status change.

### Finance backend files

- `app/Services/FleetManagerFinanceService.php`
- `app/Models/FleetManagerWallet.php`
- `app/Models/FleetManagerEarningTransaction.php`
- `app/Models/FleetManagerWithdrawalMethod.php`
- `app/Models/FleetManagerWithdrawalRequest.php`
- `database/migrations/2026_07_31_000002_add_fleet_manager_finance_tables.php`
- `database/migrations/2026_07_31_000003_add_fleet_manager_commission_to_order_transactions.php`

The `order_transactions.fleet_manager_commission` column is the reconciliation
amount used by admin reports. `admin_commission` remains the original gross
commission for refunds and audits; report totals subtract the fleet-manager
share to display the admin's net earnings.

---

## Suggested mobile files

Names can be adapted to the app’s architecture, but keep responsibilities
separate:

```text
features/fleet_management/
├── data/
│   ├── fleet_manager_api_client
│   ├── fleet_manager_repository
│   └── models/
│       ├── fleet_manager_profile
│       ├── fleet_dashboard
│       ├── managed_rider
│       ├── managed_rider_details
│       ├── payment_collection
│       └── paginated_response
├── domain/
│   └── fleet_manager_service
└── presentation/
    ├── fleet_dashboard_screen
    ├── assigned_riders_screen
    ├── rider_details_screen
    ├── submit_payment_recovery_screen
    └── payment_recovery_history_screen
```

Add mobile models for `fleet_manager_earning`, `fleet_manager_wallet`,
`withdrawal_method`, and `withdrawal_request`, plus screens for commission
history, payout-method management, and withdrawal history/status.

Existing authentication should add `account_type` to its login model and route
guard. Existing rider profile should add a nullable `fleet_manager` model.

## Mobile acceptance checklist

- Rider login still reaches the existing rider home.
- Fleet-manager login reaches the fleet dashboard.
- Invalid or inactive tokens return to login.
- Manager cannot open an unassigned rider by manually changing the ID.
- Rider profile handles a `null` fleet manager.
- Rider search, due filter, and pagination work together.
- Money is parsed as decimal/numeric data and formatted using configured
  currency.
- Collection amount cannot exceed `collectable_balance`.
- Multipart proof upload works on Android and iOS.
- Double submission is blocked in the UI.
- Pending, approved, and rejected states have distinct labels.
- Rejection reasons are displayed.
- FCM token is refreshed after login and device-token rotation.
- Manager can update only self-service profile fields.
- Commission history displays snapshotted rates and reversal state.
- Withdrawal methods render from active backend templates.
- Withdrawal requests cannot exceed `available_balance`.
- Pending, approved, and rejected withdrawal states refresh correctly.

## Server files for the complete feature

```text
routes/api/v1/api.php
bootstrap/app.php
app/Http/Middleware/FleetManagerTokenIsValid.php
app/Http/Controllers/Api/V1/Auth/DeliveryManLoginController.php
app/Http/Controllers/Api/V1/DeliverymanController.php
app/Http/Controllers/Api/V1/FleetManagerController.php
app/Http/Controllers/Admin/DeliveryMan/FleetManagerController.php
app/Services/FleetManagementService.php
app/Services/FleetManagerFinanceService.php
app/Models/FleetManager.php
app/Models/FleetManagerWallet.php
app/Models/FleetManagerEarningTransaction.php
app/Models/FleetManagerWithdrawalMethod.php
app/Models/FleetManagerWithdrawalRequest.php
app/Models/FleetManagerRiderAssignment.php
app/Models/FleetPaymentCollection.php
app/Models/DeliveryMan.php
app/Models/DeliveryManWallet.php
app/Models/DeliveryManWalletLedger.php
database/migrations/2026_07_30_000001_create_fleet_management_tables.php
database/migrations/2026_07_31_000002_add_fleet_manager_finance_tables.php
database/migrations/2026_07_31_000003_add_fleet_manager_commission_to_order_transactions.php
```
