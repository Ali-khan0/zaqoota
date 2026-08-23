<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RideCancellationReason extends Model
{
    public const ACTORS = ['customer', 'captain', 'admin'];

    protected $guarded = ['id'];

    protected $casts = [
        'ride_statuses' => 'array',
        'display_order' => 'integer',
        'status' => 'boolean',
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getTitleAttribute($value): string
    {
        $translation = $this->translations->firstWhere('key', 'title');

        return (string) ($translation?->value ?: $value);
    }

    public function appliesTo(string $actorType, string $rideStatus): bool
    {
        return $this->status
            && $this->user_type === self::canonicalActor($actorType)
            && in_array($rideStatus, $this->ride_statuses ?? [], true);
    }

    public static function canonicalActor(string $actorType): string
    {
        return $actorType === 'user' ? 'customer' : $actorType;
    }

    protected static function booted(): void
    {
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => fn ($query) => $query->where('locale', app()->getLocale())]);
        });
    }
}
