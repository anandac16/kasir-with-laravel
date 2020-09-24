<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        if(!Session()->get('username')) return redirect('/login')->with('alert', 'Silahkan login terlebih dahulu!');
        
        $data = array(
            'title' => 'Inventory',
            'username' => Session()->get('username'),
            'role' => Session()->get('id_role'),
            'data' => Inventory::getList(),
        );
        return view('inventory/list', $data);
    }
}
