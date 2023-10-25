<?php

namespace App\Http\Controllers;

use App\Models\PengajarMapel;
use App\Models\PengajarSekolah;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('pengajar')) {
                $id = $request->get('pengajar');
                $user = User::where('role', 'pengajar')->where('id', $id)->withCount([
                    'sekolah as jumlah_sekolah' => function ($query) {
                        $query->select(DB::raw('COUNT(DISTINCT id_sekolah)'));
                    }
                ])->first();
                if ($user->count()) {
                    return response()->json([
                        'data' => $user,
                        'jumlah_sekolah' => $user->jumlah_sekolah,
                        'jumlah_kelas' => $user->kelas()->count(),
                        'jumlah_siswa' => $user->kelas()->withCount('siswa')->pluck('siswa_count')->sum()
                    ]);
                } else {
                    return response()->json(['error' => "Pengajar not found"]);
                }
            }
            $query = $request->get('query');
            $pengajar = User::where('role', '=', 'pengajar')->where("nama", 'LIKE', $query . '%')->where('status', 'aktif')->with('mapel')->get();
            return response()->json($pengajar);
            if ($pengajar->count()) {
                return response()->json($pengajar);
            } else {
                return response()->json(['error' => "Pengajar not found"]);
            }
        }

        $data_pengajar = User::where('role', 'pengajar')->withCount([
            'sekolah as jumlah_sekolah' => function ($query) {
                $query->select(DB::raw('COUNT(DISTINCT id_sekolah)'));
            },
        ]);
        return view('dashboard.admin.pages.pengajar', [
            'title' => "Pengajar",
            'full' => false,
            'data_pengajar' => $data_pengajar,
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
        $jumlah_sekolah = User::where('role', 'pengajar')
            ->where('id', $pengajar->id)
            ->withCount([
                'sekolah as jumlah_sekolah' => function ($query) {
                    $query->select(DB::raw('COUNT(DISTINCT id_sekolah)'));
                },
            ])->value('jumlah_sekolah');
        return view('dashboard.admin.pages.detailPengajar', [
            'title' => "Pengajar",
            'full' => true,
            'data_pengajar' => $pengajar,
            'jumlah_sekolah' => $jumlah_sekolah,
            'jumlah_siswa' => $pengajar->kelas()->withCount('siswa')->pluck('siswa_count')->flatten()->sum(),
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
            if ($request->get('tipe') == 'sekolah') {
                try {
                    $pengajar->sekolah()->detach($request->get('id'));
                    return response()->json(['success' => "Data berhasil di hapus"]);
                } catch (\Exception $err) {
                    return response()->json(['error' => "Data gagal di hapus", "error-info" => $err]);
                }
            }
            if ($request->get('tipe') == 'kelas') {
                try {
                    $idKelas = $request->get('id');
                    $idPengajar = $pengajar->id;
                    PengajarSekolah::where('id_user', $idPengajar)
                        ->where('id_kelas', $idKelas)
                        ->delete();
                    Tugas::where("id_kelas", $idKelas);
                    return response()->json(['success' => "Data berhasil di hapus"]);
                } catch (\Exception $err) {
                    return response()->json(['error' => "Data gagal di hapus", "error-info" => $err]);
                }
            }
        }
    }
}
