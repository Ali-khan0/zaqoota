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
- `/categories` ride-category setup
- `/fares` zone/category pricing
- `/setup` basic service settings

Controllers:

- `App\Http\Controllers\Admin\RideHailing\RideHailingController`
- `App\Http\Controllers\Admin\RideHailing\RideHailingSettingController`

`App\Http\Middleware\CurrentModule` recognizes `admin/ride-hailing*` so direct
links retain the Ride Hailing sidebar even when the previous session module was
different.

Views are under `resources/views/admin-views/ride-hailing/`. The dedicated
sidebar is `resources/views/layouts/admin/partials/_sidebar_ride_hailing.blade.php`.

## Rider reuse and work mode

`delivery_men.work_mode` is `delivery` or `ride` and defaults to `delivery`.
The same rider authentication, profile, location, fleet-manager relationship,
online status, and wallet are reused.

Rules:

- A rider receives only work matching the selected mode.
- `DeliveryMan::available()` includes only `delivery` mode riders.
- A rider cannot switch to Ride mode while `current_orders > 0`.
- Ride mode requires an approved active `RideVehicle`.
- Delivery latest-order discovery returns an empty list in Ride mode.
- Delivery order acceptance independently rejects Ride mode riders.

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

A rider may have at most two ride vehicles. Only one approved vehicle can be
active at a time. The limit and category/type/fuel compatibility are enforced
in the admin controller inside database transactions.

## Fare configuration

`ride_fares` has one row per zone and active ride category. It stores:

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
