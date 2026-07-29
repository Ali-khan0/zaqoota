<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Banner;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\CentralLogics\BannerLogic;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;


class BannerController extends Controller
{
    protected function resolveZoneId(Request $request): ?string
    {
        $candidates = [
            $request->header('zoneId'),
            $request->header('Zone-Id'),
            $request->header('zone_id'),
            $request->query('zoneId'),
            $request->query('zone_id'),
        ];

        if (isset($_GET['zoneId']) && $_GET['zoneId'] !== '') {
            $candidates[] = $_GET['zoneId'];
        }
        if (isset($_GET['zone_id']) && $_GET['zone_id'] !== '') {
            $candidates[] = $_GET['zone_id'];
        }

        foreach ($candidates as $value) {
            if ($value === null) {
                continue;
            }
            if (is_array($value)) {
                $ids = array_values(array_filter($value, static fn ($v) => $v !== null && $v !== ''));
                if ($ids !== []) {
                    return json_encode(array_map(static fn ($v) => is_numeric($v) ? (int) $v : $v, $ids));
                }
                continue;
            }
            $s = trim((string) $value);
            if ($s === '') {
                continue;
            }
            if (preg_match('/^\d+$/', $s)) {
                return json_encode([(int) $s]);
            }

            return $s;
        }

        return null;
    }

    public function get_banners(Request $request)
    {
        $zone_id = $this->resolveZoneId($request);
        if ($zone_id === null || $zone_id === '') {
            $errors = [];
            array_push($errors, ['code' => 'zoneId', 'message' => translate('messages.zone_id_required')]);
            return response()->json([
                'errors' => $errors
            ], 403);
        }
        $featured = $request->boolean('featured');
        $banners = BannerLogic::get_banners($zone_id, $featured);
        $campaigns = [];
        if (! $featured)
        {
            $moduleData = config('module.current_module_data');
            $moduleId = isset($moduleData['id']) ? $moduleData['id'] : 'default';
            $cacheKey = 'campaigns_' . md5($zone_id . '_' . $moduleId);
            $campaigns = Cache::remember($cacheKey, now()->addMinutes(20), function() use ($zone_id) {
                return Campaign::whereHas('module.zones', function($query) use($zone_id) {
                    $query->whereIn('zones.id', json_decode($zone_id, true));
                })
                    ->when(config('module.current_module_data'), function($query) use($zone_id) {
                        $query->module(config('module.current_module_data')['id']);
                        if (!config('module.current_module_data')['all_zone_service']) {
                            $query->whereHas('stores', function($q) use($zone_id) {
                                $q->whereIn('zone_id', json_decode($zone_id, true));
                            });
                        }
                    })
                    ->running()
                    ->active()
                    ->get();
            });
        }

        try {
            return response()->json(['campaigns'=>Helpers::basic_campaign_data_formatting($campaigns, true),'banners'=>$banners], 200);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    public function get_store_banners(Request $request,$store_id)
    {
        $zone_id = $this->resolveZoneId($request);
        if ($zone_id === null || $zone_id === '') {
            $errors = [];
            array_push($errors, ['code' => 'zoneId', 'message' => translate('messages.zone_id_required')]);
            return response()->json([
                'errors' => $errors
            ], 403);
        }
        $moduleData = config('module.current_module_data');
        $moduleId = isset($moduleData['id']) ? $moduleData['id'] : 'default';
        $cacheKey = 'banners_' . md5(implode('_', [
                $zone_id,
                $moduleId,
                $store_id
            ]));
        $banners = Cache::remember($cacheKey, now()->addMinutes(20), function() use ($zone_id, $store_id) {
            $banners = Banner::active();

            if (config('module.current_module_data')) {
                $banners = $banners->whereHas('zone.modules', function($query) {
                    $query->where('modules.id', config('module.current_module_data')['id']);
                })
                    ->module(config('module.current_module_data')['id'])
                    ->when(!config('module.current_module_data')['all_zone_service'], function($query) use ($zone_id) {
                        $query->whereIn('zone_id', json_decode($zone_id, true));
                    });
            }

            $banners = $banners->whereIn('zone_id', json_decode($zone_id, true))
                ->whereHas('module', function($query) {
                    $query->active();
                })
                ->where('data', $store_id)
                ->where('created_by', 'store')
                ->get();

            return $banners;
        });

        return response()->json($banners, 200);
    }
}
