<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['drug'];

    public function drug()
    {
        return $this->belongsTo(Drug::class, 'drug_id');
    }

    public function checkup()
    {
        return $this->belongsTo(Checkup::class, 'checkup_id');
    }
}
