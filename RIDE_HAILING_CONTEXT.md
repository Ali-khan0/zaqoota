# Ride Hailing Codebase Context

Read this file with `CODEBASE_CONTEXT.md` before changing Ride Hailing. This
module reuses rider identity and wallet infrastructure, but it must not reuse
commerce `orders`, store items, or delivery vehicle-category pricing for trips.

## Current phase

The implemented foundation covers module navigation, rider work mode, actual
ride vehicle registration, ride categories, zone/category fare configuration,
reserved rider-wallet ledger types, authenticated customer fare estimates and
ride requests, eligible-Captain polling, expiring Captain offers, and atomic
customer offer selection. The trip lifecycle now covers Captain travel and
arrival, customer-only Trip PIN verification, server-timed waiting, active
ride-scoped location, completion, pre-start cancellation audit, and lifecycle
push notifications. Cash, online gateway, customer-wallet and
wallet-plus-cash/online partial payments, idempotent Captain/admin wallet
settlement, payment component history, cancellation dues, JSON receipts, and authenticated
private Ride realtime channels are implemented. The admin Ride Operations
control room provides paginated monitoring, filtering, current-trip status,
manual Captain assignment, latest Captain coordinates, offer/payment history,
and the immutable trip timeline. Refunds, safety and aggregate financial
reports do not yet exist.

Customers may cancel `searching` or `negotiating` requests without a fee. A
customer cancellation after Captain selection but before trip start records
the snapshotted fixed cancellation charge; Captain cancellation is free to the
customer. The payment milestone collects and posts that recorded charge.

## Admin surface

All routes use the `admin.ride-hailing.*` name prefix and live under
`admin/ride-hailing`:

- `/` dashboard
- `/rides` paginated operational queue for unassigned, active, completed, and
  cancelled rides
- `/rides/{ride}` ride detail, route, current Captain location, trip timeline,
  offers, payments, and settlement summary
- `POST /rides/{ride}/assign` manually assigns an eligible Captain and bounded
  final fare while the ride is still searching or negotiating
- `/coupons` Ride-specific admin coupon creation, editing, status and list
- `/coupons/{coupon}/usages` reservation/redemption/release audit
- `/vehicles` vehicle registry and approval
- `/vehicles/create` register a rider vehicle
- `/riders` existing shared rider accounts, work mode, and ride-vehicle summary
- `/categories` ride-category setup
- Zone module setup under `admin/business-settings/zone/module-setup/{zone}`
  connects Ride Hailing and configures every category fare in one form
- `/setup` basic service settings

Controllers:

- `App\Http\Controllers\Admin\RideHailing\RideHailingController`
- `App\Http\Controllers\Admin\RideHailing\RideOperationController`
- `App\Http\Controllers\Admin\RideHailing\RideHailingSettingController`

The operations query is scoped to the authenticated admin's zone when one is
assigned. Manual assignment locks the ride, rechecks current Captain mode,
availability, zone and approved active vehicle eligibility, rejects competing
pending offers, records an accepted admin offer, snapshots commission from the
chosen final fare, appends an admin-authored status history, and sends customer,
Captain and realtime updates. It cannot overwrite an already assigned or
started ride; reassignment needs a separate audited policy before it is added.

`App\Http\Middleware\CurrentModule` recognizes `admin/ride-hailing*` so direct
links retain the Ride Hailing sidebar even when the previous session module was
different.

Views are under `resources/views/admin-views/ride-hailing/`. The dedicated
sidebar is `resources/views/layouts/admin/partials/_sidebar_ride_hailing.blade.php`.
It must provide both `#sidebarMain` and `#sidebarCompact`; the shared layout
reads both templates before displaying the header and sidebar. Ride pages use
the standard admin header with Users, Transactions & Reports, Settings,
Dispatch Management, search, language, and the module switcher. Dashboard
statistics follow the existing commerce `__dashboard-card-2` image-card
pattern and support zone filtering.

## Rider reuse and work mode

