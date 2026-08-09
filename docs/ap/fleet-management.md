# Fleet Manager Mobile App API and Routing Specification

## 1. Purpose of this document

This is the implementation handoff for adding the fleet-manager experience to
the existing rider mobile application.

The Codex instance working inside the mobile project must:

1. inspect the mobile project before changing it;
2. reuse its existing API client, repository, state-management, navigation,
   dependency-injection, secure-storage, localization, and UI conventions;
3. keep the current rider experience unchanged;
4. use the shared delivery-man login;
5. route `account_type = fleet_manager` into a separate fleet-manager shell;
6. implement only the screens and API operations defined here;
7. add or update tests using the project's existing testing approach.

Do not create a second networking architecture or a second login system.
Treat the backend paths and response keys in this document as fixed. If the
mobile project has an older conflicting contract, migrate the mobile code to
this contract instead of inventing new server routes.

---

## 2. Confirmed product decisions

### Fleet manager responsibilities

A fleet manager can:

- see their assigned riders;
- see rider contact details and operational performance;
- see each rider's current payable balance;
- contact riders who have an outstanding payable balance;
- see commission earnings by completed order;
- see wallet totals;
- submit a withdrawal request;
- see withdrawal history and admin decisions;
- update permitted personal profile fields;
- receive push notifications.

### Fleet manager restrictions

A fleet manager cannot:

- assign, transfer, or unassign riders;
- change a rider wallet or payable balance;
- submit a rider payment;
- approve or verify a bank payment;
- mark a rider payment as recovered;
- change their commission percentage;
- change their assigned areas;
- change account status, capacity, contract type, shift, or leave status;
- approve their own withdrawal;
- view another fleet manager's riders, earnings, or withdrawals;
- access the normal rider operational home after a fleet-manager login.

Riders pay the company bank account directly. Only the existing verified
bank-payment workflow may reduce `DeliveryManWallet.collected_cash`.

### Not included in this implementation

Do not build these features from this document:

- manager/rider chat or inbox;
- complaints or ticketing;
- medical allowance or hospital vouchers;
- manager-side rider assignment;
- payment recovery submission;
- a new rider performance scoring algorithm;
- manager-side payout-method editing.

The rider detail API exposes basic operational performance values such as
rating and order counts. A new scored performance indicator would require a
separate confirmed backend contract.

### Business write operations

The minimal fleet-manager app has only two user-initiated business mutations:

1. `PUT /api/v1/fleet-manager/profile`
2. `POST /api/v1/fleet-manager/withdrawals`

There is also one technical device operation:

3. `PUT /api/v1/fleet-manager/fcm-token`

Login is naturally a `POST`, but it is an authentication operation rather than
a fleet-manager business action.

---

## 3. Important withdrawal-method prerequisite

`POST /api/v1/fleet-manager/withdrawals` requires a saved
`withdrawal_method_id` owned by the authenticated fleet manager.

For the minimal app:

- payout methods must be configured for the fleet manager by admin/back office;
- the app loads them with `GET /api/v1/fleet-manager/withdrawal-methods`;
- the app treats them as read-only;
- if no method exists, disable the withdrawal submission button and show:
  **"No payout method is configured. Please contact administration."**

The server currently also exposes withdrawal-method template and CRUD
endpoints. Do not build manager-facing add/edit/delete payout-method screens in
this minimal version.

If the business later wants managers to maintain their own bank details, treat
that as a separate feature with its own security review.

---

## 4. Required mobile navigation

### Shared authentication routing

```text
App launch
  |
  +-- No token
  |     `-- Existing delivery-man login
  |
  `-- Token exists
        `-- Restore saved account_type
              |
              +-- rider
              |     `-- Existing rider application
              |
              `-- fleet_manager
                    `-- Fleet Manager Shell
```

After a successful login:

```text
account_type = rider
    -> preserve the current rider route and behavior

account_type = fleet_manager
    -> clear any rider-only navigation stack
    -> open the Fleet Manager Dashboard
```

Do not infer the role from local state, phone number, or available screens.
Always use `account_type` returned by the login API and store it beside the
token.

### Fleet Manager Shell

