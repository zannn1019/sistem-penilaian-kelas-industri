<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login', ['title' => 'Sistem Penilaian Kelas Industri']);
    }

    public function auth(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'min:5'],
            'password' => ['required', 'min:5']
        ]);
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            if (auth()->user()->role == "pengajar") {
                return redirect()->intended('pengajar/dashboard')->with('success', "Welcome Back " . auth()->user()->nama);
            } else if (auth()->user()->role == "admin") {
                return redirect()->intended('admin/dashboard')->with('success', "Welcome Back " . auth()->user()->nama);
            }
        }
        return back()->with('error', 'Incorect username or password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
