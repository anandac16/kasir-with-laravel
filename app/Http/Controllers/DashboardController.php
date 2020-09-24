<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index()
    {
        if(!Session()->get('username')) return redirect('/login')->with('alert', 'Silahkan login terlebih dahulu!');
        
        $data = array(
            'title' => 'Dashboard',
            'username' => Session()->get('username'),
            'role' => Session()->get('id_role'),
        );
        return view('dashboard/index', $data);
    }
}