`delivery_men.work_mode` is `delivery` or `ride` and defaults to `delivery`.
The same rider authentication, profile, location, fleet-manager relationship,
online status, and wallet are reused.

All riders are freelancers (`delivery_men.earning = 1`). Rider registration and
editing surfaces do not expose an earning model or salary option; the backend
sets the value authoritatively.

Rules:

- Delivery mode receives restaurant, grocery, and parcel work.
- Ride mode receives passenger rides (when implemented) and parcel work.
- `DeliveryMan::available()` checks order capacity only. Store-order queries
  additionally use `deliveryMode()`; parcel queries intentionally do not.
- A rider cannot switch to Ride mode while a restaurant/grocery order is
  active; an active parcel does not block the switch.
- Ride mode requires an approved active `RideVehicle`.
- Latest-order discovery returns parcel orders only in Ride mode.
- Order acceptance rejects restaurant/grocery orders in Ride mode but permits
  parcels.

The endpoint contract is documented in
`docs/api/ride-hailing-rider-mode.md`. The complete rider-app implementation
handoff is `docs/api/ride-hailing-rider-app-integration.md`; give that file to
the coding agent working in the mobile repository.

## Vehicles and categories

The existing `dm_vehicles` table remains a delivery charge/coverage category.
Do not store real car or number-plate data there.

Ride Hailing uses:

- `ride_vehicle_types`: seeded Bike, Car, Rickshaw.
- `ride_categories`: seeded Petrol Bike, EV Bike, Economy, Business, Luxury,
  and Rickshaw.
- `ride_vehicles`: actual rider vehicle, make, model, year, colour, number
  plate, fuel, approval, and active state.

A rider selects Bike, Car, or Rickshaw and submits the first real vehicle with
mobile or landing-page registration. Admin rider approval also approves and
activates that first pending vehicle. After approval, the rider may submit one
additional vehicle from the rider app; it remains pending until separately
approved. A rider may have at most two vehicles and only one approved vehicle
can be active. Shared validation lives in
`app/Services/RideVehicleRegistrationService.php`.

Every newly submitted `RideVehicle` requires its own front and back image.
These files are stored under `ride-vehicle/` and exposed to the authenticated
rider response as `front_image_url` and `back_image_url`. Rider onboarding also
requires a current face photo and one or two identity-document images. Allowed
identity types are CNIC (persisted as legacy-compatible `nid`), Passport, and
Driving License; Store ID is not a valid identity type. Deliveryman Preview
separates Face Photo, Identity Document Photos, and each vehicle's clickable
front/back evidence. Older vehicle rows remain valid with nullable photo
columns and display `Not provided` until updated.

Public web rider onboarding is branded `Become Captain` at `/captain/apply`.
The former `/deliveryman/apply` GET URL permanently redirects there and its POST
path remains compatible with existing forms. This web URL does not alter the
Captain mobile API endpoint. The responsive registration UI hides its large
Captain illustration panel below desktop size and retains a compact ZAQOOTA
header above the form.

Ride Hailing does not create, enroll, or attach a second rider identity. The
Ride Riders page is an operational view of shared `delivery_men` accounts, not
a registration page. Mobile details are in
`docs/api/rider-registration-and-vehicles.md`.

The Ride Riders admin page is intentionally restricted to approved riders whose
current `work_mode` is `ride`. It is paginated at 20 rows, supports search and
zone filtering, and links the rider name to the shared Deliveryman Preview.
Delivery-mode riders remain available in the normal Delivery Man list and may
still have pending/approved ride vehicles managed from Ride Vehicles.

The standard admin delivery-man detail page loads `rideVehicles.vehicleType`
and `rideVehicles.category` and shows the rider's vehicle count, identity,
approval status, active vehicle, and current Delivery/Ride work mode. Keep this
shared profile view current when vehicle fields change. For approved riders,
the profile also provides an admin work-mode toggle through
`POST admin/users/delivery-man/work-mode/{id}`. The server locks the rider and
checks active assignments before saving: active non-parcel order IDs block the
change and are shown in the admin error toast, while parcel orders do not block
it. Switching to Ride mode still requires an approved active ride vehicle.

