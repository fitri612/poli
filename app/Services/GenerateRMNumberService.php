<?php

namespace App\Services;

use App\Models\Patient;

class GenerateRMNumberService
{
    public static function generate()
    {
        $date = date('Ym');
        $lastPatient = Patient::orderBy('id', 'desc')->first();

        if ($lastPatient) {
            $lastPatientId = $lastPatient->id;
            $lastPatientId++;

            $lastPatientId = max(1, min($lastPatientId, 100));

            $lastPatientId = str_pad($lastPatientId, 3, '0', STR_PAD_LEFT);

            return $date . '-' . $lastPatientId;
        } else {
            return $date . '-001';
        }
    }
}
