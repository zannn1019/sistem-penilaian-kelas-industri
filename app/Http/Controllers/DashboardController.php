<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\PengajarMapel;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\User;
use Brick\Math\BigRational;
use Illuminate\Support\Facades\DB;
use NumberToWords\NumberToWords;

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
                'assessment_blok_a' => [
                    'total' => 0,
                    'ternilai' => 0,
                ],
                'assessment_blok_b' => [
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
            'info_kelas' => $kelas,

        ]);
    }

    public function showNilaiPerKelas(Kelas $kelas)
    {
        return view('dashboard.pengajar.pages.showNilaiPerkelas', [
            'title' => "Raport kelas",
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas
        ]);
    }

    public function detailSiswa(Kelas $kelas, Siswa $siswa)
    {
        // ?? Mengambil tugas siswa
        $tugas = Kelas::find($siswa->id_kelas)->tugas->where('tahun_ajar', $siswa->kelas->tahun_ajar)
            ->where('semester', $siswa->kelas->semester);

        // ?? Mengambil total semua tugas
        $total = $tugas->count();

        // ?? Mengambil daftar mapel yang dipelajari
        $mapelIds = PengajarMapel::whereIn('id_user', $kelas->pengajar->pluck('id')->toArray())
            ->pluck('id_mapel')
            ->toArray();

        $avgNilai = Nilai::siswaAvg($siswa);
        return view('dashboard.pengajar.pages.detailSiswa', [
            'title' => 'Detail siswa',
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas,
            'info_siswa' => $siswa,
            'daftar_mapel' => Mapel::whereIn('id', $mapelIds)->get(),
            'nomor_id' => NumberToWords::transformNumber('id', $siswa->id),
            'rata_rata' => $avgNilai,
            'tugas' => [
                'total' => $total,
                'ternilai' => $siswa->nilai()->where('id_siswa', $siswa->id)
                    ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
                    ->where('semester', $siswa->kelas->semester)->count(),
                'tugas' =>  $tugas->whereIn('tipe', ['tugas'])->count(),
                'kuis' =>  $tugas->whereIn('tipe', ['quiz'])->count(),
                'ujian' =>  $tugas->whereIn('tipe', ['assessment_blok_a', 'assessment_blok_b'])->count(),
            ]
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
            'ujian' => $mapel->tugas()->tipe(['tipe' => ['assessment_blok_a', 'assessment_blok_b']])->where('id_kelas', $kelas->id)->get(),
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

    public function inputNilaiAkhir(Kelas $kelas)
    {
        $total_ternilai = $kelas->siswa()->withCount('nilai_akhir')->pluck('nilai_akhir_count')->sum();
        return view('dashboard.pengajar.pages.inputNilaiAkhir', [
            'title' => "Input nilai akhir",
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas,
            'total_ternilai' => $total_ternilai
        ]);
    }
}
