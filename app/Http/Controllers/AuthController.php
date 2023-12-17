<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view("pages.auth.login");
    }
    public function showRegister()
    {
        return view("pages.auth.register");
    }

    public function store(RegisterRequest $request)
    {
        User::create([
            "email" => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password),
        ]);
        return redirect('/')->with('status', 'Succesfull registration!');
    }

    public function index(LoginRequest $request)
    {
        if (Auth::check()) {
            return redirect('/')->withErrors('You are already logged in!');
        }

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return redirect('/login')->withErrors('Invalid credentials');
        }

        return redirect('/')->with('status', 'Succesfull login!');
    }
    public function destroy()
    {
        Session::flush();
        Auth::logout();

        return redirect('/')->with('status', 'Logged out!');
    }
}
