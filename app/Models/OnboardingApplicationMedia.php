<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnboardingApplicationMedia extends Model
{
    use SoftDeletes;

    public const COLLECTION_LOGO = 'logo';

    public const COLLECTION_COVER = 'cover';

    public const COLLECTION_VENUE_INSIDE = 'venue_inside';

    public const COLLECTION_VENUE_OUTSIDE = 'venue_outside';

    public const COLLECTION_MENU = 'menu';

    public const COLLECTION_TIN_CERTIFICATE = 'tin_certificate';

    public const COLLECTIONS = [
        self::COLLECTION_LOGO,
        self::COLLECTION_COVER,
        self::COLLECTION_VENUE_INSIDE,
        self::COLLECTION_VENUE_OUTSIDE,
        self::COLLECTION_MENU,
        self::COLLECTION_TIN_CERTIFICATE,
    ];

    public const STATUS_TEMPORARY = 'temporary';

    public const STATUS_ATTACHED = 'attached';

    public const STATUS_DELETING = 'deleting';

    protected $fillable = [
        'onboarding_application_id',
        'onboarding_manager_id',
        'draft_key',
        'collection',
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size_bytes',
        'checksum_sha256',
        'sort_order',
        'status',
        'uploaded_at',
    ];

    protected $hidden = [
        'draft_key',
        'disk',
        'path',
        'checksum_sha256',
    ];

    protected $casts = [
        'size_bytes' => 'integer',
        'sort_order' => 'integer',
        'uploaded_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(OnboardingApplication::class, 'onboarding_application_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'onboarding_manager_id');
    }
}
