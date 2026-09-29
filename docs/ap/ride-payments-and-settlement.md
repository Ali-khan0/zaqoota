# Ride Payments And Settlement API

Backend status: cash selection/confirmation, online gateway links, customer
wallet payment, wallet-plus-cash/online partial payment, cancellation dues,
online prepayment cancellation refunds, idempotent settlement, payment history,
and JSON receipts are implemented.

This contract follows `ride-trip-lifecycle.md`. Refunds, disputes, tips, fleet
manager Ride commission, and downloadable PDF receipts remain future work.

## Financial Rules

For a completed ride:

```text
customer payable = final accepted fare - Ride coupon discount + waiting charge
Zaqoota commission = commission percentage of final accepted fare only
Captain earning = final accepted fare - Zaqoota commission + waiting charge
```

Waiting charges go entirely to the Captain. When a customer cancels after
Captain selection but before trip start, the configured cancellation charge is
payable, Zaqoota commission is zero, and the complete charge goes to the
Captain. Free pre-selection customer cancellation and Captain cancellation use
`payment_status: not_required`.

Ride coupons are admin-funded. Captain earning and Zaqoota gross commission
remain based on the full accepted fare; the discount is stored separately as a
`ride_coupon_discount` admin expense. See `ride-coupons.md`.

A chargeable cancellation remains attached to the cancelled Ride as an
outstanding receivable. It does not make `users.wallet_balance` negative. The
customer may settle it through the next Ride's enabled payment method. Direct
payment against the cancelled Ride remains online-only because the cancelled
Ride has no active cash-collection handoff.

## Authentication And Headers

Base URL: `https://YOUR-DOMAIN.example/api/v1`

Customer routes require Passport Bearer authentication. Captain cash
confirmation uses the existing `dm.api` Bearer/token authentication.

```http
Authorization: Bearer YOUR_TOKEN
Accept: application/json
Content-Type: application/json
```

## Customer Endpoints

### Payment Summary

```http
GET /ride-hailing/customer/rides/{ride_id}/payment-summary
```

```json
{
  "payment": {
    "status": "partially_paid",
    "is_settled": false,
    "method": "partial_payment",
    "gateway": null,
    "accepted_fare": 500,
    "waiting_charge": 20,
    "cancellation_charge": 0,
    "previous_cancellation_due": 25,
    "coupon_discount": 25,
    "final_payable_amount": 520,
    "wallet_paid_amount": 100,
    "remaining_amount": 420,
    "customer_wallet_balance": 0,
    "cash_enabled": true,
    "digital_enabled": true,
    "wallet_enabled": true,
    "partial_payment_enabled": true,
    "partial_payment_method": "both",
    "cash_partial_enabled": true,
    "digital_partial_enabled": true,
    "digital_gateways": ["stripe", "assan_pay"],
    "paid_at": null,
    "receipt_number": null
  }
}
```

`coupon_discount` and `previous_cancellation_due` are the canonical payment
summary keys. During the mobile rollout the response also includes equivalent
`coupon_discount_amount` and `previous_cancellation_due_amount` aliases for
older builds. New clients must prefer the canonical keys and may fall back to
the aliases. All four values are server-calculated; clients must not recompute
the payable amount.

The payment availability fields are authoritative for that Ride. They combine
the global cash, digital, wallet and partial-payment switches with the selected
partial remainder method and active gateway credentials. Active pre-pickup
Rides and cancelled-Ride direct dues expose enabled online gateways only. The
API rechecks the same policy inside the locked payment-attempt transaction.

`is_settled` is authoritative. It is `true` when `settled_at` exists or when
`payment_status` is `paid` or `recovered`. Both settled statuses return zero
`remaining_amount`, allow receipt access and reject another payment attempt.
`recovered` is used when Zaqoota has collected a customer cancellation charge
and cleared its Captain receivable; it is not an unpaid state.

Completed Rides become payable after completion. A cancellation charge can be
collected directly against the cancelled Ride or carried into the customer's
next Ride; both paths clear the same receivable record.

### Outstanding Cancellation Dues

```http
GET /ride-hailing/customer/payment-due
```

```json
{
  "total_due": 100,
  "chargeable_cancellation_count": 1,
  "booking_blocked": false,
  "online_payment_required": false,
  "payment_options": {
    "cash_enabled": false,
    "digital_enabled": true,
    "wallet_enabled": false,
    "partial_payment_enabled": false,
    "digital_gateways": ["stripe", "assan_pay"]
  },
  "rides": [
    {
      "id": 42,
      "request_number": "ZQR-0000042",
      "cancellation_charge": 100,
      "wallet_paid_amount": 0,
      "amount_due": 100,
      "payment_status": "due_next_ride",
      "recovery_ride_id": 51,
      "recovery_method": "next_ride_or_online",
      "cancelled_at": "2026-08-09T10:30:00+05:00"
    }
  ]
}
```

