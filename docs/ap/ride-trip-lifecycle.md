# Ride Trip Lifecycle API

Backend status: Captain arrival, Trip PIN, waiting, active location, completion,
pre-start cancellation, and status notifications are implemented. Payment and
wallet behavior is defined in `ride-payments-and-settlement.md`.

This specification follows `ride-booking-and-bidding.md`. Payment collection,
wallet posting and post-completion settlement are implemented separately in
`ride-payments-and-settlement.md`; Ride chat is defined in `ride-chat.md`.

## Authentication And Headers

Base URL:

```text
https://YOUR-DOMAIN.example/api/v1
```

Customer routes require Passport authentication. Captain routes use `dm.api`.
Bearer transport is preferred for both:

```http
Authorization: Bearer TOKEN
Accept: application/json
Content-Type: application/json
```

Captain endpoints retain compatibility with a `token` body/query/header field.
Never send customer, Captain, or vehicle IDs to establish ownership.

## Lifecycle

```text
rider_selected
  -> captain_arriving
  -> arrived
  -> in_progress
  -> completed
```

Captain actions must occur in exactly that order:

| Current status | `action` | Result |
|---|---|---|
| `rider_selected` | `start_pickup` | `captain_arriving` |
| `captain_arriving` | `arrived` | `arrived` and server waiting clock starts |
| `arrived` | `start_trip` | Trip PIN is verified, waiting is snapshotted, status becomes `in_progress` |
| `in_progress` | `complete` | `completed` |

Every transition is transactionally locked and written to
`ride_status_histories`. Repeated, skipped, or out-of-order actions are rejected.

## Customer Contract

The existing endpoints return the expanded lifecycle fields:

```http
GET /ride-hailing/customer/rides/{ride_id}
GET /ride-hailing/customer/rides
```

Relevant ride response fields:

```json
{
  "id": 42,
  "status": "arrived",
  "final_accepted_fare": 310,
  "trip_pin": "4821",
  "free_waiting_minutes": 3,
  "charged_waiting_minutes": 0,
  "waiting_charge_amount": 0,
  "cancellation_charge_amount": 0,
  "captain_location": {
    "latitude": 31.4504,
    "longitude": 73.135,
    "updated_at": "2026-08-09T14:21:11+05:00"
  },
  "captain_arriving_at": "2026-08-09T14:15:00+05:00",
  "arrived_at": "2026-08-09T14:20:00+05:00",
  "trip_started_at": null,
  "completed_at": null,
  "cancelled_at": null
}
```

`trip_pin` is returned only to the owning customer and only before the trip
starts. It is encrypted at rest. Never show it to the Captain before the
customer voluntarily shares it.

### Customer Cancellation

```http
DELETE /ride-hailing/customer/rides/{ride_id}
```

Required request:

```json
{"cancellation_reason_id": 7}
```

- `searching` or `negotiating`: free cancellation.
- `rider_selected`, `captain_arriving`, or `arrived`: Laravel applies the
  snapshotted admin cancellation amount only when charging is enabled and the
  server-calculated Captain-to-pickup progress reaches the configured 30–50%
  threshold (or the progress rule is disabled).
- `in_progress` or later: API cancellation is blocked.

Only a charged customer cancellation creates a strike. When the configured
strike limit is reached, estimate and create endpoints return HTTP 403 with
`errors[0].code=ride_cancellation_cooldown`, `booking_blocked`,
`blocked_until`, and `cooldown_seconds`. The create endpoint rechecks this
under the locked customer row. Captain/admin cancellation never creates a
customer charge or strike.

Turning `cancellation_charge_enabled` off applies to new cancellations only.
A newly cancelled Ride records zero charge, creates no strike or Captain
receivable, and fully refunds any paid prepayment to the customer wallet.
Existing legitimate cancellation dues/receivables and an already-active
`ride_booking_blocked_until` cooldown are retained until their normal
collection or expiry; changing the switch is not a financial-data deletion.

Charge collection and wallet posting follow `ride-payments-and-settlement.md`.

## Captain Contract

### Current Assigned Ride

```http
GET /delivery-man/rides/current
```

