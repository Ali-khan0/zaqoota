# Nearest-first dispatch rollout

Updated 2026-09-27.

## Required production configuration

Nearest-first list visibility and acceptance are enforced by server time. Individual in-app/Firebase notifications for later waves additionally require a durable queue and a continuously supervised worker.

Set one supported asynchronous connection in the deployed `.env`, for example:

```dotenv
QUEUE_CONNECTION=database
```

Do not use `sync` or `null`. The database driver uses the existing `jobs` migration. Redis or another configured Laravel asynchronous driver is also valid.

Run the migration and readiness check:

```bash
php artisan migrate --force
php artisan config:cache
php artisan dispatch:health
```

`dispatch:health` fails when the queue is synchronous, required tables/columns are missing, or business settings are unavailable. It also prints the effective commerce and Ride wave values. It cannot prove that an operating-system worker process is alive.

After deployment, use **Business Settings → Queue Worker / Operations** for the runtime view. The scheduler submits a heartbeat every minute. The page also has a manual heartbeat button, process-level enable switches, a master processing switch, queue totals, per-process metrics and recent failed jobs. A heartbeat older than three minutes is reported as unconfirmed.

## Worker process

Run the default queue continuously under Supervisor, systemd, or the hosting platform's process manager:

```bash
php artisan queue:work --queue=default --sleep=1 --tries=3 --timeout=90
```

Deployments must run `php artisan queue:restart` after the new code and cached configuration are ready. The repository deployment workflow now runs migrations and health checks without suppressing failures, then requests a worker restart.

## Controlled verification

Use at least seven approved, online Captains with fresh GPS timestamps and no conflicting work. Put them at known increasing distances from one pickup.

1. Configure wave size `3`, interval `20`, and freshness `180`.
2. Create an eligible order or Ride and record the server creation/eligible timestamp.
3. Confirm Captains ranked 1–3 see and receive it immediately.
4. Confirm rank 4 cannot accept before 20 seconds and receives `dispatch_wave_pending`.
5. Confirm ranks 4–6 become visible and receive individual notifications after 20 seconds.
6. Confirm rank 7 opens after 40 seconds.
7. Confirm ranks 1–3 remain visible after later waves open but do not receive another request push.
8. Change rider distances across a wave boundary before the next wave; confirm every rider in the cumulative open set is processed and no existing recipient receives another push chain.
9. Accept concurrently from two open-wave Captains and confirm exactly one owner/workload increment.
10. Confirm queued later waves become `superseded` and do not send after assignment or cancellation.
11. Register and log in from outside all active zones; confirm the account has no operational zone but authentication succeeds.
12. Confirm that outside-zone Captain sees no new zone-wise work.
13. Move that Captain into another active zone and confirm new work and Firebase topics follow the new location without logout.
14. Put an otherwise eligible bike Captain beyond the configured module radius; confirm no push, no list visibility and no direct acceptance, then move inside the radius and repeat.

For commerce orders and parcels, inspect the **Nearest-first dispatch monitor** on the admin order-detail page. For passenger Rides, inspect the notification counts on Ride Details. Firebase `accepted` means the provider accepted submission; it does not prove the device displayed or the rider opened the notification.
