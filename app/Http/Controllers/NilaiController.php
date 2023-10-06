<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ?? Jika request lewat XHTTP request / AJAX
        if ($request->ajax()) {
            // ?? Mengambil data nilai dan data siswa
            $nilai = Nilai::where('id_siswa', $request->get('id_siswa'))->get();
            $siswa = Siswa::find($request->get('id_siswa'));

            // ?? Mengambil data jumlah tugas,kuis dan ujian yang sudah di nilai
            $tugas = $nilai->whereIn("tugas.tipe", ['tugas'])->count();
            $kuis = $nilai->whereIn("tugas.tipe", ['quiz'])->count();
            $ujian = $nilai->whereIn("tugas.tipe", ['PTS', 'PAS'])->count();

            // ?? Mengambil data nilai yang belum di nilai dan total smeua tugas
            $belum = Kelas::find($siswa->id_kelas)->tugas->count() - $tugas - $kuis - $ujian;
            $total = Kelas::find($siswa->id_kelas)->tugas->count();

            return response()->json(['nilai' => [
                'total' => $total,
                'tugas' => $tugas,
                'kuis' => $kuis,
                'ujian' => $ujian,
                'belum' => $belum
            ]]);
        }
        if (auth()->user()->role == 'pengajar') {
            $data_nilai = collect([]);
            if ($request->hasAny(['filter', 'tgl'])) {
                $data_nilai = Nilai::all();
            }

            return view('dashboard.pengajar.pages.nilai', [
                'title' => "Nilai",
                'full' => false,
                'data_nilai' => $data_nilai
            ]);
        }
        return redirect()->back();
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
        // ?? Jika user request lewat XHTTP request / AJAX
        if ($request->ajax()) {
            // ?? Cek data nilai siswa apakah sudah dinilai atau belum
            $cek_data = Nilai::where('id_siswa', $request->id_siswa)->where('id_tugas', $request->id_tugas);
            $validatedData = $request->validate([
                'id_siswa' => ['required'],
                'id_tugas' => ['required'],
                'nilai' => ['required']
            ]);

            if (!$cek_data->count()) {
                // ?? Jika nilai nya belum di tambahkan
                if (Nilai::create($validatedData)) {
                    return response()->json(['success' => 'data_store', 'time' => date(now())]);
                } else {
                    return response()->json(['error' => 'Nilai gagal di tambahkan!']);
                }
            } else {
                // ?? Jika nilai nya sudah di tambahkan
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
    public function show(Nilai $nilai)
    {
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
