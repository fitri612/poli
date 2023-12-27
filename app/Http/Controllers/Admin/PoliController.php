<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polis = Poli::all();
        return view('dashboard.admin.poli.index', compact('polis'));
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
            'description' => 'required'
        ], [
            'name.required' => 'Nama poli harus diisi',
            'description.required' => 'Deskripsi poli harus diisi'
        ]);

        Poli::create($validation);

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Poli berhasil ditambahkan',
            'message' => 'Data poli berhasil ditambahkan'
        );

        return back()->with($notification);
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
        $validation  = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ], [
            'name.required' => 'Nama poli harus diisi',
            'description.required' => 'Deskripsi poli harus diisi'
        ]);

        $poli = Poli::find($id);

        if (!$poli) {
            $notification = array(
                'status' => 'error',
                'title' => 'Poli tidak ditemukan',
                'message' => 'Data poli tidak ditemukan'
            );

            return back()->with($notification);
        }

        $poli->update($validation);

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Poli berhasil diupdate',
            'message' => 'Data poli berhasil diupdate'
        );

        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poli = Poli::find($id);

        if (!$poli) {
            $notification = array(
                'status' => 'error',
                'title' => 'Poli tidak ditemukan',
                'message' => 'Data poli tidak ditemukan'
            );

            return back()->with($notification);
        }

        $poli->delete();

        $notification = array(
            'status' => 'toast_success',
            'title' => 'Poli berhasil dihapus',
            'message' => 'Data poli berhasil dihapus'
        );

        return back()->with($notification);
    }
}
