<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the user associated with the patient.
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrationPoli()
    {
        return $this->hasMany(RegistrationPoli::class, 'patient_id');
    }
}
