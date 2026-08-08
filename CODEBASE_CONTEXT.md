# Zaqoota Codebase Context

> Living map for future feature work. Read this file before deciding where a
> change belongs, then verify the named route/controller/model because this
> application is actively evolving.

## 1. What this project is

Zaqoota is a modular, multi-business marketplace backend and administration
application built on Laravel 12 and PHP 8.2+. It serves:

- a public website and payment return/callback pages;
- a super-admin web panel;
- a vendor/store web panel;
- REST APIs for customer, vendor, and delivery-man applications;
- pluggable business modules (food/grocery/e-commerce/pharmacy/parcel through
  the core `Module` model and module middleware);
- separate AI product-entry, vehicle-rental, and tax/VAT modules.

The repository is server-rendered Laravel/Blade with Laravel Mix assets. It is
not the source of the customer mobile or React frontend, but it exposes the APIs
and configuration those clients consume.

## 2. Runtime and important dependencies

- Backend: Laravel 12, PHP `^8.2|^8.3|^8.4`, Eloquent, Passport.
- Modules: `nwidart/laravel-modules`; enabled state is in
  `modules_statuses.json`.
- Frontend assets: Laravel Mix 6, Axios, Lodash, Laravel Echo, Pusher JS.
- Realtime: Laravel Reverb/Pusher-compatible broadcasting.
- AI: `openai-php/laravel`; module engine abstraction lives under
  `Modules/AI/app/Core`.
- Push/auth infrastructure: Firebase Admin SDK and Firebase service worker.
- Media/storage: local/S3 Flysystem and Intervention Image.
- Export/documents: Laravel Excel, FastExcel, mPDF, ZIP.
- Messaging: Twilio plus configurable SMS/email helpers.
- Payments: core controllers for Stripe, PayPal, Razorpay, SSLCommerz, bKash,
  Paystack, Paytm, Flutterwave, Mercado Pago, Paymob, Paytabs, LiqPay,
  SenangPay, AssanPay, Iyzico, PhonePe, Xendit, and optional gateway addons.

Primary configuration is in `config/`, runtime secrets are in `.env`, and safe
variable examples belong in `.env.example`. Never put secret values in this
document or commit `.env`.

## 3. Bootstrap and route loading

`bootstrap/app.php` defines the global/web/api middleware stacks and aliases.
`App\Providers\RouteServiceProvider` loads the core routes:

| Surface | URL prefix | Route file |
|---|---|---|
| Public/payment web | none | `routes/web.php` |
| Admin panel | `/admin` | `routes/admin.php` |
| Additional admin CRUD | `/admin` | `routes/admin/routes.php` |
| Vendor panel | `/vendor-panel` | `routes/vendor.php` |
| REST API v1 | `/api/v1` | `routes/api/v1/api.php` |
| REST API v2 | `/api/v2` | `routes/api/v2/api.php` |
| Installation/update | conditional provider loading | `routes/install.php`, `routes/update.php` |

Module service providers load their own files:

| Module | Main route files |
|---|---|
| AI | `Modules/AI/routes/web.php`, `routes/admin/routes.php`, `routes/api/v1/api.php` |
| Rental | `Modules/Rental/Routes/web/admin/admin.php`, `web/vendor/routes.php`, `api/v1/provider/api.php` |
| Tax/VAT | `Modules/TaxModule/Routes/web.php`, `Routes/api/v1/api.php` |

Important middleware aliases:

- `admin`, `vendor`: panel authentication/authorization.
- `auth:api`: Passport customer authentication.
- `vendor.api`, `dm.api`: vendor and delivery-man token validation.
- `apiGuestCheck`: permits the customer/guest API behavior used by cart/order
  flows.
- `module:<permission>`: admin/vendor feature permission.
- `subscription:<feature>`: vendor subscription entitlement.
- `module-check`, `current-module`: active business-module context.
- `actch[:client]`: activation/license checks.
- `localization`: API locale selection.
- `admin-rental-module`, `provider-rental-module`: rental panel guards.

When adding a route, put it in the route file for the consuming client. Match
the surrounding prefix, name, authentication, permission, subscription, and
module-context middleware.

Route names must be globally unique so `php artisan route:cache` and
`php artisan optimize` can serialize the route collection. When GET and POST
share one form URL, keep the GET route named for links/form URL generation and
leave the POST route unnamed unless it has a distinct route name and consumers.

## 4. Core source layout

