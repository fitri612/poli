<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drugs = Drug::all();
        return view('dashboard.admin.drug.index', compact('drugs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'packaging' => 'required',
            'price' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Nama obat harus diisi',
            'packaging.required' => 'Kemasan obat harus diisi',
            'price.required' => 'Harga obat harus diisi',
            'price.numeric' => 'Harga obat harus berupa angka',
            'price.min' => 'Harga obat minimal 1',
        ]);

        // check code drug
        if ($request->code == null) {
            $code = 'DRG' . rand(1000, 9999);
            $validation['code'] = $code;
        } else {
            $code = Drug::where('code', $request->code)->first();
            if ($code) {
                $notification = array(
                    'status' => 'error',
                    'title' => 'Kode obat sudah digunakan',
                    'message' => 'Kode obat sudah digunakan'
                );
                return back()->with($notification);
            } else {
                $validation['code'] = $request->code;
            }
        }

        Drug::create($validation);

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Data obat berhasil ditambahkan',
            'message' => 'Data obat berhasil ditambahkan'
        );

        return redirect()->route('dashboard.admin.drug.index')->with($notification);
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
        $drug = Drug::findOrfail($id);

        $validation = $request->validate([
            'name' => 'required',
            'packaging' => 'required',
            'price' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Nama obat harus diisi',
            'packaging.required' => 'Kemasan obat harus diisi',
            'price.required' => 'Harga obat harus diisi',
            'price.numeric' => 'Harga obat harus berupa angka',
            'price.min' => 'Harga obat minimal 1',
        ]);

        // check code drug
        if ($request->code == $drug->code) {
            $validation['code'] = $request->code;
        } else {
            $code = Drug::where('code', $request->code)->first();
            if ($code) {
                $notification = array(
                    'status' => 'error',
                    'title' => 'Kode obat sudah digunakan',
                    'message' => 'Kode obat sudah digunakan'
                );
                return back()->with($notification);
            } else {
                $validation['code'] = $request->code;
            }
        }


        $drug->update($validation);

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Data obat berhasil diubah',
            'message' => 'Data obat berhasil diubah'
        );

        return redirect()->route('dashboard.admin.drug.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drug = Drug::findOrfail($id);

        $drug->delete();

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Data obat berhasil dihapus',
            'message' => 'Data obat berhasil dihapus'
        );

        return redirect()->route('dashboard.admin.drug.index')->with($notification);
    }
}
