<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\RecordQueueWorkerHeartbeat;
use App\Models\BusinessSetting;
use App\Services\QueueProcessService;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class QueueOperationsController extends Controller
{
    public function index(QueueProcessService $processes)
    {
        $definitions = $processes->definitions();
        $statuses = $processes->statuses();
        $queueConnection = (string) config('queue.default');
        $queueCounts = null;
        $pendingByProcess = collect();

        if ($queueConnection === 'database' && Schema::hasTable('jobs')) {
            $now = now()->timestamp;
            $queueCounts = [
                'total' => DB::table('jobs')->count(),
                'ready' => DB::table('jobs')->whereNull('reserved_at')->where('available_at', '<=', $now)->count(),
                'delayed' => DB::table('jobs')->whereNull('reserved_at')->where('available_at', '>', $now)->count(),
                'reserved' => DB::table('jobs')->whereNotNull('reserved_at')->count(),
            ];

            foreach ($definitions as $process => $definition) {
                $pendingByProcess->put(
                    $process,
                    DB::table('jobs')->where('payload', 'like', '%'.$definition['job'].'%')->count(),
                );
            }
        }

        $failedCount = Schema::hasTable('failed_jobs') ? DB::table('failed_jobs')->count() : null;
        $recentFailures = Schema::hasTable('failed_jobs')
            ? DB::table('failed_jobs')->latest('failed_at')->limit(10)->get()->map(function ($failure) {
                $payload = json_decode($failure->payload, true);
                $failure->display_name = data_get($payload, 'displayName', data_get($payload, 'job', 'Unknown queued job'));

                return $failure;
            })
            : collect();

        $heartbeatValue = BusinessSetting::query()->where('key', 'queue_worker_last_heartbeat_at')->value('value');
        $heartbeatConnection = BusinessSetting::query()->where('key', 'queue_worker_last_connection')->value('value');
        $heartbeatAt = $heartbeatValue ? Carbon::parse($heartbeatValue) : null;
        $heartbeatHealthy = ! in_array($queueConnection, ['', 'sync', 'null'], true)
            && $heartbeatAt?->gte(now()->subMinutes(3))
            && $heartbeatConnection === $queueConnection;

        return view('admin-views.business-settings.queue-operations', [
            'definitions' => $definitions,
            'statuses' => $statuses,
            'masterEnabled' => $processes->masterEnabled(),
            'queueConnection' => $queueConnection,
            'queueCounts' => $queueCounts,
            'pendingByProcess' => $pendingByProcess,
            'failedCount' => $failedCount,
            'recentFailures' => $recentFailures,
            'heartbeatAt' => $heartbeatAt,
            'heartbeatHealthy' => $heartbeatHealthy,
        ]);
    }

    public function update(Request $request, QueueProcessService $processes)
    {
        if (env('APP_MODE') === 'demo') {
            Toastr::info(translate('messages.update_option_is_disable_for_demo'));

            return back();
        }

        $keys = array_keys($processes->definitions());
        $validated = $request->validate([
            'master_enabled' => ['nullable', 'boolean'],
            'processes' => ['nullable', 'array'],
            'processes.*' => ['string', Rule::in($keys)],
        ]);

        $processes->updateControls(
            $request->boolean('master_enabled'),
            array_values($validated['processes'] ?? []),
        );
        Toastr::success(translate('Queue process controls updated successfully.'));

        return back();
    }

    public function probe()
    {
        RecordQueueWorkerHeartbeat::dispatch();
        Toastr::info(translate('Queue heartbeat was submitted. Refresh after a few seconds to confirm the worker processed it.'));

        return back();
    }
}
