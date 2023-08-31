<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
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
            activity()
                ->useLog(auth()->user()->role)
                ->causedBy(auth()->user())
                ->log('Login');
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
        activity()
            ->useLog(auth()->user()->role)
            ->causedBy(auth()->user())
            ->log('Logout');
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
        $validated_data = $request->validate([
            'foto' => ['required'],
            'nik' => ['required', 'unique:users,nik'],
            'nama' => ['required'],
            'username' => ['required', 'unique:users,username'],
            'password' => ['confirmed', 'required'],
            'email' => ['required', 'email:dns'],
            'no_telp' => ['required']
        ]);
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($validated_data['nama']) . '.' . $extension;
            $file->move('storage/pengajar', $fileName);
            $validated_data['foto'] = $fileName;
        }
        $validated_data['role'] = "pengajar";
        $validated_data['statue'] = "aktif";
        User::create($validated_data);
        return redirect()->route('pengajar.index')->with('success', 'Pengajar berhasil ditambahkan');
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
        if ($request->foto != null) {
            $validated_data = $request->validate([
                'foto' => [],
                'nik' => ['required'],
                'nama' => ['required'],
                'username' => ['required'],
                'email' => ['required', 'email:dns'],
                'no_telp' => ['required'],
                'status' => ['required']
            ]);
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::slug($validated_data['nama']) . '.' . $extension;
                $file->move('storage/pengajar', $fileName);
                $validated_data['foto'] = $fileName;
            } else {
                $validated_data['foto'] = $user->logo;
            }
        } else {
            $validated_data = $request->validate([
                'nik' => ['required'],
                'nama' => ['required'],
                'username' => ['required'],
                'email' => ['required', 'email:dns'],
                'no_telp' => ['required'],
                'status' => ['required']
            ]);
        }
        if ($user->update($validated_data)) {
            return back()->with('success', "Informasi berhasil diubah!");
        } else {
            return back()->with('success', "Informasi gagal diubah!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
