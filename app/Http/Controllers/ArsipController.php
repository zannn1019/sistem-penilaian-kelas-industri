<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Sekolah;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Termwind\Components\Dd;

class ArsipController extends Controller
{
    public function admin()
    {
        if (auth()->user()->role != 'admin') {
            abort(404);
        }
        $sekolah = Sekolah::onlyTrashed()->get()->map(function ($item) {
            $item['tipe'] = 'sekolah';
            return $item;
        });

        $kelas = Kelas::onlyTrashed()->get()->map(function ($item) {
            $item['tipe'] = 'kelas';
            return $item;
        });

        $mapel = Mapel::onlyTrashed()->get()->map(function ($item) {
            $item['tipe'] = 'mapel';
            return $item;
        });

        $mergeData = $sekolah->concat($kelas)->concat($mapel);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;

        $paginatedData = new LengthAwarePaginator(
            $mergeData->forPage($currentPage, $perPage),
            $mergeData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dashboard.admin.pages.arsipAdmin', [
            'title' => 'Arsip',
            'full' => true,
            'arsip' => $paginatedData
        ]);
    }

    public function pengajar()
    {
        if (auth()->user()->role != 'pengajar') {
            abort(404);
        }
        $pengajar = auth()->user();
        $tugas = $pengajar->tugas()->onlyTrashed()->get()->map(function ($tugas) {
            $tugas['tipe'] = "tugas";
            return $tugas;
        });
        $mergeData = $tugas;

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;

        $paginatedData = new LengthAwarePaginator(
            $mergeData->forPage($currentPage, $perPage),
            $mergeData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dashboard.pengajar.pages.arsipPengajar', [
            'title' => 'Arsip',
            'full' => true,
            'arsip' => $paginatedData
        ]);
    }

    public function aksi(Request $request)
    {
        try {
            $dataCollection = collect($request->get('id'))->zip($request->get('tipe'))->map(function ($item) {
                return ['tipe' => $item[1], 'id' => $item[0]];
            });
            $dataTipe = $dataCollection->unique('tipe')->pluck('tipe')->toArray();
            foreach ($dataTipe as $tipe) {
                if ($tipe != null) {
                    $model = "App\\Models\\" . ucfirst($tipe);
                    $dataId = $dataCollection->filter(function ($item) use ($tipe) {
                        return $item['tipe'] ===  $tipe;
                    })->pluck('id')->toArray();
                    $data = $model::onlyTrashed()->whereIn('id', $dataId);
                    if ($request->get('aksi') == 'hapus') {
                        $data->forceDelete();
                    }
                    if ($request->get('aksi') == 'pulihkan') {
                        $data->restore();
                        $this->cascadeRestore($model);
                    }
                }
            }
            $modelName = explode('\\', $model);
            $tipe = $request->get('tipe');
            foreach ($tipe as $t) {
                $desc = $request->get('aksi') == "hapus" ? "Mengapus secara permanen " : "Memulihkan ";
                activity()
                    ->event($request->get('aksi'))
                    ->useLog('arsip')
                    ->performedOn(app($model))
                    ->causedBy(auth()->user()->id)
                    ->withProperties(['role' => auth()->user()->role])
                    ->log($desc . ' data ' . end($modelName));
            }
            return redirect()->back()->with('success', "Data berhasil di" . $request->get('aksi') . " !");
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with("error", 'Data tidak ditemukan!');
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", 'Data gagal dihapus!');
        }
    }
    public function cascadeRestore($model)
    {
        $models = $model::withTrashed()->get();

        foreach ($models as $value) {
            foreach ($value->getRelations() as $key => $relation) {
                $arr = explode('\\', $model);

                if (strpos($key, 'pengajar') !== false) {
                    $relatedModel = "App\\Models\\PengajarMapel";
                } else {
                    $relatedModel = "App\\Models\\" . ucfirst($key);
                }

                $relatedModel::onlyTrashed()->restore();
            }
        }
    }
}
