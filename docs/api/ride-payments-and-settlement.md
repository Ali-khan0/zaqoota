# Ride Payments And Settlement API

Backend status: cash selection/confirmation, online gateway links, idempotent
wallet settlement, payment history, and JSON receipts are implemented.

This contract follows `ride-trip-lifecycle.md`. Refunds, disputes, tips, fleet
manager Ride commission, and downloadable PDF receipts remain future work.

## Financial Rules

For a completed ride:

```text
customer payable = final accepted fare + waiting charge
Zaqoota commission = commission percentage of final accepted fare only
Captain earning = final accepted fare - Zaqoota commission + waiting charge
```

Waiting charges go entirely to the Captain. They do not increase Zaqoota
commission.

When the customer cancels after Captain selection but before trip start:

```text
customer payable = configured cancellation charge
Zaqoota commission = 0
Captain earning = cancellation charge
```

Free/customer pre-selection cancellation and Captain cancellation have
`payment_status: not_required`.

## Authentication

Base URL:

```text
https://YOUR-DOMAIN.example/api/v1
```

Customer routes require Passport Bearer authentication. Captain cash
confirmation uses the existing `dm.api` Bearer/token authentication.

## Customer Endpoints

### Payment Summary

```http
GET /ride-hailing/customer/rides/{ride_id}/payment-summary
```

```json
{
  "payment": {
    "status": "unpaid",
    "method": null,
    "gateway": null,
    "accepted_fare": 500,
    "waiting_charge": 20,
    "cancellation_charge": 0,
    "final_payable_amount": 520,
    "paid_at": null,
    "receipt_number": null
  }
}
```

Payment can begin only for a completed ride or a cancelled ride with a positive
customer cancellation charge.

### Select Cash

```http
POST /ride-hailing/customer/rides/{ride_id}/payments
```

```json
{"payment_method": "cash"}
```

This creates one pending cash attempt. It does not mark the ride paid. The
assigned Captain must confirm actual collection.

### Create Online Payment Link

```http
POST /ride-hailing/customer/rides/{ride_id}/payments
```

```json
{
  "payment_method": "digital",
  "payment_gateway": "assan_pay",
  "payment_platform": "app",
  "callback_url": "zaqoota://ride-payment-result"
}
```

Response:

```json
{
  "message": "Payment link created.",
  "redirect_link": "https://example.com/payment/assan-pay/pay?payment_id=...",
  "payment": {
    "id": 18,
    "amount": 520,
    "payment_method": "digital",
    "payment_gateway": "assan_pay",
    "status": "pending"
  }
}
```

Open `redirect_link` in the established payment webview/browser flow. The
gateway invokes `ride_payment_success` or `ride_payment_fail`. The success hook
is the only authority that marks an online attempt paid and posts wallets.

Only one pending attempt may exist. The app must wait for completion/failure
before changing payment methods or creating another online attempt.

### Payment History

```http
GET /ride-hailing/customer/rides/{ride_id}/payments?limit=20&page=1
```

Returns paginated pending, failed, and paid attempts with method, gateway,
amount, transaction reference, and timestamps.

### Receipt

```http
GET /ride-hailing/customer/rides/{ride_id}/receipt
```

Available only after successful settlement. The JSON receipt includes receipt
and ride numbers, route, Captain/vehicle, payment reference, accepted fare,
waiting/cancellation charges, and total paid. The receipt number format is
`ZQR-R-0000042`.

## Captain Endpoint

### Confirm Cash Collection

```http
POST /delivery-man/rides/{ride_id}/payments/cash/confirm
```

No body is required. Only the assigned Captain can confirm a pending cash
attempt. Confirmation atomically posts the Captain earning and cash collection,
marks the ride paid, and creates the receipt.

## Wallet And Accounting

Settlement locks the payment, ride, Captain wallet, and admin wallet. The
`ride_requests.settled_at` timestamp is the idempotency barrier.

Captain wallet:

- `total_earning` increases by the Captain net earning.
- For cash, `collected_cash` increases by the full amount collected from the
  customer. This naturally leaves the platform commission payable to Zaqoota.
- For online payment, `collected_cash` does not change.

Captain ledger rows:

- `ride_earning`: gross Captain-side fare/charges credit.
- `ride_platform_commission`: accepted-fare platform commission debit.
- `ride_cash_collection`: full customer cash collection debit, cash only.

Admin wallet:

- `total_commission_earning` increases by accepted-fare commission.
- `digital_received` increases by the full customer payment for online
  payments.

The payment and every ledger row use `ride:{ride_id}` as their audit reference.
No fleet-manager Ride commission is posted in this milestone because its Ride
policy has not been defined.

## Mobile Behavior

Customer app:

1. On completed or chargeable-cancelled status, load payment summary.
2. Show accepted fare and waiting/cancellation lines separately.
3. For cash, show `Waiting for Captain confirmation` while pending.
4. For digital, open the returned redirect link and refresh payment summary
   after callback/deep-link return.
5. Never mark an online payment successful based only on the redirect flag;
   require API `payment.status == paid`.
6. Enable the receipt screen only when paid.

Captain app:

1. For a completed cash ride, show the exact `final_payable_amount`.
2. Require an explicit `Cash received` confirmation.
3. Disable repeat confirmation while the request is in flight.
4. Refresh the wallet after success.

## Errors And Security

Errors use the existing envelope, generally HTTP 403:

```json
{"errors":[{"code":"payment","message":"This ride has already been paid."}]}
```

- Customer ownership and Captain assignment are enforced server-side.
- Client-supplied amounts are never accepted.
- Gateway and callback fields are validated.
- Payment and settlement use row locks.
- Repeated gateway callbacks do not repost wallet balances.
- Payment success is based on the server gateway callback, not mobile state.

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
- `tests/Unit/RideSettlementCalculatorTest.php`
