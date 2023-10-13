<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Sekolah;
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
            $siswa = Siswa::find($request->get('id_siswa'));
            $nilai = Nilai::where('id_siswa', $request->get('id_siswa'))->where('tahun_ajar', $siswa->kelas->tahun_ajar)->where('semester', $siswa->kelas->semester)->get();

            // ?? Mengambil data jumlah tugas,kuis dan ujian yang sudah di nilai
            $tugas = $nilai->whereIn("tugas.tipe", ['tugas'])->count();
            $kuis = $nilai->whereIn("tugas.tipe", ['quiz'])->count();
            $ujian = $nilai->whereIn("tugas.tipe", ['assessment_blok_a', 'assessment_blok_b'])->count();

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
            $data_nilai = Nilai::filterByTgl($request->input('tgl'))
                ->filterBySekolah($request->input('sekolah'))
                ->filterByKelas($request->input('kelas'))
                ->filterBySemester($request->input('semester'))
                ->filterByTugas($request->input('tugas'))
                ->get();
            return view('dashboard.pengajar.pages.nilai', [
                'title' => "Nilai",
                'full' => false,
                'data_nilai' => $data_nilai,
                'data_sekolah' => Sekolah::all(),
                'terakhir_dinilai' => Nilai::latest()->take(2)->get()
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
                'nilai' => ['required'],
                'tahun_ajar' => ['required'],
                'semester' => ['required'],
            ]);

            if (!$cek_data->count()) {
                // ?? Jika nilai nya belum di tambahkan
                if (Nilai::create($validatedData)) {
                    activity()
                        ->event('created')
                        ->useLog('nilai')
                        ->performedOn(Nilai::latest()->first())
                        ->causedBy(auth()->user()->id)
                        ->log('Menambah data nilai');
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
                        ->useLog('nilai')
                        ->performedOn($nilai->first())
                        ->causedBy(auth()->user()->id)
                        ->log('Mengubah data nilai');
                    return response()->json(['success' => "data_update", 'time' => date(now())]);
                } else {
                    return response()->json(['error' => 'Nilai gagal di ubah!']);
                }
            }
        }
        return redirect()->back();
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
