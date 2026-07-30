<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class FleetManager extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'primary_zone_id',
        'employee_id',
        'f_name',
        'l_name',
        'phone',
        'email',
        'password',
        'auth_token',
        'fcm_token',
        'image',
        'status',
        'on_leave',
        'rider_capacity',
        'shift_start',
        'shift_end',
        'joining_date',
        'contract_type',
        'notes',
    ];

    protected $hidden = [
        'password',
        'auth_token',
        'remember_token',
        'notes',
    ];

    protected $casts = [
        'status' => 'boolean',
        'on_leave' => 'boolean',
        'rider_capacity' => 'integer',
        'joining_date' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return trim($this->f_name.' '.$this->l_name);
    }

    public function primaryZone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'primary_zone_id');
    }

    public function zones(): BelongsToMany
    {
        return $this->belongsToMany(Zone::class, 'fleet_manager_zone')->withTimestamps();
    }

    public function riders(): HasMany
    {
        return $this->hasMany(DeliveryMan::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(FleetManagerRiderAssignment::class);
    }

    public function paymentCollections(): HasMany
    {
        return $this->hasMany(FleetPaymentCollection::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', true)->where('on_leave', false);
    }
}
