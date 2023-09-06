<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
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
    public function showKelas(User $pengajar, Kelas $kelas)
    {
        return view('dashboard.admin.pages.adminPengajar.selectMapel', [
            'title' => "Pilih Mapel",
            'full' => true,
            'info_pengajar' => $pengajar,
            'info_kelas' => $kelas
        ]);
    }
}
