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
            if ($request->get('query')) {
                $data = Kelas::search($request->get('query'))->where('id_sekolah', $request->get('id_sekolah'))->get();
                return response()->json($data);
            } else {
                $data = Kelas::where('id_sekolah', $request->get('id_sekolah'))->get();
                return response()->json($data);
            }
        }
        if (auth()->user()->role == "pengajar") {
            dd('tes');
            //?Jika pengguna memiliki role 'pengajar'
            if ($request->query() == null || $request->input("filter")) {
                $data_kelas = auth()->user()->kelas;
            } else {
                $data_kelas = auth()->user()->kelas()->filter(['sekolah' => $request->input('sekolah'), 'tingkat' => $request->input('tingkat')]);
            }
            return view('dashboard.pengajar.pages.kelas', [
                'title' => "Kelas",
                'full' => false,
                'data_kelas' => $data_kelas,
                'info_pengajar' => auth()->user(),
                'data_mapel' => auth()->user()->mapel
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
        activity()
            ->event('created')
            ->useLog('kelas')
            ->performedOn(Kelas::latest()->first())
            ->causedBy(auth()->user()->id)
            ->withProperties(['role' => auth()->user()->role])
            ->log('Menambah data kelas');
        return redirect()->route('kelas.show', ['kela' => Kelas::latest()->first()])->with('success', 'Data kelas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kela)
    {
        if (auth()->user()->role == "pengajar") {
            return view('dashboard.pengajar.pages.selectMapel', [
                'title' => 'Pilih Tugas',
                'full' => true,
                'info_kelas' => $kela,
                'info_pengajar' => auth()->user(),
                'data_mapel' => auth()->user()->mapel()
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
        activity()
            ->event('update')
            ->useLog('kelas')
            ->performedOn($kela)
            ->causedBy(auth()->user()->id)
            ->withProperties(['role' => auth()->user()->role])
            ->log('Mengubah data kelas');
        return back()->with('success', 'Data kelas berhasil di ubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kela)
    {
        $kela->delete();
        activity()
            ->event('arsip')
            ->useLog('kelas')
            ->performedOn($kela)
            ->causedBy(auth()->user()->id)
            ->withProperties(['role' => auth()->user()->role])
            ->log('Mengarsipkan data kelas');
        return redirect()->route('sekolah.show', $kela->sekolah->id)->with('success', 'Data kelas berhasil diarsipkan');
    }
}
