<?php

namespace App\Http\Controllers;

use App\Models\NilaiAkhir;
use Illuminate\Http\Request;

class NilaiAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
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
        if (!$request->ajax()) {
            abort(404);
        }
        $cek_data = NilaiAkhir::where('id_siswa', $request->id_siswa);
        $validatedData = $request->validate([
            'id_siswa' => ['required'],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['required_if:nilai,<=75'],
            'tahun_ajar' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            'semester' => ['required']
        ]);
        if (!$cek_data->count()) {
            // ?? Jika nilai nya belum di tambahkan
            if (NilaiAkhir::create($validatedData)) {
                activity()
                    ->event('created')
                    ->useLog('nilai_akhir')
                    ->performedOn(NilaiAkhir::latest()->first())
                    ->causedBy(auth()->user()->id)
                    ->log('Menambah data nilai akhir');
                return response()->json(['success' => 'data_store', 'time' => date(now())]);
            } else {
                return response()->json(['error' => 'Nilai gagal di tambahkan!']);
            }
        } else {
            // ?? Jika nilai nya sudah di tambahkan
            $nilai = $cek_data;
            if ($nilai->update($validatedData)) {
                activity()
                    ->event('update')
                    ->useLog('nilai_akhir')
                    ->performedOn($nilai->first())
                    ->causedBy(auth()->user()->id)
                    ->log('Mengubah data nilai akhir');
                return response()->json(['success' => "data_update", 'time' => date(now())]);
            } else {
                return response()->json(['error' => 'Nilai gagal di ubah!']);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NilaiAkhir $nilaiAkhir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiAkhir $nilaiAkhir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NilaiAkhir $nilaiAkhir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiAkhir $nilaiAkhir)
    {
        //
    }
}
