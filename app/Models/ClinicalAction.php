<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $case_title
 * @property string|null $action_type
 * @property int|null $pet_id
 * @property string|null $animal_name
 * @property string|null $species
 * @property string|null $owner_name
 * @property string|null $owner_contact
 * @property \Illuminate\Support\Carbon|null $action_date
 * @property string $description
 * @property string|null $diagnosis
 * @property string|null $treatment_given
 * @property string|null $medication
 * @property \Illuminate\Support\Carbon|null $follow_up_date
 * @property string|null $outcome
 * @property int|null $veterinarian_id
 * @property int|null $barangay_id
 * @property int|null $assigned_to
 * @property string $status
 * @property string|null $remarks
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\User|null $veterinarian
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereActionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereAnimalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereCaseTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereFollowUpDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereMedication($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereOutcome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereTreatmentGiven($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicalAction whereVeterinarianId($value)
 * @mixin \Eloquent
 */
class ClinicalAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_type',
        'pet_id',
        'barangay_id',
        'animal_name',
        'species',
        'owner_name',
        'owner_contact',
        'action_date',
        'description',
        'diagnosis',
        'treatment_given',
        'medication',
        'follow_up_date',
        'outcome',
        'veterinarian_id',
        'created_by',
    ];

    protected $casts = [
        'action_date' => 'date',
        'follow_up_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function veterinarian()
    {
        return $this->belongsTo(User::class, 'veterinarian_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public const ACTION_TYPES = [
        'surgery' => 'Surgery',
        'treatment' => 'Treatment',
        'checkup' => 'Check-up',
        'emergency' => 'Emergency',
        'dental' => 'Dental Care',
        'grooming' => 'Grooming',
        'other' => 'Other',
    ];

    public const OUTCOMES = [
        'completed' => 'Completed',
        'ongoing' => 'Ongoing',
        'referred' => 'Referred',
        'died' => 'Died/Euthanized',
        'released' => 'Released',
    ];
}