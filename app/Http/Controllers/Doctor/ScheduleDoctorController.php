<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPoli;
use App\Models\ServiceSchedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleDoctorController extends Controller
{
    public function index()
    {
        $allData = ServiceSchedule::all();
        $schedule = [];
        foreach ($allData as $data) {
            if ($data->doctor_id == auth()->user()->doctor->id) {
                array_push($schedule, $data);
            }
        }
        return view('dashboard.doctor.schedule.index', compact('schedule'));
    }

    public function store(Request $request)
    {
        $user = User::with('doctor')->find(auth()->user()->id);

        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'is_active' => 'required',
        ]);


        $dataServis = ServiceSchedule::all();
        foreach ($dataServis as $data) {
            if ($data->day == $request->hari) {
                $notification = array(
                    'status' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Jadwal tidak dapat diubah, karena sudah ada jadwal yang sama',
                );

                return redirect()->back()->with($notification);
            }
        }

        ServiceSchedule::create([
            'doctor_id' => $user->doctor->id,
            'day' => $request->hari,
            'start_time' => $request->jam_mulai,
            'end_time' => $request->jam_selesai,
            'is_active' => $request->is_active,
        ]);

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Berhasil',
            'message' => 'Jadwal berhasil terapkan',
        );

        return redirect()->back()->with($notification);
    }

    public function update(Request $request, $id)
    {
        $findData = ServiceSchedule::find($id);
        $checkData = RegistrationPoli::where('service_schedule_id', $findData->id)->where('status', 'waiting')->first();

        if ($checkData) {
            $notification = array(
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Jadwal tidak dapat diubah, karena sudah ada pasien yang terdaftar',
            );

            return redirect()->back()->with($notification);
        }

        $request->validate([
            'is_active' => 'required',
        ]);

        if ($findData->is_active == 1) {
            $findData->update([
                'is_active' => 0,
            ]);
        } else {
            $findData->update([
                'is_active' => 1,
            ]);
        }

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Berhasil',
            'message' => 'Jadwal berhasil terapkan',
        );

        return redirect()->back()->with($notification);
    }
}