| Path | Responsibility |
|---|---|
| `app/Http/Controllers/Admin` | Admin panel orchestration and views |
| `app/Http/Controllers/Vendor` | Store/vendor panel orchestration and views |
| `app/Http/Controllers/Api/V1` | Customer/public/delivery-man REST endpoints |
| `app/Http/Controllers/Api/V1/Vendor` | Vendor application REST endpoints |
| `app/Http/Controllers/Api/V1/Auth` | Customer, vendor, social, and delivery-man auth/password flows |
| `app/Http/Controllers` | Public site, login, payment, install/update controllers |
| `app/Models` | Core Eloquent entities and relationships |
| `app/Services` | Reusable business operations for newer CRUD features |
| `app/Repositories` | Persistence/query layer used by the service-based CRUD code |
| `app/Contracts` | Service/repository contracts |
| `app/CentralLogics` | Older cross-cutting business logic (orders, products, stores, coupons, SMS, files, helpers) |
| `app/Traits` | Shared behavior, addon helpers, uploads, translations, etc. |
| `app/Rules` | Request validation rules |
| `app/Events`, `app/Listeners`, `app/Jobs` | Realtime location/message work and queued jobs |
| `app/Exports` | Excel/FastExcel export implementations |
| `resources/views` | Core public/admin/vendor Blade templates |
| `resources/js`, `resources/css` | Source assets compiled by Mix |
| `public/assets` | Published/static browser assets; prefer editing source assets when available |
| `database/migrations` | Core schema history |
| `database/seeders` | Initial/default data |
| `database/factories` | Test factories |
| `resources/lang` | Core translations |
| `tests` | Very small current automated-test suite |

### Existing service/repository pattern

Newer CRUD domains use contracts + repository + service, including addon,
attribute, banner, brand, cashback, category, common condition, coupon, custom
role, delivery man, vehicle, employee, module, notification, unit, wallet
bonus, and zone.

For a change inside one of these domains, extend its existing controller,
service, repository, contract, request/rule, model, and view/API response rather
than placing query logic directly in another controller. Older, large domains
such as orders/items/stores still rely heavily on controllers and
`app/CentralLogics`; follow the local pattern unless the task explicitly
includes a refactor.

## 5. Feature map: where future changes belong

### Catalog and discovery

Includes modules, categories, brands, attributes, units, addons, items/products,
generic names, nutrition, tags, allergies, common conditions, search, recent
searches, flash sales, and module-specific item detail records.

- Admin routes: `routes/admin.php` (`item`) and `routes/admin/routes.php`
  (`category`, `brand`, `attribute`, `unit`, `addon`, `common-condition`).
- Vendor routes: `routes/vendor.php` (`category`, `item`, `addon`).
- API: `routes/api/v1/api.php` (`items`, `categories`, `brand`,
  `common-condition`, search endpoints).
- Controllers: `Admin/ItemController`, corresponding admin CRUD controllers,
  `Vendor/ItemController`, and `Api/V1/ItemController`,
  `CategoryController`, `BrandController`, `SearchController`.
- Models: `Item`, `Category`, `Brand`, `Attribute`, `Unit`, `AddOn`,
  `AddonCategory`, `GenericName`, nutrition/tag/allergy join models,
  `EcommerceItemDetails`, `PharmacyItemDetails`.
- Shared logic: `ProductLogic`, `CategoryLogic`, `FileManagerLogic`.

Any new item field usually requires: migration, `Item` fill/cast/relationship
updates, admin and vendor forms, both admin/vendor save/update paths, API
serialization in item endpoints, validation, translations, and import/export
column handling.

### Stores, vendors, employees, roles, and subscriptions

- Admin: store/vendor approval, configuration, schedules, employees/roles,
  subscription packages, billing, disbursement, and reports.
- Vendor: dashboard, profile/store settings, employee/role management and
  subscription package workflows.
- APIs: vendor auth and `/api/v1/vendor/...` profile/config/subscription
  endpoints.
- Core models: `Store`, `StoreConfig`, `StoreSchedule`, `Vendor`,
  `VendorEmployee`, `EmployeeRole`, `Admin`, `AdminRole`,
  `SubscriptionPackage`, `SubscriptionTransaction`,
  `SubscriptionBillingAndRefundHistory`, `StoreSubscription`.
- Cross-cutting guards: `module:*` permissions and `subscription:*`
  entitlements.

### Customers, loyalty, wallet, and identity

- Admin routes: customer management, wallet adjustments, loyalty reports,
  account deletion requests and contacts.
- API: auth/social auth/password reset, customer profile, address, wishlist,
  loyalty points, wallet, notifications, account removal.
- Models: `User`, `UserInfo`, `CustomerAddress`, `Wishlist`,
  `LoyaltyPointTransaction`, `WalletTransaction`, `WalletPayment`,
  `WalletBonus`, verification/reset models, `AccountDeletionRequest`.
- Controllers: `Api/V1/Auth/*`, `Api/V1/CustomerController`,
  `WalletController`, `LoyaltyPointController`, `WishlistController`.

Changes to authentication must also check Passport guards, verification
settings, Firebase/social-login settings, and every client-specific auth
controller.

