<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\RegistrationPoli;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $patients = Patient::whereHas('registrationPoli', function ($query) {
            $query->whereHas('schedule', function ($query) {
                $query->where('doctor_id', auth()->user()->doctor->id);
            });
        })->get();

        return view('dashboard.doctor.history.index', compact('patients'));
    }

    public function show($id)
    {
        $checkup = RegistrationPoli::with('checkup')->where('patient_id', $id)->where('status','done')->whereHas('schedule', function ($query) {
            $query->where('doctor_id', auth()->user()->doctor->id);
        })->get();
        return view('dashboard.doctor.history.detail', compact('checkup'));
    }
}
