<?php

namespace App\Http\Controllers\Api\V1\Ops;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Ops\OpsOnboardingSubmissionRequest;
use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Services\OpsOnboardingSubmissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpsSubmissionController extends Controller
{
    public function __construct(private readonly OpsOnboardingSubmissionService $submissionService)
    {
    }

    public function store(OpsOnboardingSubmissionRequest $request): JsonResponse
    {
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $data = $this->submissionService->submit($manager, $request->validated());

        return response()->json([
            'message' => 'Restaurant registration submitted successfully.',
            'data' => $data,
            'already_processed' => $data['already_processed'],
        ]);
    }

    public function show(Request $request, string $idempotencyKey): JsonResponse
    {
        Validator::make(['idempotency_key' => $idempotencyKey], [
            'idempotency_key' => ['required', 'string', 'min:16', 'max:150'],
        ])->validate();
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $application = OnboardingApplication::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('idempotency_key_hash', hash('sha256', $idempotencyKey))
            ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
            ->with('invoice')
            ->firstOrFail();
        $data = $this->submissionService->receipt($application, true);

        return response()->json([
            'message' => 'Restaurant registration was already submitted.',
            'data' => $data,
            'already_processed' => true,
        ]);
    }
}
