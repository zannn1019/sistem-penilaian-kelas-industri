<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class RiwayatEditController extends Controller
{
    public function admin(Request $request)
    {
        $perPage = 1;
        if ($request->input('data') == 'admin' || $request->input('data') == null) {
            $riwayat = Activity::where('properties->role', 'admin')->where("event", "LIKE", $request->get('search') . "%")->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('MAX(DATE_FORMAT(created_at, "%H:%i:%s")) as jam'),
                DB::raw('COUNT(*) as jumlah')
            )
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderByDesc('tanggal')
                ->paginate($perPage);
        } else {
            $riwayat = Activity::where('properties->role', 'pengajar')->where("event", "LIKE", $request->get('search') . "%")->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('MAX(DATE_FORMAT(created_at, "%H:%i:%s")) as jam'),
                DB::raw('COUNT(*) as jumlah')
            )
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderByDesc('tanggal')
                ->paginate($perPage);
        }

        $riwayat->getCollection()->transform(function ($item) use ($request) {
            return [
                'tanggal' => $item->tanggal . ' ' . $item->jam,
                'data' => Activity::where('properties->role', $request->get('data') ?? 'admin')->where("event", "LIKE", $request->get('search') . "%")->where('created_at', 'LIKE', '%' . $item->tanggal . '%')->whereNotNull('causer_id')->orderByDesc('id')->distinct()->get(),
            ];
        });

        return view('dashboard.admin.pages.riwayatEdit', [
            'title' => "Riwayat Edit",
            'full' => true,
            'riwayat' => $riwayat,
            'data_user' => User::all()
        ]);
    }

    public function pengajar(Request $request)
    {
        $perPage = 1;
        $riwayat = Activity::where('properties->role', 'pengajar')->where('causer_id', auth()->user()->id)->select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('MAX(DATE_FORMAT(created_at, "%H:%i:%s")) as jam'),
            DB::raw('COUNT(*) as jumlah')
        )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc('tanggal')
            ->paginate($perPage);

        $riwayat->getCollection()->transform(function ($item) use ($request) {
            return [
                'tanggal' => $item->tanggal . ' ' . $item->jam,
                'data' => Activity::where('properties->role', 'pengajar')->where('causer_id', auth()->user()->id)->where('created_at', 'LIKE', '%' . $item->tanggal . '%')->whereNotNull('causer_id')->orderByDesc('id')->distinct()->get(),
            ];
        });

        return view('dashboard.pengajar.pages.riwayatEdit', [
            'title' => "Riwayat Edit",
            'full' => true,
            'riwayat' => $riwayat,
            'data_user' => User::all()
        ]);
    }
}