Recommended primary navigation:

```text
Fleet Manager Shell
  |
  +-- Dashboard
  +-- Riders
  +-- Earnings
  +-- Wallet
  `-- Profile
```

The project may use tabs, a drawer, or its existing navigation pattern. Keep
these logical destinations even if the visual navigation differs.

### Required route names

Adapt route syntax to the mobile framework, but keep stable logical names:

```text
fleetManager.dashboard
fleetManager.riders
fleetManager.riderDetails
fleetManager.earnings
fleetManager.wallet
fleetManager.withdrawals
fleetManager.requestWithdrawal
fleetManager.profile
fleetManager.editProfile
```

All `fleetManager.*` routes require:

- a valid token; and
- saved `account_type == fleet_manager`.

A rider must never enter these routes through a deep link.

---

## 5. Required screens

### 5.1 Dashboard

Show:

- assigned rider count;
- active rider count;
- offline rider count;
- riders with payable balance;
- total rider payable balance;
- manager commission percentage;
- total earnings;
- available withdrawal balance;
- pending withdrawal amount;
- total withdrawn;
- shortcuts to Due Riders, Earnings, and Request Withdrawal.

Do not show shift, contract type, or primary area as operational controls.

### 5.2 Assigned Riders

Show a paginated list with:

- rider image;
- name;
- phone;
- area;
- active/offline state;
- current orders;
- rating;
- current payable balance;
- call/contact action;
- rider-detail action.

Required controls:

- search by rider name or phone;
- "Due only" filter;
- pagination/infinite scroll using the existing app pattern;
- pull-to-refresh if the project already uses it.

The payable balance is read-only.

### 5.3 Rider Details

Show:

- name and image;
- phone and email;
- area;
- vehicle;
- account and availability status;
- current orders;
- average rating and rating count;
- total orders;
- delivered orders;
- canceled orders;
- member-since date;
- current payable balance;
- call/contact action.

Do not add a "Recover Payment", "Paid", "Approve", or balance-edit button.

### 5.4 Earnings Report

Show:

- wallet summary;
- earnings total for the selected filter;
- reversed earnings total;
- eligible order count;
- paginated earning transactions.

Each transaction shows:

- date;
- order ID;
- rider name;
- delivery amount;
- admin commission pool;
- manager percentage snapshot;
- manager earned amount;
- `earned` or `reversed` status.

Filters:

- from date;
- to date;
- status: all, earned, reversed.

### 5.5 Wallet and Withdrawals

Show:

- total earnings;
- available balance;
- pending withdrawal;
- total withdrawn;
- read-only configured payout methods;
- withdrawal history;
- request-withdrawal action.

Withdrawal states:

- `pending`: waiting for admin review;
- `approved`: paid/accepted by admin;
- `rejected`: declined and amount released back to available balance.

Display `admin_note` when present, especially for rejected requests.

### 5.6 Request Withdrawal

Fields:

- payout method, selected from saved read-only methods;
- amount;
- optional note.

Rules:

- method is required;
- amount must be greater than zero;
- amount cannot exceed `wallet.available_balance`;
- disable repeated taps while submitting;
- after success, refresh wallet and withdrawal history;
- do not allow editing or canceling a submitted request.

### 5.7 Profile

Display:

- name;
- employee ID;
- phone;
- email;
- image if available;
- assigned areas;
- assigned rider count;
- manager commission percentage;
- account status;
- wallet summary.

Editable fields:

- first name;
- last name;
- phone;
- email;
- password.

Read-only/admin-controlled fields:

- employee ID;
- commission percentage;
- assigned areas;
- rider capacity;
- status;
- leave status;
- shift;
- joining date;
- contract type.

The mobile UI does not need to display shift, primary area, or contract type
unless the business later confirms a use for them.

### 5.8 Existing rider profile: assigned fleet manager

The normal rider application remains unchanged except for the rider profile or
support area, which must show the currently assigned fleet manager when one
exists.

Show:

- fleet-manager name;
- phone;
- email when available;
- assigned area when available;
- call/contact action.

If `fleet_manager` is null, show a neutral "No fleet manager assigned" state.
Do not block normal rider functionality.

---

## 6. API base, headers, and authentication

Use the mobile project's existing base URL and environment configuration.

All paths below are relative to:

```text
/api/v1
```

For fleet-manager endpoints, send the token using the same convention already
used by the delivery-man app. The backend accepts:

```http
Authorization: Bearer <token>
```

It also accepts a `token` header or `token` request field, but Bearer
authentication is preferred when compatible with the current API client.

Expected content type for JSON mutations:

```http
Accept: application/json
Content-Type: application/json
```

On HTTP `401`:

1. clear the saved token and account type;
2. clear fleet-manager state;
3. unsubscribe from fleet-manager push topics if supported;
4. return to the shared login route.

---

## 7. Required endpoint matrix

| Type | Method | Endpoint | Required mobile use |
|---|---|---|---|
| Auth | POST | `/auth/delivery-man/login` | Shared rider/fleet-manager login |
| Read | GET | `/delivery-man/profile` | Existing rider profile plus assigned manager |
| Read | GET | `/fleet-manager/profile` | Profile and role restoration |
| Write | PUT | `/fleet-manager/profile` | Update permitted profile fields |
| Read | GET | `/fleet-manager/dashboard` | Dashboard cards |
| Technical | PUT | `/fleet-manager/fcm-token` | Register current push token |
| Read | GET | `/fleet-manager/riders` | Assigned rider list |
| Read | GET | `/fleet-manager/riders/{id}` | Scoped rider details |
| Read | GET | `/fleet-manager/earnings` | Earnings report |
| Read | GET | `/fleet-manager/withdrawal-methods` | Read-only saved payout methods |
| Read | GET | `/fleet-manager/withdrawals` | Wallet and withdrawal history |
| Write | POST | `/fleet-manager/withdrawals` | Submit withdrawal request |

### Existing backend endpoints not used by this minimal mobile version

```text
GET    /fleet-manager/withdrawal-method-templates
POST   /fleet-manager/withdrawal-methods
PUT    /fleet-manager/withdrawal-methods/{id}
PUT    /fleet-manager/withdrawal-methods/{id}/default
DELETE /fleet-manager/withdrawal-methods/{id}
```

### Removed/forbidden payment endpoints

Do not call or recreate:

```text
GET  /fleet-manager/payment-collections
POST /fleet-manager/payment-collections
```

---

## 8. Shared login

```http
POST /api/v1/auth/delivery-man/login
```

Request:

```json
{
  "phone": "+923001234567",
  "password": "SecurePassword"
}
```

Fleet-manager success:

```json
{
  "token": "120-character-token",
  "account_type": "fleet_manager",
  "topic": "fleet_manager_42",
  "zone_topic": ""
}
```

Rider success:

```json
{
  "token": "120-character-token",
  "account_type": "rider",
  "topic": "delivery_man_1_2",
  "zone_topic": "zone_topic_push"
}
```

Implementation rules:

- extend the existing login response model with `account_type`;
- preserve all existing rider-login behavior;
- store `token`, `account_type`, `topic`, and `zone_topic`;
- subscribe to the returned `topic` using the app's existing notification
  integration;
- never show the role selector to the user;
- the server determines the account type from the credentials.

Common errors:

- `401`: invalid credentials, suspended manager, inactive manager, or manager
  currently marked on leave;
- `403`: invalid request fields.

---

## 9. Rider profile fleet-manager field

```http
GET /api/v1/delivery-man/profile
```

This is the existing rider profile endpoint. Preserve all existing fields and
parse these additional fields:

```json
{
  "account_type": "rider",
  "fleet_manager": {
    "id": 42,
    "name": "Ahmed Khan",
    "phone": "+923001234567",
    "email": "manager@example.com",
    "area": "North Zone",
    "shift_start": null,
    "shift_end": null
  }
}
```

`fleet_manager` may be null. Its `email`, `area`, `shift_start`, and
`shift_end` may also be null.

The rider UI only needs name, contact details, and area. Do not build shift
logic from `shift_start` or `shift_end`.

---

## 10. Fleet-manager profile

```http
GET /api/v1/fleet-manager/profile
```

Response:

```json
{
  "id": 42,
  "account_type": "fleet_manager",
  "employee_id": "FM-0042",
  "name": "Ahmed Khan",
  "f_name": "Ahmed",
  "l_name": "Khan",
  "phone": "+923001234567",
  "email": "manager@example.com",
  "image": null,
  "status": true,
  "on_leave": false,
  "rider_capacity": 100,
  "assigned_riders_count": 31,
  "shift_start": null,
  "shift_end": null,
  "joining_date": "2026-07-01",
  "contract_type": "contractor",
  "commission_percentage": 5,
  "wallet": {
    "total_earning": 12500,
    "total_withdrawn": 7000,
    "pending_withdraw": 1000,
    "available_balance": 4500
  },
  "primary_zone": {
    "id": 1,
    "name": "North Zone",
    "display_name": "North Zone"
  },
  "zones": [
    {
      "id": 1,
      "name": "North Zone",
      "display_name": "North Zone"
    }
  ]
}
```

Nullable fields:

- `employee_id`
- `email`
- `image`
- `shift_start`
- `shift_end`
- `joining_date`
- `primary_zone`

The mobile model may parse all fields, but the UI should follow the display
rules in section 5.7.

---

## 11. Update profile

```http
PUT /api/v1/fleet-manager/profile
```

Request:

```json
{
  "f_name": "Ahmed",
  "l_name": "Khan",
  "phone": "+923001234567",
  "email": "manager@example.com",
  "password": null
}
```

Rules:

- `f_name`: required, string, maximum 100;
- `l_name`: nullable, string, maximum 100;
- `phone`: required, unique across riders and fleet managers;
- `email`: nullable, valid and unique across riders and fleet managers;
- `password`: nullable; when provided it must contain uppercase, lowercase,
  number, and symbol characters and be at least eight characters.

Success:

```json
{
  "message": "Profile updated successfully."
}
```

After success, call `GET /fleet-manager/profile` and replace the locally cached
profile.

HTTP `422` uses the standard error envelope described in section 20.

---

## 12. Dashboard

```http
GET /api/v1/fleet-manager/dashboard
```

Response:

```json
{
  "assigned_riders": 31,
  "active_riders": 22,
  "offline_riders": 9,
  "riders_with_due": 7,
  "total_due": 18500.5,
  "commission_percentage": 5,
  "wallet": {
    "total_earning": 12500,
    "total_withdrawn": 7000,
    "pending_withdraw": 1000,
    "available_balance": 4500
  }
}
```

`total_due` is informational. It must never be submitted back as a payment or
used to mutate a rider wallet.

---

## 13. Assigned-rider list

```http
GET /api/v1/fleet-manager/riders?search=Ali&due_only=1&page=1
```

Query parameters:

| Parameter | Type | Required | Meaning |
|---|---|---:|---|
| `search` | string | No | Rider first name, last name, or phone |
| `due_only` | boolean/int | No | Use `1` to return riders with payable balance |
| `page` | integer | No | Pagination page |

The response is a standard Laravel paginator:

```json
{
  "current_page": 1,
  "data": [
    {
      "id": 81,
      "name": "Ali Raza",
      "phone": "+923111234567",
      "image_full_url": "https://example.com/storage/rider.png",
      "zone": "North Zone",
      "active": true,
      "status": true,
      "current_orders": 1,
      "rating": 4.7,
      "payable_balance": 2500
    }
  ],
  "first_page_url": "https://example.com/api/v1/fleet-manager/riders?page=1",
  "from": 1,
  "last_page": 3,
  "last_page_url": "https://example.com/api/v1/fleet-manager/riders?page=3",
  "links": [],
  "next_page_url": "https://example.com/api/v1/fleet-manager/riders?page=2",
  "path": "https://example.com/api/v1/fleet-manager/riders",
  "per_page": 25,
  "prev_page_url": null,
  "to": 25,
  "total": 61
}
```

Do not hard-code `per_page`. Use `next_page_url` or `current_page < last_page`
according to the app's pagination convention.

Security behavior:

- only riders currently assigned to the authenticated manager are returned;
- the mobile app must still handle `401` and empty lists;
- the mobile app must not attempt to supply a manager ID.

---

## 14. Assigned-rider details

```http
GET /api/v1/fleet-manager/riders/{rider_id}
```

Response:

```json
{
  "id": 81,
  "name": "Ali Raza",
  "f_name": "Ali",
  "l_name": "Raza",
  "phone": "+923111234567",
  "email": "ali@example.com",
  "image_full_url": "https://example.com/storage/rider.png",
  "zone": {
    "id": 1,
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
  "payable_balance": 2500
}
```

`email`, `zone`, `vehicle`, and vehicle subfields may be null.

HTTP `404` means the rider does not exist or is not assigned to the
authenticated manager. Show a generic unavailable-rider message and return to
the manager's rider list.

---

## 15. Commission earnings

```http
GET /api/v1/fleet-manager/earnings?from=2026-07-01&to=2026-07-31&status=earned&page=1
```

Query parameters:

| Parameter | Values | Required |
|---|---|---:|
| `from` | `YYYY-MM-DD` | No |
| `to` | `YYYY-MM-DD`, not before `from` | No |
| `status` | `earned`, `reversed` | No |
| `page` | positive integer | No |

Response:

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
    "last_page": 1,
    "total": 1
  }
}
```

Commission calculation:

```text
calculated manager amount = delivery amount x manager percentage / 100
credited manager amount = minimum(calculated manager amount, admin commission pool)
```

Commission eligibility:

- The customer-facing delivery charge must be greater than zero.
- The admin delivery-commission pool must be greater than zero.
- Admin-sponsored and vendor-sponsored free delivery do not create a fleet
  earning transaction, even though the rider can still receive delivery
  earnings from the preserved original delivery value.
- The existing rider/admin delivery percentage remains in effect for
  admin-sponsored free delivery; this fleet-manager exclusion does not change
  rider earnings.
- Mobile clients must not calculate fleet commission locally or treat the
  absence of a free-delivery order from this endpoint as a missing earning.
- This endpoint returns commission transactions, not a complete list of the
  assigned riders' completed deliveries.

Examples:

```text
Non-parcel:
delivery amount = 100
admin commission pool = 10
manager percentage = 5%
manager earns = 5
admin retains = 5

Parcel:
parcel delivery amount = 100
deliveryman commission setting = 90%
rider earns = 90
admin commission pool = 10
manager percentage = 5%
manager earns = 5
admin retains = 5
```

The manager percentage and financial values are snapshots. Later settings
changes do not rewrite old earning transactions.

`reversed` means the earning was reversed by the backend, normally because the
related order/refund flow reversed the commission.

---

## 16. Read-only withdrawal methods

```http
GET /api/v1/fleet-manager/withdrawal-methods
```

Response:

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

Critical distinction:

- `id` is the saved manager-owned method ID;
- `withdrawal_method_id` is the admin template ID;
- `POST /withdrawals` requires the saved manager-owned `id`.

The mobile app should:

- select the default method automatically;
- allow choosing another returned saved method;
- display fields as read-only;
- never log full banking fields;
- mask sensitive account values where practical;
- disable withdrawal submission when the array is empty.

---

## 17. Withdrawal history

```http
GET /api/v1/fleet-manager/withdrawals?status=pending&page=1
```

Query parameters:

| Parameter | Values | Required |
|---|---|---:|
| `status` | `pending`, `approved`, `rejected` | No |
| `page` | positive integer | No |

Response:

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
    "last_page": 1,
    "total": 1
  }
}
```

The payout details are historical snapshots. Do not replace old request details
with values from the current saved method.

---

## 18. Submit withdrawal request

```http
POST /api/v1/fleet-manager/withdrawals
```

Request:

```json
{
  "withdrawal_method_id": 22,
  "amount": 1000,
  "note": "July payout"
}
```

Remember: `withdrawal_method_id` here is the manager-owned saved method `id`
returned by `GET /fleet-manager/withdrawal-methods`.

Rules:

- amount must be greater than zero;
- amount cannot exceed `available_balance`;
- selected method must belong to the authenticated manager;
- selected template must still be active;
- note is nullable and has a maximum of 1,000 characters.

Success, HTTP `201`:

```json
{
  "message": "Withdrawal request submitted successfully.",
  "wallet": {
    "total_earning": 12500,
    "total_withdrawn": 7000,
    "pending_withdraw": 2000,
    "available_balance": 3500
  },
  "withdrawal": {
    "id": 72,
    "amount": 1000,
    "method_name": "Bank Transfer",
    "method_fields": {
      "account_name": "Ahmed Khan",
      "iban": "PK00EXAMPLE0001"
    },
    "manager_note": "July payout",
    "status": "pending",
    "admin_note": null,
    "requested_at": "2026-07-31T12:30:00+00:00",
    "reviewed_at": null
  }
}
```

Financial state behavior:

```text
Request submitted:
available_balance decreases
pending_withdraw increases

