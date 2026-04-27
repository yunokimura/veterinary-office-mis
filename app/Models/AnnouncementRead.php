<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $announcement_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $read_at
 * @property-read \App\Models\Announcement $announcement
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead whereAnnouncementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnnouncementRead whereUserId($value)
 * @mixin \Eloquent
 */
class AnnouncementRead extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'announcement_reads';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'announcement_id',
        'user_id',
        'read_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the announcement.
     */
    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    /**
     * Get the user who read the announcement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