## Fare configuration

`ride_fares` has one row per connected zone and active ride category. Zone
availability is authoritative in the existing `module_zone` connection; fare
rows do not activate a zone. The same Zone Module Setup save synchronizes the
module connection and fare rows inside one database transaction. Disconnecting
the module makes saved fares inactive operationally but retains them for a
future reconnect. It stores:

- base and minimum fare;
- per-kilometre and per-minute charge;
- pickup-distance and waiting-per-minute charge;
- free waiting minutes before the waiting charge starts;
- cancellation charge;
- platform commission percentage;
- negotiated minimum and maximum as percentages of the calculated fare;
- rider-offer expiry time in seconds.

Future fare calculation must read one persisted row, produce a transparent
breakdown, use decimal-safe arithmetic, and snapshot every applied value on the
trip. Ride Hailing does not use surge pricing; demand pricing is handled through
customer/rider negotiation. Platform commission must be calculated from the
final price accepted by the customer and rider, never from the system estimate,
customer's opening bid, or an expired/rejected rider offer. Never recalculate
historical trip finances from current settings.

## Wallet convention

Ride earnings share the existing rider wallet but use separate
`DeliveryManWalletLedger` transaction types:

- `ride_earning`
- `ride_platform_commission`
- `ride_cash_collection`
- `ride_refund`

The payment workflow now posts the earning, commission and cash-collection
types transactionally. `ride_refund` remains reserved for a future refund flow.

Customer wallet payment follows existing commerce settings and transactions.
Full wallet payment uses `trip_booking`; a split wallet component uses
`partial_payment`. `ride_requests.wallet_paid_amount` snapshots the applied
wallet total, while separate `ride_payments` rows track wallet and cash/online
components. Captain `collected_cash` increases only by the actual cash
remainder, and admin `digital_received` increases only by the online remainder.
Economic settlement waits until paid components equal the full payable amount.

A chargeable customer cancellation immediately credits the original Captain
from Zaqoota and records an admin `ride_cancellation_advance` expense and
Captain ledger entry. The customer receivable is exposed by
`GET api/v1/ride-hailing/customer/payment-due`, reserved on the next Ride, and
added as `carried_cancellation_due_amount` when that Ride completes. It never
increases the new Captain's earning or platform commission and coupons cannot
discount it. Cancelling the recovery Ride releases its source dues; successful
payment marks them recovered and records an offsetting
`ride_cancellation_recovery` accounting row.

After a passenger reaches two lifetime chargeable Ride cancellations, any
unrecovered cancellation advance blocks new booking and must be paid directly
through an online gateway. The existing Ride payment endpoint accepts digital
payment only for each cancelled source Ride. Direct recovery posts no second
Captain earning; once all dues are recovered, booking is unlocked.

## Ride coupons

Ride promotions use dedicated `ride_coupons` and `ride_coupon_usages`; do not
reuse commerce coupons, which are coupled to stores, orders and modules. Admin
CRUD lives under `admin/ride-hailing/coupons`. Conditions include fixed or
percentage discount with cap, minimum accepted fare, pickup zones, Ride
categories, payment methods, first Ride, total/per-passenger limits and dates.

The customer may preview a code and attach it when creating a Ride, but
`RideCouponService` locks and authoritatively revalidates it against the final
accepted Captain fare. The customer may replace or remove it while the Ride is
still searching/negotiating through `PUT rides/{ride_id}/coupon`. Usage is reserved on selection, redeemed at trip start,
and released on pre-start cancellation. The discount reduces passenger payable
only; Captain earning and gross commission remain based on the full accepted
fare. Settlement records the subsidy in `expenses` as
`ride_coupon_discount` linked by `ride_request_id`. Coupons never discount
waiting or cancellation charges. Allowed payment methods are snapshotted on the
Ride at reservation. See `docs/api/ride-coupons.md`.

