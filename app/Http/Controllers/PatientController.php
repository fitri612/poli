<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RegistrationPoli;
use App\Models\ServiceSchedule;
use App\Models\User;
use App\Services\GenerateRMNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function register(Request $request)
    {

        try {
            DB::beginTransaction();
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'ktp_number' => 'required|unique:patients,ktp_number',
                'phone_number' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:6',
            ]);

            $no_rm = GenerateRMNumberService::generate();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'guest',
                'password' => bcrypt($request->password),
                'is_active' => 1,
            ]);

            $patien = Patient::create([
                'name' => $request->name,
                'address' => $request->address,
                'ktp_number' => $request->ktp_number,
                'phone_number' => $request->phone_number,
                'rm_number' => $no_rm,
                'user_id' => $user->id,
            ]);

            DB::commit();
            $notification = array(
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Pendaftaran berhasil',
            );
            return redirect()->route('login')->with($notification);
        } catch (\Throwable $th) {
            DB::rollBack();
            $notification = array(
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Pendaftaran gagal',
            );
            return redirect()->back()->with($notification);
        }
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
            'service_schedule_id' => $request->schedule_id,
            'status' => 'waiting',
            'complaint' => $request->complaint,
        ]);

        $registration->update([
            'queue_number' => "ANTRIAN-$request->poli_id-" . $registration->id
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
