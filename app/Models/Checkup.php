<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['drugDetail'];

    public function registrationPoli()
    {
        return $this->belongsTo(RegistrationPoli::class, 'registration_poli_id');
    }

    public function drugDetail()
    {
        return $this->hasMany(DrugDetail::class, 'checkup_id');
    }
}
