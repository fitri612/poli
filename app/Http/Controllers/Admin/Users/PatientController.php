<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use App\Services\GenerateRMNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    public function index()
    {
        $patients = Patient::all();
        return view('dashboard.admin.users.patient.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'nama' => 'required',
            'ktp' => 'required|unique:patients,ktp_number',
            'no_telp' => 'required',
            'alamat' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        try {
            DB::beginTransaction();

            $toUsersTable = [
                'name' => $request->nama,
                'email' => $request->email,
                'email_verified_at' => now(),
                'role' => 'guest',
                'is_active' => 1,
                'password' => bcrypt($request->password),
                'remember_token' => null,
            ];

            $user = User::create($toUsersTable);

            $no_rm = GenerateRMNumberService::generate();

            $toPatientsTable = [
                'name' => $request->nama,
                'ktp_number' => $request->ktp,
                'rm_number' => $no_rm,
                'phone_number' => $request->no_telp,
                'address' => $request->alamat,
                'user_id' => $user->id,
            ];

            Patient::create($toPatientsTable);

            DB::commit();
            $notification = array(
                'message' => 'Data berhasil ditambahkan',
                'alert-type' => 'success'
            );

            return Redirect()->back()->with($notification);
        } catch (\Throwable $th) {
            DB::rollback();
            $notification = array(
                'message' => 'Data gagal ditambahkan',
                'alert-type' => 'error'
            );

            return Redirect()->back()->with($notification);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $user = User::find($id);

            if (!$user) {
                $notification = array(
                    'message' => 'Data gagal diubah',
                    'alert-type' => 'error'
                );

                return Redirect()->back()->with($notification);
            } else {
                $user->update([
                    'name' => $request->nama,
                ]);

                $user->patient()->update([
                    'name' => $request->nama,
                    'phone_number' => $request->no_telp,
                    'address' => $request->alamat,
                ]);

                DB::commit();
                $notification = array(
                    'message' => 'Data berhasil diubah',
                    'alert-type' => 'success'
                );

                return Redirect()->back()->with($notification);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            $notification = array(
                'message' => 'Data gagal diubah',
                'alert-type' => 'error'
            );

            return Redirect()->back()->with($notification);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            $notification = array(
                'message' => 'Data gagal dihapus',
                'alert-type' => 'error'
            );

            return Redirect()->back()->with($notification);
        }

        $user->patient()->delete();

        $user->delete();

        $notification = array(
            'message' => 'Data berhasil dihapus',
            'alert-type' => 'success'
        );

        return Redirect()->back()->with($notification);
    }
}
