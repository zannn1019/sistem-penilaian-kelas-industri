<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function adminSearch(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $result  = collect([]);
        $query = $request->input('query');
        $sekolah = Sekolah::select('id', 'nama')
            ->where('nama', 'LIKE', $query . '%')
            ->get()
            ->map(function ($sekolah) {
                $url = '/admin/sekolah/' . $sekolah->id;
                $sekolah->url = $url;
                return $sekolah;
            });
        $kelas = Kelas::select('kelas.id', 'nama_kelas as nama', 'sekolah.nama as nama_sekolah')
            ->join('sekolah', 'sekolah.id', '=', 'kelas.id_sekolah')
            ->where('nama_kelas', 'LIKE', $query . "%")
            ->get()
            ->map(function ($kelas) {
                $url = '/admin/kelas/' . $kelas->id;
                $desc = $kelas->nama_sekolah;
                $kelas->desc = $desc;
                $kelas->url = $url;
                return $kelas;
            });
        $mapel = Mapel::select('id', 'nama_mapel as nama')
            ->where('nama_mapel', 'LIKE', $query . '%')
            ->get()
            ->map(function ($mapel) {
                $url = '/admin/mapel/' . $mapel->id;
                $mapel->url = $url;
                return $mapel;
            });
        $pengajar = User::select('id', 'nama', 'nik')
            ->where(function ($builder) use ($query) {
                $builder->where('nama', 'LIKE', $query . '%')
                    ->orWhere('nik', 'LIKE', $query . '%');
            })
            ->where('role', 'pengajar')
            ->get()
            ->map(function ($pengajar) {
                $url = '/admin/pengajar/' . $pengajar->id;
                $pengajar->url = $url;
                $pengajar->desc = $pengajar->nik;
                return $pengajar;
            });
        $siswa = Siswa::select('siswa.id', 'siswa.nama', 'sekolah.nama as nama_sekolah')
            ->leftJoin('sekolah', 'siswa.id_sekolah', '=', 'sekolah.id')
            ->where('siswa.nama', 'LIKE', $query . '%')
            ->get()
            ->map(function ($siswa) {
                $url = '/admin/siswa/' . $siswa->id;
                $siswa->url = $url;
                $siswa->desc = $siswa->nama_sekolah;
                return $siswa;
            });
        $result = ['sekolah' => $sekolah, 'kelas' => $kelas, 'mapel' => $mapel, 'pengajar' => $pengajar, 'siswa' => $siswa];
        return response()->json($result, 200);
    }

    public function pengajarSearch(User $pengajar, Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
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
