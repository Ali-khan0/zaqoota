<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class RideHistoryFilterService
{
    public function apply(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['status'] ?? null, fn (Builder $builder, string $status) => $builder->where('status', $status))
            ->when($filters['from'] ?? null, fn (Builder $builder, string $from) => $builder->where('created_at', '>=', Carbon::createFromFormat('Y-m-d', $from)->startOfDay()))
            ->when($filters['to'] ?? null, fn (Builder $builder, string $to) => $builder->where('created_at', '<=', Carbon::createFromFormat('Y-m-d', $to)->endOfDay()));
    }
}
