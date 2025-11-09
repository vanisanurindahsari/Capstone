<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }
     public function login(Request $request) {
        // Validasi Input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
                if ($user->role === 'owner') {
                return redirect()->route('owner.dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'pegawai') {
                return redirect()->route('pegawai.dashboard');
            }
        }
         return back()->withErrors([
        'email' => 'Email atau password salah. Silahkan coba lagi.'
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
