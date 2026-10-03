# Ops settings and compatibility

Existing `GET /api/v1/config` remains public and gains an additive `ops` object:

```json
{"ops":{"maintenance_enabled":false,"maintenance_message":null,"minimum_version_android":"0.0.0","minimum_version_ios":"0.0.0","update_url_android":null,"update_url_ios":null,"notification_token_enabled":true}}
```

Ops Flutter prefers this object and falls back to the old root fields against
older backends. Customer/Captain/Vendor config fields are unchanged. Version
policy controls the Ops UI; it is not an API authorization mechanism.

The existing manager-authenticated registration reference endpoint retains its
response shape. `validation_policy` additionally includes `invoice_due_days`,
`maximum_menu_photos`, and `maximum_photo_size_kb`. These are positive integers.
Service IDs/descriptions/default prices/selection retain their existing types.
No pagination or new headers are introduced; use existing Ops Bearer auth and
normal JSON request headers. Validation errors retain existing 422 contracts.

New forms default their due date to today plus the configured days; restored
drafts keep their saved due date. Menu picking follows the remote maximum and
upload/submission limits remain server-authoritative. Previously created
invoices/commission snapshots never change with settings.

Settings are stored in BusinessSetting `ops_admin_settings`; only admins with
settings permission may update them. Changes are audited. No storage paths,
gateway credentials or account secrets are configurable through this page.
Config loading applies policy to HTTP requests and reloads it before queue jobs.

Sources: OpsSettingsService, Admin/OpsSettingsController, ConfigServiceProvider,
Api/V1/ConfigController, OpsRegistrationController, OpsOnboardingSubmissionRequest,
OpsManagerFinanceService, config/ops.php and the Ops settings Blade page.
