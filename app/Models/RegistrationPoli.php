<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPoli extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['patient', 'schedule'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function schedule()
    {
        return $this->belongsTo(ServiceSchedule::class, 'service_schedule_id');
    }

    public function checkup()
    {
        return $this->hasOne(Checkup::class, 'registration_poli_id');
    }
}