### Cart, checkout, orders, delivery, refunds, and parcels

- API groups: `customer`, `cart`, `order`; guest/customer behavior is mediated
  by `apiGuestCheck`.
- Admin: order queues/details/status, dispatch, refunds, cancellation reasons,
  parcels, delivery-man assignment and earnings.
- Vendor: POS, order lifecycle, delivery-man operations.
- Models: `Cart`, `Order`, `OrderDetail`, `OrderPayment`, `OrderTransaction`,
  `OrderDeliveryHistory`, `OrderCancelReason`, `Refund`, `RefundReason`,
  parcel cancellation/category/instruction models.
- Controllers: `Api/V1/CartController`, `OrderController`,
  `DeliverymanController`; admin/vendor `OrderController`, `POSController`.
- Shared logic: `OrderLogic`, `ProductLogic`, `StoreLogic`, `CouponLogic`.

Order changes are high fan-out. Check pricing calculations, tax, coupon,
cashback, wallet/partial payment, offline/gateway payment, stock, delivery fee,
status history, notifications, invoices, admin/vendor/customer responses, and
reports/exports.

### Promotions and content

Includes banners, module-wise banners, campaigns, coupons, cashback, ads,
notifications, newsletters, testimonials, promotional banners and home-page
content.

- Admin route groups: `banner`, `promotional-banner`, `campaign`, `coupon`,
  `cashback`, `advertisement`, `notification`, `marketing`.
- Vendor: banner, campaign, coupon, advertisement.
- Public/customer API: banners, other banners, campaigns, flash sales, coupons,
  cashback, ads, notifications, testimonials.
- Models/controllers/services generally share the domain name.

### Delivery men, vehicles, location, and earnings

Core delivery features use `DeliveryMan`, `DMVehicle`, wallets/ledgers,
reviews, bonuses/milestones, tracking and earnings models. Admin/vendor/API
controllers each expose their relevant lifecycle.

Fleet management is part of the core delivery context:

- `FleetManager` is a separate login role, scoped to one or more `Zone`
  records through `fleet_manager_zone`.
- `DeliveryMan.fleet_manager_id` is the current assignment;
  `FleetManagerRiderAssignment` is the immutable assignment/transfer history.
- Admin management lives under
  `/admin/users/delivery-man/fleet-manager/...` and
  `Admin/DeliveryMan/FleetManagerController`.
- The existing delivery-man login returns `account_type` (`rider` or
  `fleet_manager`). Fleet-manager app APIs live at `/api/v1/fleet-manager`
  and are guarded by `fleet-manager.api`.
- Rider profile responses expose the current fleet manager.
- Rider cash due remains `DeliveryManWallet.collected_cash`. Fleet managers can
  see due riders and contact them, but cannot submit payments or mutate wallet
  balances. Riders pay the company bank account through the existing verified
  payment workflow.
- Admin Rider Payables is a filtered manager-accountability page. Each manager
  links to a dedicated assigned-rider list with live payable balances, contact
  details, rider profiles, and unassignment controls.
- Fleet-manager commission is configured per manager and snapshotted per
  completed order in `FleetManagerEarningTransaction`. The amount is calculated
  from the delivery-value base and capped by the admin delivery-commission
  amount. Only customer-paid deliveries with positive admin delivery commission
  qualify; admin- and vendor-sponsored free delivery do not create a fleet
  earning transaction. This exclusion does not change the existing rider/admin
  delivery percentage: rider earnings still use the preserved original delivery
  value minus the configured admin delivery commission. `FleetManagerWallet`
  tracks earned, pending-withdrawal, withdrawn, and available balances.
- `OrderTransaction.fleet_manager_commission` stores the fleet payout allocated
  to that order. Gross `admin_commission` remains unchanged for refund/audit
  compatibility; admin dashboards and financial reports subtract the fleet
  payout to show net admin earnings.
- The manager report is available from Fleet Managers > Report and from
  Transactions & Reports > Fleet Manager Reports. It includes searchable,
  date/status-filtered order earning transactions plus wallet and rider payable
  summaries.
- The backend supports manager-owned payout details from shared
  `WithdrawalMethod` templates and `FleetManagerWithdrawalRequest` records.
  The minimal mobile panel treats saved payout methods as read-only and exposes
  only withdrawal submission; admin/back office must provision a method first.
  Admin review lives in Transactions & Reports; approval/rejection moves the
  reserved wallet balance atomically.

Current fleet-manager app contract:

