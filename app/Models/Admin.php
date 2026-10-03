<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

/**
 * Class Admin
 *
 * @property int $id
 * @property string|null $f_name
 * @property string|null $l_name
 * @property string|null $phone
 * @property string $email
 * @property string|null $image
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $role_id
 * @property int|null $zone_id
 * @property bool $is_logged_in
 */
class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public const STAFF_TYPE_ADMIN_EMPLOYEE = 'admin_employee';

    public const STAFF_TYPE_ONBOARDING_MANAGER = 'onboarding_manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'phone',
        'email',
        'image',
        'password',
        'remember_token',
        'login_remember_token',
        'role_id',
        'staff_type',
        'onboarding_commission_percent',
        'ops_status',
        'ops_fcm_token',
        'ops_fcm_platform',
        'zone_id',
        'is_logged_in',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_logged_in' => 'boolean',
        'ops_status' => 'boolean',
        'onboarding_commission_percent' => 'decimal:2',
    ];

    protected $hidden = ['password', 'remember_token', 'login_remember_token', 'ops_fcm_token'];

    protected $appends = ['image_full_url'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(AdminRole::class, 'role_id');
    }

    public function zones(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function onboardingApplications(): HasMany
    {
        return $this->hasMany(OnboardingApplication::class, 'onboarding_manager_id');
    }

    public function onboardingMedia(): HasMany
    {
        return $this->hasMany(OnboardingApplicationMedia::class, 'onboarding_manager_id');
    }

    public function opsPayoutMethod(): HasOne
    {
        return $this->hasOne(OpsManagerPayoutMethod::class, 'manager_id');
    }

    public function opsWithdrawals(): HasMany
    {
        return $this->hasMany(OpsManagerWithdrawal::class, 'manager_id');
    }

    public function opsFinanceLedger(): HasMany
    {
        return $this->hasMany(OpsManagerFinanceLedger::class, 'manager_id');
    }

    public function opsAudits(): HasMany
    {
        return $this->hasMany(OpsManagerAudit::class, 'manager_id');
    }

    public function getImageFullUrlAttribute()
    {
        $value = $this->image;
        if (count($this->storage) > 0) {
            foreach ($this->storage as $storage) {
                if ($storage['key'] == 'image') {
                    return Helpers::get_full_url('admin', $value, $storage['value']);
                }
            }
        }

        return Helpers::get_full_url('admin', $value, 'public');
    }

    public function getFullNameAttribute()
    {
        return Str::limit($this->f_name.' '.$this->l_name, 15, '...');
    }

    public function getMaskedEmailAttribute()
    {

        if ($this->email) {
            [$name, $domain] = explode('@', $this->email);
            $maskedName = substr($name, 0, 2).str_repeat('*', max(0, strlen($name) - 2));
            $domainParts = explode('.', $domain);
            $maskedDomain = str_repeat('*', strlen($domainParts[0])).end($domainParts);
            $maskedEmail = $maskedName.'@'.$maskedDomain;
        }

        return $maskedEmail ?? $this->email;
    }

    public function scopeZone($query): mixed
    {
        if (isset(auth('admin')->user()->zone_id)) {
            return $query->where('zone_id', auth('admin')->user()->zone_id);
        }

        return $query;
    }

    public function storage()
    {
        return $this->morphMany(Storage::class, 'data');
    }

    public function isOnboardingManager(): bool
    {
        return $this->staff_type === self::STAFF_TYPE_ONBOARDING_MANAGER;
    }

    public function canUseOps(): bool
    {
        return $this->isOnboardingManager()
            && (bool) $this->ops_status
            && $this->role !== null
            && (bool) $this->role->status;
    }

    protected static function booted()
    {
        static::addGlobalScope('storage', function ($builder) {
            $builder->with('storage');
        });
    }

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if ($model->isDirty('image')) {
                $value = Helpers::getDisk();

                DB::table('storages')->updateOrInsert([
                    'data_type' => get_class($model),
                    'data_id' => $model->id,
                    'key' => 'image',
                ], [
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($model->wasChanged(['staff_type', 'ops_status', 'password'])) {
                $model->tokens()->update(['revoked' => true]);
            }
        });
    }
}
