<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Sekolah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //?Request ajax
        if ($request->ajax()) {
            $data = Kelas::search($request->get('query'))->where('id_sekolah', $request->get('id_sekolah'))->get();
            return response()->json($data);
        }
        if (auth()->user()->role == "pengajar") {
            //?Jika pengguna memiliki role 'pengajar'
            $data_kelas = Kelas::where('pengajar_id', auth()->user()->id)->get();
            return view('dashboard.pengajar.pages.kelas', [
                'title' => "Kelas",
                'full' => false,
                'data_kelas' => $data_kelas
            ]);
        } else {
            //?Jika pengguna memiliki role 'admin'
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.forms.createKelas', [
            'title' => "Kelas",
            'full' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tahun_ajaran = $request->tahun_ajar == null ? date("Y") . '/' . date("Y") + 1 : $request->tahun_ajar;
        $semester = $request->semester == null ? '1' : $request->semester;
        $request['tahun_ajar'] = $tahun_ajaran;
        $request['semester'] = $semester;
        $validated_data = $request->validate([
            'id_sekolah' => ['required'],
            'tingkat' => ['required'],
            'jurusan' => ['required'],
            'kelas' => ['required'],
            'nama_kelas' => ['required'],
            'tahun_ajar' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            'semester' => ['required']
        ], [
            'tahun_ajar.regex:/^\d{4}\/\d{4}$/' => 'Format tahun harus dalam format "yyyy/yyyy", contoh: 2023/2024.',
        ]);

        Kelas::create($validated_data);
        return redirect()->route('kelas.show', ['kela' => Kelas::latest()->first()])->with('success', 'Data kelas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kela)
    {
        if (auth()->user()->role == "pengajar") {
            return view('dashboard.pengajar.pages.pilih_tugas', [
                'title' => 'Pilih Tugas',
                'full' => true,
                'kelas' => $kela
            ]);
        } else {
            return view('dashboard.admin.pages.detailKelas', [
                'title' => "Sekolah",
                'full' => true,
                'data' => $kela
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kela)
    {
        $tahun_ajaran = isset($request->tahun_ajar) ? $request->tahun_ajar : $kela->tahun_ajar;
        $semester = isset($request->semester)  ? $request->semester : $kela->semester;
        $request['tahun_ajar'] = $tahun_ajaran;
        $request['semester'] = $semester;
        $validated_data = $request->validate([
            'id_sekolah' => ['required'],
            'tingkat' => ['required'],
            'jurusan' => ['required'],
            'kelas' => ['required'],
            'nama_kelas' => ['required'],
            'tahun_ajar' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
            'semester' => ['required']
        ], [
            'tahun_ajar.regex' => 'Format tahun harus dalam format "yyyy/yyyy", contoh: 2023/2024',
        ]);
        $kela->update($validated_data);
        return back()->with('success', 'Data kelas berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kela)
    {
        Siswa::where('id_kelas', '=', $kela->id)->delete();
        $kela->destroy($kela->id);
    }
}
