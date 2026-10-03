<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Models\OpsManagerFinanceLedger;
use App\Models\OpsManagerWithdrawal;
use App\Services\OpsManagerAuditService;
use App\Services\OpsManagerFinanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OpsFinanceController extends Controller
{
    public function __construct(private readonly OpsManagerFinanceService $finance) {}

    private function withdrawals()
    {
        return OpsManagerWithdrawal::query()->whereHas('manager', fn ($q) => $q
            ->when(auth('admin')->user()->zone_id, fn ($q, $zone) => $q->where('zone_id', $zone)));
    }

    private function applications()
    {
        return OnboardingApplication::query()->where('status', '!=', 'draft')
            ->when(auth('admin')->user()->zone_id, fn ($q, $zone) => $q->where('zone_id', $zone));
    }

    public function index(Request $request)
    {
        $request->validate(['status' => ['nullable', Rule::in(['pending', 'approved', 'processing', 'paid', 'rejected', 'cancelled'])]]);
        $withdrawals = $this->withdrawals()->with(['manager', 'reviewer', 'payer'])
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->latest('id')->paginate(20, ['*'], 'withdrawals_page')->withQueryString();
        $applications = $this->applications()->with('invoice')->latest('id')
            ->paginate(20, ['*'], 'applications_page')->withQueryString();

        return view('admin-views.ops-finance.index', compact('withdrawals', 'applications'));
    }

    public function withdrawal(Request $request, int $withdrawal)
    {
        $record = $this->withdrawals()->findOrFail($withdrawal);
        $data = $request->validate([
            'action' => ['required', Rule::in(['approved', 'rejected', 'paid'])],
            'note' => ['required', 'string', 'max:1000'],
            'reference' => ['required_if:action,paid', 'nullable', 'string', 'max:150'],
            'proof' => ['required_if:action,paid', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);
        $disk = (string) config('ops.media.disk', 'local');
        $path = null;
        try {
            if ($data['action'] === 'paid') {
                $path = $request->file('proof')->store('ops-withdrawal-proofs', $disk);
                if (! $path) {
                    throw new \RuntimeException('Unable to store payment proof.');
                }
            }
            DB::transaction(function () use ($record, $data, $path, $disk, $request): void {
                Admin::query()->whereKey($record->manager_id)->lockForUpdate()->firstOrFail();
                $locked = $this->withdrawals()->lockForUpdate()->findOrFail($record->id);
                if ($data['action'] === 'paid') {
                    abort_if($locked->status === 'paid', 409, 'Payment is already recorded.');
                    $this->finance->markWithdrawalPaid($locked, auth('admin')->user(), trim($data['reference']));
                    $locked->forceFill(['proof_disk' => $disk, 'proof_path' => $path,
                        'proof_mime' => $request->file('proof')->getMimeType(), 'admin_note' => $data['note']])->save();
                } else {
                    $this->finance->reviewWithdrawal($locked, $data['action'], auth('admin')->user(), $data['note']);
                }
            }, 3);
        } catch (\Throwable $exception) {
            if ($path) {
                Storage::disk($disk)->delete($path);
            }
            throw $exception;
        }

        return back()->with('success', 'Withdrawal updated.');
    }

    public function commission(Request $request, int $application)
    {
        $record = $this->applications()->findOrFail($application);
        $data = $request->validate(['action' => ['required', Rule::in(['release', 'reverse'])], 'note' => ['required', 'string', 'max:1000']]);
        DB::transaction(function () use ($record, $data): void {
            Admin::query()->whereKey($record->onboarding_manager_id)->lockForUpdate()->firstOrFail();
            $locked = $this->applications()->lockForUpdate()->findOrFail($record->id);
            abort_if((int) $locked->onboarding_manager_id === (int) auth('admin')->id(), 403);
            if ($data['action'] === 'release') {
                $this->finance->releaseCommission($locked, auth('admin')->user());
            } else {
                $releasedByActor = $locked->financeLedger()->where('entry_type', 'commission_released')
                    ->where('actor_admin_id', auth('admin')->id())->exists();
                if ($releasedByActor) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['action' => 'A different staff member must reverse released commission.']);
                }
                $this->finance->reverseCommission($locked, auth('admin')->user(), $data['note']);
            }
            app(OpsManagerAuditService::class)->record('ops_finance_decision', $locked->manager, [
                'application_id' => $locked->id, 'action' => $data['action'], 'reason' => $data['note'],
            ]);
        }, 3);

        return back()->with('success', 'Commission decision recorded.');
    }

    public function proof(int $withdrawal)
    {
        $record = $this->withdrawals()->findOrFail($withdrawal);
        abort_unless($record->proof_disk && $record->proof_path, 404);

        return Storage::disk($record->proof_disk)->response($record->proof_path, 'payment-proof', [
            'Content-Type' => $record->proof_mime, 'Cache-Control' => 'private, no-store', 'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function destination(int $withdrawal)
    {
        $record = $this->withdrawals()->findOrFail($withdrawal);
        abort_unless(in_array($record->status, ['approved', 'processing'], true), 403);
        abort_if((int) auth('admin')->id() === (int) $record->manager_id, 403);
        app(OpsManagerAuditService::class)->record('ops_payout_destination_viewed', $record->manager, ['withdrawal_id' => $record->id]);

        return response()->view('admin-views.ops-finance.destination', ['record' => $record, 'destination' => $record->destination_snapshot])
            ->header('Cache-Control', 'private, no-store');
    }

    public function export()
    {
        $query = OpsManagerFinanceLedger::query()->whereHas('manager', fn ($q) => $q
            ->when(auth('admin')->user()->zone_id, fn ($q, $zone) => $q->where('zone_id', $zone)));

        return response()->streamDownload(function () use ($query): void {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, ['ID', 'Manager ID', 'Application ID', 'Type', 'Bucket', 'Direction', 'Amount', 'Currency', 'Reference', 'Created']);
            foreach ($query->orderBy('id')->lazyById(500) as $entry) {
                $row = [$entry->id, $entry->manager_id, $entry->onboarding_application_id, $entry->entry_type, $entry->bucket, $entry->direction, $entry->amount, $entry->currency, $entry->reference, $entry->created_at];
                fputcsv($stream, array_map(fn ($value) => preg_match('/^[=+@\-\t\r\n]/', (string) $value) ? "'".$value : $value, $row));
            }
            fclose($stream);
        }, 'ops-finance-ledger.csv', ['Content-Type' => 'text/csv', 'Cache-Control' => 'private, no-store']);
    }
}