## Ride promotions

Ride promotions use dedicated `ride_banners` and `ride_push_notifications`
instead of commerce banner/notification tables. The Ride sidebar exposes
Coupons, Ride Banners and Push Notifications together. Banners support an
all-zone or single-zone scope, optional category scope, active dates, ordering,
and no-action/Ride-home/coupon/URL actions. Push history supports all customers
or one zone and Ride-home/coupon/URL actions. Firebase uses
`all_zone_customer` or `zone_{id}_customer` with `type=ride_promotion`.
Authenticated customer endpoints provide active banners and a paginated 30-day
notification feed. See `docs/api/ride-promotions.md`.

## Booking and bidding milestone

Passenger rides use core `ride_requests` and `ride_offers`; they never use
commerce `orders` or Rental `Trips`. `RideRouteService` obtains authoritative
driving distance/duration from Google Routes. `RideFareCalculator` uses
integer-cents arithmetic for estimates, negotiation bounds, and final accepted
fare commission snapshots. Customer fare quotes are encrypted, customer-bound,
and valid for five minutes.

Captain discovery is pickup-distance aware. It uses each Captain's existing
latest `delivery_histories` coordinate, excludes requests outside the
admin-configured `ride_hailing_maximum_pickup_radius_km`, and returns available
requests nearest-first with `pickup_distance_meters` and
`pickup_eta_seconds`. ETA uses `ride_hailing_pickup_eta_speed_kmh` only for
display and never affects fare. Realtime creation events are refresh signals;
the REST list is authoritative and the offer write path repeats the radius
check.

Offer submission snapshots pickup distance/ETA in `ride_offers`. Passenger
offer lists sort these snapshots nearest-first and expose them in REST and
realtime payloads, so the customer app can compare proximity with fare and
rating without trusting client-calculated distance.

Customer APIs live under `/api/v1/ride-hailing/customer` with Passport auth.
Captain discovery/offers live under `/api/v1/delivery-man` with `dm.api`.
Captain discovery is polling-based in this milestone. Eligibility is rechecked
at discovery, offer submission, and customer selection. Final selection locks
the ride and offer, accepts one Captain, rejects competing offers, and snapshots
commission from the final accepted amount without posting wallet balances.
Pickup-distance charge is not applied to the pre-Captain system estimate;
Captains can account for pickup travel in their bounded offer until formal
pickup-distance settlement is introduced with the trip lifecycle.
The complete contract is `docs/api/ride-booking-and-bidding.md`.

The customer-app extension adds an always-advertised config capability object,
admin-controlled booking/rebid/rejection/nearby settings, vehicle/category
images, one-route batch estimates, transactional opening-price updates,
individual offer rejection and aggregate nearby availability. Customer-rejected
offers are final for that Captain. Realtime and Firebase are refresh hints and
never contain Trip PIN. Nearby markers are rounded and identity-free. See
`docs/ap/ride-customer-app-integration.md`.

## Trip lifecycle milestone

Assigned rides advance only through `rider_selected`, `captain_arriving`,
`arrived`, `in_progress`, and `completed`. `RideTripStateMachine` defines the
single legal Captain action at each step, while `RideTripService` locks every
transition and appends `ride_status_histories`. The four-digit Trip PIN is
encrypted at rest, returned only to the owning customer before trip start, and
must be verified to enter `in_progress`.

The server starts waiting at `arrived_at`. When the Captain starts the trip,
every started minute beyond the snapshotted free allowance is stored in
`charged_waiting_minutes` and `waiting_charge_amount`. Waiting remains separate
from the accepted-fare commission snapshot until payment policy is implemented.
Captains can update ride-scoped coordinates only during an assigned active
ride; this also maintains the existing shared delivery location record.
Customer lifecycle events are stored and sent through Firebase when configured,
and Captain offer acceptance is pushed to the Captain. Private realtime events
now reduce latency, while API polling remains authoritative during reconnects.
See `docs/api/ride-trip-lifecycle.md` and `docs/api/ride-realtime.md`.