Admin approves:
pending_withdraw decreases
total_withdrawn increases

Admin rejects:
pending_withdraw decreases
available_balance becomes available again
```

The client must trust the wallet object returned by the server rather than
calculating and persisting its own authoritative balance.

---

## 19. Update FCM token

```http
PUT /api/v1/fleet-manager/fcm-token
```

Request:

```json
{
  "fcm_token": "device-fcm-token"
}
```

Success:

```json
{
  "message": "FCM token updated successfully."
}
```

Call this:

- after fleet-manager login;
- after device-token rotation;
- after restoring a session when the local FCM token changed.

Do not block the entire dashboard when FCM registration fails. Report/retry it
using the project's existing notification error policy.

---

## 20. Error contract

Validation and authentication errors normally use:

```json
{
  "errors": [
    {
      "code": "amount",
      "message": "The withdrawal amount exceeds the available balance."
    }
  ]
}
```

Required handling:

| HTTP status | Mobile behavior |
|---|---|
| `200`/`201` | Parse response and update state |
| `401` | Clear session and return to shared login |
| `404` | Show unavailable/not-found state without exposing other managers' data |
| `422` | Show field errors; preserve entered non-sensitive form values |
| `500` | Show retry state; do not duplicate a withdrawal automatically |

For withdrawal submission:

- prevent double taps;
- do not automatically retry a timed-out POST;
- if the result is uncertain, refresh withdrawal history before allowing
  another submission.

---

## 21. Mobile models

Use the project's naming and serialization conventions. The implementation
needs logical equivalents of:

```text
AuthResponse
  token
  accountType
  topic
  zoneTopic

