<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Module;
use App\Models\OnboardingApplication;
use App\Models\OnboardingInvoice;
use App\Models\Store;

class OnboardingInvoiceCreationService
{
    public function create(
        Store $store,
        Module $module,
        array $items,
        array $attributes,
        ?Admin $actor = null,
        ?OnboardingApplication $application = null,
    ): OnboardingInvoice {
        OnboardingInvoice::query()->lockForUpdate()->latest('id')->first();
        $normalizedItems = collect($items)->map(fn (array $item) => [
            'description' => trim((string) $item['description']),
            'quantity' => round((float) $item['quantity'], 2),
            'unit_price' => round((float) $item['unit_price'], 2),
            'line_total' => round((float) $item['quantity'] * (float) $item['unit_price'], 2),
        ]);
        $actorName = trim(($actor?->f_name ?? '').' '.($actor?->l_name ?? '')) ?: $actor?->email;
        $invoice = OnboardingInvoice::create([
            ...$attributes,
            'onboarding_application_id' => $application?->id,
            'invoice_number' => $this->nextInvoiceNumber(),
            'amount' => $normalizedItems->sum('line_total'),
            'module_id' => $module->id,
            'store_id' => $store->id,
            'module_name' => $module->module_name,
            'store_name' => $store->name,
            'store_owner_name' => trim(($store->vendor?->f_name ?? '').' '.($store->vendor?->l_name ?? '')) ?: null,
            'store_email' => $store->email,
            'store_address' => $store->address,
            'created_by' => $actor?->id,
            'generated_by_name' => $actorName,
        ]);
        $invoice->items()->createMany($normalizedItems->all());
        $invoice->events()->create([
            'event_type' => 'created',
            'description' => 'Invoice created.',
            'admin_id' => $actor?->id,
            'admin_name' => $actorName,
        ]);

        return $invoice->load('items');
    }

    public function nextInvoiceNumber(): string
    {
        $highest = OnboardingInvoice::query()
            ->where('invoice_number', 'like', 'ZQ-%')
            ->pluck('invoice_number')
            ->map(fn ($number) => preg_match('/^ZQ-(\d+)$/', $number, $matches) ? (int) $matches[1] : 0)
            ->max() ?? 0;

        return 'ZQ-'.str_pad((string) max(40, $highest + 1), 4, '0', STR_PAD_LEFT);
    }
}
