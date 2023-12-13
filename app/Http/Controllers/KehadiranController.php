<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKehadiranRequest;
use App\Http\Requests\UpdateKehadiranRequest;
use App\Models\Kegiatan;
use App\Models\User;
use Carbon\Carbon;

class KehadiranController extends Controller
{

    public function getKehadiranData(Request $request)
    {
        if (!$request->ajax()) {
            abort(403);
        }

        $user = User::find($request->get('id'));
        switch ($user->role) {
            case 'pengajar':
                $kehadiran = Kehadiran::where("id_user", $user->id)
                    ->get()
                    ->map(function ($data) {
                        return [
                            'id' => $data->id,
                            'title' => $data->user->nama,
                            'start' => $data->tanggal,
                            'child' => $data->kegiatan->map(function ($kegiatan) use ($data) {
                                return [
                                    'id' => $kegiatan->id,
                                    'id_kehadiran' => $kegiatan->id_kehadiran,
                                    'title' => $kegiatan->nama_kegiatan,
                                    'start' => $data->tanggal . " " . $kegiatan->jam_mulai,
                                    'end' => $data->tanggal . " " . $kegiatan->jam_selesai,
                                    'tes' => "tes"
                                ];
                            })
                        ];
                    });
                return response()->json($kehadiran, 200);
                break;
            case 'admin':
                $kehadiran = Kehadiran::all()
                    ->map(function ($data) {
                        return [
                            'id' => $data->user->id,
                            'title' => $data->user->nama,
                            'start' => $data->tanggal,
                            'child' => $data->kegiatan->map(function ($kegiatan) use ($data) {
                                return [
                                    'title' => $kegiatan->nama_kegiatan,
                                    'start' => $data->tanggal . " " . $kegiatan->jam_mulai,
                                    'end' => $data->tanggal . " " . $kegiatan->jam_selesai,
                                ];
                            })
                        ];
                    });
                return response()->json($kehadiran, 200);
                break;
            default:
                return response()->json($user, 403);
                break;
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(auth()->user()->role != "pengajar" && auth()->user()->role != "admin", 403);
        if (auth()->user()->role == "pengajar") {
            return view('dashboard.pengajar.pages.kehadiran', [
                'title' => "Kehadiran",
                'full' => true
            ]);
        } elseif (auth()->user()->role == "admin") {
            return view('dashboard.admin.pages.kehadiran', [
                'title' => "Kehadiran",
                'full' => true
            ]);
        } else {
            abort(403);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKehadiranRequest $request)
    {
        $validatedData = $request->validate([
            'kegiatan' => ["required"],
            'id_user' => ['required', 'numeric'],
            'tanggal' => ['date', 'required', 'before:tomorrow'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required']
        ]);

        $kehadiran = Kehadiran::where('id_user', $validatedData['id_user'])
            ->where("tanggal", $validatedData['tanggal'])
            ->first();
        if ($kehadiran) {
            foreach ($validatedData['kegiatan'] as  $index => $kegiatan) {
                $mulai = Carbon::parse($validatedData['jam_mulai'][$index]);
                $selesai = Carbon::parse($validatedData['jam_selesai'][$index]);
                if ($selesai->isAfter($mulai)) {
                    Kegiatan::create([
                        'id_kehadiran' => $kehadiran->id,
                        'nama_kegiatan' => $kegiatan,
                        'jam_mulai' => $mulai,
                        'jam_selesai' => $selesai
                    ]);
                } else {
                    $errors[] = "Waktu selesai harus lebih besar dari waktu mulai untuk kegiatan ke-$index";
                }
            }
        } else {
            $kehadiran = Kehadiran::create([
                'id_user' => $validatedData['id_user'],
                'tanggal' => $validatedData['tanggal']
            ]);

            if ($request->has("kegiatan")) {
                foreach ($validatedData['kegiatan'] as $index => $kegiatan) {
                    $mulai = Carbon::parse($validatedData['jam_mulai'][$index]);
                    $selesai = Carbon::parse($validatedData['jam_selesai'][$index]);
                    if ($selesai->isAfter($mulai)) {
                        Kegiatan::create([
                            'id_kehadiran' => $kehadiran->id,
                            'nama_kegiatan' => $kegiatan,
                            'jam_mulai' => $mulai,
                            'jam_selesai' => $selesai
                        ]);
                    } else {
                        $errors[] = "Waktu selesai harus lebih besar dari waktu mulai untuk kegiatan ke-$index";
                    }
                }
            }
        }

        activity()
            ->event('created')
            ->useLog('kehadiran')
            ->performedOn($kehadiran)
            ->causedBy(auth()->user()->id)
            ->withProperties(['role' => auth()->user()->role])
            ->log('Menambah data kehadiran');

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }
        return redirect()->back()->with('success', 'Kehadiran berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Kehadiran $kehadiran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kehadiran $kehadiran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kehadiran $kehadiran)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kehadiran $kehadiran)
    {
        //
    }
}
