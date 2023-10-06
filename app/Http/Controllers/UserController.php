<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

    //? Password reset controller
    public function forgotpass()
    {
        return view('forgotPassword');
    }

    public function forgotpass_email(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetform(string $token)
    {
        return view('resetPassword', ['token' => $token]);
    }

    public function resetpass(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    //? End of password reset
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