| Method | Endpoint | Purpose |
|---|---|---|
| POST | `/api/v1/auth/delivery-man/login` | Shared login; branch UI using `account_type` |
| GET | `/api/v1/fleet-manager/profile` | Manager profile, zones and rider count |
| PUT | `/api/v1/fleet-manager/profile` | Update manager-owned profile fields |
| GET | `/api/v1/fleet-manager/dashboard` | Rider availability and current payable totals |
| PUT | `/api/v1/fleet-manager/fcm-token` | Register manager push token |
| GET | `/api/v1/fleet-manager/earnings` | Paginated commission earnings and wallet summary |
| GET | `/api/v1/fleet-manager/riders` | Assigned riders; supports search and `due_only` |
| GET | `/api/v1/fleet-manager/riders/{id}` | Scoped rider operational details |
| GET | `/api/v1/fleet-manager/withdrawal-method-templates` | Active admin payout templates |
| GET/POST | `/api/v1/fleet-manager/withdrawal-methods` | List or save manager payout methods |
| PUT/DELETE | `/api/v1/fleet-manager/withdrawal-methods/{id}` | Update/delete an owned payout method |
| PUT | `/api/v1/fleet-manager/withdrawal-methods/{id}/default` | Set the default payout method |
| GET/POST | `/api/v1/fleet-manager/withdrawals` | List or submit withdrawal requests |

Fleet-manager API requests use the login token in `token`, a Bearer token, or
the `token` header, matching the existing delivery-man token convention.

Realtime location uses:

- `app/Events/DeliveryLocationUpdated.php`;
- `app/Jobs/DispatchDriverLocationJob.php`;
- `app/Listeners/HandleClientMessage.php`;
- `routes/channels.php`;
- broadcasting/Reverb configuration and the Echo client setup.

Do not confuse core delivery vehicles with rental vehicles; rental entities and
routes live entirely in `Modules/Rental`.

### Finance, wallets, withdrawals, disbursement, and reporting

Core models include account/store/admin/delivery-man wallets, transactions,
expenses, withdrawals, disbursements, payment requests, and order
transactions. Admin routes contain account transactions, store/DM
disbursements, withdrawals, tax reports, and general reports; vendor routes
contain wallet, withdrawal methods, and reports.

A monetary change must preserve decimal/currency handling and ledger symmetry.
Update transaction creation, balance mutation, reports, exports, invoices, and
refund/reversal paths together.

Admin-created onboarding invoices are a standalone receivables workflow under
`/admin/transactions/onboarding-invoices`; they do not mutate order,
subscription, wallet, commission, expense, or disbursement ledgers.
`OnboardingInvoice` stores the selected active non-Rental module and store IDs
plus immutable module/store/owner/email/address snapshots, optional additional
recipient emails, the generating admin's display-name snapshot, invoice
number/type/date,
due date, amount, payment state, and email-delivery audit fields. The create
form loads active modules directly but discovers stores through the paginated
`onboarding-invoices/stores` Select2 endpoint after a module is chosen, so it
never loads all stores into one dropdown and does not hide temporarily closed
or disabled stores from historical billing. Admins can create only
or create-and-send; invoice numbers are generated atomically from `ZQ-0040`.
Selecting a store copies its saved email into the editable additional-recipient
field. Admins can view the saved invoice, download its shared mPDF document,
retry email delivery, and change paid/unpaid status. Dashboard summaries track
the total invoiced, paid, and unpaid amounts plus collection progress. The
first transition from
unpaid to paid automatically emails a paid PDF copy to the snapshotted store
email. The invoice identifies the restaurant owner in the bill-to section and
shows the generating admin as a `Generated by` tag in place of the deferred
authorized signature. Mail/PDF generation is implemented by `OnboardingInvoiceMail` and
`resources/views/{email-templates,admin-views/onboarding-invoice}`; authorized
signature support is intentionally deferred.
- Issued invoices support normalized `OnboardingInvoiceItem` charge rows,
  public PDF notes, private admin notes, payment method/reference/actor data,
  computed unpaid/due-soon/overdue/paid/void presentation states, and voiding
  with a mandatory reason. Void invoices are retained for audit, cannot be sent
  or updated financially, and are excluded from receivable totals.
- New onboarding invoices start with three concise, removable lines: partner
  account onboarding; store profile and menu configuration; and delivery-zone
  setup with initial technical support. The form can add blank custom rows or
  presets for photography, video, menu/data/design, promotion, training,
  support, featured placement, integration and other services. All descriptions,
  quantities and prices remain editable before issue.
- The primary snapshotted store email cannot be removed. Additional recipients
  can be added or removed after creation and selected for invoice resends.
  Unpaid invoices support payment reminders with a repeat guard. Every
  per-recipient send attempt is stored in `OnboardingInvoiceDelivery`, including
  delivery type, success/failure, error and acting admin. Creation, recipient,
  delivery, reminder, payment and void actions append immutable
  `OnboardingInvoiceEvent` timeline records.
