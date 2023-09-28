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
            'full' => true
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mapel $mapel)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapel)
    {
        //
    }
}