Call this during Ride entry/startup to explain any amount that will be added to
the passenger's next Ride. One due can be reserved for recovery through the
next Ride. A temporary booking block is controlled by the cancellation strike
policy and its server expiry, not by whether the due was paid. Fare estimates expose
`previous_cancellation_due_amount` and `estimated_total_with_previous_due`.
`total_due` is the sum of the listed `amount_due` values. Clients must display
`amount_due` as the outstanding card amount; `cancellation_charge` is the
original charge before any recorded wallet contribution.
The created Ride and its payment summary expose
`previous_cancellation_due_amount`/`previous_cancellation_due`. Coupons never
discount this carried amount.

When the passenger cancellation is chargeable, Laravel creates one pending
`ride_cancellation_receivables` row tied to the cancelled Ride, customer and
original Captain. It creates no admin expense and does not credit the Captain
wallet yet. The next Ride can reserve the outstanding customer amount. If that
Ride is cancelled, the reservation is released to a later Ride.

Once the customer amount is actually collected—either directly or through a
paid recovery Ride—the receivable row is locked and changed from `pending` to
`cleared`. In the same transaction, the original Captain wallet is credited and
one `ride_cancellation_earning` ledger entry is written. Replay sees the cleared
row and cannot credit again. The recovery Ride's Captain earnings and platform
commission exclude the carried amount.

The cancelled source Ride uses `payment_status=due_next_ride` while collection
is pending. After collection it changes to `payment_status=recovered`; the
Captain API exposes `cancellation_receivable.status` as `pending_collection` or
`cleared`, plus the amount and `cleared_at` timestamp.

## Repeat-cancellation restriction

Only charged cancellations create strikes. Reaching the admin-configured strike
limit temporarily blocks new estimates and bookings until `blocked_until`; it
does not force one payment method. Outstanding dues remain payable by the
methods allowed for that Ride. Direct or next-Ride collection credits the
original Captain receivable exactly once.

### Pay Fully From Customer Wallet

```http
POST /ride-hailing/customer/rides/{ride_id}/payments
```

```json
{"payment_method": "wallet"}
```

The wallet must be enabled and contain the entire remaining amount. The backend
debits it, creates a paid wallet component and completes settlement. The app
must never subtract wallet balance itself.

### Cash Or Wallet Plus Cash

```http
POST /ride-hailing/customer/rides/{ride_id}/payments
```

```json
{"payment_method": "cash", "use_wallet": true}
```

With `use_wallet: false`, this creates a pending cash attempt for the full
remaining amount. With `use_wallet: true`, the backend uses the available
wallet balance and creates a pending cash component only for the remainder.
Partial wallet plus cash requires global partial payment to be enabled and its
configured method to be `cod` or `both`. The assigned Captain confirms actual
cash collection.

### Online Or Wallet Plus Online

```http
POST /ride-hailing/customer/rides/{ride_id}/payments
```

```json
{
  "payment_method": "digital",
  "payment_gateway": "assan_pay",
  "payment_platform": "app",
  "callback_url": "zaqoota://ride-payment-result",
  "use_wallet": true
}
```

```json
{
  "message": "Payment link created.",
  "redirect_link": "https://example.com/payment/assan-pay/pay?payment_id=...",
  "wallet_amount": 100,
  "remaining_amount": 420,
  "payment": {
    "id": 18,
    "amount": 420,
    "payment_method": "digital",
    "payment_gateway": "assan_pay",
    "status": "pending"
  }
}
```

Wallet plus online requires partial payment method `digital_payment` or `both`.
If the wallet covers the whole amount, `redirect_link` is `null` and
`remaining_amount` is zero. Otherwise open the link in the established payment
webview/browser flow. Only the `ride_payment_success` server hook marks the
online component paid. Never trust the redirect flag alone.

Only one pending cash/online attempt may exist. After a failed online attempt,
an already-paid wallet component remains valid and the customer retries only
the remaining amount.

Cash attempts require the global cash switch. Digital attempts require the
global digital switch and an active credential returned in
`digital_gateways`. Full-wallet payment requires the wallet switch. Partial
wallet payment additionally requires the partial-payment switch and the
selected remainder method (`cod`, `digital_payment`, or `both`).

### Online Prepayment Before Pickup

After a Captain is selected and before the trip starts, the existing payment
endpoint accepts online gateway payment only. Cash, wallet and wallet-partial
prepayment are rejected. A successful callback records
`payment_status=prepaid`; it does not post Captain earnings or mark the Ride
settled. Completion finalizes the payment, or leaves only any later waiting
charge as the remaining balance.