- Unpaid, non-void invoices show configurable bank-transfer instructions in the
  admin detail, HTML mail and attached PDF. Defaults are stored as
  `BusinessSetting` keys (`onboarding_invoice_bank_name`,
  `onboarding_invoice_account_title`, `onboarding_invoice_iban`, and
  `onboarding_invoice_account_number`) and can be edited above the invoice
  history. Paid and void invoices suppress the transfer instructions.

Order commission reporting convention:

- `OrderTransaction.admin_commission` is the authoritative gross admin result
  stored for an order. At transaction creation it already includes product/store
  commission, delivery commission and applicable additional charges, and already
  deducts admin-funded free delivery, coupons, referral bonuses and discounts.
- `OrderTransaction.delivery_fee_comission` and `admin_expense` are breakdown
  fields for presentation and reconciliation. Do not add the delivery field to,
  or subtract the expense field from, `admin_commission` again when calculating
  total admin earnings.
- Net admin earnings are `admin_commission - fleet_manager_commission`, matching
  `OrderTransaction::NET_ADMIN_COMMISSION_SQL` and the `net_admin_commission`
  accessor. Store Sales Report totals and exports follow this convention.
- For admin-sponsored free delivery, the customer-facing delivery charge is
  zero, the original rider/admin percentage split remains intact, the original
  delivery value is recorded as an admin free-delivery expense, and no fleet
  manager commission is created.

### Business settings and integrations

- Admin settings: `routes/admin.php` and `Admin/BusinessSettingsController`,
  `ExternalConfigurationController`, `SMSModuleController`,
  `OfflinePaymentMethodController`.
- System Addons are managed at `/admin/business-settings/system-addon` by
  `Admin/System/AddonController`; the legacy `/admin/addon/system-addons`
  shortcut redirects to that canonical route. Addon discovery and `Addon/info.php`
  loading must use `base_path('Modules/...')` because the web-server working
  directory is not guaranteed to be the Laravel project root.
- Rental is considered active on the System Addons page only when its
  `Addon/info.php` published flag, `modules_statuses.json` entry, and core
  `Module` database row are all active. Activation updates those sources
  together and must surface migration or persistence failures instead of
  displaying a false success state. It clears the serialized route cache after
  changing module status so the next request loads the Rental route surface.
  Because upload, activation and deletion modify deployed module files, the PHP
  web-server user needs write access to `Modules/` and `modules_statuses.json`;
  keep that access narrowly scoped rather than making the application tree
  world-writable.
- Rental is addon-owned and is therefore intentionally excluded from the
  `/admin/business-settings/module/store` manual module-type choices. Successful
  addon activation creates/enables its core `Module` row; it appears on the
  Business Module List at `/admin/business-settings/module`. Shared
  `addon_published_status()` checks must resolve addon metadata with `base_path()`
  so PHP-FPM working-directory differences do not hide Rental.
- Stored settings: `BusinessSetting`, `Setting`, `ExternalConfiguration`,
  `MailConfig`, `NotificationSetting`, `DataSetting`, `AnalyticScript`,
  `SocialMedia`, and related models.
- All core Admin, Store, Delivery Man, and Customer email templates use the unified
  Zaqoota recipient layout in
  `resources/views/email-templates/new-email-format-12.blade.php`, regardless
  of an older saved theme number. Rental email themes retain their existing
  layouts. Core action buttons are controlled per
  `EmailTemplate` by `button_enabled` and render only when a valid dynamic or
  configured URL exists; URLs are never printed as email text. Empty
  generated-link placeholders, the legacy per-template icon, and fallback
  icon/banner assets must not be sent. The teal header renders `ZAQOOTA` as
  white text rather than a remote logo or CSS-filtered image, ensuring reliable
  rendering across email clients. The compact footer retains enabled policy,
  contact, social, footer-text, and copyright settings.
- Core template titles and bodies are branded for Zaqoota by
  `2026_08_07_000001_brand_email_templates_for_zaqoota.php`. The migration
  covers current and optional Admin, Store, Delivery Man, and Customer events,
  sets the shared support/footer copy, and uses only placeholders supported by
  `Helpers::text_variable_data_format`: `{userName}`, `{storeName}`,
  `{deliveryManName}`, `{orderId}`, `{transactionId}`, and where applicable
  `{advertisementId}`. OTP values remain separate mail view data (`$code`) and
  must not be hard-coded into editable body copy. The Admin preview displays
  `123456` only as a visual sample for actual OTP template types; sent mail
  renders the real `$code`. Store-approval mail uses the optional action button
  labeled `Sign in to Partner Panel` with
  `https://zaqoota.com/login/vendor`; do not restore the legacy 6amMart URL.
  Store registration, approval, and denial dispatchers must pass the canonical
  `Store::name` into `{storeName}`, never the vendor owner's first/last name.
  The Registration and Approval editor pages expose button label and absolute
  URL fields whenever their action-button toggle is enabled; the preview button
  remains in the DOM for live toggling, and delivered buttons render after all
  body content and immediately before the footer. Migration
  `2026_08_08_000001_fix_store_registration_email_content.php` removes the
  legacy approval instructions and obsolete `body_2` content from deployed
  databases.
  Every core Admin, Store, Delivery Man, and Customer template editor includes
  a shared test-email panel below its preview. It posts to the authenticated,
  rate-limited `admin.business-settings.email-setup.send-test` route, sends the
  currently saved template with safe sample placeholder values (and `123456`
  for OTP templates), prefixes the subject with `[TEST]`, and returns inline
  success/failure feedback. The SMTP connection tester under Third Party
  settings remains separate and does not render a selected template.
