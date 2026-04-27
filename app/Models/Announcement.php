<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $attachment_path
 * @property string|null $photo_path
 * @property string $category
 * @property bool $is_active
 * @property string|null $status
 * @property Carbon|null $event_date
 * @property string|null $event_time
 * @property string|null $location
 * @property int|null $barangay_id
 * @property string|null $contact_number
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $createdBy
 * @property-read Barangay|null $barangay
 * @property-read Collection<int, AnnouncementRead> $reads
 * @property-read int|null $reads_count
 * @property-read User|null $usersRead
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement campaigns()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement events()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereAttachmentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereEventTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Announcement whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Announcement extends Model
{
    const CATEGORY_CAMPAIGN = 'campaign';

    const CATEGORY_EVENT = 'event';

    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'content',
        'attachment_path',
        'photo_path',
        'category',
        'is_active',
        'status',
        'event_date',
        'event_time',
        'location',
        'barangay_id',
        'contact_number',
        'created_by',
        'organized_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
    ];

    public static function getCategories(): array
    {
        return [
            self::CATEGORY_CAMPAIGN,
            self::CATEGORY_EVENT,
        ];
    }

    public function scopeCampaigns($query)
    {
        return $query->where('category', self::CATEGORY_CAMPAIGN);
    }

    public function scopeEvents($query)
    {
        return $query->where('category', self::CATEGORY_EVENT);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reads(): HasMany
    {
        return $this->hasMany(AnnouncementRead::class, 'announcement_id');
    }

    public function usersRead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'announcement_reads');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }
}
