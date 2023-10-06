<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LogActivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($this->shouldLogActivity($request) && $this->isSuccessfulUpdate($request, $response)) {
            $activityDescription = $this->getActivityDescription($request);

            // Peroleh pengguna yang sedang melakukan permintaan
            $user = User::find(auth()->user()->id);

            // Catat aktivitas hanya jika permintaan PUT atau PATCH berhasil
            activity()
                ->performedOn($user)
                ->log($activityDescription['desc']);
        }
        return $response;
    }

    protected function shouldLogActivity($request)
    {
        return ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch') || $request->isMethod('delete'));
    }
    protected function isSuccessfulUpdate(Request $request, $response)
    {
        // Periksa apakah permintaan PUT atau PATCH
        if ($request->isMethod('put') || $request->isMethod('patch')) {
            // Periksa apakah status respons HTTP adalah 2xx
            return $response->isSuccessful();
        }

        return false;
    }
    protected function getActivityDescription($request)
    {
        if ($request->isMethod('post')) {
            return ['desc' => 'Menambahkan data baru', 'name' => 'store'];
        } elseif ($request->isMethod('put') || $request->isMethod('patch')) {
            return ['desc' => 'Mengedit data', 'name' => 'update'];
        } elseif ($request->isMethod('delete')) {
            return ['desc' => 'Menghapus data', 'name' => 'delete'];
        }
        return 'Aktivitas tidak diketahui';
    }
}