- Runtime configuration: `config/*.php` + `.env`/`.env.example`.
- Shared access: `app/Utils/settings.php`, `app/CentralLogics/Helpers.php`.

This application frequently stores settings in the database rather than only
in `.env`. Before adding a new setting, inspect how adjacent settings are
loaded, cached, validated, encrypted/masked, and exposed through the config API.

### Payments

The payment launch/success/fail/cancel contract starts in
`PaymentController` and `routes/web.php`. Gateway controllers are in
`app/Http/Controllers`. Some gateways can be supplied by the optional
`Modules/Gateways` addon; core routes are conditionally registered only when
that addon is not published.

For a gateway change, check:

1. gateway configuration/admin publishing;
2. payment request creation and callback signature verification;
3. CSRF exclusions only for authenticated gateway callbacks;
4. idempotent success/failure handling;
5. order/subscription/rental payment consumers;
6. mobile redirect response contract;
7. refund support and transaction recording.

### Public site, installation, update, and localization

- Public pages/login/invoices: `routes/web.php` and top-level controllers.
- Installation/update: `InstallController`, `UpdateController`,
  `routes/install.php`, `routes/update.php`, and `installation/`.
- Core views: `resources/views`.
- Languages: `resources/lang`, `Translation` model, language admin routes and
  localization middleware.

Every user-facing string should use the existing translation mechanism. Keep
RTL/layout effects in mind.

## 6. Module-specific architecture

### AI product auto-fill (`Modules/AI`)

Purpose: generate product titles, descriptions, general setup, pricing/other
data, SEO fields, and variations, including image analysis.

Flow:

`route -> Admin/API ProductAutoFillController -> Products/Action/ProductAutoFillService -> ProductPrompts/ProductResource -> AIEngineFactory -> AIEngineInterface -> OpenAIEngine -> ProductResponse`

Important files:

- Core provider/routing: `app/Providers/AIServiceProvider.php`,
  `RouteServiceProvider.php`.
- Engine abstraction: `app/Core/Contracts`, `Core/Factory`, `Core/Engines`,
  `Core/Constants`.
- Prompt/schema work: `app/Services/Products/Prompts`,
  `Resource`, `Response`, `Action`.
- Admin endpoints: nine routes under admin product auto-fill.
- Vendor API: `/api/v1/ai/...`, protected by `vendor.api` and activation
  middleware.
- Credentials/timeouts: core `config/openai.php` and environment variables.

Add a new generated field first to the prompt/resource/response contract, then
service parsing, admin and/or API controller response, UI consumer, validation,
and tests. Keep provider-specific behavior behind `AIEngineInterface`.

Note: `Modules/AI/routes/web.php` contains a public `/test-ai` debug route with
a hard-coded remote image. It should not be used as a production integration
point.

### Rental (`Modules/Rental`)

Purpose: vehicle rental marketplace with providers, vehicles, categories,
brands, drivers, carts, bookings/trips, payment, reviews, wishlists, promotions,
conversations, tax reports, dashboards, invoices and exports.

Main entities:

- `Vehicle`, `VehicleBrand`, `VehicleCategory`, `VehicleDriver`,
  `VehicleIdentity`, `VehicleReview`;
- `RentalCart`, `RentalCartUserData`, `RentalWishlish`;
- `Trips`, `TripDetails`, `TripVehicleDetails`, `TripTransaction`,
  `PartialPayment`;
- `RentalEmailTemplate`.

Surfaces:

- Admin: `Routes/web/admin/admin.php` and
  `Http/Controllers/Web/Admin`.
- Provider web: `Routes/web/vendor/routes.php` and
  `Http/Controllers/Web/Provider`.
- Provider/customer/public API: `Routes/api/v1/provider/api.php` and
  `Http/Controllers/Api/{Provider,Public,User}`.
- Views: `Resources/views`; module browser assets: `public/assets`.
- Schema/seed data: `Database/Migrations`, `Database/Seeders`.
- Transactions: `Services/TripTransactionService.php`.

