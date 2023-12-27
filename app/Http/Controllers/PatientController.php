<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RegistrationPoli;
use App\Models\ServiceSchedule;
use App\Services\GenerateRMNumberService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'ktp_number' => 'required|unique:patients,ktp_number',
            'phone_number' => 'required',
        ]);

        $no_rm = GenerateRMNumberService::generate();

        Patient::create([
            'name' => $request->name,
            'address' => $request->address,
            'ktp_number' => $request->ktp_number,
            'phone_number' => $request->phone_number,
            'rm_number' => $no_rm,
        ]);

        return view('client.success-register', compact('no_rm'));
    }

    public function registerPoli(Request $request)
    {
        $request->validate([
            'rm_number' => 'required|exists:patients,rm_number',
            'poli_id' => 'required|exists:polis,id',
            'schedule_id' => 'required|exists:service_schedules,id',
            'complaint' => 'required',
        ]);

        // cek apakah jadwal yang dipilih itu memiliki poli yang sama
        $schedule = ServiceSchedule::with('doctor')->find($request->schedule_id);
        $poli = $schedule->doctor->poli->id;
        $patient = Patient::where('rm_number', $request->rm_number)->first();

        if ($poli != $request->poli_id) {
            $notification = array(
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Poli yang dipilih tidak sesuai dengan jadwal dokter',
            );

            return redirect()->back()->with($notification);
        }

        $registration = RegistrationPoli::create([
            'patient_id' => $patient->id,
            'poli_id' => $request->poli_id,
            'service_schedule_id' => $request->schedule_id,
            'status' => 'waiting',
            'complaint' => $request->complaint,
        ]);

        $registration->update([
            'queue_number' => 'ANTRIAN-' . $registration->id
        ]);

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Berhasil',
            'message' => 'Pendaftaran berhasil',
        );

        $notification['queue_number'] = $registration->queue_number;
        return redirect()->back()->with($notification);
    }
}
