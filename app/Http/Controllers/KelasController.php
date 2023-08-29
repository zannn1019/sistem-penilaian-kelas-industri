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
    public function index()
    {
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
        $validated_data = $request->validate([
            'id_sekolah' => ['required'],
            'tingkat' => ['required'],
            'jurusan' => ['required'],
            'nama' => ['required'],
            'sticker' => ['required']
        ]);
        $sekolah = Sekolah::find($validated_data['id_sekolah'])->nama;
        if ($request->hasFile('sticker')) {
            $file = $request->file('sticker');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($sekolah) . '-' . Str::slug($validated_data['jurusan']) . '.' . $extension;
            $file->move('storage/jurusan', $fileName);
            $validated_data['sticker'] = $fileName;
        }
        Kelas::create($validated_data);
        return back();
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
    public function update(Request $request, Kelas $kelas)
    {
        //
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
