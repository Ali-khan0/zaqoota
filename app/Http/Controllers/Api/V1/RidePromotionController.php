<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\RideBanner;
use App\Models\RidePushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RidePromotionController extends Controller
{
    public function banners(Request $request)
    {
        $validator = Validator::make($request->all(), ['zone_id' => 'required|integer|exists:zones,id', 'ride_category_id' => 'nullable|integer|exists:ride_categories,id']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $now = now();
        $banners = RideBanner::query()->where('status', true)->where('starts_at', '<=', $now)->where('expires_at', '>=', $now)
            ->where(fn ($query) => $query->whereNull('zone_id')->orWhere('zone_id', $request->integer('zone_id')))
            ->when($request->filled('ride_category_id'), fn ($query) => $query->where(fn ($scope) => $scope->whereNull('ride_category_id')->orWhere('ride_category_id', $request->integer('ride_category_id'))))
            ->orderBy('sort_order')->latest('id')->get();

        return response()->json(['banners' => $banners->map(fn ($item) => $this->banner($item))->values()]);
    }

    public function notifications(Request $request)
    {
        $validator = Validator::make($request->all(), ['zone_id' => 'required|integer|exists:zones,id', 'limit' => 'nullable|integer|min:1|max:50']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $page = RidePushNotification::query()->where('status', true)->whereNotNull('sent_at')->where('sent_at', '>=', now()->subDays(30))
            ->where(fn ($query) => $query->whereNull('zone_id')->orWhere('zone_id', $request->integer('zone_id')))
            ->latest('sent_at')->paginate($request->integer('limit', 20));

        return response()->json(['notifications' => collect($page->items())->map(fn ($item) => [
            'id' => $item->id, 'title' => $item->title, 'description' => $item->description, 'image_url' => $item->image_full_url,
            'action_type' => $item->action_type, 'action_value' => $item->action_value, 'sent_at' => $item->sent_at?->toIso8601String(),
        ])->values(), 'pagination' => ['total' => $page->total(), 'per_page' => $page->perPage(), 'current_page' => $page->currentPage(), 'last_page' => $page->lastPage()]]);
    }

    private function banner(RideBanner $item): array
    {
        return ['id' => $item->id, 'title' => $item->title, 'description' => $item->description, 'image_url' => $item->image_full_url,
            'action_type' => $item->action_type, 'action_value' => $item->action_value, 'starts_at' => $item->starts_at->toIso8601String(), 'expires_at' => $item->expires_at->toIso8601String()];
    }
}
