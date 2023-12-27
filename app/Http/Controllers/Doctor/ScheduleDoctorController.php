<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ServiceSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleDoctorController extends Controller
{
    public function index()
    {
        $schedule = ServiceSchedule::where('doctor_id', auth()->user()->doctor->id)->first();
        return view('dashboard.doctor.schedule.index', compact('schedule'));
    }

    public function store(Request $request)
    {
        $user = User::with('doctor')->find(auth()->user()->id);

        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // cek apakah jadwal bertabrakan dengan jadwal lain
        $schedule = ServiceSchedule::where('doctor_id', '!=', $user->doctor->id)
            ->where('day', $request->hari)
            ->where('start_time', '<=', $request->jam_mulai)
            ->where('end_time', '>=', $request->jam_selesai)
            ->first();

        // cek jika pada jadwal sebelumnya ada pasien yg periksa & hari ini adalah hari yg sama
        //  maka tidak boleh mengubah jadwal


        if ($schedule) {
            $notification = array(
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Jadwal bertabrakan dengan jadwal lain',
            );

            return redirect()->back()->with($notification);
        }

        $user->doctor->serviceSchedule()->updateOrCreate(
            [
                'doctor_id' => $user->doctor->id,
            ],
            [
                'day' => $request->hari,
                'start_time' => $request->jam_mulai,
                'end_time' => $request->jam_selesai,
            ]
        );

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Berhasil',
            'message' => 'Jadwal berhasil terapkan',
        );

        return redirect()->back()->with($notification);
    }
}
