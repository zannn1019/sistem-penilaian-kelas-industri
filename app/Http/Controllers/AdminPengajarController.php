<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pengajar;
use App\Models\PengajarMapel;
use App\Models\PengajarSekolah;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\User;
use NumberToWords\NumberToWords;
use PhpParser\Node\Expr\FuncCall;

class AdminPengajarController extends Controller
{
    //? Index
    public function index(User $pengajar)
    {
        $tugas = $pengajar->tugas()->with('kelas.siswa', 'nilai')->get();
        $total_tugas = $tugas->pluck('kelas.siswa')->flatten()->count();
        $total_ternilai = $tugas->pluck('nilai')->flatten()->count();
        $status_tugas = [
            "total_tugas" => $total_tugas,
            "total_ternilai" => $total_ternilai,
            'harian' => [
                'total' => 0,
                'ternilai' => 0,
            ],
            'PTS' => [
                'total' => 0,
                'ternilai' => 0,
            ],
            'PAS' => [
                'total' => 0,
                'ternilai' => 0,
            ],
        ];
        $groupedTugas = $tugas->groupBy('tipe');
        foreach ($groupedTugas as $tipe => $tugasByTipe) {
            if ($tipe === 'tugas' || $tipe === 'quiz') {
                $tipe = 'harian';
            }
            $totalTugasByTipe = $tugasByTipe->pluck('kelas.siswa')->flatten()->count();
            $totalTernilaiByTipe = $tugasByTipe->pluck('nilai')->flatten()->count();
            if (!isset($status_tugas[$tipe])) {
                $status_tugas[$tipe] = [
                    'total' => 0,
                    'ternilai' => 0,
                ];
            }
            $status_tugas[$tipe]['total'] += $totalTugasByTipe;
            $status_tugas[$tipe]['ternilai'] += $totalTernilaiByTipe;
        }

        return view('dashboard.admin.pages.adminPengajar.dashboard', [
            'title' => "Dashboard Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar,
            'status_tugas' => $status_tugas
        ]);
    }

    //? Daftar kelas untuk dashboard pengajar pada page admin
    public function kelas(User $pengajar)
    {
        return view('dashboard.admin.pages.adminPengajar.kelas', [
            'title' => "Kelas Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar
        ]);
    }

    //? Daftar mapel yang diajarkan oleh pengajar
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

    //? Daftar tugas yang dibuat oleh pengajar
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
            'pengajar_mapel' => $mapel
        ]);
    }

    //? Daftar siswa per kelas
    public function showSiswa(User $pengajar, Kelas $kelas)
    {
        return view('dashboard.admin.pages.adminPengajar.showSiswa', [
            'title' => "Daftar Siswa",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
        ]);
    }

    //? Daftar pengajar yang mengajar pada kelas yang di pilih
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

    //? Daftar nilai siswa per tugas yang dibuat oleh pengajar
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

    //? Informasi identitas dan nilai siswa
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

    //? Daftar nilai siswa per mapel yang di ajarkan oleh pengajar
    public function raporKelas(User $pengajar, Kelas $kelas)
    {
        return view('dashboard.admin.pages.adminPengajar.raporPerKelas', [
            'title' => 'raport Kelas',
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas
        ]);
    }

    //? Daftar nilai siswa per tugas yang dibuat oleh pengajar
    public function showNilai(User $pengajar, Kelas $kelas, PengajarMapel $mapel)
    {
        return view('dashboard.admin.pages.adminPengajar.nilaiSiswaPerTugas', [
            'title' => 'Nilai siswa',
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'info_mapel' => $mapel
        ]);
    }
}
