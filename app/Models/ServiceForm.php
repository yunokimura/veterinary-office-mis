<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $form_id
 * @property string $form_type
 * @property string $title
 * @property string|null $description
 * @property bool $is_active
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Announcement> $announcements
 * @property-read int|null $announcements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FormSubmission> $approvedSubmissions
 * @property-read int|null $approved_submissions_count
 * @property-read \App\Models\User|null $creator
 * @property-read mixed $type_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FormSubmission> $pendingSubmissions
 * @property-read int|null $pending_submissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FormSubmission> $submissions
 * @property-read int|null $submissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereFormType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceForm whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_type',
        'title',
        'description',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who created the form.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the announcements linked to this form.
     */
    public function announcements()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_forms', 'form_id', 'announcement_id')
            ->withTimestamps();
    }

    /**
     * Get the submissions for this form.
     */
    public function submissions()
    {
        return $this->hasMany(FormSubmission::class, 'form_id');
    }

    /**
     * Get pending submissions.
     */
    public function pendingSubmissions()
    {
        return $this->hasMany(FormSubmission::class, 'form_id')->where('status', 'pending');
    }

    /**
     * Get approved submissions.
     */
    public function approvedSubmissions()
    {
        return $this->hasMany(FormSubmission::class, 'form_id')->where('status', 'approved');
    }

    /**
     * Get form type label.
     */
    public function getTypeLabelAttribute()
    {
        return match($this->form_type) {
            'kapon' => 'Libre Kapon',
            'vaccination' => 'Vaccination',
            'pet_registration' => 'Pet Registration',
            'adoption' => 'Adoption',
            'bite_report' => 'Animal Bite Report',
            'stray_report' => 'Stray Animal Report',
            default => ucfirst(str_replace('_', ' ', $this->form_type)),
        };
    }
}
