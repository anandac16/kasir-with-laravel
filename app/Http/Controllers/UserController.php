<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;

class UserController extends Controller
{

    public function profile(Request $request)
    {
        if(!Session()->get('username')) return redirect('/login')->with('alert', 'Silahkan login terlebih dahulu!');
        
        $data = array(
            'title' => 'Dashboard',
            'username' => $request->session()->get('username'),
            'role' => $request->session()->get('id_role'),
            'profile_data' => User::where('username', $request->session()->get('username'))->first(),
        );
        return view('user/profile', $data);
    }
}
