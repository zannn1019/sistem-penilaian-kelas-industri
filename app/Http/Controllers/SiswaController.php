<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\PengajarMapel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use NumberToWords\NumberToWords;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $validated_data = $request->validate([
            'id_sekolah' => ['required'],
            'id_kelas' => ['required'],
            'nis' => ['required', 'unique:siswa,nis'],
            'nama' => ['required'],
            'no_telp' => ['required'],
            'email' => ['required', 'email:dns']
        ]);
        Siswa::create($validated_data);
        return redirect()->route('kelas.show', ['kela' => $request->id_kelas])->with('success', 'Siswa berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        // ?? Mengambil kelas siswa
        $kelas = Kelas::find($siswa->id_kelas);

        // ?? Mengambil tugas siswa
        $tugas = $kelas->tugas->where('tahun_ajar', $siswa->kelas->tahun_ajar)
            ->where('semester', $siswa->kelas->semester);

        // ?? Mengambil total semua tugas
        $total = $tugas->count();

        // ?? Mengambil daftar mapel yang dipelajari
        $mapelIds = PengajarMapel::whereIn('id_user', $kelas->pengajar->pluck('id')->toArray())
            ->pluck('id_mapel')
            ->toArray();
        $avgNilai = Nilai::siswaAvg($siswa);
        return view("dashboard.admin.pages.detailSiswa", [
            'title' => "Detail Siswa",
            'full' => true,
            'info_siswa' => $siswa,
            'daftar_mapel' => Mapel::whereIn('id', $mapelIds)->get(),
            'nomor_id' => NumberToWords::transformNumber('id', $siswa->id),
            'rata_rata' => $avgNilai,
            'tugas' => [
                'total' => $total,
                'ternilai' => $siswa->nilai()->count(),
                'tugas' =>  $tugas->whereIn('tipe', ['tugas'])->count(),
                'kuis' =>  $tugas->whereIn('tipe', ['quiz'])->count(),
                'ujian' =>  $tugas->whereIn('tipe', ['assessment_blok_a', 'assessment_blok_b'])->count(),
            ]
        ]);
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
        $cek_data = Siswa::where('nis', $request->nis);
        if ($cek_data->count() && $cek_data->first()->id != $siswa->id) {
            return redirect()->back()->with('error', 'NIS sudah digunakan!');
        }
        $validated_data = $request->validate([
            'id_sekolah' => ['required'],
            'id_kelas' => ['required'],
            'nis' => ['required'],
            'nama' => ['required'],
            'no_telp' => ['required'],
            'email' => ['required', 'email:dns']
        ]);
        $siswa->update($validated_data);
        return redirect()->back()->with('success', 'Siswa berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    //?? Destroy Siswa
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        activity()
            ->event('arsip')
            ->useLog('mapel')
            ->performedOn($siswa)
            ->causedBy(auth()->user()->id)
            ->withProperties(['role' => auth()->user()->role])
            ->log('Mengarsipkan data siswa');
        return redirect()->route('kelas.show')->with('success', "Siswa berhasil di arsipkan");
    }

    public function getExcelFormat()
    {
        $file = public_path() . "/excel/siswa.xlsx";
        $headers = array(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        );
        return response()->download($file, "siswa_import_example.xlsx", $headers);
    }

    public function importSiswa(Kelas $kelas, Request $request)
    {
        if ($request->hasFile('excel-file')) {
            $import = new SiswaImport($kelas);
            Excel::import($import, $request->file('excel-file'));

            $duplicateCount = $import->getDuplicateData();
            $incompleteCount = $import->getErrorCount();
            $successCount = $import->getSuccessCount();
            if ($duplicateCount > 0 || $incompleteCount > 0) {
                Session::flash('error', $duplicateCount . ' Data duplikat dan ' . $incompleteCount . ' data tidak berhasil ditambahkan!');
            }

            if ($successCount > 0) {
                Session::flash('success', $successCount . ' Data berhasil ditambahkan!');
            }

            return redirect()->back();
        }
    }
}