Rental is a separate bounded context: implement rental fields and workflows in
this module, not in core `Item`, `Order`, `Cart`, or `DMVehicle`, unless the
feature explicitly joins the two systems.

### Tax/VAT (`Modules/TaxModule`)

Purpose: configurable taxes, taxable associations, system/vendor tax behavior,
order-tax records, calculation API, exports and reports.

- Entities: `Tax`, `Taxable`, `TaxAdditionalSetup`, `SystemTaxSetup`,
  `OrderTax`.
- Calculation: `Services/CalculateTaxService.php`.
- Shared configuration behavior: `Traits/VatTaxConfiguration.php`.
- Admin: `TaxVatController`, `SystemTaxVatSetupController`,
  `Routes/web.php`, Blade views and JS.
- API: `/api/v1/taxvat/get-taxVat-list` and
  `/api/v1/taxvat/get-calculated-tax`.

Any taxable price change should be checked against this module plus core order
and rental calculations. Persist the exact applied tax on the transaction/order
record rather than relying only on the current tax configuration.

## 7. Database and model conventions

- Core schema changes go in `database/migrations`; module-owned schema changes
  go in that module's `Database/Migrations`.
- Put new relationships, casts, scopes, and fillable/guarded decisions on the
  owning Eloquent model.
- Check model observers in `app/Observers`, global scopes in `app/Scopes`, and
  reusable traits before duplicating behavior.
- Many entities support translations; inspect the model's translation
  relationship/trait and the `Translation` model before adding localized data.
- Many records are filtered by zone, business module, store, or vendor. Preserve
  these tenant/context constraints in new queries.
- Add indexes for new foreign keys and frequent filter/sort columns.
- For production-safe migrations, define upgrade and rollback behavior and do
  not assume existing rows are empty.

## 8. API response and compatibility rules

Before changing an endpoint:

- Identify all clients: customer app, vendor app, delivery-man app, web AJAX,
  rental clients, or third-party callback.
- Preserve existing response keys unless a versioned breaking change is
  intentional.
- Follow the controller's existing paginator/list envelope and error format.
- Validate via Laravel request/rules before business logic.
- Apply locale, active module, zone, store ownership, token guard, activation,
  permission, and subscription checks as appropriate.
- Avoid exposing admin/internal model fields through raw model serialization.
- Update `/api/v1/config` or related configuration endpoints if clients need a
  feature flag or setting.
- Prefer adding to v1 for compatible changes. Use `routes/api/v2/api.php` and a
  v2 controller only for a genuinely incompatible contract.
- Create or update the feature’s mobile specification under `docs/api/` and
  register it in `docs/api/README.md` in the same change.

## 9. UI and asset rules

- Admin Blade: `resources/views/admin-views`.
- Vendor Blade: `resources/views/vendor-views`.
- Public/auth/payment views: adjacent folders under `resources/views`.
- Module views remain under each module's `Resources/views`.
- JavaScript/CSS may be inline in legacy Blade templates or under
  `resources/js`, `resources/css`, and module asset folders.
- `public/assets` contains published output and third-party assets. If an
  editable source exists, change and compile the source rather than hand-editing
  a generated/minified file.
- `webpack.mix.js` is the core build entry; modules may have their own Mix/Vite
  files.

## 10. How to place a new feature

Use this decision sequence:

1. **Choose the bounded context.** Core marketplace, Rental, AI, or Tax/VAT.
2. **Choose consumers.** Admin web, vendor web, public web, customer API, vendor
   API, delivery-man API, or background/realtime.
3. **Start from routes.** Add endpoints to every required surface with matching
   middleware.
4. **Define persistence.** Migration, model fields/casts/relationships, indexes,
   seed/default settings.
5. **Implement business logic once.** Extend an existing service/repository or
   CentralLogic. Keep controllers focused on validation, authorization, calling
   logic, and formatting the response/view.
6. **Wire every presentation.** Blade form/list/detail, AJAX/JS, API response,
   config/feature flag, translation strings.
7. **Cover side effects.** Notifications, events/jobs, transaction ledgers,
   exports, reports, invoices, caches and uploaded files.
8. **Test all roles and states.** Success, validation failure, unauthorized
   access, wrong store/module/zone, inactive/subscription state, empty data, and
   rollback/retry/idempotency.

### Common change matrix

