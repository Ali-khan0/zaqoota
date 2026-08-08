<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\RideCaptainEligibilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class RideBroadcastController extends Controller
{
    public function customerAuth(Request $request)
    {
        return Broadcast::auth($request);
    }

    public function captainAuth(Request $request, RideCaptainEligibilityService $eligibilityService)
    {
        $captain = $eligibilityService->captainByToken($request->token);
        abort_unless($captain, 401);
        $request->setUserResolver(fn () => $captain);

        return Broadcast::auth($request);
    }
}
