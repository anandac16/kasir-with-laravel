<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
    }

    public function index()
    {
        $data = array(
            'title' => 'Dashboard',
            'username' => Session()->get('username'),
            'role' => Session()->get('id_role'),
        );
        return view('dashboard/index', $data);
    }
}
