<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
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
        $user = User::create([
            "email" => $request->email,
            "name" => $request->name,
            "password" => Hash::make($request->password),
        ]);
        if ($user->id === 1) {
            $user->isAdmin = true;
            $user->save();
        }
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

    public function showChangePassword()
    {
        return view('pages.auth.changepassword');
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::find(Auth::id());
        if (Hash::check($request->oldPassword, $user->password)) {
            if (Hash::check($request->password, $user->password)) {
                return redirect()->back()->withErrors('New password can not be the same as old password!');
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('/')->with('status', 'Password changed successfully!');
        }
        return redirect()->back()->withErrors('Wrong password!');
    }
}
