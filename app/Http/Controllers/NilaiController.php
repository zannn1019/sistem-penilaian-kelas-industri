<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $cek_data = Nilai::where('id_siswa', $request->id_siswa)->where('id_tugas', $request->id_tugas);
            $validatedData = $request->validate([
                'id_siswa' => ['required'],
                'id_tugas' => ['required'],
                'nilai' => ['required']
            ]);
            if (!$cek_data->count()) {
                if (Nilai::create($validatedData)) {
                    return response()->json(['success' => 'data_store', 'time' => date(now())]);
                } else {
                    return response()->json(['error' => 'Nilai gagal di tambahkan!']);
                }
            } else {
                $nilai = $cek_data;
                if ($nilai->update($validatedData)) {
                    return response()->json(['success' => "data_update", 'time' => date(now())]);
                } else {
                    return response()->json(['error' => 'Nilai gagal di ubah!']);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NIlai $nIlai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NIlai $nIlai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NIlai $nIlai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NIlai $nIlai)
    {
        //
    }
}