## Payment and settlement milestone

Admin Ride details include a pre-start cancellation action with a required
reason. Admin cancellation records `cancelled_by=admin`, charges neither party,
notifies the passenger and assigned Captain, and appears prominently in Ride
operations. Passenger and Captain cancellations use different notification
wording, include the recorded reason, and explicitly describe whether a
cancellation charge/compensation applies.

Ride lifecycle message templates live in the `BusinessSetting` JSON key
`ride_hailing_notification_templates` and are managed at
`admin/ride-hailing/notification-settings`. Each condition has a fixed
passenger or Captain audience, editable title/body, and independent Push and
In-App toggles. `RideNotificationService` is the only renderer/delivery entry
point; controllers send event keys rather than hardcoded user-facing text.
New-request fan-out is additionally recorded per eligible Captain in
`ride_notification_deliveries`. The unique Ride/Captain/event key prevents
duplicate in-app entries and repeat pushes after Firebase acceptance. Admin
Ride Details exposes the aggregate delivery state and may retry only open
searching/negotiating requests; retry eligibility is recalculated and accepted
recipients are skipped. Firebase acceptance does not represent device receipt
or message-read confirmation.
Firebase submissions run in the retryable `SendRideRequestPush` queue job;
production must not use the synchronous queue connection and must supervise a
durable queue worker.


Completed rides are payable at accepted fare plus waiting. Zaqoota commission
remains the accepted-fare commission snapshot; waiting goes entirely to the
Captain. A customer cancellation charge goes entirely to the Captain with zero
platform commission. Free and Captain cancellations require no payment.

Customer APIs expose payment summary, cash/digital attempt creation, paginated
attempt history, and a paid JSON receipt. Online payments reuse the generic
`PaymentRequest` gateway layer with `ride_payment_success` and
`ride_payment_fail` hooks. Cash is settled only when the assigned Captain
confirms collection. `RidePaymentService` locks the attempt, ride, Captain
wallet, and admin wallet; `ride_requests.settled_at` prevents duplicate wallet
posting on repeated callbacks.

Captain wallet `total_earning` receives net fare plus waiting/cancellation. A
cash ride also increases `collected_cash` by the full customer payment. Online
payments increase admin `digital_received`; accepted-fare commission increases
admin `total_commission_earning`. Dedicated Ride ledger types record gross Ride
earning, platform commission debit, and cash collection debit. Fleet-manager
Ride commission is not posted because no Ride-specific fleet policy exists.
See `docs/api/ride-payments-and-settlement.md`.

## Realtime milestone

Mobile customers and Captains authenticate private Pusher/Reverb-compatible
channels through separate Passport and `dm.api` endpoints. Customer and Captain
account channels deliver pre-trip offers/discovery; `ride.trip.{ride_id}` is
authorized only for the owning customer or assigned Captain and carries status,
location, and payment updates. New requests fan out to at most 100 recalculated
eligible private Captain channels instead of a persistent shared zone channel.

`RideRealtimeEvent` broadcasts immediately after committed mutations. The
mobile apps must fetch REST state after events and use 10-second polling when
disconnected. A non-sync queue worker enables punctual `ExpireRideOffer` events;
REST expiry normalization remains correct without it. Production requires the
configured websocket server under process supervision. See
`docs/api/ride-realtime.md`.

## Next bounded contexts

The next milestone should add customer/Captain ratings and Ride admin
operations/reporting. Refunds, disputes, safety, complaints, downloadable PDF
receipts, tips, and a separately approved fleet-manager Ride commission policy
follow.

Each mobile-facing addition requires a specification under `docs/api/` in the
same change. Rider mode is not enough to authorize future trip operations;
matching and acceptance must recheck mode, active vehicle, zone, category,
approval, online state, capacity, and conflicting work server-side.
