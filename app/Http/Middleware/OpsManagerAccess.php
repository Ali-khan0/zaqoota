<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OpsManagerAccess
{
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        /** @var Admin|null $manager */
        $manager = $request->user('ops_api');

        if (! $manager || ! $manager->tokenCan('ops:access')) {
            return response()->json(['code' => 'unauthenticated', 'message' => 'Please log in again.'], 401);
        }

        if (! $manager->isOnboardingManager()) {
            return response()->json(['code' => 'unsupported_role', 'message' => 'Only onboarding managers can use Zaqoota Ops.'], 403);
        }

        if (! $manager->canUseOps()) {
            return response()->json(['code' => 'account_banned', 'message' => 'Your Zaqoota Ops account is inactive. Contact an administrator.'], 403);
        }

        $request->attributes->set('ops_manager', $manager);

        return $next($request);
    }
}
