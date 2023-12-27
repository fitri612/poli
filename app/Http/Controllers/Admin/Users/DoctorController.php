<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Poli;
use App\Models\ServiceSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::all();
        $polis = Poli::all();
        return view('dashboard.admin.users.doctor.index', compact('doctors', 'polis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation  = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'poli_id' => 'required|exists:polis,id',
            // 'hari' => 'required',
            // 'jam_mulai' => 'required',
            // 'jam_selesai' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $validation['name'],
                'email' => $validation['email'],
                'password' => bcrypt($validation['password']),
                'is_active' => true,
                'role' => 'doctor'
            ]);

            $user->doctor()->create([
                'name' => $validation['name'],
                'phone_number' => $validation['phone_number'],
                'address' => $validation['address'],
                'poli_id' => $validation['poli_id']
            ]);

            // $doctor = Doctor::where('user_id', $user->id)->first();

            // ServiceSchedule::create([
            //     'doctor_id' => $doctor->id,
            //     'day' => $validation['hari'],
            //     'start_time' => $validation['jam_mulai'],
            //     'end_time' => $validation['jam_selesai'],
            // ]);

            DB::commit();
            $notification = array(
                'status' => 'toast_success',
                'title' => 'Dokter berhasil ditambahkan',
                'message' => 'Data dokter berhasil ditambahkan'
            );

            return back()->with($notification);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            $notification = array(
                'status' => 'error',
                'title' => 'Dokter gagal ditambahkan',
                'message' => 'Data dokter gagal ditambahkan'
            );

            return back()->with($notification);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validation  = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'poli_id' => 'required|exists:polis,id',
            'is_active' => 'required|in:0,1',
        ]);
        try {
            DB::beginTransaction();

            if (!$user) {
                $notification = array(
                    'status' => 'error',
                    'title' => 'Dokter gagal diupdate',
                    'message' => 'Data dokter gagal diupdate'
                );

                return back()->with($notification);
            } else {
                $user->update([
                    'name' => $validation['name'],
                    'email' => $validation['email'],
                    'password' => $request->password ? bcrypt($validation['password']) : $user->password,
                    'is_active' => $validation['is_active'],
                ]);

                $user->doctor()->update([
                    'name' => $validation['name'],
                    'phone_number' => $validation['phone_number'],
                    'address' => $validation['address'],
                    'poli_id' => $validation['poli_id']
                ]);

                DB::commit();
                $notification = array(
                    'status' => 'toast_success',
                    'title' => 'Dokter berhasil diupdate',
                    'message' => 'Data dokter berhasil diupdate'
                );

                return back()->with($notification);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            $notification = array(
                'status' => 'error',
                'title' => 'Dokter gagal diupdate',
                'message' => 'Data dokter gagal diupdate'
            );

            return back()->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            $notification = array(
                'status' => 'error',
                'title' => 'Dokter gagal dihapus',
                'message' => 'Data dokter gagal dihapus'
            );

            return back()->with($notification);
        }


        ServiceSchedule::where('doctor_id', $user->doctor->id)->delete();
        $user->doctor()->delete();
        $user->delete();

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Dokter berhasil dihapus',
            'message' => 'Data dokter berhasil dihapus'
        );

        return back()->with($notification);
    }
}
