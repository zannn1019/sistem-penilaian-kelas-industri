<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pengajar;
use App\Models\PengajarMapel;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\User;
use NumberToWords\NumberToWords;

class AdminPengajarController extends Controller
{
    //

    public function index(User $pengajar)
    {
        $tugas = $pengajar->tugas()->with('kelas.siswa', 'nilai')->get();
        $total_tugas = $tugas->pluck('kelas.siswa')->flatten()->count();
        $total_ternilai = $tugas->pluck('nilai')->flatten()->count();
        $status_tugas = collect([
            "total_tugas" => $total_tugas,
            "total_ternilai" => $total_ternilai,
            'harian' => [
                'total' => $pengajar->tugas()->tipe(['tipe' => ['tugas', 'quiz']])->count(),
                'ternilai' => 0
            ],
            'PTS' => [
                'total' => $pengajar->tugas()->tipe(['tipe' => ['PTS']])->count(),
                'ternilai' => 0
            ],
            'PAS' => [
                'total' => $pengajar->tugas()->tipe(['tipe' => ['PAS']])->count(),
                'ternilai' => 0
            ],
        ]);

        return view('dashboard.admin.pages.adminPengajar.dashboard', [
            'title' => "Dashboard Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar,
            'status_tugas' => $status_tugas
        ]);
    }

    public function kelas(User $pengajar)
    {
        return view('dashboard.admin.pages.adminPengajar.kelas', [
            'title' => "Kelas Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar
        ]);
    }
    public function showMapel(User $pengajar, Kelas $kelas)
    {
        $mapel = PengajarMapel::where('id_user', $pengajar->id);

        return view('dashboard.admin.pages.adminPengajar.selectMapel', [
            'title' => "Pilih Mapel",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'data_mapel' => $mapel
        ]);
    }
    public function showTugas(User $pengajar, Kelas $kelas, PengajarMapel $mapel)
    {
        $daftar_tugas = collect([
            'tugas' => $mapel->tugas()->tipe(['tipe' => ['tugas', 'quiz']])->where('id_kelas', $kelas->id)->get(),
            'ujian' => $mapel->tugas()->tipe(['tipe' => ['PTS', 'PAS']])->where('id_kelas', $kelas->id)->get(),
        ]);
        return view('dashboard.admin.pages.adminPengajar.selectTugas', [
            'title' => "Pilih Tugas",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'info_mapel' => $mapel,
            'daftar_tugas' => $daftar_tugas,
            'pengajar_mapel' => $pengajar->mapel()->where('mapel.id', $mapel->id)->value('pengajar_mapel.id')
        ]);
    }
    public function showSiswa(User $pengajar, Kelas $kelas)
    {
        return view('dashboard.admin.pages.adminPengajar.showSiswa', [
            'title' => "Daftar Siswa",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
        ]);
    }
    public function showPengajar(User $pengajar, Kelas $kelas)
    {
        return view('dashboard.admin.pages.adminPengajar.showPengajar', [
            'title' => "Daftar Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'data_pengajar' => $kelas->pengajar()
        ]);
    }
    public function nilaiSiswaPerKelas(User $pengajar, Kelas $kelas, Tugas $tugas)
    {
        return view('dashboard.admin.pages.adminPengajar.nilaiSiswaPerKelas', [
            'title' => "Nilai Siswa",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'data_tugas' => $tugas
        ]);
    }

    public function detailSiswa(User $pengajar, Kelas $kelas, Siswa $siswa)
    {
        // ?? Mengambil tugas siswa
        $tugas = Kelas::find($siswa->id_kelas)->tugas;

        // ?? Mengambil total semua tugas
        $total = $tugas->count();

        // ?? Mengambil daftar mapel yang dipelajari
        $mapelIds = PengajarMapel::whereIn('id_user', $kelas->pengajar->pluck('id')->toArray())
            ->pluck('id_mapel')
            ->toArray();

        return view('dashboard.admin.pages.adminPengajar.detailSiswa', [
            'title' => 'Detail Siswa',
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'info_siswa' => $siswa,
            'daftar_mapel' => Mapel::whereIn('id', $mapelIds)->get(),
            'nomor_id' => NumberToWords::transformNumber('id', $siswa->id),
            'tugas' => [
                'total' => $total,
                'ternilai' => $siswa->nilai()->count(),
                'tugas' =>  $tugas->whereIn('tipe', ['tugas'])->count(),
                'kuis' =>  $tugas->whereIn('tipe', ['quiz'])->count(),
                'ujian' =>  $tugas->whereIn('tipe', ['PAS', 'PTS'])->count(),
            ]
        ]);
    }
}
