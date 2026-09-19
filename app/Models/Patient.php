<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $suffix
 * @property Carbon|null $date_of_birth
 * @property string|null $gender
 * @property string|null $contact_number
 * @property string|null $address
 * @property int|null $barangay_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Barangay|null $barangay
 * @property-read int|null $age
 */
class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'date_of_birth',
        'age',
        'gender',
        'contact_number',
        'address',
        'barangay_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function getAgeAttribute(): ?int
    {
        if ($this->attributes['age'] !== null) {
            return (int) $this->attributes['age'];
        }

        if (!$this->date_of_birth) {
            return null;
        }

        return Carbon::parse($this->date_of_birth)->age;
    }

    public function getFullNameAttribute(): string
    {
        $name = $this->first_name;

        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }

        if ($this->last_name) {
            $name .= ' ' . $this->last_name;
        }

        if ($this->suffix) {
            $name .= ' ' . $this->suffix;
        }

        return $name;
    }
}
