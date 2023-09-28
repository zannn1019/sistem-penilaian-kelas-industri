<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tugas;
use App\Models\Pengajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
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
                'tipe' => "PTS",
                'kode' => "PTS"
            ],
            [
                'tipe' => "PAS",
                'kode' => "PAS"
            ],
        ]);
        $count = Tugas::where('tipe', $tipe)->count();
        $codeTugas = $listCodeTugas->where('tipe', $tipe)->first()['kode'] . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        return $codeTugas;
    }

    public function createUjian($request, $tipe)
    {
        return [
            '_token' => $request->_token,
            'id_kelas' => $request->id_kelas,
            'id_pengajar' => $request->id_pengajar,
            'nama' => $tipe,
            'kode_tugas' => $this->getKodeTugas($tipe),
            'tipe' => $tipe,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        if ($request->otomatis == 'on') {
            $ujian = collect([
                "PTS" => $this->createUjian($request, "PTS"),
                "PAS" => $this->createUjian($request, "PAS"),
            ]);
            if (!Tugas::where('id_pengajar', $request->id_pengajar)->where('id_kelas', $request->id_kelas)->where('tipe', 'PTS')->count()) {
                Tugas::create($ujian["PTS"]);
            }
            if (!Tugas::where('id_pengajar', $request->id_pengajar)->where('id_kelas', $request->id_kelas)->where('tipe', 'PAS')->count()) {
                Tugas::create($ujian["PAS"]);
            }
            return back()->with('success', 'Tugas berhasil di tambahkan!');
        } else {
            $validatedData = $request->validate([
                'id_kelas' => ['required'],
                'id_pengajar' => ['required'],
                'tipe' => ['required'],
                'nama' => ['required']
            ]);
            $validatedData['kode_tugas'] = $this->getKodeTugas($validatedData['tipe']);
            Tugas::create($validatedData);
            return back()->with('success', 'Tugas berhasil di tambahkan!');
        }
        return back()->with('error', 'Tugas gagal di tambahkan!');
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
        //
    }
}
