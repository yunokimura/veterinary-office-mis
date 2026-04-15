<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'appointment_date',
        'appointment_time',
        'service_type',
        'service_id',
        'status',
        'total_weight',
        'metadata',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'time',
        'metadata' => 'array',
    ];

    public function service()
    {
        return $this->morphTo('service', 'service_type', 'service_id');
    }
}