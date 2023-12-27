<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['poli'];

    /**
     * Get the user associated with the doctor.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the poli associated with the doctor.
     */

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    /**
     * Get the service schedules associated with the doctor.
     */

    public function serviceSchedule()
    {
        return $this->hasOne(ServiceSchedule::class);
    }
}
