<?php

namespace App\Http\Controllers\Api\V1\Ops;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\OnboardingApplicationMedia;
use App\Services\OpsOnboardingMediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OpsMediaController extends Controller
{
    public function __construct(private readonly OpsOnboardingMediaService $mediaService) {}

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'image',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:'.max(1, (int) config('ops.media.maximum_size_kb', 2048)),
            ],
            'kind' => ['required', Rule::in(['logo', 'cover', 'inside', 'outside', 'menu', 'tin_certificate'])],
            'position' => ['required', 'integer', 'min:0', 'max:99'],
            'draft_id' => ['nullable', 'integer', 'min:1'],
        ]);
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $media = $this->mediaService->upload(
            manager: $manager,
            file: $request->file('file'),
            kind: $validated['kind'],
            position: (int) $validated['position'],
            draftId: isset($validated['draft_id']) ? (int) $validated['draft_id'] : null,
        );

        return response()->json(['data' => [
            'id' => (string) $media->id,
            'url' => $this->mediaService->previewUrl($media),
            'file_name' => $media->original_name,
            'size_bytes' => $media->size_bytes,
            'kind' => $validated['kind'],
        ]], 201);
    }

    public function destroy(Request $request, int $media): JsonResponse
    {
        /** @var Admin $manager */
        $manager = $request->attributes->get('ops_manager');
        $record = OnboardingApplicationMedia::query()
            ->where('onboarding_manager_id', $manager->id)
            ->findOrFail($media);
        $this->mediaService->deleteTemporary($record);

        return response()->json(['message' => 'Photo removed successfully.']);
    }

    public function preview(int $media): StreamedResponse
    {
        $record = OnboardingApplicationMedia::query()->findOrFail($media);
        abort_unless(Storage::disk($record->disk)->exists($record->path), 404);
        $stream = Storage::disk($record->disk)->readStream($record->path);
        abort_unless(is_resource($stream), 404);
        $filename = str_replace(['"', "\r", "\n"], '', basename($record->original_name ?: 'photo'));

        return response()->stream(function () use ($stream): void {
            try {
                fpassthru($stream);
            } finally {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $record->mime_type ?: 'application/octet-stream',
            'Content-Length' => (string) $record->size_bytes,
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
            'Cache-Control' => 'private, max-age=300',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
