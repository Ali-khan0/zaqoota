# Ride Map Markers Laravel Progress

This checklist tracks the implementation defined by
`ride_map_markers_laravel_requirements.md`. A step is marked **Done** only after
its code, documentation, and relevant automated verification are complete.

## Status legend

- [x] Done
- [ ] Pending
- [~] In progress
- [!] Blocked (the reason and required follow-up must be recorded)

## 0. Context and repository audit

- [x] Read the root `AGENTS.md` instructions completely.
- [x] Read `CODEBASE_CONTEXT.md` completely and use its Ride feature map and
  change matrix.
- [x] Read `RIDE_HAILING_CONTEXT.md` and all project-owned Markdown files
  (excluding dependency, generated, cache, and storage trees).
- [x] Read `ride_map_markers_laravel_requirements.md` completely.
- [x] Audit the current customer, Captain, admin, route, realtime, eligibility,
  cancellation, migration, test, and API-documentation surfaces.
- [x] Confirm the current baseline: anonymous nearby markers exist without
  heading; assigned-trip location telemetry exists; Ride cancellation is
  free-text; no Captain-to-pickup route cache exists.

## 1. Anonymous nearby Captain marker heading

- [x] Define a backward-compatible telemetry source and reliability rules for
  heading (normalization, freshness, accuracy, and stationary filtering).
- [x] Persist optional Captain heading/speed/accuracy for availability updates
  without making existing Captain clients fail validation.
- [x] Add nullable `heading` to each privacy-rounded nearby marker.
- [x] Preserve zone/category/vehicle/activity/conflict eligibility, configured
  marker limit, response throttling, and privacy restrictions.
- [x] Add tests for normalized reliable heading and null heading for missing,
  stale, inaccurate, and stationary telemetry.
- [x] Add privacy regression assertions proving no Captain identity, vehicle,
  exact coordinate, token, or private channel is exposed.

## 2. Actor-scoped Ride cancellation reasons

- [x] Add the Ride-specific cancellation reason data model, migration, stable
  code, actor scope, lifecycle scope, status, display order, and translations.
- [x] Canonicalize actors to `customer`, `captain`, and `admin`; map legacy
  `user` to `customer` only at compatibility boundaries.
- [x] Add the customer cancellation-reasons endpoint with localization and
  lifecycle filtering.
- [x] Require and validate `cancellation_reason_id` for customer cancellation.
- [x] Apply equivalent actor/lifecycle validation to Captain and admin Ride
  cancellation flows.
- [x] Snapshot reason ID, code, localized text, and actor on the Ride while
  preserving cancellation charge, locking, history, notification, and
  post-commit realtime behavior.
- [x] Return the structured `cancellation_reason` object and `cancelled_by` in
  owned Ride responses.
- [x] Add/administer Ride cancellation reasons through the appropriate admin
  surface without coupling them to commerce or parcel reasons.
- [~] Add tests for active/inactive, actor, lifecycle, localization, ordering,
  searching/assigned states, fees, and response snapshots.

## 3. Assigned Captain-to-pickup road route

- [x] Add nullable cached Captain-to-pickup route fields and model casts.
- [x] Implement an ownership- and lifecycle-aware route cache service using the
  configured server road-routing provider.
- [x] Refresh when Captain movement reaches the configured threshold or cache
  age expires; otherwise reuse the cached route.
- [x] Expose `captain_pickup_route` only for `rider_selected`,
  `captain_arriving`, and `arrived` owned Ride detail responses.
- [x] Omit/clear the route for `in_progress`, cancelled, and completed rides.
- [x] Keep the existing pickup-to-destination `route_polyline` unchanged.
- [~] Add tests for ownership, lifecycle, polyline payload, movement threshold,
  time threshold, cache reuse, and provider failure handling.

## 4. Realtime and REST reconciliation

- [x] Verify Captain location writes commit before `ride.location.updated` is
  published and include the latest safe telemetry.
- [x] Ensure owned Ride detail remains authoritative for the newest location
  and cached Captain-to-pickup route.
- [x] Verify status events publish after transaction commit.
- [x] Audit negotiation events so only eligible recipients receive updates and
  REST refresh remains authoritative.
- [x] Reconcile the documented nearby category parameter with the active
  `ride_category_id` contract without breaking existing clients.
- [~] Add focused realtime and response-contract regression tests.

## 5. API documentation and repository context

- [x] Create or update dedicated mobile API specifications under `docs/api/`
  covering authentication, headers, fields, examples, errors, screens,
  security, privacy, throttling, and backend files.
- [x] Add/update the specification entry in `docs/api/README.md`.
- [x] Update `CODEBASE_CONTEXT.md` for every new model, migration, service,
  route, admin surface, event contract, and cross-cutting workflow.
- [x] Reconcile older Ride documents where their contracts conflict with the
  implemented API.

## 6. Verification and handoff

- [ ] Run PHP syntax checks on every changed PHP file.
- [ ] Run focused marker, cancellation, route-cache, and realtime tests.
- [ ] Run the complete Ride test group/filter.
- [ ] Record any environment-caused skips or blockers with exact evidence.
- [ ] Manually verify nearby markers, all three cancellation actors, assigned
  pickup routing, lifecycle clearing, and private realtime behavior against a
  configured database and route provider.
- [ ] Review the final diff for unrelated changes, privacy leaks, unsafe root
  PHP usage, and documentation drift.

## Progress log

### 2026-08-23

