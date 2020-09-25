<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (Session()->exists('credential_key')) 
            return redirect('/');
        return view('login/index');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->put('credential_key', Hash::make($username));
            $request->session()->put('username', $username);
            $request->session()->put('password', $password);
            $request->session()->put('id_role', Auth::user()->id_role);
            return redirect('/');
        }else{
            $request->session()->flash('type', 'danger');
            return redirect('/login')->with('alert', 'Username atau password salah!');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('username');
        $request->session()->flush();
        $request->session()->flash('type', 'success');
        return redirect('/login')->with('alert', 'logout berhasil');

    }
}
