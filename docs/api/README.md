# Mobile API Documentation

This directory contains mobile-facing API contracts that follow the repository's
current `docs/api/` documentation convention.

## Available specifications

| Feature | Document | Status |
|---|---|---|
| Customer home module visibility by zone | [module-visibility.md](module-visibility.md) | Backend implemented |
| Customer Ride experience enrichment, ratings, history filters and telemetry | [ride-customer-experience-enhancements.md](ride-customer-experience-enhancements.md) | P0 implemented; P1/P2 in progress |
| Ride map markers, actor-scoped cancellation and assigned pickup routing | [ride-map-markers-cancellation-routing.md](ride-map-markers-cancellation-routing.md) | Backend implemented; database/manual verification pending |
| Rider operational zone, nearest-first dispatch and request viewers | [rider-operational-zone-and-dispatch.md](rider-operational-zone-and-dispatch.md) | GPS zone, commerce waves, zone-independent Ride waves and privacy-limited viewer acknowledgements implemented; runtime verification pending |
| Nearest-first production rollout and verification | [nearest-first-dispatch-rollout.md](nearest-first-dispatch-rollout.md) | Deployment health check implemented; live verification pending |
| Ride-scoped customer/Captain chat | [ride-chat.md](ride-chat.md) | Source implemented; migration, Firebase and two-device verification pending |
| Captain Ride history and financial details | [captain-ride-history.md](captain-ride-history.md) | Source implemented; authenticated API verification pending |
| Rejected Captain Ride vehicle correction and resubmission | [ride-vehicle-resubmission.md](ride-vehicle-resubmission.md) | Source implemented; authenticated API/device verification pending |

The older specifications currently stored under `docs/ap/` remain valid until
they are migrated as a separate documentation cleanup.
# Ops configuration

See [Ops settings and compatibility](ops-settings.md) for the additive Ops config
object, registration policy fields and admin settings behavior.
