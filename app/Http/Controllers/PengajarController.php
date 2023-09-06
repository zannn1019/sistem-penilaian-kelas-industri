<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Pengajar;
use App\Models\User;
use App\Models\PengajarMapel;
use App\Models\PengajarSekolah;
use App\Models\Sekolah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $pengajar = User::where('role', '=', 'pengajar')->where("nama", 'LIKE', $query . '%')->get();
            if ($pengajar->count()) {
                return response()->json($pengajar);
            } else {
                return response()->json(['error' => "Pengajar not found"]);
            }
        }
        return view('dashboard.admin.pages.pengajar', [
            'title' => "Pengajar",
            'full' => false,
            'data_pengajar' => User::where('role', '=', 'pengajar')->latest(),
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
        $tipe = $request->get('tipe');
        if ($tipe == "mapel") {
            if ($request->id_mapel != null) {
                $id = explode(',', $request->id_mapel);
            } else {
                $id = [];
            }
            $user = User::find($request->id_user);
            foreach ($user->mapel()->get() as $mapel) {
                array_push($id, $mapel->id);
            }
            $user->mapel()->sync($id);
            return back()->with("success", 'Mapel pengajar berhasil di tambah!');
        } elseif ($tipe == "sekolah") {
            $user = User::find($request->id_user);
            $id_sekolah = $request->id_sekolah;
            $id_kelas = $request->id_kelas;

            if (!$user->sekolah()->wherePivot('id_sekolah', $id_sekolah)->wherePivot('id_kelas', $id_kelas)->exists()) {
                $user->sekolah()->attach($id_sekolah, ['id_kelas' => $id_kelas]);
                return back()->with("success", 'Pengajar berhasil ditambahkan!');
            } else {
                return back()->with("error", 'Pengajar sudah terhubung dengan sekolah dan kelas ini sebelumnya.');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $pengajar)
    {
        $jumlah_tugas = 0;
        $jumlah_kelas = $pengajar->kelas()->get();
        $jumlah_siswa = 0;
        foreach ($jumlah_kelas as $kelas) {
            $jumlah_siswa += $kelas->siswa()->count();
        }
        $data_mapel = Mapel::all();
        return view('dashboard.admin.pages.detailPengajar', [
            'title' => "Pengajar",
            'full' => true,
            'data_pengajar' => $pengajar,
            'jumlah_siswa' => $jumlah_siswa,
            'jumlah_tugas' => $jumlah_tugas,
            'mapel_pengajar' => $pengajar->mapel()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Pengajar $pengajar)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Pengajar $pengajar)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $pengajar, Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('tipe') == "mapel") {
                $id_mapel = $request->id_mapel;
                if ($pengajar->mapel()->detach($id_mapel)) {
                    return response()->json(['success' => "Data berhasil di hapus"]);
                } else {
                    return response()->json(['error' => "Data gagal di hapus"]);
                }
            }
        }
    }
}
