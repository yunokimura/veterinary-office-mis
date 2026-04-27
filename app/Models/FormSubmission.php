<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $submission_id
 * @property int $form_id
 * @property int|null $submitted_by_user_id
 * @property string|null $citizen_name
 * @property string|null $citizen_contact
 * @property string|null $citizen_address
 * @property array<array-key, mixed>|null $payload_json
 * @property string $status
 * @property int|null $reviewed_by
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 * @property string|null $review_notes
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ServiceForm $form
 * @property-read mixed $status_badge
 * @property-read \App\Models\User|null $reviewer
 * @property-read \App\Models\User|null $submitter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission rejected()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereCitizenAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereCitizenContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereCitizenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission wherePayloadJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereReviewNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereReviewedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereSubmissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereSubmittedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FormSubmission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'submitted_by_user_id',
        'citizen_name',
        'citizen_contact',
        'citizen_address',
        'payload_json',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
    ];

    protected $casts = [
        'payload_json' => 'array',
        'reviewed_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Get the form this submission belongs to.
     */
    public function form()
    {
        return $this->belongsTo(ServiceForm::class, 'form_id');
    }

    /**
     * Get the user who submitted (if logged in).
     */
    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }

    /**
     * Get the admin who reviewed this submission.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope for pending submissions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved submissions.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for rejected submissions.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
