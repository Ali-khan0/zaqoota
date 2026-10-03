<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Models\OnboardingApplicationMedia;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OpsOnboardingMediaService
{
    private const KIND_TO_COLLECTION = [
        'logo' => OnboardingApplicationMedia::COLLECTION_LOGO,
        'cover' => OnboardingApplicationMedia::COLLECTION_COVER,
        'inside' => OnboardingApplicationMedia::COLLECTION_VENUE_INSIDE,
        'outside' => OnboardingApplicationMedia::COLLECTION_VENUE_OUTSIDE,
        'menu' => OnboardingApplicationMedia::COLLECTION_MENU,
        'tin_certificate' => OnboardingApplicationMedia::COLLECTION_TIN_CERTIFICATE,
    ];

    public function upload(Admin $manager, UploadedFile $file, string $kind, int $position, ?int $draftId): OnboardingApplicationMedia
    {
        $application = $this->ownedDraft($manager, $draftId);
        [$mime, $extension, $size, $checksum] = $this->inspect($file);
        $collection = self::KIND_TO_COLLECTION[$kind];
        $draftKey = $application ? 'draft:'.$application->id : 'manager:'.$manager->id;
        $scope = OnboardingApplicationMedia::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', OnboardingApplicationMedia::STATUS_TEMPORARY)
            ->where('draft_key', $draftKey);
        if ($kind === 'menu'
            && (clone $scope)->where('collection', OnboardingApplicationMedia::COLLECTION_MENU)->count()
                >= (int) config('ops.media.maximum_menu_photos', 8)) {
            throw ValidationException::withMessages(['file' => ['You can upload up to eight menu photos.']]);
        }

        $disk = (string) config('ops.media.disk', 'local');
        $directory = 'ops-onboarding/'.$manager->id.'/'.now()->format('Y/m');
        $filename = (string) Str::ulid().'.'.$extension;
        $path = $directory.'/'.$filename;
        $storedPath = Storage::disk($disk)->putFileAs($directory, $file, $filename, ['visibility' => 'private']);
        if ($storedPath === false) {
            throw ValidationException::withMessages(['file' => ['The photo could not be stored. Please try again.']]);
        }

        try {
            $media = OnboardingApplicationMedia::create([
                'onboarding_application_id' => $application?->id,
                'onboarding_manager_id' => $manager->id,
                'draft_key' => $draftKey,
                'collection' => $collection,
                'disk' => $disk,
                'path' => $path,
                'original_name' => Str::limit(basename($file->getClientOriginalName()), 255, ''),
                'mime_type' => $mime,
                'size_bytes' => $size,
                'checksum_sha256' => $checksum,
                'sort_order' => $position,
                'status' => OnboardingApplicationMedia::STATUS_TEMPORARY,
                'uploaded_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            Storage::disk($disk)->delete($path);
            throw $exception;
        }

        if ($kind !== 'menu') {
            (clone $scope)
                ->where('collection', $collection)
                ->whereKeyNot($media->id)
                ->get()
                ->each(function (OnboardingApplicationMedia $replaced): void {
                    try {
                        $this->deleteTemporary($replaced);
                    } catch (\Throwable $exception) {
                        report($exception);
                    }
                });
        }

        return $media;
    }

    public function deleteTemporary(OnboardingApplicationMedia $media): void
    {
        if ($media->status !== OnboardingApplicationMedia::STATUS_TEMPORARY) {
            throw ValidationException::withMessages(['media' => ['Submitted media cannot be removed from the registration form.']]);
        }
        $media->update(['status' => OnboardingApplicationMedia::STATUS_DELETING]);
        try {
            if (! Storage::disk($media->disk)->delete($media->path)) {
                throw new \RuntimeException('Unable to remove temporary onboarding media.');
            }
            $media->delete();
        } catch (\Throwable $exception) {
            $media->update(['status' => OnboardingApplicationMedia::STATUS_TEMPORARY]);
            throw $exception;
        }
    }

    public function previewUrl(OnboardingApplicationMedia $media): string
    {
        return URL::temporarySignedRoute(
            'api.ops.registration.media.preview',
            now()->addMinutes(max(5, (int) config('ops.media.preview_minutes', 60))),
            ['media' => $media->id],
        );
    }

    public function refreshDraftUrls(array $payload, Admin $manager): array
    {
        $items = collect($payload['media'] ?? []);
        $ids = $items->pluck('remote_id')->filter()->map(fn ($id) => (int) $id)->unique()->values();
        if ($ids->isEmpty()) {
            return $payload;
        }
        $owned = OnboardingApplicationMedia::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', OnboardingApplicationMedia::STATUS_TEMPORARY)
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');
        $payload['media'] = $items->map(function ($item) use ($owned) {
            if (! is_array($item)) {
                return $item;
            }
            $media = $owned->get((int) ($item['remote_id'] ?? 0));
            if ($media) {
                $item['remote_url'] = $this->previewUrl($media);
                $item['size_bytes'] = $media->size_bytes;
                $item['name'] = $media->original_name ?: ($item['name'] ?? 'photo.jpg');
            }

            return $item;
        })->all();

        return $payload;
    }

    public function associateDraftMedia(array $payload, Admin $manager, OnboardingApplication $application): void
    {
        $ids = collect($payload['media'] ?? [])
            ->pluck('remote_id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();
        if ($ids->isEmpty()) {
            return;
        }
        OnboardingApplicationMedia::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', OnboardingApplicationMedia::STATUS_TEMPORARY)
            ->whereIn('id', $ids)
            ->where(function ($query) use ($application) {
                $query->whereNull('onboarding_application_id')
                    ->orWhere('onboarding_application_id', $application->id);
            })
            ->update([
                'onboarding_application_id' => $application->id,
                'draft_key' => 'draft:'.$application->id,
                'updated_at' => now(),
            ]);
    }

    public function prepareStoreAssets(Admin $manager, array $submittedMedia): array
    {
        $idsByKind = collect($submittedMedia)
            ->whereIn('kind', ['logo', 'cover', 'tin_certificate'])
            ->mapWithKeys(fn ($item) => [$item['kind'] => (int) $item['id']]);
        $records = OnboardingApplicationMedia::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', OnboardingApplicationMedia::STATUS_TEMPORARY)
            ->whereIn('id', $idsByKind->values())
            ->get()
            ->keyBy('id');
        $targetDisk = Helpers::getDisk();
        $assets = ['disk' => $targetDisk, 'files' => []];
        try {
            foreach (['logo' => 'store/', 'cover' => 'store/cover/', 'tin_certificate' => 'store/'] as $kind => $directory) {
                if ($kind === 'tin_certificate' && ! $idsByKind->has($kind)) {
                    continue;
                }
                $source = $records->get($idsByKind->get($kind));
                if (! $source || $source->collection !== self::KIND_TO_COLLECTION[$kind]) {
                    throw ValidationException::withMessages(['media' => ["The uploaded {$kind} is unavailable."]]);
                }
                $extension = $this->extensionForMime($source->mime_type);
                $filename = now()->toDateString().'-'.Str::lower((string) Str::ulid()).'.'.$extension;
                $targetPath = $directory.$filename;
                $stream = Storage::disk($source->disk)->readStream($source->path);
                if (! is_resource($stream)) {
                    throw ValidationException::withMessages(['media' => ["The uploaded {$kind} could not be read."]]);
                }
                try {
                    if (! Storage::disk($targetDisk)->put($targetPath, $stream, ['visibility' => 'public'])) {
                        throw new \RuntimeException("Unable to promote {$kind} media.");
                    }
                } finally {
                    fclose($stream);
                }
                $assets[$kind] = $filename;
                if ($kind === 'tin_certificate') {
                    $assets['tin_certificate_path'] = $targetPath;
                }
                $assets['files'][] = $targetPath;
            }
        } catch (\Throwable $exception) {
            $this->discardStoreAssets($assets);
            throw $exception;
        }

        return $assets;
    }

    public function discardStoreAssets(array $assets): void
    {
        if (! empty($assets['disk']) && ! empty($assets['files'])) {
            Storage::disk($assets['disk'])->delete($assets['files']);
        }
    }

    public function cleanupOrphans(int $hours): int
    {
        $cutoff = now()->subHours(max(1, $hours));
        $deleted = 0;
        OnboardingApplicationMedia::query()
            ->whereIn('status', [OnboardingApplicationMedia::STATUS_TEMPORARY, OnboardingApplicationMedia::STATUS_DELETING])
            ->where('updated_at', '<', $cutoff)
            ->chunkById(100, function (Collection $media) use (&$deleted) {
                foreach ($media as $record) {
                    try {
                        if (! Storage::disk($record->disk)->delete($record->path)) {
                            throw new \RuntimeException('Unable to remove orphaned onboarding media.');
                        }
                        $record->delete();
                        $deleted++;
                    } catch (\Throwable $exception) {
                        report($exception);
                    }
                }
            });

        return $deleted;
    }

    private function ownedDraft(Admin $manager, ?int $draftId): ?OnboardingApplication
    {
        if (! $draftId) {
            return null;
        }

        return OnboardingApplication::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', OnboardingApplication::STATUS_DRAFT)
            ->findOrFail($draftId);
    }

    private function inspect(UploadedFile $file): array
    {
        $maximumBytes = max(1, (int) config('ops.media.maximum_size_kb', 2048)) * 1024;
        $size = (int) $file->getSize();
        $mime = (string) $file->getMimeType();
        if ($size < 1 || $size > $maximumBytes || ! array_key_exists($mime, $this->mimeExtensions())) {
            throw ValidationException::withMessages(['file' => ['Upload a JPG, PNG or WebP image no larger than 2 MB.']]);
        }
        $dimensions = @getimagesize($file->getRealPath());
        if (! $dimensions || ($dimensions[0] * $dimensions[1]) > (int) config('ops.media.maximum_image_pixels', 40000000)) {
            throw ValidationException::withMessages(['file' => ['The image dimensions are invalid or too large.']]);
        }

        return [$mime, $this->extensionForMime($mime), $size, hash_file('sha256', $file->getRealPath())];
    }

    private function extensionForMime(?string $mime): string
    {
        return $this->mimeExtensions()[$mime] ?? 'jpg';
    }

    private function mimeExtensions(): array
    {
        return ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    }
}
