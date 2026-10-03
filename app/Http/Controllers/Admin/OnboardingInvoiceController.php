<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OnboardingInvoiceStoreRequest;
use App\Models\BusinessSetting;
use App\Models\Module;
use App\Models\OnboardingInvoice;
use App\Models\OnboardingInvoicePaymentAttempt;
use App\Models\Store;
use App\Services\OnboardingInvoiceCreationService;
use App\Services\OnboardingInvoiceDeliveryService;
use App\Services\OpsOnboardingCheckoutService;
use App\Services\OpsOnboardingApprovalService;
use App\Services\OpsOnboardingPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OnboardingInvoiceController extends Controller
{
    public function __construct(
        private readonly OnboardingInvoiceDeliveryService $deliveryService,
        private readonly OnboardingInvoiceCreationService $invoiceCreationService,
        private readonly OpsOnboardingPaymentService $paymentService,
        private readonly OpsOnboardingCheckoutService $checkoutService,
        private readonly OpsOnboardingApprovalService $approvalService,
    ) {}

    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $totals = OnboardingInvoice::query()
            ->whereNull('voided_at')
            ->selectRaw('COUNT(*) as invoice_count')
            ->selectRaw('COALESCE(SUM(amount), 0) as total_amount')
            ->selectRaw("COALESCE(SUM(CASE WHEN payment_status = 'paid' THEN amount ELSE 0 END), 0) as paid_amount")
            ->selectRaw("COALESCE(SUM(CASE WHEN payment_status = 'unpaid' THEN amount ELSE 0 END), 0) as unpaid_amount")
            ->first();
        $invoices = OnboardingInvoice::query()
            ->when($search !== '', fn ($query) => $query->where(fn ($nested) => $nested
                ->where('invoice_number', 'like', "%{$search}%")
                ->orWhere('store_name', 'like', "%{$search}%")
                ->orWhere('store_email', 'like', "%{$search}%")))
            ->when($request->filled('payment_status'), function ($query) use ($request) {
                match ($request->payment_status) {
                    'paid' => $query->whereNull('voided_at')->where('payment_status', 'paid'),
                    'unpaid' => $query->whereNull('voided_at')->where('payment_status', 'unpaid')->whereDate('due_date', '>=', today()->addDays(8)),
                    'due_soon' => $query->whereNull('voided_at')->where('payment_status', 'unpaid')->whereBetween('due_date', [today(), today()->addDays(7)]),
                    'overdue' => $query->whereNull('voided_at')->where('payment_status', 'unpaid')->whereDate('due_date', '<', today()),
                    'refunded' => $query->whereNull('voided_at')->where('payment_status', OnboardingInvoice::PAYMENT_REFUNDED),
                    'void' => $query->whereNotNull('voided_at'),
                    default => null,
                };
            })
            ->when($request->filled('send_status'), fn ($query) => $query->where('send_status', $request->send_status))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $bankDetails = $this->bankData();

        return view('admin-views.onboarding-invoice.index', compact('invoices', 'totals', 'bankDetails'));
    }

    public function create()
    {
        $modules = Module::query()->active()->commerce()->orderBy('module_name')->get(['id', 'module_name']);
        $invoiceNumber = $this->invoiceCreationService->nextInvoiceNumber();

        return view('admin-views.onboarding-invoice.create', compact('modules', 'invoiceNumber'));
    }

    public function stores(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'module_id' => ['required', 'integer'],
            'q' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $module = Module::query()->active()->commerce()->findOrFail($validated['module_id']);
        $term = trim((string) ($validated['q'] ?? ''));
        $stores = Store::withoutGlobalScopes()
            ->with('vendor:id,f_name,l_name,email')
            ->where('module_id', $module->id)
            ->when($term !== '', fn ($query) => $query->where('name', 'like', "%{$term}%"))
            ->orderBy('name')
            ->paginate(20, ['id', 'vendor_id', 'name', 'email']);

        return response()->json([
            'results' => collect($stores->items())->map(fn (Store $store) => [
                'id' => $store->id,
                'text' => $store->name.($store->email ? " ({$store->email})" : ''),
                'email' => $store->email,
                'owner_name' => trim(($store->vendor?->f_name ?? '').' '.($store->vendor?->l_name ?? '')),
            ]),
            'pagination' => ['more' => $stores->hasMorePages()],
        ]);
    }

    public function bankDetails(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:150'],
            'account_title' => ['required', 'string', 'max:150'],
            'iban' => ['required', 'string', 'max:50'],
            'account_number' => ['required', 'string', 'max:50'],
        ]);
        $keys = [
            'bank_name' => 'onboarding_invoice_bank_name',
            'account_title' => 'onboarding_invoice_account_title',
            'iban' => 'onboarding_invoice_iban',
            'account_number' => 'onboarding_invoice_account_number',
        ];
        foreach ($keys as $field => $key) {
            BusinessSetting::updateOrCreate(['key' => $key], ['value' => trim($validated[$field])]);
        }

        return back()->with('success', translate('Invoice payment details updated successfully.'));
    }

    public function store(OnboardingInvoiceStoreRequest $request): RedirectResponse
    {
        $module = Module::query()->active()->commerce()->findOrFail($request->integer('module_id'));
        $store = Store::withoutGlobalScopes()->with('vendor')->where('module_id', $module->id)->findOrFail($request->integer('store_id'));
        $invoice = DB::transaction(function () use ($request, $module, $store) {
            return $this->invoiceCreationService->create(
                store: $store,
                module: $module,
                items: $request->validated('items'),
                attributes: [
                    'invoice_type' => $request->validated('invoice_type'),
                    'invoice_date' => $request->validated('invoice_date'),
                    'due_date' => $request->validated('due_date'),
                    'public_note' => $request->validated('public_note'),
                    'private_note' => $request->validated('private_note'),
                    'recipient_emails' => $request->recipientEmails(),
                ],
                actor: auth('admin')->user(),
            );
        });

        if ($request->input('submit_action') === 'create_and_send') {
            $this->sendInvoice($invoice, null, 'invoice');
        }

        $mailFailed = $invoice->send_status === OnboardingInvoice::SEND_FAILED;

        return redirect()->route('admin.transactions.onboarding-invoices.show', $invoice)
            ->with($mailFailed ? 'error' : 'success', $mailFailed
                ? translate('Invoice created, but the email could not be sent. You can retry from the invoice page.')
                : translate('Invoice created successfully.'));
    }

    public function show(OnboardingInvoice $onboarding_invoice)
    {
        $onboarding_invoice->load([
            'items', 'paymentVerifier', 'refundVerifier',
            'paymentAttempts' => fn ($query) => $query->with('refundedBy')->latest(),
            'deliveries' => fn ($query) => $query->latest(),
            'events' => fn ($query) => $query->latest(),
        ]);
        $checkoutUrl = $this->checkoutService->urlForInvoice($onboarding_invoice, auth('admin')->user());

        return view('admin-views.onboarding-invoice.show', [
            'invoice' => $onboarding_invoice,
            'bankDetails' => $this->bankData(),
            'checkoutUrl' => $checkoutUrl,
        ]);
    }

    public function download(OnboardingInvoice $onboarding_invoice): Response
    {
        $html = View::make('admin-views.onboarding-invoice.pdf', $this->documentData($onboarding_invoice))->render();
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('tmp'), 'default_font' => 'dejavusans', 'mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Zaqoota-Invoice-'.$onboarding_invoice->invoice_number.'.pdf"',
        ]);
    }

    public function send(OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        abort_if($onboarding_invoice->voided_at, 422, 'A void invoice cannot be sent.');
        $validated = request()->validate(['recipients' => ['nullable', 'array'], 'recipients.*' => ['email']]);
        $this->sendInvoice($onboarding_invoice, $validated['recipients'] ?? null, 'invoice');

        return back()->with($onboarding_invoice->send_status === OnboardingInvoice::SEND_SENT ? 'success' : 'error',
            $onboarding_invoice->send_status === OnboardingInvoice::SEND_SENT
                ? translate('Invoice sent successfully.')
                : translate('Invoice could not be sent. Check the recorded error and mail configuration.'));
    }

    public function remind(Request $request, OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        abort_if($onboarding_invoice->voided_at || $onboarding_invoice->payment_status !== OnboardingInvoice::PAYMENT_UNPAID, 422, 'Only unpaid invoices can receive reminders.');
        if ($onboarding_invoice->last_reminder_at?->gt(now()->subMinutes(5))) {
            return back()->with('error', translate('Please wait before sending another reminder.'));
        }
        $validated = $request->validate(['recipients' => ['nullable', 'array'], 'recipients.*' => ['email']]);
        $this->sendInvoice($onboarding_invoice, $validated['recipients'] ?? null, 'reminder');
        $onboarding_invoice->update(['last_reminder_at' => now()]);
        $this->logEvent($onboarding_invoice, 'reminder_sent', 'Payment reminder sent.');

        return back()->with('success', translate('Payment reminder processed.'));
    }

    public function addRecipient(Request $request, OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        $validated = $request->validate(['email' => ['required', 'email', 'max:255']]);
        $email = strtolower($validated['email']);
        $recipients = collect($onboarding_invoice->recipient_emails ?? [])->push($email)
            ->reject(fn ($item) => strtolower((string) $item) === strtolower((string) $onboarding_invoice->store_email))
            ->unique()->values()->all();
        $onboarding_invoice->update(['recipient_emails' => $recipients]);
        $this->logEvent($onboarding_invoice, 'recipient_added', "Recipient {$email} added.", ['email' => $email]);

        return back()->with('success', translate('Recipient added successfully.'));
    }

    public function removeRecipient(Request $request, OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        $validated = $request->validate(['email' => ['required', 'email']]);
        abort_if(strtolower($validated['email']) === strtolower((string) $onboarding_invoice->store_email), 422, 'The primary store email cannot be removed.');
        $recipients = collect($onboarding_invoice->recipient_emails ?? [])
            ->reject(fn ($email) => strtolower((string) $email) === strtolower($validated['email']))->values()->all();
        $onboarding_invoice->update(['recipient_emails' => $recipients]);
        $this->logEvent($onboarding_invoice, 'recipient_removed', "Recipient {$validated['email']} removed.", ['email' => $validated['email']]);

        return back()->with('success', translate('Recipient removed successfully.'));
    }

    public function paymentStatus(Request $request, OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        abort_if($onboarding_invoice->voided_at, 422, 'A void invoice cannot be updated.');
        $isOpsInvoice = $onboarding_invoice->onboarding_application_id !== null;
        $validated = $request->validate([
            'payment_status' => ['required', 'in:paid,unpaid'],
            'payment_method' => ['nullable', 'required_if:payment_status,paid', 'string', 'max:100'],
            'payment_reference' => [$isOpsInvoice ? 'required_if:payment_status,paid' : 'nullable', 'string', 'max:255'],
            'payment_proof' => [
                $isOpsInvoice && $onboarding_invoice->payment_status !== OnboardingInvoice::PAYMENT_PAID
                    ? 'required_if:payment_status,paid'
                    : 'nullable',
                'file',
                'max:5120',
                'mimetypes:image/jpeg,image/png,application/pdf',
            ],
        ]);
        if ($isOpsInvoice) {
            if ($validated['payment_status'] === OnboardingInvoice::PAYMENT_UNPAID) {
                abort_if(
                    $onboarding_invoice->payment_status === OnboardingInvoice::PAYMENT_PAID,
                    422,
                    'A verified Ops payment cannot be changed back to unpaid. Use the reversal/refund workflow.',
                );

                return back()->with('success', translate('Invoice is already unpaid.'));
            }
            if ($onboarding_invoice->payment_status === OnboardingInvoice::PAYMENT_PAID) {
                return back()->with('success', translate('This onboarding payment was already verified.'));
            }
            $this->paymentService->settleManual(
                $onboarding_invoice,
                auth('admin')->user(),
                $validated['payment_method'],
                $validated['payment_reference'],
                $request->file('payment_proof'),
            );

            return back()->with('success', translate('Payment verified and application moved to data entry pending.'));
        }

        $wasPaid = $onboarding_invoice->payment_status === OnboardingInvoice::PAYMENT_PAID;
        $onboarding_invoice->update([
            'payment_status' => $validated['payment_status'],
            'paid_at' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? now() : null,
            'payment_method' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? $validated['payment_method'] : null,
            'payment_reference' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? ($validated['payment_reference'] ?? null) : null,
            'paid_by' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? auth('admin')->id() : null,
        ]);
        $this->logEvent($onboarding_invoice, 'payment_status_changed', "Payment status changed to {$validated['payment_status']}.");

        if (! $wasPaid && $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID) {
            $this->sendInvoice($onboarding_invoice->fresh(), null, 'paid');
        }

        return back()->with($onboarding_invoice->fresh()->send_status === OnboardingInvoice::SEND_FAILED ? 'error' : 'success',
            translate('Invoice payment status updated.'));
    }

    public function paymentProof(OnboardingInvoice $onboarding_invoice): StreamedResponse
    {
        abort_unless($onboarding_invoice->payment_proof_disk && $onboarding_invoice->payment_proof_path, 404);
        $disk = Storage::disk($onboarding_invoice->payment_proof_disk);
        abort_unless($disk->exists($onboarding_invoice->payment_proof_path), 404);

        return $disk->response(
            $onboarding_invoice->payment_proof_path,
            $onboarding_invoice->payment_proof_name ?: 'payment-proof',
            [
                'Content-Type' => $onboarding_invoice->payment_proof_mime ?: 'application/octet-stream',
                'Cache-Control' => 'private, no-store',
                'X-Content-Type-Options' => 'nosniff',
            ],
        );
    }

    public function reissueCheckoutLink(OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        $this->checkoutService->rotateToken($onboarding_invoice, auth('admin')->user());

        return back()->with('success', translate('A new hosted checkout link was issued. Older links no longer work.'));
    }

    public function refundPaymentAttempt(
        Request $request,
        OnboardingInvoice $onboarding_invoice,
        OnboardingInvoicePaymentAttempt $payment_attempt,
    ): RedirectResponse {
        abort_unless($payment_attempt->onboarding_invoice_id === $onboarding_invoice->id, 404);
        $validated = $request->validate([
            'refund_reference' => ['required', 'string', 'max:255'],
            'refund_reason' => ['required', 'string', 'max:2000'],
        ]);
        $this->paymentService->recordGatewayRefund(
            $payment_attempt,
            auth('admin')->user(),
            $validated['refund_reference'],
            $validated['refund_reason'],
        );

        return back()->with('success', translate('Gateway refund recorded successfully.'));
    }

    public function reissueVendorPasswordSetup(OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        $application = $onboarding_invoice->onboardingApplication;
        abort_unless($application, 404);
        $this->approvalService->reissue($application, auth('admin')->user());

        return back()->with('success', translate('A new one-time vendor password setup link was queued for email.'));
    }

    public function voidInvoice(Request $request, OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        abort_if($onboarding_invoice->voided_at, 422, 'Invoice is already void.');
        $validated = $request->validate(['void_reason' => ['required', 'string', 'max:2000']]);
        if ($onboarding_invoice->onboarding_application_id) {
            $this->paymentService->voidUnpaid(
                $onboarding_invoice,
                auth('admin')->user(),
                $validated['void_reason'],
            );

            return back()->with('success', translate('Invoice voided and onboarding application cancelled.'));
        }
        $onboarding_invoice->update(['voided_at' => now(), 'void_reason' => $validated['void_reason'], 'voided_by' => auth('admin')->id()]);
        $this->logEvent($onboarding_invoice, 'voided', 'Invoice voided.', ['reason' => $validated['void_reason']]);

        return back()->with('success', translate('Invoice voided successfully.'));
    }

    private function sendInvoice(OnboardingInvoice $invoice, ?array $selectedRecipients, string $deliveryType): void
    {
        $admin = auth('admin')->user();
        $this->deliveryService->send(
            invoice: $invoice,
            deliveryType: $deliveryType,
            selectedRecipients: $selectedRecipients,
            actorAdminId: $admin?->id,
            actorName: trim(($admin?->f_name ?? '').' '.($admin?->l_name ?? '')) ?: $admin?->email,
        );
    }

    private function documentData(OnboardingInvoice $invoice): array
    {
        $invoice->loadMissing('items');
        $business = BusinessSetting::whereIn('key', ['business_name', 'address', 'phone', 'email_address'])->pluck('value', 'key');
        $bankDetails = $this->bankData();
        $checkoutUrl = $this->checkoutService->urlForInvoice($invoice, auth('admin')->user());

        return compact('invoice', 'business', 'bankDetails', 'checkoutUrl');
    }

    private function bankData(): array
    {
        $values = BusinessSetting::whereIn('key', [
            'onboarding_invoice_bank_name', 'onboarding_invoice_account_title',
            'onboarding_invoice_iban', 'onboarding_invoice_account_number',
        ])->pluck('value', 'key');

        return [
            'bank_name' => $values['onboarding_invoice_bank_name'] ?? 'Askari Bank',
            'account_title' => $values['onboarding_invoice_account_title'] ?? 'Zaqoota',
            'iban' => $values['onboarding_invoice_iban'] ?? 'PK02ASCM0009010200001008',
            'account_number' => $values['onboarding_invoice_account_number'] ?? '09010200001008',
        ];
    }

    private function logEvent(OnboardingInvoice $invoice, string $type, string $description, array $metadata = []): void
    {
        $admin = auth('admin')->user();
        $invoice->events()->create([
            'event_type' => $type,
            'description' => $description,
            'metadata' => $metadata ?: null,
            'admin_id' => $admin?->id,
            'admin_name' => trim(($admin?->f_name ?? '').' '.($admin?->l_name ?? '')) ?: $admin?->email,
        ]);
    }
}
