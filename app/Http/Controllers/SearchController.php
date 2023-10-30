<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function adminSearch(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $query = $request->input('query');
        $result = [];
        return $result;
    }
    public function pengajarSearch(User $pengajar, Request $request)
    {
        // if (!$request->ajax()) {
        //     abort(404);
        // }
        $result  = collect([]);
        $query = $request->input('query');
        $sekolah = $pengajar->sekolah()
            ->select('id_sekolah', 'nama')
            ->where('nama', 'LIKE', $query . '%')
            ->get()
            ->unique('id_sekolah')
            ->map(function ($sekolah) {
                $url = '/pengajar/kelas?sekolah=' . $sekolah->id_sekolah;
                $sekolah->url = $url;
                return $sekolah;
            });
        $kelas = $pengajar->kelas()
            ->select('nama_kelas as nama', 'id_kelas', 'sekolah.nama as nama_sekolah')
            ->join('sekolah', 'sekolah.id', '=', 'kelas.id_sekolah')
            ->where('nama_kelas', 'LIKE', $query . "%")
            ->get()
            ->map(function ($kelas) {
                $url = '/pengajar/kelas/' . $kelas->id_kelas;
                $desc = $kelas->nama_sekolah;
                $kelas->desc = $desc;
                $kelas->url = $url;
                return $kelas;
            });
        $siswa = $pengajar->sekolah()
            ->with('siswa')
            ->get()
            ->pluck('siswa')
            ->flatten()
            ->filter(function ($siswa) use ($query) {
                return stripos($siswa['nama'], $query) !== false;
            })
            ->map(function ($siswa) {
                $url = '/pengajar/kelas/' . $siswa->id_kelas . '/siswa/' . $siswa->id;
                $desc = $siswa->sekolah->nama . ' - ' . $siswa->kelas->nama_kelas;
                $siswa->desc = $desc;
                $siswa->url = $url;
                return $siswa;
            })
            ->unique()
            ->values();
        $result = ['sekolah' => $sekolah, 'kelas' => $kelas, 'siswa' => $siswa];
        return response()->json($result, 200);
    }
}
