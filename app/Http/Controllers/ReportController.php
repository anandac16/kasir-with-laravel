<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function purchase(Type $var = null)
    {
        return view('report/purchase');
    }
}
