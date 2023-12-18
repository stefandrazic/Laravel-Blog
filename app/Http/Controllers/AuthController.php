<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyUserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
        }
        $user->verify_string = Str::uuid()->toString();
        $user->save();
        $mailData = $user->only('email', 'verify_string');
        Mail::to($user->email)->send(new VerifyUserMail($mailData));

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

        $user = Auth::user();
        if (!$user->email_verified_at) {
            Session::flush();
            Auth::logout();
            return redirect('/login')->with('status', 'Not verified!');
        }
        return redirect('/')->with('status', 'Successfully loged in!');
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

    public function verify(string $string)
    {
        $user = User::where('verify_string', $string)->first();
        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();
        }
        return redirect('/login')->with('status', 'Succesfully verified');
    }
}
