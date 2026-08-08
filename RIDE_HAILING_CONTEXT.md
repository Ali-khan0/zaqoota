# Ride Hailing Codebase Context

Read this file with `CODEBASE_CONTEXT.md` before changing Ride Hailing. This
module reuses rider identity and wallet infrastructure, but it must not reuse
commerce `orders`, store items, or delivery vehicle-category pricing for trips.

## Current phase

The implemented foundation covers module navigation, rider work mode, actual
ride vehicle registration, ride categories, zone/category fare configuration,
and reserved rider-wallet ledger types. Booking, matching, trips, passenger
APIs, driver ride offers, payments, commission posting, and reports do not yet
exist.

## Admin surface

All routes use the `admin.ride-hailing.*` name prefix and live under
`admin/ride-hailing`:

- `/` dashboard
- `/vehicles` vehicle registry and approval
- `/vehicles/create` register a rider vehicle
- `/riders` existing shared rider accounts, work mode, and ride-vehicle summary
- `/categories` ride-category setup
- Zone module setup under `admin/business-settings/zone/module-setup/{zone}`
  connects Ride Hailing and configures every category fare in one form
- `/setup` basic service settings

Controllers:

- `App\Http\Controllers\Admin\RideHailing\RideHailingController`
- `App\Http\Controllers\Admin\RideHailing\RideHailingSettingController`

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
- cancellation charge;
- platform commission percentage;
- negotiated minimum and maximum as percentages of the calculated fare;
- optional surge multiplier.

Future fare calculation must read one persisted row, produce a transparent
breakdown, use decimal-safe arithmetic, and snapshot every applied value on the
trip. Never recalculate historical trip finances from current settings.

## Wallet convention

Ride earnings share the existing rider wallet but use separate
`DeliveryManWalletLedger` transaction types:

- `ride_earning`
- `ride_platform_commission`
- `ride_cash_collection`
- `ride_refund`

These constants reserve the accounting vocabulary only. No balances are posted
until the trip/payment workflow is implemented transactionally.

## Next bounded contexts

Before implementing a booking flow, define trips and state transitions,
passenger pickup/destination data, fixed versus negotiated fare snapshots,
driver offer/ETA confirmation, automatic reassignment, scheduled rides, Trip
PIN, cancellation policy, live location, payments, platform/fleet commission,
safety escalation, complaints, notifications, and reports.

Each mobile-facing addition requires a specification under `docs/api/` in the
same change. Rider mode is not enough to authorize future trip operations;
matching and acceptance must recheck mode, active vehicle, zone, category,
approval, online state, capacity, and conflicting work server-side.
