<?php

namespace App\Http\Controllers;

use App\Exports\inputNilaiTugasExport;
use App\Exports\KehadiranExports;
use App\Exports\NilaiExport;
use App\Exports\NilaiSiswaExport;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\PengajarMapel;
use App\Models\Siswa;
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
        array_push($heading, "Nilai Akhir");
        array_push($heading, "Nilai Tambahan");
        array_push($heading, "Total Nilai");

        return Excel::download(new NilaiExport(
            $kelas,
            $heading,
            1,
            "raport kelas " . $kelas->tingkat . '-' . $kelas->jurusan . '-' . $kelas->kelas . ' semester ' . $kelas->semester . ' (' . $kelas->tahun_ajar . ')'
        ), 'nilai_kelas_' .  $kelas->tingkat . '-' . $kelas->jurusan . '-' . $kelas->kelas . '.xlsx');
        return redirect()->back();
    }
    public function ExportPerSiswa(Siswa $siswa)
    {
        return Excel::download(new NilaiSiswaExport($siswa),  $siswa->nama . '_raport' . '.xlsx');
        return redirect()->back();
    }
    public function ExportPerTugas(Kelas $kelas, Mapel $mapel)
    {
        $heading = [
            'No',
            'NIS',
            'Nama Siswa',
        ];
        foreach ($mapel->tugas->where('tahun_ajar', $kelas->tahun_ajar)->where('semester', $kelas->semester) as $tugas) {
            array_push($heading, $tugas['nama']);
        }
        return Excel::download(new NilaiExport(
            $kelas,
            $heading,
            2,
            "raport kelas " . $kelas->tingkat . ' ' . $kelas->jurusan . ' ' . $kelas->kelas . ' - mapel ' . $mapel->nama_mapel . ' (' . $kelas->semester . '-' . $kelas->tahun_ajar . ')',
            $mapel
        ), 'nilai_tugas_mapel_'  . $mapel->nama_mapel . '_kelas_'  .  $kelas->tingkat . '-' . $kelas->jurusan . '-' . $kelas->kelas . '.xlsx');
        return redirect()->back();
    }

    public function ExportKehadiranPengajar($tipe)
    {
        return Excel::download(new KehadiranExports($tipe), 'Kehadiran Pengajar.xlsx');
    }

    public function ExportInputNilai(Kelas $kelas, PengajarMapel $mapel)
    {
        return Excel::download(new inputNilaiTugasExport($kelas, $mapel), 'Format input nilai siswa.xlsx');
    }
}
