<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function formLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return view('dashboard.auth.login');
    }

    public function login(Request $request)
    {
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->withErrors('Email inválido.');
        }
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->withInput()->withErrors('Email ou senha inválidos.');
        }

        return redirect()->route('dashboard.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('dashboard.login');
    }
}
