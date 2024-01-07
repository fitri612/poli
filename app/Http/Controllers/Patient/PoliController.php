<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\RegistrationPoli;
use App\Models\ServiceSchedule;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::all();
        $dataSchedules = ServiceSchedule::with('doctor')->get();
        $schedules = [];
        foreach ($dataSchedules as $schedule) {
            if ($schedule->is_active == 1) {
                array_push($schedules, $schedule);
            }
        }

        $registerPoli = RegistrationPoli::where('patient_id', auth()->user()->patient->id)->get();
        return view('dashboard.patient.poli.index', compact('polis', 'schedules', 'registerPoli'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'schedule_id' => 'required|exists:service_schedules,id',
            'complaint' => 'required',
        ]);

        $schedule = ServiceSchedule::with('doctor')->find($request->schedule_id);
        $poli = $schedule->doctor->poli->id;

        if ($poli != $request->poli_id) {
            $notification = array(
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Poli yang dipilih tidak sesuai dengan jadwal dokter',
            );

            return redirect()->back()->with($notification);
        }

        $registration = RegistrationPoli::create([
            'patient_id' => auth()->user()->patient->id,
            'poli_id' => $request->poli_id,
            'service_schedule_id' => $request->schedule_id,
            'status' => 'waiting',
            'complaint' => $request->complaint,
        ]);

        $registration->update([
            'queue_number' => "ANTRIAN-$request->poli_id." . $registration->id
        ]);

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Berhasil',
            'message' => 'Pendaftaran berhasil',
        );

        $notification['queue_number'] = $registration->queue_number;
        return redirect()->back()->with($notification);
    }

    public function show($id)
    {
        $checkup = RegistrationPoli::with('checkup')->where('id', $id)->where('patient_id', auth()->user()->patient->id)->firstOrFail();
        return view('dashboard.patient.poli.history', compact('checkup'));
    }
}
