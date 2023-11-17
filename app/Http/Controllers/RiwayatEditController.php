<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class RiwayatEditController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 1;

        if ($request->input('data') == 'admin' || $request->input('data') == null) {
            $riwayat = Activity::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('MAX(DATE_FORMAT(created_at, "%H:%i:%s")) as jam'),
                DB::raw('COUNT(*) as jumlah')
            )
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderByDesc('tanggal')
                ->paginate($perPage);
        } else {
            $riwayat = Activity::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('MAX(DATE_FORMAT(created_at, "%H:%i:%s")) as jam'),
                DB::raw('COUNT(*) as jumlah')
            )
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderByDesc('tanggal')
                ->paginate($perPage);
        }

        $riwayat->getCollection()->transform(function ($item) {
            return [
                'tanggal' => $item->tanggal . ' ' . $item->jam,
                'data' => Activity::where('created_at', 'LIKE', '%' . $item->tanggal . '%')->whereNotNull('causer_id')->orderByDesc('id')->distinct()->get(),
            ];
        });

        return view('dashboard.admin.pages.riwayatEdit', [
            'title' => "Riwayat Edit",
            'full' => true,
            'riwayat' => $riwayat,
            'data_user' => User::all()
        ]);
    }
}
