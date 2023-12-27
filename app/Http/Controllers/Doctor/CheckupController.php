<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\RegistrationPoli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckupController extends Controller
{
    public function index()
    {
        $registration = RegistrationPoli::whereHas('schedule', function ($query) {
            $query->where('doctor_id', auth()->user()->doctor->id);
        })->get();

        return view('dashboard.doctor.checkup.index', compact('registration'));
    }

    public function checkupForm($id)
    {
        $registration = RegistrationPoli::findOrfail($id);
        $drugs = Drug::all();
        return view('dashboard.doctor.checkup.form', compact('registration', 'drugs'));
    }

    public function checkup(Request $request, $id)
    {
        $registration = RegistrationPoli::findOrfail($id);

        $validation  = $request->validate([
            'date_checkup' => 'required|date',
            'note' => 'required',
            'drugs' => 'required|array',
        ]);

        try {
            DB::beginTransaction();
            $registration->checkup()->create([
                'date_checkup' => $validation['date_checkup'],
                'note' => $validation['note'],
            ]);

            $total_payment = 0;
            foreach ($validation['drugs'] as $drug_id) {
                $drug = Drug::findOrfail($drug_id);
                $total_payment += (int) $drug->price;
                $registration->checkup->drugDetail()->create([
                    'drug_id' => $drug->id,
                ]);
            }

            $registration->update([
                'status' => 'done',
            ]);

            $registration->checkup->update([
                'amount' => $total_payment + config('serviceprice.service.price'),
                'total_payment' => $total_payment + config('serviceprice.service.price'),
            ]);

            DB::commit();

            $notification = array(
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil melakukan pemeriksaan ',
            );
            return redirect()->route('dashboard.doctor.checkup.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            $notification = array(
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Gagal melakukan pemeriksaan',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function update(Request $request, $id)
    {
        $registration = RegistrationPoli::findOrfail($id);

        $validation  = $request->validate([
            'date_checkup' => 'required|date',
            'note' => 'required',
            'drugs' => 'required|array',
        ]);

        try {
            DB::beginTransaction();
            $registration->checkup()->update([
                'date_checkup' => $validation['date_checkup'],
                'note' => $validation['note'],
            ]);

            $total_payment = 0;
            foreach ($validation['drugs'] as $drug_id) {
                $drug = Drug::findOrfail($drug_id);
                $total_payment += (int) $drug->price;
                $registration->checkup->drugDetail()->updateOrCreate([
                    'drug_id' => $drug->id,
                ]);
            }

            $registration->update([
                'status' => 'done',
            ]);

            $registration->checkup->update([
                'amount' => $total_payment + config('serviceprice.service.price'),
                'total_payment' => $total_payment + config('serviceprice.service.price'),
            ]);

            DB::commit();

            $notification = array(
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Berhasil melakukan pemeriksaan ',
            );
            return redirect()->route('dashboard.doctor.checkup.index')->with($notification);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            $notification = array(
                'status' => 'error',
                'title' => 'Gagal',
                'message' => 'Gagal melakukan pemeriksaan',
            );
            return redirect()->back()->with($notification);
        }
    }
}
