<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Sekolah;
use App\Models\Pengajar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PengajarSekolah;
use App\Models\Tugas;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

class SekolahController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sekolah::search('a')->get();
            return response()->json($data);
        }
        return view('dashboard.admin.pages.sekolah', [
            'title' => "Sekolah",
            'full' => false,
            'data_sekolah' => Sekolah::orderBy('id', 'DESC'),
            'kelas' => Kelas::class
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.forms.createSekolah', [
            'title' => "Sekolah",
            'full' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'logo' => ['required'],
            'nama' => ['required', 'unique:sekolah,nama'],
            'provinsi' => ['required'],
            'kabupaten_kota' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'jalan' => ['required'],
            'email' => ['required', 'email:dns'],
            'no_telp' => ['required']
        ], [
            'nama.unique' => "Sekolah dengan nama tersebut sudah ada!",
            'email.email:dns' => "Alamat email tidak valid!"
        ]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($validated_data['nama']) . '.' . $extension;
            $file->move('storage/sekolah', $fileName);
            $validated_data['logo'] = $fileName;
        }
        Sekolah::create($validated_data);
        return redirect()->route('sekolah.show', ["sekolah" => Sekolah::latest()->get()->first()->id])->with('success', 'Sekolah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah, Request $request)
    {
        if ($request->get('data') == "kelas" || $request->get('data') == null) {
            $data = Kelas::where('id_sekolah', '=', $sekolah->id);
        } else {
            $data = $sekolah->pengajar()->withCount([
                'sekolah as jumlah_sekolah' => function ($query) {
                    $query->select(DB::raw('COUNT(DISTINCT id_sekolah)'));
                },
            ])->distinct();
        }
        $pengajar = DB::table('pengajar_sekolah')
            ->select('id_user')
            ->where('id_sekolah', '=', $sekolah->id)
            ->groupBy('id_user')
            ->get();

        return view("dashboard.admin.pages.detailSekolah", [
            'title' => "Sekolah",
            'full' => true,
            'info_sekolah' => $sekolah,
            'data' => $data,
            'jumlah_pengajar' => $pengajar,
            'data_kelas' => Kelas::where('id_sekolah', '=', $sekolah->id)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        return view('dashboard.admin.forms.editSekolah', [
            'title' => 'Sekolah',
            'full' => true,
            'data' => $sekolah,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $validated_data = $request->validate([
            'logo' => [''],
            'nama' => ['required'],
            'provinsi' => ['required'],
            'kabupaten_kota' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'jalan' => ['required'],
            'email' => ['required'],
            'no_telp' => ['required']
        ]);
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($validated_data['nama']) . '.' . $extension;
            $file->move('storage/sekolah', $fileName);
            $validated_data['logo'] = $fileName;
        } else {
            $validated_data['logo'] = $sekolah->logo;
        }
        $sekolah->update($validated_data);
        return redirect()->route('sekolah.show', ["sekolah" => $sekolah->id])->with('success', "Informasi sekolah berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        $pengajar = PengajarSekolah::where("id_sekolah", $sekolah->id);
        $pengajar->delete();
        Tugas::whereIn('id_pengajar', $pengajar->pluck('id')->toArray())->delete();
        $sekolah->siswa()->delete();
        $sekolah->kelas()->delete();
        $sekolah->delete();
        return redirect()->route('sekolah.index')->with('success', "Data sekolah berhasil di arsipkan");
    }

    public function maximize(Sekolah $sekolah, $data, Request $request)
    {
        if ($data == "pengajar") {
            if ($request->query()) {
                $pengajar = $sekolah->pengajar()->filter(['status' => $request->get('status'), 'sort' => $request->get('sort')])->withCount([
                    'sekolah as jumlah_sekolah' => function ($query) {
                        $query->select(DB::raw('COUNT(DISTINCT id_sekolah)'));
                    },
                ])->distinct('id_user');
            } else {
                $pengajar = $sekolah->pengajar()->withCount([
                    'sekolah as jumlah_sekolah' => function ($query) {
                        $query->select(DB::raw('COUNT(DISTINCT id_sekolah)'));
                    },
                ])->distinct('id_user');
            }
            return view('dashboard.admin.pages.daftarPengajarPerSekolah', [
                'title' => "Sekolah",
                'full' => true,
                'info_sekolah' => $sekolah,
                'daftar_pengajar' => $pengajar->paginate(8)->withQueryString()
            ]);
        }
        if ($request->query()) {
            $dataKelas = $sekolah->kelas()->filter(['tingkat' => $request->get('tingkat'), 'jurusan' => $request->get('jurusan'), 'ajaran' => $request->get('ajaran')]);
        } else {
            $dataKelas = $sekolah->kelas();
        }

        $semuaJurusan = $sekolah->kelas()->pluck('jurusan')->unique()->values()->all();
        $jurusanUnik = collect($semuaJurusan)->map(function ($jurusan) {
            return [
                'nama_jurusan' => $jurusan,
                'slug' => Str::slug($jurusan),
            ];
        })->toArray();

        $semuaTahunAjaran = $sekolah->kelas()->pluck('tahun_ajar')->unique()->values()->all();
        $semuaTahunAjaran = collect($semuaTahunAjaran)->map(function ($tahun_ajar) {
            return $tahun_ajar;
        })->toArray();


        return view('dashboard.admin.pages.daftarKelasPerSekolah', [
            'title' => "Sekolah",
            'full' => true,
            'info_sekolah' => $sekolah,
            'daftar_kelas' => $dataKelas,
            'daftar_jurusan' => $jurusanUnik,
            'tahun_ajaran' => $semuaTahunAjaran
        ]);
    }
}
