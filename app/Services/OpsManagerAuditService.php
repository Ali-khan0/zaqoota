<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\OpsManagerAudit;
use Illuminate\Http\Request;

class OpsManagerAuditService
{
    public function record(
        string $action,
        ?Admin $manager = null,
        array $metadata = [],
        ?Request $request = null,
        ?Admin $actor = null,
    ): void {
        $request ??= request();

        OpsManagerAudit::create([
            'manager_id' => $manager?->id,
            'actor_admin_id' => $actor?->id ?? auth('admin')->id(),
            'action' => $action,
            'metadata' => $metadata === [] ? null : $metadata,
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 500),
        ]);
    }
}
