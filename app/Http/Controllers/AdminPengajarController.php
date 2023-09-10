<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pengajar;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPengajarController extends Controller
{
    //

    public function index(User $pengajar)
    {
        return view('dashboard.admin.pages.adminPengajar.dashboard', [
            'title' => "Dashboard Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar
        ]);
    }
    public function kelas(User $pengajar)
    {
        return view('dashboard.admin.pages.adminPengajar.kelas', [
            'title' => "Kelas Pengajar",
            'full' => true,
            'info_pengajar' => $pengajar
        ]);
    }
    public function showMapel(User $pengajar, Kelas $kelas)
    {
        return view('dashboard.admin.pages.adminPengajar.selectMapel', [
            'title' => "Pilih Mapel",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
        ]);
    }
    public function showTugas(User $pengajar, Kelas $kelas, Mapel $mapel)
    {
        $idMapel = $pengajar->mapel()->find($mapel->id)->id;
        $daftar_tugas = collect([
            'tugas' => $pengajar->tugas()->where('id_kelas', $kelas->id)->where(function ($query) {
                $query->where('tipe', 'tugas')->orWhere("tipe", 'quiz');
            })->where('id_pengajar', $idMapel)->get(),
            'ujian' => $pengajar->tugas()->where('id_kelas', $kelas->id)->where(function ($query) {
                $query->where('tipe', 'PTS')->orWhere("tipe", 'PAT');
            })->where('id_pengajar', $idMapel)->get(),
        ]);
        return view('dashboard.admin.pages.adminPengajar.selectTugas', [
            'title' => "Pilih Tugas",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'info_mapel' => $mapel,
            'daftar_tugas' => $daftar_tugas
        ]);
    }
    public function showSiswa(User $pengajar, Kelas $kelas)
    {
        return view('dashboard.admin.pages.adminPengajar.showSiswa', [
            'title' => "Pilih Mapel",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
        ]);
    }
    public function showPengajar(User $pengajar, Kelas $kelas)
    {
        return view('dashboard.admin.pages.adminPengajar.showPengajar', [
            'title' => "Pilih Mapel",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas,
            'data_pengajar' => $kelas->pengajar()
        ]);
    }
}