- Completed the full Markdown/context pass and mapped the requirements to the
  active Laravel implementation.
- Started Phase 1. The current nearby response rounds coordinates and limits
  markers, but `delivery_histories` does not yet carry the optional reliability
  telemetry needed to expose heading safely.
- Confirmed the existing assigned-Ride telemetry fields must not be reused for
  anonymous pre-assignment markers because they belong to a specific Ride.
- Added optional telemetry columns to the shared Captain location heartbeat.
  Existing clients can continue sending only latitude, longitude, and location.
- Nearby markers now contain privacy-rounded coordinates and a nullable,
  normalized heading. Heading is hidden when older than 60 seconds, less
  accurate than 100 metres, slower than 0.5 m/s, or incomplete.
- Verification: all changed PHP files pass `php -l`; the focused marker tests
  pass (5 tests, 5 assertions); `php artisan test --filter=Ride` passes 37 tests
  and 93 assertions. Nine pre-existing database-backed tests remain skipped
  because this PHP runtime does not have `pdo_sqlite`.
- Completed Phase 1's explicit exact-key privacy assertion. The anonymous
  marker formatter returns only `latitude`, `longitude`, and nullable
  `heading`, even if its telemetry source contains identity/private fields.
- Started Phase 2 with a Ride-specific reason table and localized model,
  canonical actor/lifecycle resolution, default actor-scoped reasons, and
  immutable Ride snapshot columns.
- Customer and Captain reason-list endpoints now filter active definitions by
  actor and requested Ride status. Customer, Captain, and admin cancellation
  now require a numeric reason ID, resolve it under the Ride transaction lock,
  reject mismatches with validation errors, and preserve the existing fee,
  history, notification, and realtime flow.
- Structured cancellation snapshots and legacy free-text response fallbacks
  are covered by unit tests. Current Ride verification passes 42 tests and 103
  assertions; the same nine database-backed tests are skipped for missing
  `pdo_sqlite`.
- Added the Ride admin cancellation-reason screen and sidebar entry. Admins can
  configure localized titles, immutable reporting codes, actor/lifecycle
  scopes, order, and active status. Deleting a definition leaves snapshots on
  historical Rides intact.
- Added isolated feature coverage for active/actor/lifecycle filtering,
  ordering, invalid resolution, and localization. It uses the repository's
  established SQLite-isolation pattern and will skip on this runtime until
  `pdo_sqlite` is installed.
- `php artisan view:cache` succeeds. `php artisan route:list` is blocked by an
  unrelated existing missing `Modules\\AI\\app\\Http\\Controllers\\AIController`
  class, not by a Ride route.
- Added transaction-level cancellation coverage for missing IDs returning
  HTTP 422, searching cancellation snapshots without a fee, and assigned
  customer cancellation preserving the charge, payable amount, Captain
  earning, wallet ledger, and admin-funded expense. These three tests are
  currently environment-skipped with the other SQLite-backed tests.
- Current Ride verification: 42 passing tests, 103 assertions, and 15 skips.
  The increased skip count is entirely the six new cancellation database tests
  awaiting `pdo_sqlite`.
- Started Phase 3 with separate Captain-to-pickup cache columns and a dedicated
  service backed by the configured server route provider. It refreshes after
  75 metres of movement or 15 seconds, reuses a fresh cache, and retains the
  last valid route when the provider is unavailable.
- Customer-owned Ride detail, Captain active/detail responses, assignment, and
  Captain location updates now use `captain_pickup_route`. The payload is
  restricted to assigned pre-trip states, and transition/cancellation clears
  only the approach cache while preserving the booked `route_polyline`.
- Phase 3 unit coverage passes for reuse, movement/staleness thresholds,
  lifecycle visibility, assignment privacy, provider failure, response shape,
  and booked-route preservation. Current Ride verification is 48 tests and 117
  assertions passing, with 15 SQLite-dependent skips.
- Added a database-isolated Phase 3 integration test specifying successful
  route persistence, owner scoping, fresh-cache reuse, movement refresh, and
  preservation of the booked route. It awaits `pdo_sqlite` execution.
- Completed the Phase 4 transaction audit. Existing controller broadcasts were
  already called after their transaction closures; `RideRealtimeService` now
  additionally registers every broadcast with `DB::afterCommit`, preventing
  future callers from exposing rolled-back status, location, offer, discovery,
  or payment state.
- Negotiation refreshes eligibility after commit and sends the request update
  only to the resulting Captain channels plus the owning customer. The active
  nearby query contract remains `ride_category_id`; conflicting older wording
  will be corrected in the API documentation rather than adding an ambiguous
  alias.
- Added isolated tests specifying dispatch-after-commit and no dispatch after
  rollback. Current Ride verification remains 48 passing tests and 117
  assertions; 18 database tests now skip without `pdo_sqlite`.
- Added `docs/api/ride-map-markers-cancellation-routing.md` and registered it in
  the mobile API index. It documents authentication/localization, marker and
  telemetry contracts, both mobile reason-list/cancellation flows, structured
  snapshots, assigned routing, errors, pagination, screens, privacy, realtime,
  and all relevant backend files.
- Updated `CODEBASE_CONTEXT.md` with the new change-matrix entry, migrations,
  models, services, admin surface, cache semantics, after-commit convention,
  and active API contract. Reconciled the older customer marker and trip
  lifecycle documents so they no longer prescribe heading-less markers or
  free-text Ride cancellation.
