<?php

namespace App\Http\Controllers\Api\V1\Ops;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\OpsManagerAuditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OpsAuthController extends Controller
{
    public function __construct(private readonly OpsManagerAuditService $auditService)
    {
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        /** @var Admin|null $manager */
        $manager = Admin::with('role')->where('email', $validated['email'])->first();

        if (! $manager || ! Hash::check($validated['password'], (string) $manager->password)) {
            return response()->json(['code' => 'invalid_credentials', 'message' => 'The email or password is incorrect.'], 401);
        }

        if (! $manager->isOnboardingManager()) {
            return response()->json(['code' => 'unsupported_role', 'message' => 'Only onboarding managers can use Zaqoota Ops.'], 403);
        }

        if (! $manager->canUseOps()) {
            return response()->json(['code' => 'account_banned', 'message' => 'Your Zaqoota Ops account is inactive. Contact an administrator.'], 403);
        }

        $token = $manager->createToken(
            $validated['device_name'] ?? 'Zaqoota Ops',
            ['ops:access'],
        )->accessToken;

        $this->auditService->record('ops_login', $manager, ['device_name' => $validated['device_name'] ?? null], $request);

        return response()->json([
            'token' => $token,
            'manager' => $this->managerPayload($manager),
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');

        return response()->json(['manager' => $this->managerPayload($manager)]);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $manager->token()?->revoke();
        $this->auditService->record('ops_logout', $manager, request: $request);

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function notificationToken(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string', 'max:4096'],
            'action' => ['required', 'in:register,unregister'],
            'platform' => ['nullable', 'in:android,ios'],
        ]);

        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $token = $validated['token'];

        if ($validated['action'] === 'unregister') {
            if (hash_equals((string) $manager->ops_fcm_token, $token)) {
                $manager->forceFill(['ops_fcm_token' => null, 'ops_fcm_platform' => null])->save();
            }
            $action = 'ops_notification_token_removed';
        } else {
            $manager->forceFill([
                'ops_fcm_token' => $token,
                'ops_fcm_platform' => $validated['platform'] ?? null,
            ])->save();
            $action = 'ops_notification_token_updated';
        }

        $this->auditService->record($action, $manager, ['platform' => $validated['platform'] ?? null], $request);

        return response()->json(['message' => 'Notification token updated successfully.']);
    }

    private function managerPayload(Admin $manager): array
    {
        return [
            'id' => $manager->id,
            'name' => trim($manager->f_name.' '.$manager->l_name),
            'email' => $manager->email,
            'phone' => $manager->phone,
            'image' => $manager->image_full_url,
            'role' => Admin::STAFF_TYPE_ONBOARDING_MANAGER,
            'is_active' => $manager->canUseOps(),
            'commission_percentage' => (float) $manager->onboarding_commission_percent,
        ];
    }
}
