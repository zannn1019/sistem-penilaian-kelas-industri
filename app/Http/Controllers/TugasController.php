<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Tugas;
use App\Models\Pengajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
    public function showNilai(Kelas $kelas, Mapel $mapel)
    {
        return view('dashboard.pengajar.pages.showNilaiPerTugas', [
            'title' => "Nilai pertugas",
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas,
            'info_mapel' => $mapel,
        ]);
    }
    public static function getKodeTugas($tipe)
    {
        $tipeTugas = $tipe;
        $listCodeTugas = collect([
            [
                'tipe' => "tugas",
                'kode' => "TGS"
            ],
            [
                'tipe' => "quiz",
                'kode' => "QZ"
            ],
            [
                'tipe' => "assessment_blok_a",
                'kode' => "ASMA"
            ],
            [
                'tipe' => "assessment_blok_b",
                'kode' => "ASMB"
            ],
        ]);
        $count = Tugas::where('tipe', $tipe)->count();
        $codeTugas = $listCodeTugas->where('tipe', $tipe)->first()['kode'] . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        return $codeTugas;
    }

    public function createUjian($request, $tipe, $nama)
    {
        $kelas = Kelas::find($request->get('id_kelas'));
        if (!$request->get('tahun_ajar') && !$request->get('semester')) {
            $request['tahun_ajar'] = $kelas->tahun_ajar;
            $request['semester'] = $kelas->semester;
        }
        return [
            '_token' => $request->_token,
            'id_kelas' => $request->id_kelas,
            'id_pengajar' => $request->id_pengajar,
            'nama' => $nama,
            'kode_tugas' => $this->getKodeTugas($tipe),
            'tipe' => $tipe,
            'tahun_ajar' => $request->tahun_ajar,
            'semester' => $request->semester
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Kelas $kelas, Mapel $mapel)
    {
        $daftar_tugas = collect([
            'tugas' => $mapel->tugas()->tipe(['tipe' => ['tugas', 'quiz']])->where('id_kelas', $kelas->id)->get(),
            'ujian' => $mapel->tugas()->tipe(['tipe' => ['assessment_blok_a', 'assessment_blok_b']])->where('id_kelas', $kelas->id)->get(),
        ]);
        return view('dashboard.pengajar.pages.selectTugas', [
            'title' => "Pilih Tugas",
            'full' => true,
            'info_pengajar' => auth()->user(),
            'info_kelas' => $kelas,
            'info_mapel' => $mapel,
            'daftar_tugas' => $daftar_tugas,
            'pengajar_mapel' => $mapel
        ]);
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
        if (auth()->user()->role == 'pengajar') {
            if ($request->otomatis == 'on') {
                $ujian = collect([
                    "assessment_blok_a" => $this->createUjian($request, "assessment_blok_a", "Assessment Blok A"),
                    "assessment_blok_b" => $this->createUjian($request, "assessment_blok_b", 'Assessment Blok B'),
                ]);
                $kelas = Kelas::find($request->get('id_kelas'));
                if ($kelas->semester == 'ganjil') {
                    if (!Tugas::where('id_pengajar', $request->id_pengajar)->where('id_kelas', $request->id_kelas)->where('tipe', 'assessment_blok_a')->count()) {
                        Tugas::create($ujian["assessment_blok_a"]);
                    }
                }
                if ($kelas->semester == 'genap') {
                    if (!Tugas::where('id_pengajar', $request->id_pengajar)->where('id_kelas', $request->id_kelas)->where('tipe', 'assessment_blok_b')->count()) {
                        Tugas::create($ujian["assessment_blok_b"]);
                    }
                }
                return back()->with('success', 'Tugas berhasil di tambahkan!');
            } else {
                $kelas = Kelas::find($request->get('id_kelas'));
                if (!$request->get('tahun_ajar') && !$request->get('semester')) {
                    $request['tahun_ajar'] = $kelas->tahun_ajar;
                    $request['semester'] = $kelas->semester;
                }
                $validatedData = $request->validate([
                    'id_kelas' => ['required'],
                    'id_pengajar' => ['required'],
                    'tipe' => ['required'],
                    'nama' => ['required', 'unique:tugas,nama'],
                    'tahun_ajar' => ['required'],
                    'semester' => ['required']
                ]);
                $validatedData['kode_tugas'] = $this->getKodeTugas($validatedData['tipe']);
                Tugas::create($validatedData);
                return back()->with('success', 'Tugas berhasil di tambahkan!');
            }
            return back()->with('error', 'Tugas gagal di tambahkan!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tugas)
    {
        $tugas->delete();
    }
}
