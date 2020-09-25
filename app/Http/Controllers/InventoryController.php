<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Unit;
use App\Models\Category;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
        $this->middleware('isAdmin');
    }
    public function index()
    {
        $data = array(
            'title' => 'Inventory',
            'username' => Session()->get('username'),
            'role' => Session()->get('id_role'),
            'data' => Inventory::getList(),
            'unit' => Unit::all(),
            'category' => Category::all(),
        );
        return view('inventory/list', $data);
    }

    public function add(Request $request)
    {
        $data = json_decode($request->getContent());

        //check if item code is exist
        $exists = Inventory::isExist('item_code', $data->item_code);
        if($exists)
            return response()->json(['result' => false, 'message' => 'Item Code sudah digunakan!']);
        $insert = new Inventory;
        $insert->item_code = $data->item_code;
        $insert->item_name = $data->item_name;
        $insert->price = floatval(str_replace(',','', $data->price));
        $insert->id_unit = $data->id_unit;
        $insert->id_category = $data->id_category;
        if($insert->save()){
            return response()->json(['result' => true,'message' => 'Item berhasil ditambahkan!']);
        }else{
            return response()->json(['result' => false, 'message' => 'Item gagal ditambahkan!']);
        }
    }
}
