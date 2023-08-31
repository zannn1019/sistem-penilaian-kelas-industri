<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\User;
use App\Models\Pengajar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.admin.pages.pengajar', [
            'title' => "Pengajar",
            'full' => false,
            'data_pengajar' => User::where('role', '=', 'pengajar')->orderBy("id", "DESC")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.forms.createPengajar', [
            'title' => "Pengajar",
            'full' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(User $pengajar)
    {
        $jumlah_sekolah = Pengajar::withCount('sekolah')->where('id_user', '=', $pengajar->id)->first()->sekolah_count ?? '0';
        $jumlah_kelas = Pengajar::withCount('kelas')->where('id_user', '=', $pengajar->id)->get();
        $jumlah_tugas = 0;
        $jumlah_siswa = 0;
        $data_mapel = Pengajar::where('id_user', '=', $pengajar->id)->get();
        foreach ($jumlah_kelas as $kelas) {
            dd($kelas);
        }
        return view('dashboard.admin.pages.detailPengajar', [
            'title' => "Pengajar",
            'full' => true,
            'data_pengajar' => $pengajar,
            'jumlah_sekolah' => $jumlah_sekolah,
            'jumlah_kelas' => $jumlah_kelas->count(),
            'jumlah_siswa' => $jumlah_siswa,
            'jumlah_tugas' => $jumlah_tugas,
            'data_mapel' => $data_mapel,
            'daftar_mapel' => Mapel::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengajar $pengajar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajar $pengajar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajar $pengajar)
    {
        //
    }
}