FleetManagerProfile
FleetManagerDashboard
ManagedRiderSummary
ManagedRiderDetails
FleetManagerWallet
FleetManagerEarning
SavedWithdrawalMethod
FleetManagerWithdrawal
PaginatedResponse<T>
ApiError
```

All money fields must be parsed as decimal/numeric values and formatted with
the application's configured currency formatter. Do not concatenate a
hard-coded currency symbol.

All nullable API values must remain nullable in the mobile model.

---

## 22. Suggested mobile file placement

The next Codex must first inspect the project and map these responsibilities to
the existing architecture. Do not blindly create these exact directories if
the application uses different conventions.

Logical placement:

```text
authentication/
  extend login response with account_type
  add role-aware post-login routing

fleet_manager/
  data/
    fleet_manager_api
    fleet_manager_repository
    models/
  state/
    dashboard state
    riders state
    earnings state
    withdrawals state
    profile state
  presentation/
    dashboard
    riders list
    rider details
    earnings report
    wallet/withdrawals
    request withdrawal
    profile/edit profile

routing/
  fleet-manager shell
  fleet-manager route guard

notifications/
  fleet-manager topic subscription
  FCM token synchronization
```

Reuse:

- the existing HTTP client and interceptors;
- existing secure token storage;
- existing error parsing;
- existing pagination utilities;
- existing loading/empty/error widgets;
- existing currency/date formatting;
- existing phone/call launcher;
- existing FCM integration;
- existing dependency-injection and state-management approach.

---

## 23. State and refresh rules

### On successful fleet-manager login

1. save token and `account_type`;
2. subscribe to returned topic;
3. update FCM token;
4. load profile;
5. load dashboard;
6. route to Fleet Manager Dashboard.

### On dashboard refresh

Refresh:

- dashboard;
- optionally profile if the project already refreshes identity data.

### On withdrawal success

Refresh:

- withdrawal history;
- dashboard wallet;
- profile wallet if profile state caches it;
- earnings summary if it displays the wallet.

### On profile update success

Refresh profile and any header/drawer identity widgets.

### On logout or HTTP 401

Clear:

- token;
- account type;
- fleet-manager profile;
- dashboard;
- riders and rider details;
- earnings;
- saved methods;
- withdrawals.

Do not leave fleet-manager data visible when the next user logs in as a rider.

---

## 24. Security and privacy requirements

- Store the token only in the project's secure-storage mechanism.
- Never log passwords, tokens, full withdrawal fields, or banking details.
- Mask sensitive payout details in UI where practical.
- Never cache another manager's rider details across accounts.
- Do not send manager ID or rider assignment changes from the mobile client.
- Do not implement a wallet-balance update endpoint.
- Do not implement payment collection/recovery submission.
- Validate route access locally, but treat backend authorization as final.
- Do not interpret `payable_balance` as money held by the manager.

---

## 25. Empty, loading, and failure states

Required empty states:

- no assigned riders;
- no due riders;
- no earnings in selected date range;
- no withdrawal history;
- no configured payout method.

Required retry states:

- dashboard load failure;
- rider list/detail load failure;
- earnings load failure;
- withdrawal history load failure;
- profile load failure.

For paginated screens, a next-page failure must not remove already loaded
records.

---

## 26. Acceptance checklist

### Authentication and routing

- Rider login still opens the unchanged rider application.
- Fleet-manager login opens the fleet-manager dashboard.
- Saved sessions restore the correct shell from `account_type`.
- Rider deep links cannot open fleet-manager routes.
- HTTP `401` clears the session and returns to login.
- Rider profile shows the assigned manager and handles a null assignment.

### Dashboard

- All rider, due, commission, and wallet totals render correctly.
- Dashboard shortcuts open the correct screens.
- No rider payment mutation exists.

### Riders

- Search, due-only filter, refresh, and pagination work together.
- A manager cannot open an unassigned rider.
- Rider contact action works.
- Payable balance is visible and read-only.
- No recover/paid/approve button is present.

### Earnings

- Date and status filters work.
- Pagination preserves filters.
- Earned and reversed states are visually distinct.
- Parcel and non-parcel earning rows use server-returned values.
- The client does not recalculate authoritative commission.

### Withdrawals

- Saved payout methods load read-only.
- Empty payout method disables request submission.
- Amount above available balance is blocked locally and handled from HTTP `422`.
- Double submission is blocked.
- Successful request refreshes wallet/history.
- Pending, approved, and rejected states render correctly.
- Admin rejection notes are visible.

### Profile

- Only permitted fields are editable.
- Admin-controlled fields cannot be submitted.
- Password can be left empty.
- Updated identity appears throughout the fleet-manager shell.

### Quality

- Existing rider tests continue to pass.
- New parsing, role routing, repository, and state tests are added using current
  project conventions.
- No duplicate API client, router, theme, or state-management system is added.
- Static analysis/lint/build/tests pass.

---

## 27. Backend source-of-truth files

Use these only to verify the contract if the backend project is also available:

```text
routes/api/v1/api.php
app/Http/Controllers/Api/V1/Auth/DeliveryManLoginController.php
app/Http/Controllers/Api/V1/FleetManagerController.php
app/Http/Middleware/FleetManagerTokenIsValid.php
app/Services/FleetManagerFinanceService.php
app/Models/FleetManager.php
app/Models/FleetManagerWallet.php
app/Models/FleetManagerEarningTransaction.php
app/Models/FleetManagerWithdrawalMethod.php
app/Models/FleetManagerWithdrawalRequest.php
app/Models/DeliveryMan.php
app/Models/DeliveryManWallet.php
```

The API routes and controllers are the final backend source of truth. If the
mobile project contains an older API document or older payment-recovery
screens, this document replaces them.
