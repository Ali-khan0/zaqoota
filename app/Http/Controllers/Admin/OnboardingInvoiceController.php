<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OnboardingInvoiceStoreRequest;
use App\Mail\OnboardingInvoiceMail;
use App\Models\BusinessSetting;
use App\Models\Module;
use App\Models\OnboardingInvoice;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class OnboardingInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $totals = OnboardingInvoice::query()
            ->whereNull('voided_at')
            ->selectRaw("COUNT(*) as invoice_count")
            ->selectRaw("COALESCE(SUM(amount), 0) as total_amount")
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
        $invoiceNumber = $this->nextInvoiceNumber();

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
                'text' => $store->name . ($store->email ? " ({$store->email})" : ''),
                'email' => $store->email,
                'owner_name' => trim(($store->vendor?->f_name ?? '') . ' ' . ($store->vendor?->l_name ?? '')),
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
            OnboardingInvoice::query()->lockForUpdate()->latest('id')->first();
            $items = collect($request->validated('items'))->map(fn ($item) => [
                'description' => $item['description'],
                'quantity' => round((float) $item['quantity'], 2),
                'unit_price' => round((float) $item['unit_price'], 2),
                'line_total' => round((float) $item['quantity'] * (float) $item['unit_price'], 2),
            ]);
            $invoice = OnboardingInvoice::create([
                ...$request->safe()->except('submit_action', 'additional_emails', 'items'),
                'invoice_number' => $this->nextInvoiceNumber(),
                'amount' => $items->sum('line_total'),
                'module_name' => $module->module_name,
                'store_name' => $store->name,
                'store_owner_name' => trim(($store->vendor?->f_name ?? '') . ' ' . ($store->vendor?->l_name ?? '')) ?: null,
                'store_email' => $store->email,
                'recipient_emails' => $request->recipientEmails(),
                'store_address' => $store->address,
                'created_by' => auth('admin')->id(),
                'generated_by_name' => trim((auth('admin')->user()?->f_name ?? '') . ' ' . (auth('admin')->user()?->l_name ?? '')) ?: auth('admin')->user()?->email,
            ]);
            $invoice->items()->createMany($items->all());
            $this->logEvent($invoice, 'created', 'Invoice created.');

            return $invoice;
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
        $onboarding_invoice->load(['items', 'deliveries' => fn ($query) => $query->latest(), 'events' => fn ($query) => $query->latest()]);
        return view('admin-views.onboarding-invoice.show', ['invoice' => $onboarding_invoice, 'bankDetails' => $this->bankData()]);
    }

    public function download(OnboardingInvoice $onboarding_invoice): Response
    {
        $html = View::make('admin-views.onboarding-invoice.pdf', $this->documentData($onboarding_invoice))->render();
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('tmp'), 'default_font' => 'dejavusans', 'mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);

        return response($mpdf->Output('', 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Zaqoota-Invoice-' . $onboarding_invoice->invoice_number . '.pdf"',
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
        abort_if($onboarding_invoice->voided_at || $onboarding_invoice->payment_status === OnboardingInvoice::PAYMENT_PAID, 422, 'Only unpaid invoices can receive reminders.');
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
        $validated = $request->validate([
            'payment_status' => ['required', 'in:paid,unpaid'],
            'payment_method' => ['nullable', 'required_if:payment_status,paid', 'string', 'max:100'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
        ]);
        $wasPaid = $onboarding_invoice->payment_status === OnboardingInvoice::PAYMENT_PAID;
        $onboarding_invoice->update([
            'payment_status' => $validated['payment_status'],
            'paid_at' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? now() : null,
            'payment_method' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? $validated['payment_method'] : null,
            'payment_reference' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? ($validated['payment_reference'] ?? null) : null,
            'paid_by' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? auth('admin')->id() : null,
        ]);
        $this->logEvent($onboarding_invoice, 'payment_status_changed', "Payment status changed to {$validated['payment_status']}.");

        if (!$wasPaid && $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID) {
            $this->sendInvoice($onboarding_invoice->fresh(), null, 'paid');
        }

        return back()->with($onboarding_invoice->fresh()->send_status === OnboardingInvoice::SEND_FAILED ? 'error' : 'success',
            translate('Invoice payment status updated.'));
    }

    public function voidInvoice(Request $request, OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        abort_if($onboarding_invoice->voided_at, 422, 'Invoice is already void.');
        $validated = $request->validate(['void_reason' => ['required', 'string', 'max:2000']]);
        $onboarding_invoice->update(['voided_at' => now(), 'void_reason' => $validated['void_reason'], 'voided_by' => auth('admin')->id()]);
        $this->logEvent($onboarding_invoice, 'voided', 'Invoice voided.', ['reason' => $validated['void_reason']]);

        return back()->with('success', translate('Invoice voided successfully.'));
    }

    private function sendInvoice(OnboardingInvoice $invoice, ?array $selectedRecipients, string $deliveryType): void
    {
        $allowedRecipients = collect([$invoice->store_email, ...($invoice->recipient_emails ?? [])])
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();
        $recipients = $selectedRecipients === null
            ? $allowedRecipients
            : $allowedRecipients->intersect($selectedRecipients)->values();

        if ($recipients->isEmpty()) {
            $invoice->update([
                'send_status' => OnboardingInvoice::SEND_FAILED,
                'last_send_error' => translate('The store does not have a valid email address.'),
            ]);
            return;
        }

        $sent = 0;
        $lastError = null;
        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient)->send(new OnboardingInvoiceMail($invoice->loadMissing('items'), $deliveryType));
                $invoice->deliveries()->create(['recipient_email' => $recipient, 'delivery_type' => $deliveryType, 'status' => 'sent', 'sent_by' => auth('admin')->id(), 'sent_at' => now()]);
                $sent++;
            } catch (\Throwable $exception) {
                report($exception);
                $lastError = mb_substr($exception->getMessage(), 0, 2000);
                $invoice->deliveries()->create(['recipient_email' => $recipient, 'delivery_type' => $deliveryType, 'status' => 'failed', 'error_message' => $lastError, 'sent_by' => auth('admin')->id()]);
            }
        }
        $invoice->update(['send_status' => $sent > 0 ? OnboardingInvoice::SEND_SENT : OnboardingInvoice::SEND_FAILED, 'sent_at' => $sent > 0 ? now() : $invoice->sent_at, 'last_send_error' => $lastError]);
        $this->logEvent($invoice, $deliveryType . '_delivery', ucfirst($deliveryType) . " delivery processed for {$recipients->count()} recipient(s).", ['sent' => $sent, 'failed' => $recipients->count() - $sent]);
    }

    private function documentData(OnboardingInvoice $invoice): array
    {
        $invoice->loadMissing('items');
        $business = BusinessSetting::whereIn('key', ['business_name', 'address', 'phone', 'email_address'])->pluck('value', 'key');
        $bankDetails = $this->bankData();

        return compact('invoice', 'business', 'bankDetails');
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
            'admin_name' => trim(($admin?->f_name ?? '') . ' ' . ($admin?->l_name ?? '')) ?: $admin?->email,
        ]);
    }

    private function nextInvoiceNumber(): string
    {
        $highest = OnboardingInvoice::query()
            ->where('invoice_number', 'like', 'ZQ-%')
            ->pluck('invoice_number')
            ->map(fn ($number) => preg_match('/^ZQ-(\d+)$/', $number, $matches) ? (int) $matches[1] : 0)
            ->max() ?? 0;

        return 'ZQ-' . str_pad((string) max(40, $highest + 1), 4, '0', STR_PAD_LEFT);
    }
}
