<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeRedirectController extends Controller
{
    // / にアクセスしたときに振り分け
    public function __invoke()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return redirect()->route('landing');
    }
}

class HomeController extends Controller
{
    // /home
    public function index()
    {
        return view('home'); // resources/views/home.blade.php
    }

    // 新規登録フォーム
    public function showRegisterForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    // 新規登録処理
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended('/home');
    }

    // ログインフォーム
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    // ログイン処理
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません。',
        ]);
    }

    // ログアウト処理
    public function logout()
    {
        Auth::logout();
        return redirect()->route('landing');
    }
}