| Feature idea | Minimum places to inspect |
|---|---|
| New item/product field | migration, `Item`, admin+vendor controllers/forms, API item response, validation, import/export, translations, AI auto-fill if generatable |
| New order state/action | `Order` models, API/admin/vendor order controllers, `OrderLogic`, histories, stock/payment/refund effects, notifications, reports |
| New vendor capability | admin permission setup, vendor web route/controller/view, vendor API if app needs it, `module` and `subscription` middleware |
| New customer setting | migration/default seed or `BusinessSetting`, admin settings UI/controller, helper/cache lookup, config API |
| New promotion | admin/vendor CRUD, eligibility logic, customer discovery API, cart/order application, history/reporting |
| New payment gateway | config/settings, gateway controller/routes, callback verification, payment request/order transaction, refunds, redirects |
| New rental feature | module migration/entity, admin/provider/user routes and controllers, module views/API, trip transaction/report impacts |
| New tax rule | TaxModule entity/config/calculation/API, core order pricing, rental pricing, persisted order tax, invoice/report/export |
| New AI-generated field | AI prompt/resource/response/service, admin/API controllers, target product form/model validation |
| New realtime event | event/channel authorization, broadcaster config, job/listener, Echo client subscriber, retry/failure handling |
| New fleet-manager capability | manager zone scope and capacity, assignment history, rider profile contract, fleet-manager API permission, admin audit trail, due-recovery effects |
| New ride-hailing capability | core `ride_hailing` module registration, dedicated admin setup/sidebar, then separately define vehicles, drivers, fares, trips, booking API, payments, safety, dispatch, notifications, and reports |

### Ride Hailing foundation

Ride Hailing is registered as the core module type `ride_hailing`. It is not a
store/item/order commerce module and is not part of the Rental addon. The
registration migration is
`database/migrations/2026_08_08_000007_register_ride_hailing_module.php`; it
creates the active module row only when that module type does not already exist
and seeds its initial business-setting keys.

The initial admin surface is intentionally limited to platform setup:

- Routes: `GET|PUT admin/ride-hailing/setup`, named
  `admin.ride-hailing.setup` and `.setup.update`.
- Controller:
  `App\Http\Controllers\Admin\RideHailing\RideHailingSettingController`.
- View: `resources/views/admin-views/ride-hailing/settings.blade.php`.
- Navigation:
  `resources/views/layouts/admin/partials/_sidebar_ride_hailing.blade.php`.
- Settings: service name, distance unit, support email, and support phone in
  `business_settings` using the `ride_hailing_*` prefix.

Selecting the module redirects the generic admin dashboard to this setup page,
preventing the incomplete module from falling through to commerce dashboards.
The `Module::commerce()` scope excludes both Rental and Ride Hailing from
store-based workflows such as onboarding invoice store selection.
`Module::discoverable()` excludes Ride Hailing from existing customer module
and config APIs until its mobile booking contract exists.

No customer/driver mobile API, vehicle, fare, trip, dispatch, payment, safety,
notification, or reporting behavior exists at this stage. Those contracts must
be designed and documented under `docs/api/` when mobile-facing development
begins.

## 11. Verification commands

Dependencies are not currently present in this backup (`vendor/autoload.php` is
missing), so Artisan/PHPUnit cannot run until Composer dependencies are
installed.

After dependencies are available, use:

```text
composer install
php artisan optimize:clear
php artisan route:list
php artisan test
php artisan migrate:status
npm install
npm run development
```

For a focused change, also run PHP syntax checks/Pint on touched PHP files and
exercise the exact admin/vendor/API routes. Do not run migrations against a
production database merely to validate them.

## 12. Known risks and cleanup targets

These findings affect future work and deployment:

- **Critical security concern:** `oAMv1Zx7default.php` and
  `uiXNZJyLdefault.php` are roughly 0.9–1.0 MB, obfuscated PHP files in the
  repository root that suppress errors and construct function names
  dynamically. They do not resemble Laravel application code and should be
  treated as suspected backdoors/malware. Do not execute or include them.
  Quarantine/investigate them and the server history before deployment; rotate
  secrets after confirming compromise. They were documented but not deleted.
- `.env` exists in this backup. Keep it out of Git and never copy its values
  into documentation, tickets, tests, or logs.
- `routes/web.php` contains `/test` and AI has `/test-ai`; debug routes should
  be removed or restricted before production.
- `routes/web.php` contains an empty `Route::post('')` declaration; verify
  intent before modifying nearby routes.
- The default README is mostly Laravel boilerplate and is not an architecture
  guide; this file is the repository-specific source of orientation.
- The automated test suite is extremely small relative to the application.
  High-risk changes need focused tests plus manual API/panel verification.
- Much of the application is legacy controller/CentralLogic code while newer
  areas use services/repositories. Avoid introducing a third pattern.

## 13. Keeping this document accurate

Update this file whenever a change introduces:

- a new module or bounded context;
- a new route surface or API version;
- a new external integration or required environment variable;
- a new cross-cutting business workflow;
- a new service/repository convention;
- a security/deployment constraint;
- a change to the feature placement matrix above.

The route files, migrations, models, and service providers remain the final
source of truth. This document is the map that tells the next developer where
to look first.