Returns the assigned active passenger Ride first. When no active Ride exists,
it returns the newest assigned completed Ride whose settlement is still
`unpaid`, `pending`, or `partially_paid`, allowing the Captain to recover the
payment screen after restart or a missed notification. Paid and otherwise
settled completed Rides are excluded. When neither an active nor recoverable
Ride exists it returns `{"ride": null}`. The Ride contains the customer, route,
fare, timestamps, payment fields, and `next_action`.

### Assigned Ride Details

```http
GET /delivery-man/rides/{ride_id}
```

The Captain can access only rides assigned to their authenticated account.
The Trip PIN is never returned in Captain responses.

The existing authorized Admin → Ride Hailing → Ride Operations detail page may
show the decrypted four-digit PIN only for an assigned Ride in
`rider_selected`, `captain_arriving`, or `arrived` with no `trip_started_at`.
It is labelled sensitive and disappears at trip start. It is never included in
admin lists, exports, logs, notifications, realtime events, or mobile APIs.

### Advance Trip Status

```http
PUT /delivery-man/rides/{ride_id}/status
```

Start pickup:

```json
{"action": "start_pickup"}
```

Mark arrived:

```json
{"action": "arrived"}
```

Start trip:

```json
{"action": "start_trip", "trip_pin": "4821"}
```

Complete:

```json
{"action": "complete"}
```

The server starts waiting time at `arrived_at`. On `start_trip`, every started
minute after `free_waiting_minutes` is charged using the snapshotted
`waiting_charge_per_minute`.

Waiting is stored separately from `final_accepted_fare`. Waiting goes entirely
to the Captain and does not increase the accepted-fare commission; see
`ride-payments-and-settlement.md`.

### Update Active Location

```http
PUT /delivery-man/rides/{ride_id}/location
```

```json
{"latitude": 31.4504, "longitude": 73.135}
```

Allowed from `rider_selected` through `in_progress`, limited to 120 requests per
minute. It updates both the ride-scoped current location and the existing shared
Captain delivery history. The customer reads the location from their owned ride
detail response. The mobile app should send updates only while an active ride
screen is visible or background tracking permission is active.

The request may also send nullable `heading` (`0 <= x < 360`), `speed_mps`
(`0-100`) and `accuracy_meters` (`0-1000`). The owned active-Ride response and
private location event return these fields. Terminal Ride responses suppress
the last exact location and telemetry. See
`../api/ride-customer-experience-enhancements.md`.

### Captain Cancellation

```http
DELETE /delivery-man/rides/{ride_id}
```

```json
{"cancellation_reason_id": 12}
```

The actor- and lifecycle-scoped Ride cancellation reason ID is required.
Customers list reasons at
`GET /api/v1/ride-hailing/customer/cancellation-reasons`; Captains use
`GET /api/v1/delivery-man/ride-cancellation-reasons`. Cancellation is allowed
before `in_progress` and has no
customer charge. An in-progress or completed ride cannot be cancelled through
this endpoint.

Captain cancellation is terminal: it rejects every pending offer, creates no
customer strike or Captain receivable, fully refunds any paid Ride prepayment
to the customer wallet, and never starts another dispatch wave. The assigned
Captain remains attached only for history/audit; `rides/current` excludes the
cancelled Ride. The customer receives the configured `captain_cancelled`
in-app/Firebase notification plus `ride.status.updated`, and must request a new
Ride manually.

## Notifications And Polling

Customer lifecycle changes and Captain cancellation create a stored customer
notification and attempt Firebase push delivery. Selecting an offer sends the
Captain a Firebase push. Push failure never rolls back a valid trip transition.

Private Ride channels are defined in `ride-realtime.md`. API refresh/polling
remains authoritative during reconnects. Do not subscribe to the existing broad
delivery-man location channel for passenger rides.

## Customer Rating

```http
PUT /ride-hailing/customer/rides/{ride_id}/rating
```

```json
{"rating": 5, "comment": "Professional Captain"}
```

