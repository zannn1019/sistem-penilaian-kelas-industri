<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SekolahController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.admin.pages.sekolah', [
            'title' => "Sekolah",
            'full' => false,
            'data_sekolah' => Sekolah::all(),
            'kelas' => Kelas::class
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = json_decode(file_get_contents('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json'));
        return view('dashboard.admin.forms.createSekolah', [
            'title' => "Sekolah",
            'full' => true,
            'data_provinsi' => $provinsi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'logo' => ['required'],
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
        }
        Sekolah::create($validated_data);
        return redirect()->route('sekolah.show', ["sekolah" => Sekolah::latest()->get()->first()->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah)
    {
        return view("dashboard.admin.pages.detailSekolah", [
            'title' => "Sekolah",
            'full' => true,
            'data' => $sekolah,
            'data_kelas' => Kelas::where('id_sekolah', '=', $sekolah->id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        return view('dashboard.admin.forms.editSekolah', [
            'title' => 'Sekolah',
            'full' => false,
            'data' => $sekolah
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
            'alamat' => ['required'],
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
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        $sekolah->destroy($sekolah->id);
        return back();
    }
}
