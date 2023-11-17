<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use App\Models\PengajarMapel;

class MapelController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mapel = Mapel::query();

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $mapel->filter(['filter' => $filter]);
        }

        if ($request->ajax()) {
            $query = $request->get('query');
            $pengajarId = $request->get('id');
            $mapelPengajar = PengajarMapel::where('id_user', $pengajarId)->pluck('id_mapel')->toArray();
            $mapel = Mapel::search($query)->whereNotIn('id', $mapelPengajar)->get();
            if ($mapel->count()) {
                return response()->json($mapel);
            } else {
                return response()->json(['error' => "Mapel not found"]);
            }
        }
        return view('dashboard.admin.pages.mapel', [
            'title' => 'Mapel',
            'full' => true,
            'daftar_mapel' => $mapel->get()
        ]);
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
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'nama_mapel' => ['required', 'min:1', 'max:75', 'unique:mapel,nama_mapel']
        ]);
        Mapel::create($validated_data);
        activity()
            ->event('created')
            ->useLog('mapel')
            ->performedOn(Mapel::latest()->first())
            ->causedBy(auth()->user()->id)
            ->withProperties(['role' => auth()->user()->role])
            ->log('Menambah data mapel');

        return redirect()->back()->with('success', 'Mata pelajaran berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mapel $mapel)
    {
        return view('dashboard.admin.pages.daftarPengajarMapel', [
            'title' => "Mapel",
            'full' => true,
            'info_mapel' => $mapel
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mapel $mapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapel $mapel)
    {
        $validated_data = $request->validate([
            'nama_mapel' => ['required', 'min:1', 'max:75', 'unique:mapel,nama_mapel']
        ]);

        $mapel->update($validated_data);
        activity()
            ->event('update')
            ->useLog('mapel')
            ->performedOn($mapel)
            ->causedBy(auth()->user()->id)
            ->withProperties(['role' => auth()->user()->role])
            ->log('Mengubah data mapel');
        return redirect()->back()->with('success', 'Mata pelajaran berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapel)
    {
        PengajarMapel::where('id_mapel', $mapel->id)->delete();
        $mapel->delete();
        activity()
            ->event('arsip')
            ->useLog('mapel')
            ->performedOn($mapel)
            ->causedBy(auth()->user()->id)
            ->withProperties(['role' => auth()->user()->role])
            ->log('Mengarsipkan data mapel');
        return redirect()->route('mapel.index')->with('success', 'Mata pelajaran berhasil diarsipkan');
    }
}