Only the owning customer can rate an assigned completed Ride. `rating` is an
integer from 1 through 5 and `comment` is optional, stripped of HTML and limited
to 1,000 characters. The Ride row is locked while saving. The database unique
Ride key and `updateOrCreate` preserve one rating per Ride; submitting again
updates that rating instead of adding a duplicate. Rating, history, Ride detail,
payment and receipt endpoints remain accessible when new customer booking is
disabled.

## Errors

Validation and state errors use the existing error envelope, usually HTTP 403:

```json
{
  "errors": [
    {"code": "ride", "message": "The Trip PIN is incorrect."}
  ]
}
```

Important codes are `action`, `trip_pin`, `latitude`, `longitude`, and `ride`.
Unowned or missing rides return 404. Invalid authentication returns 401.

## Mobile Screen Behavior

Customer app:

1. After offer selection, show Captain, vehicle, live map, and the four-digit
   Trip PIN.
2. Refresh the owned ride on foreground/resume and while the active screen is
   open.
3. At `arrived`, show the free-wait countdown based on server `arrived_at`.
4. Hide the PIN when status becomes `in_progress`.
5. Display charged waiting separately from the negotiated fare.
6. Disable cancellation when status is `in_progress`.

Captain app:

1. Open `/rides/current` after an accepted-offer push or app resume.
2. Render only the server-provided `next_action`.
3. Ask for the four-digit PIN only for `start_trip`.
4. Begin ride location updates after selection and stop after completion or
   cancellation.
5. Never advance the UI optimistically before the status endpoint succeeds.

## Security And Concurrency

- Every customer read/write is scoped to the Passport user.
- Every Captain read/write is scoped to the `dm.api` token and assigned ride.
- Trip PIN is encrypted at rest and compared server-side. Before trip start it
  is visible only to the owning customer and the authorized scoped admin Ride
  detail; it is never returned to the Captain.
- State transitions and cancellation lock the ride row.
- Server timestamps, not device clocks, determine arrival and waiting.
- Location input is coordinate-validated and accepted only for active rides.
- Completion calculates the payable snapshot but does not itself mutate wallet
  balances; the separate payment settlement flow performs those mutations.

## Backend Files

- `routes/api/v1/api.php`
- `app/Http/Controllers/Api/V1/CustomerRideController.php`
- `app/Http/Controllers/Api/V1/CaptainRideController.php`
- `app/Models/RideRequest.php`
- `app/Models/RideStatusHistory.php`
- `app/Services/RideTripStateMachine.php`
- `app/Services/RideTripService.php`
- `app/Services/RideNotificationService.php`
- `app/Services/RideFareCalculator.php`
- `database/migrations/2026_08_09_000003_add_trip_lifecycle_to_ride_requests.php`
- `tests/Unit/RideTripStateMachineTest.php`
- `tests/Unit/RideFareCalculatorTest.php`
# Cancellation notifications

Cancellation messages are actor-specific. A passenger cancellation notifies the assigned Captain with the snapshotted passenger reason and whether cancellation compensation is due. A Captain cancellation notifies the passenger with the snapshotted reason and confirms that no cancellation charge applies. An admin cancellation records `cancelled_by=admin`, requires an admin-scoped reason ID, charges neither party, and notifies both passenger and assigned Captain. All three flows publish `ride.status.updated` after commit; REST `cancelled_by`, structured `cancellation_reason`, `cancellation_charge_amount`, and `payment_status` remain authoritative. See `docs/api/ride-map-markers-cancellation-routing.md` for the active contract.

Ride messages for both passengers and Captains are stored in the existing `user_notifications` feed as well as sent through Firebase when a token is available. Captain Ride notifications therefore appear through the existing delivery-man notifications endpoint after reconnecting or missing a push.

All Ride lifecycle titles, bodies, Push toggles and In-App toggles are managed under `/admin/ride-hailing/notification-settings`. Templates are condition-specific and support only these server-rendered placeholders: `{rideNumber}`, `{passengerName}`, `{captainName}`, `{reason}`, `{cancellationCharge}`, `{walletRefund}`, `{pickupAddress}`, `{finalFare}`, and `{captainEarning}`. Mobile apps must display the rendered payload and must not attempt template substitution.
