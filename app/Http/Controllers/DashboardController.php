<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\PengajarMapel;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == "pengajar") {
            $pengajar = auth()->user();
            $tugas = $pengajar->tugas;
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

            return view('dashboard.pengajar.pages.dashboard', [
                'title' => "Dashboard",
                'full' => false,
                'info_pengajar' => auth()->user(),
                'status_tugas' => $status_tugas
            ]);
        } else if (auth()->user()->role == "admin") {
            $data_pengajar = User::where('role', 'pengajar')->withCount([
                'sekolah as jumlah_sekolah' => function ($query) {
                    $query->select(DB::raw('COUNT(DISTINCT id_sekolah)'));
                },
            ]);
            return view('dashboard.admin.pages.dashboard', [
                'title' => "Dashboard",
                'full' => false,
                'data_sekolah' => Sekolah::orderBy("id", "DESC")->get(),
                'daftar_pengajar' => $data_pengajar->get(),
                'mapel' => Mapel::all()->count(),
                'kelas' => Kelas::all()->count(),
                'siswa' => Siswa::all()->count()
            ]);
        }
    }

    public function profile()
    {
        $pengajar = auth()->user();
        $jumlah_tugas = 0;
        $jumlah_sekolah = User::where('role', 'pengajar')
            ->where('id', $pengajar->id)
            ->withCount([
                'sekolah as jumlah_sekolah' => function ($query) {
                    $query->select(DB::raw('COUNT(DISTINCT id_sekolah)'));
                },
            ])->value('jumlah_sekolah');
        return view('dashboard.pengajar.pages.profile', [
            'title' => "Pengajar",
            'full' => true,
            'data_pengajar' => $pengajar,
            'jumlah_sekolah' => $jumlah_sekolah,
            'jumlah_siswa' => $pengajar->kelas()->withCount('siswa')->pluck('siswa_count')->flatten()->sum(),
            'jumlah_tugas' => $jumlah_tugas,
            'mapel_pengajar' => $pengajar->mapel()->get(),
        ]);
    }

    public function kelas()
    {
        return view('dashboard.pengajar.pages.kelas', [
            'title' => "Kelas",
            'full' => false,
            'data_kelas' => auth()->user()->kelas,
            'info_pengajar' => auth()->user(),
            'data_mapel' => auth()->user()->mapel
        ]);
    }

    public function showSiswa(Kelas $kelas)
    {
        return view('dashboard.pengajar.pages.showSiswa', [
            'title' => "Daftar siswa",
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas
        ]);
    }

    public function selectMapel(Kelas $kelas)
    {
        return view('dashboard.pengajar.pages.selectMapel', [
            'title' => 'Pilih mapel',
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas,
            'data_mapel' => auth()->user()->mapel()
        ]);
    }

    public function  selectTugas(Kelas $kelas, Mapel $mapel)
    {
        $pengajar_mapel = PengajarMapel::where('id_mapel', $mapel->id)->where('id_user', auth()->user()->id);
        $daftar_tugas = collect([
            'tugas' => $mapel->tugas()->tipe(['tipe' => ['tugas', 'quiz']])->where('id_kelas', $kelas->id)->get(),
            'ujian' => $mapel->tugas()->tipe(['tipe' => ['PTS', 'PAS']])->where('id_kelas', $kelas->id)->get(),
        ]);
        return view('dashboard.pengajar.pages.selectTugas', [
            'title' => 'Pilih tugas',
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas,
            'info_mapel' => $mapel,
            'daftar_tugas' => $daftar_tugas,
            'pengajar_mapel' => $pengajar_mapel->first()
        ]);
    }

    public function inputNilai(Kelas $kelas, Tugas $tugas)
    {
        return view('dashboard.pengajar.pages.inputNilaiSiswa', [
            'title' => "Input nilai",
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas,
            'data_tugas' => $tugas
        ]);
    }
}
