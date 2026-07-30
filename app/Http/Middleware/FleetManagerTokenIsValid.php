<?php

namespace App\Http\Middleware;

use App\CentralLogics\Helpers;
use App\Models\FleetManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FleetManagerTokenIsValid
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->input('token')
            ?: $request->bearerToken()
            ?: $request->header('token');

        if ($token !== null && $token !== '') {
            $request->merge(['token' => $token]);
        }

        $validator = Validator::make($request->all(), [
            'token' => 'required|exists:fleet_managers,auth_token',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 401);
        }

        if (! FleetManager::query()->available()->where('auth_token', $token)->exists()) {
            return response()->json([
                'errors' => [
                    ['code' => 'auth-003', 'message' => translate('Fleet manager account is inactive or unavailable.')],
                ],
            ], 401);
        }

        return $next($request);
    }
}
