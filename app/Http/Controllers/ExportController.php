<?php

namespace App\Http\Controllers;

use App\Exports\NilaiExport;
use App\Models\Kelas;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function ExportPerKelas(Kelas $kelas)
    {
        $heading = [
            'No',
            'NIS',
            'Nama Siswa',
        ];
        $mapel_names = $kelas->pengajar->pluck('mapel')->flatten();

        foreach ($mapel_names as $mapel_name) {
            array_push($heading, $mapel_name['nama_mapel']);
        }
        return Excel::download(new NilaiExport($kelas, $heading), 'nilai_kelas_' .  $kelas->tingkat . '-' . $kelas->jurusan . '-' . $kelas->kelas . '.xlsx');
        return redirect()->back();
    }
    public function ExportPerSiswa()
    {
    }
    public function ExportPerTugas()
    {
    }
}
