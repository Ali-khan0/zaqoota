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
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class OnboardingInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $totals = OnboardingInvoice::query()
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
            ->when($request->filled('payment_status'), fn ($query) => $query->where('payment_status', $request->payment_status))
            ->when($request->filled('send_status'), fn ($query) => $query->where('send_status', $request->send_status))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin-views.onboarding-invoice.index', compact('invoices', 'totals'));
    }

    public function create()
    {
        $modules = Module::query()->active()->notRental()->orderBy('module_name')->get(['id', 'module_name']);

        return view('admin-views.onboarding-invoice.create', compact('modules'));
    }

    public function stores(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'module_id' => ['required', 'integer'],
            'q' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $module = Module::query()->active()->notRental()->findOrFail($validated['module_id']);
        $term = trim((string) ($validated['q'] ?? ''));
        $stores = Store::withoutGlobalScopes()->query()
            ->where('module_id', $module->id)
            ->where('status', 1)
            ->where('active', 1)
            ->when($term !== '', fn ($query) => $query->where('name', 'like', "%{$term}%"))
            ->orderBy('name')
            ->paginate(20, ['id', 'name', 'email']);

        return response()->json([
            'results' => collect($stores->items())->map(fn (Store $store) => [
                'id' => $store->id,
                'text' => $store->name . ($store->email ? " ({$store->email})" : ''),
            ]),
            'pagination' => ['more' => $stores->hasMorePages()],
        ]);
    }

    public function store(OnboardingInvoiceStoreRequest $request): RedirectResponse
    {
        $module = Module::query()->active()->notRental()->findOrFail($request->integer('module_id'));
        $store = Store::withoutGlobalScopes()->where('module_id', $module->id)->findOrFail($request->integer('store_id'));
        $invoice = OnboardingInvoice::create([
            ...$request->safe()->except('submit_action', 'additional_emails'),
            'module_name' => $module->module_name,
            'store_name' => $store->name,
            'store_email' => $store->email,
            'recipient_emails' => $request->recipientEmails(),
            'store_address' => $store->address,
            'created_by' => auth('admin')->id(),
        ]);

        if ($request->input('submit_action') === 'create_and_send') {
            $this->sendInvoice($invoice);
        }

        $mailFailed = $invoice->send_status === OnboardingInvoice::SEND_FAILED;

        return redirect()->route('admin.transactions.onboarding-invoices.show', $invoice)
            ->with($mailFailed ? 'error' : 'success', $mailFailed
                ? translate('Invoice created, but the email could not be sent. You can retry from the invoice page.')
                : translate('Invoice created successfully.'));
    }

    public function show(OnboardingInvoice $onboarding_invoice)
    {
        return view('admin-views.onboarding-invoice.show', ['invoice' => $onboarding_invoice]);
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
        $this->sendInvoice($onboarding_invoice);

        return back()->with($onboarding_invoice->send_status === OnboardingInvoice::SEND_SENT ? 'success' : 'error',
            $onboarding_invoice->send_status === OnboardingInvoice::SEND_SENT
                ? translate('Invoice sent successfully.')
                : translate('Invoice could not be sent. Check the recorded error and mail configuration.'));
    }

    public function paymentStatus(Request $request, OnboardingInvoice $onboarding_invoice): RedirectResponse
    {
        $validated = $request->validate(['payment_status' => ['required', 'in:paid,unpaid']]);
        $wasPaid = $onboarding_invoice->payment_status === OnboardingInvoice::PAYMENT_PAID;
        $onboarding_invoice->update([
            'payment_status' => $validated['payment_status'],
            'paid_at' => $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID ? now() : null,
        ]);

        if (!$wasPaid && $validated['payment_status'] === OnboardingInvoice::PAYMENT_PAID) {
            $this->sendInvoice($onboarding_invoice->fresh());
        }

        return back()->with($onboarding_invoice->fresh()->send_status === OnboardingInvoice::SEND_FAILED ? 'error' : 'success',
            translate('Invoice payment status updated.'));
    }

    private function sendInvoice(OnboardingInvoice $invoice): void
    {
        $recipients = collect([$invoice->store_email, ...($invoice->recipient_emails ?? [])])
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();

        if ($recipients === []) {
            $invoice->update([
                'send_status' => OnboardingInvoice::SEND_FAILED,
                'last_send_error' => translate('The store does not have a valid email address.'),
            ]);
            return;
        }

        try {
            Mail::to(array_shift($recipients))->cc($recipients)->send(new OnboardingInvoiceMail($invoice));
            $invoice->update(['send_status' => OnboardingInvoice::SEND_SENT, 'sent_at' => now(), 'last_send_error' => null]);
        } catch (\Throwable $exception) {
            report($exception);
            $invoice->update(['send_status' => OnboardingInvoice::SEND_FAILED, 'last_send_error' => mb_substr($exception->getMessage(), 0, 2000)]);
        }
    }

    private function documentData(OnboardingInvoice $invoice): array
    {
        $business = BusinessSetting::whereIn('key', ['business_name', 'address', 'phone', 'email_address'])->pluck('value', 'key');

        return compact('invoice', 'business');
    }
}
