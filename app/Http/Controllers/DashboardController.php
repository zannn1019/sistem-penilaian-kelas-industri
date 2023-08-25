<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pengajar;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == "pengajar") {
            return view('dashboard.pengajar.pages.dashboard', [
                'title' => "Dashboard",
                'full' => false,
                'kelas' => Kelas::all()
            ]);
        } else if (auth()->user()->role == "admin") {
            return view('dashboard.admin.pages.dashboard', [
                'title' => "Dashboard",
                'full' => false,
                'data_sekolah' => Sekolah::orderBy("id", "DESC")->get(),
                'daftar_pengajar' => User::where("role", '=', 'pengahar')->get(),
                'mapel' => Mapel::all()->count(),
                'kelas' => Kelas::all()->count(),
                'siswa' => Siswa::all()->count()
            ]);
        }
    }


    public function nilai()
    {
        return view('dashboard.pages.nilai', ['title' => "Nilai"]);
    }
}
