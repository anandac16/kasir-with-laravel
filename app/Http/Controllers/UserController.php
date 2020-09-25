<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
    }

    public function profile(Request $request)
    {
        $data = array(
            'title' => 'Dashboard',
            'username' => $request->session()->get('username'),
            'role' => $request->session()->get('id_role'),
            'profile_data' => User::where('username', $request->session()->get('username'))->first(),
        );
        return view('user/profile', $data);
    }
}
