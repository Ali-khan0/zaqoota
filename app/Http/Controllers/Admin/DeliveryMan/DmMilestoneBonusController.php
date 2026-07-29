<?php

namespace App\Http\Controllers\Admin\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\DmBonusAward;
use App\Models\DmBonusMilestone;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DmMilestoneBonusController extends Controller
{
    public function index(): View
    {
        $daily = DmBonusMilestone::where('period_type', 'daily')->orderBy('slot')->get();
        $weekly = DmBonusMilestone::where('period_type', 'weekly')->orderBy('slot')->get();

        return view('admin-views.delivery-man.milestone-bonus.index', compact('daily', 'weekly'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'period_type' => 'required|in:daily,weekly',
            'orders_required' => 'required|integer|min:1',
            'bonus_amount' => 'required|numeric|min:0',
        ]);

        // Cast slots to int: pluck() can return strings from MySQL; strict in_array would miss them and reuse slot 1.
        $usedSlots = array_map(
            'intval',
            DmBonusMilestone::where('period_type', $request->period_type)->pluck('slot')->all()
        );
        
        if (count($usedSlots) >= 4) {
            Toastr::error(translate('messages.error'));

            return back();
        }

        $nextSlot = null;
        for ($s = 1; $s <= 4; $s++) {
            if (! in_array($s, $usedSlots, true)) {
                $nextSlot = $s;
                break;
            }
        }
        if ($nextSlot === null) {
            Toastr::error(translate('messages.error'));

            return back();
        }

        DmBonusMilestone::create([
            'period_type' => $request->period_type,
            'slot' => $nextSlot,
            'orders_required' => (int) $request->orders_required,
            'bonus_amount' => (float) $request->bonus_amount,
            'status' => true,
        ]);

        Toastr::success(translate('messages.added_successfully'));

        return back();
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'orders_required' => 'required|integer|min:1',
            'bonus_amount' => 'required|numeric|min:0',
            'status' => 'nullable|in:0,1',
        ]);

        $m = DmBonusMilestone::findOrFail($id);
        $m->orders_required = (int) $request->orders_required;
        $m->bonus_amount = (float) $request->bonus_amount;
        if ($request->has('status')) {
            $m->status = (bool) (int) $request->status;
        }
        $m->save();

        Toastr::success(translate('messages.updated_successfully'));

        return back();
    }

    public function delete(int $id): RedirectResponse
    {
        DmBonusMilestone::where('id', $id)->delete();
        Toastr::success(translate('messages.deleted'));

        return back();
    }

    public function awards(Request $request): View
    {
        $search = $request->get('search');
        $q = DmBonusAward::with(['deliveryMan', 'milestone'])->orderByDesc('id');

        if ($search) {
            $q->whereHas('deliveryMan', function ($sub) use ($search) {
                $sub->where('f_name', 'like', "%{$search}%")
                    ->orWhere('l_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $awards = $q->paginate(config('default_pagination', 25));

        return view('admin-views.delivery-man.milestone-bonus.awards', compact('awards'));
    }
}
