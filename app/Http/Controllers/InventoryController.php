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

    public function save(Request $request)
    {
        $data = json_decode($request->getContent());
        $exists = Inventory::get()->where('item_code', $data->item_code)->first();    //check if item code is exist
        if($exists && $data->id_inventory != $exists->id_inventory)
            return response()->json(['result' => false, 'message' => 'Item Code sudah digunakan!']);
        if(!Inventory::isExist('id_inventory', $data->id_inventory)) {
            $inventory = new Inventory;
            $action = 'ditambahkan';
        }else{
            $inventory = Inventory::find($data->id_inventory); 
            $action = 'diubah';
        }
        $inventory->item_code = $data->item_code;
        $inventory->item_name = $data->item_name;
        $inventory->price_buy = floatval(str_replace(',','', $data->price_buy));
        $inventory->price_sell = floatval(str_replace(',','', $data->price_sell));
        $inventory->id_unit = $data->id_unit;
        $inventory->id_category = $data->id_category;
        if($inventory->save()) {
            return response()->json(['result' => true,'message' => 'Item berhasil '. $action .'!']);
        }else{
            return response()->json(['result' => false, 'message' => 'Item gagal '. $action .'!']);
        }

    }

    public function find(Request $request)
    {
        $id_inventory = (int) $request->input('id_inventory');
        return Inventory::get()->where('id_inventory', $id_inventory)->first();
    }

    public function findFromCode(Request $request)
    {
        $item_code = $request->input('item_code');
        return Inventory::get()->where('item_code', $item_code)->first();
    }

    public function delete(Request $request)
    {
        $id_inventory = (int) $request->input('id_inventory');
        Inventory::find($id_inventory)->delete();
        return response()->json(['result' => true,'message' => 'Item berhasil dihapus!']);
    }
}
