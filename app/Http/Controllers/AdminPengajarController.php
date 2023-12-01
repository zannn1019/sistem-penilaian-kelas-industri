<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\Pengajar;
use App\Models\NilaiAkhir;
use Illuminate\Http\Request;
use App\Models\PengajarMapel;
use App\Models\PengajarSekolah;
use NumberToWords\NumberToWords;
use PhpParser\Node\Expr\FuncCall;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

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
            'latihan' => [
                'total' => 0,
                'ternilai' => 0,
            ],
            'assessment' => [
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
        foreach ($pengajar->kelas->pluck('siswa')->flatten() as $siswa) {
            if ($siswa->nilai_akhir->where('tahun_ajar', $siswa->kelas->tahun_ajar)->where('semester', $siswa->kelas->semester)->count()) {
                $status_tugas['assessment']['ternilai'] += 1;
                $status_tugas['total_ternilai'] += 1;
            }
            $status_tugas['assessment']['total'] += 1;
            $status_tugas['total_tugas'] += 1;
        }

        return view('dashboard.admin.pages.adminPengajar.dashboard', [
            'title' => "Dashboard Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar,
            'status_tugas' => $status_tugas
        ]);
    }

    //? Daftar kelas untuk dashboard pengajar pada page admin
    public function kelas(User $pengajar, Request $request)
    {
        if ($request->query() == null || $request->input("filter")) {
            $data_kelas = $pengajar->kelas();
        } else {
            $sekolah = $request->input('sekolah');
            $tingkat = $request->input('tingkat');
            $sort = $request->input('sort');
            $semester = $request->input('semester');
            $search = $request->input('search');

            $data_kelas = $pengajar->kelas();

            if ($sekolah) {
                $data_kelas->where('kelas.id_sekolah', $sekolah);
            }

            if ($tingkat) {
                $data_kelas->where('tingkat', $tingkat);
            }

            if ($sort == 'edited') {
                $data_kelas->orderBy('updated_at', 'DESC');
            }

            if ($sort == 'az') {
                $data_kelas->orderBy('nama_kelas', 'DESC');
            }

            if ($semester) {
                $data_kelas->where('kelas.semester', $semester);
            }
            if ($search) {
                $data_kelas->where("nama_kelas", "LIKE", $search . "%");
            }
        }
        return view('dashboard.admin.pages.adminPengajar.kelas', [
            'title' => "Kelas Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar,
            'data_kelas' => $data_kelas
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
            'tugas' => $mapel->tugas()->tipe(['tipe' => ['tugas', 'quiz', 'latihan']])->where('id_kelas', $kelas->id)->get(),
            'ujian' => $mapel->tugas()->tipe(['tipe' => ['assessment_blok_a', 'assessment_blok_b']])->where('id_kelas', $kelas->id)->get(),
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
        $tugas = Kelas::find($siswa->id_kelas)->tugas->where('tahun_ajar', $siswa->kelas->tahun_ajar)
            ->where('semester', $siswa->kelas->semester);

        // ?? Mengambil total semua tugas
        $total = $tugas->count();

        // ?? Mengambil daftar mapel yang dipelajari
        $mapelIds = PengajarMapel::whereIn('id_user', $kelas->pengajar->pluck('id')->toArray())
            ->pluck('id_mapel')
            ->toArray();

        $avgNilai = Nilai::siswaAvg($siswa);

        return view('dashboard.admin.pages.adminPengajar.detailSiswa', [
            'title' => 'Detail Siswa',
            'full' => true,
            'info_pengajar' => $pengajar,
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

    public function nilaiAkhir(User $pengajar, Kelas $kelas)
    {
        $total_ternilai = $kelas->siswa()->withCount('nilai_akhir')->pluck('nilai_akhir_count')->sum();
        return view('dashboard.admin.pages.adminPengajar.nilaiAkhir', [
            'title' => 'Nilai Akhir',
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'total_ternilai' => $total_ternilai
        ]);
    }

    public function inputNilaiAkhir(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $cek_data = NilaiAkhir::where('id_siswa', $request->id_siswa);
        if ($request->get('nilai') <= 75 && $request->get('keterangan') == null) {
            return response()->json(['nilai_kurang' => 'Nilai yang di bawah 75 harus disertai keterangan']);
        }
        $validatedData = $request->validate([
            'id_siswa' => ['required'],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['required_if:nilai,<=,75'],
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
                    ->withProperties(['role' => auth()->user()->role])
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
                    ->withProperties(['role' => auth()->user()->role])
                    ->log('Mengubah data nilai akhir');
                return response()->json(['success' => "data_update", 'time' => date(now())]);
            } else {
                return response()->json(['error' => 'Nilai gagal di ubah!']);
            }
        }
    }
}
