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
            ->select('nama')
            ->where('nama', 'LIKE', $query . '%')
            ->get()
            ->unique('id_sekolah')
            ->map(function ($sekolah) {
                $url = '/pengajar/kelas?sekolah=' . $sekolah->id_sekolah;
                $sekolah->url = $url;
                return $sekolah;
            });
        $kelas = $pengajar->kelas()
            ->select('nama_kelas as nama')
            ->where('nama_kelas', 'LIKE', $query . "%")
            ->get()
            ->map(function ($kelas) {
                $url = '/pengajar/kelas/' . $kelas->id;
                $kelas->url = $url;
                return $kelas;
            });

        $result = ['sekolah' => $sekolah, 'kelas' => $kelas];
        return response()->json($result, 200);
    }
}
