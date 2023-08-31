<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_kelas = Kelas::find(Request::capture()->kelas);
        return view('dashboard.admin.forms.createSiswa', [
            'title' => "Siswa",
            'full' => true,
            'data' => $data_kelas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tahun_ajaran = $request->tahun_ajar == null ? date("Y") . '/' . date("Y") + 1 : $request->tahun_ajar;
        $semester = $request->semester == null ? '1' : $request->semester;
        $request['tahun_ajar'] = $tahun_ajaran;
        $request['semester'] = $semester;
        $validated_data = $request->validate([
            'id_sekolah' => ['required'],
            'id_kelas' => ['required'],
            'nis' => ['required', 'unique:siswa,nis'],
            'nama' => ['required'],
            'no_telp' => ['required'],
            'tahun_ajar' => ['required'],
            'semester' => ['required']
        ]);
        // dd($validated_data);
        Siswa::create($validated_data);
        return redirect()->route('kelas.show', ['kela' => $request->id_kelas])->with('success', 'Siswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        //
    }
}