If the Ride is cancelled before pickup, Laravel locks the Ride/payment and
creates one `ride_cancellation_refunds` record. An applicable cancellation
charge is allocated to the original Captain receivable, and the remaining paid
amount is atomically credited to `users.wallet_balance` with a
`ride_cancellation_refund` wallet transaction. With no applicable charge, the
full prepayment is credited. Gateway callback/cancellation races use the same
Ride-first lock order; the unique refund row and receivable state prevent a
second refund or Captain credit. The customer receives the rendered
`cancellation_wallet_refunded` push/in-app notification containing the
authoritative wallet amount.

If cancellation charging is disabled at cancellation time, the allocated
amount is zero, payment status becomes `refunded`, the full paid amount is
credited once, and no strike, Captain receivable, Captain wallet credit or
admin expense is created. The switch does not erase historical dues or an
existing cooldown.

### Payment History

```http
GET /ride-hailing/customer/rides/{ride_id}/payments?limit=20&page=1
```

Returns paginated wallet, cash, and online components with amount, gateway,
status, transaction reference, and timestamps.

### Receipt

```http
GET /ride-hailing/customer/rides/{ride_id}/receipt
```

Available only after complete settlement. It includes the wallet-paid amount,
payment method, accepted fare, waiting/cancellation charges, total paid, route,
Captain and vehicle. Receipt numbers use `ZQR-R-0000042`.

## Captain Endpoint

```http
POST /delivery-man/rides/{ride_id}/payments/cash/confirm
```

Only the assigned Captain can confirm a pending cash component. For partial
payment, the Ride payload's `remaining_payment_amount` is the amount to collect,
not `final_payable_amount`. Confirmation settles the full Ride exactly once.

The Captain current-Ride endpoint uses active assignment first, then falls back
to the newest assigned completed Ride with `settled_at = null` and payment
status `unpaid`, `pending`, or `partially_paid`. This keeps cash confirmation
and online-payment waiting recoverable after app restart. Paid and fully
wallet-settled completed Rides are not returned by that fallback.

## Wallet And Accounting

Settlement locks the payment, Ride, Captain wallet, and admin wallet.
`ride_requests.settled_at` is the idempotency barrier.

Customer wallet:

- Full wallet payment creates a `trip_booking` debit transaction.
- Partial wallet payment creates a `partial_payment` debit transaction.
- Both use `ride:{ride_id}` as reference.
- `ride_payments` stores wallet separately from cash/online remainder.

Captain wallet and ledgers:

- `total_earning` increases by the full Captain net earning once fully paid.
- `collected_cash` increases only by the actual cash component.
- Ledger types are `ride_earning`, `ride_platform_commission`, and cash-only
  `ride_cash_collection`.

Admin wallet:

- `total_commission_earning` increases by accepted-fare commission.
- `digital_received` increases only by the online component. Wallet funds are
  not counted again when spent.

No fleet-manager Ride commission is posted because its policy is not defined.

## Mobile Screen Behavior

Customer app:

1. Check `payment-due` when entering Ride Hailing and explain that it will be collected with the next Ride.
2. Show accepted fare, waiting, previous cancellation due, coupon, wallet paid, and remaining due as separate lines.
3. Offer wallet only when `wallet_enabled`.
4. Offer split payment only when the partial flags permit the remainder method.
5. For cash, show `Waiting for Captain confirmation` while pending.
6. For digital, refresh payment summary after callback/deep-link return.
7. Enable the receipt only when `status` is `paid`.

Captain app:

1. Collect `remaining_payment_amount` for cash and show `previous_cancellation_due_amount` as an admin recovery, not Captain earning.
2. Require an explicit `Cash received` confirmation.
3. Disable repeat confirmation while in flight and refresh wallet after success.

## Errors And Security

Errors use the existing HTTP 403 envelope:

```json
{"errors":[{"code":"payment","message":"This ride has already been paid."}]}
```

- Customer ownership and Captain assignment are enforced server-side.
- Client-supplied amounts are never accepted.
- Wallet balance is locked and debited by the backend.
- Payment and settlement use row locks.
- Repeated callbacks cannot repost wallet balances.
- A positive cancellation due is server-reserved against the next Ride and cannot be removed or discounted by the client.

## Backend Files

- `routes/api/v1/api.php`
- `app/helpers.php`
- `app/Http/Controllers/Api/V1/CustomerRideController.php`
- `app/Http/Controllers/Api/V1/CaptainRideController.php`
- `app/Models/RideRequest.php`
- `app/Models/RidePayment.php`
- `app/Services/RidePaymentService.php`
- `app/Services/RideSettlementCalculator.php`
- `database/migrations/2026_08_09_000004_add_ride_payment_and_settlement.php`
- `database/migrations/2026_08_09_000005_add_wallet_payment_to_ride_requests.php`
- `tests/Unit/RideSettlementCalculatorTest.php`
