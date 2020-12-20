<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\Unit;

class StockController extends Controller
{
    public function index(Type $var = null)
    {
        $data = array(
            'data' => Stock::getList(),
            'inventory' => Inventory::all(),
            'supplier' => Supplier::all(),
            'unit' => Unit::all(),
            'title' => 'Inventory > Stock',
        );
        return view('stock/list', $data);
    }

    public function save(Request $request)
    {
        $data = json_decode($request->getContent());
        $id_stock = $data->id_stock;
        $stock = new Stock;
        if($id_stock > 0) 
            $stock = Stock::find($id_stock);
        $stock->id_inventory = $data->id_inventory;
        $stock->id_supplier = $data->id_supplier;
        $stock->stock = $data->stock;
        $stock->id_unit = $data->id_unit;
        $stock->created_by = Session()->get('username');
        if($stock->save()) {
            Stock::createPO($stock);
            return response()->json(['result' => true,'message' => 'Success!!']);
        }else{
            return response()->json(['result' => false, 'message' => 'Failed!!']);
        }
    }

    public function delete(Request $request)
    {
        $id_stock = (int) $request->input('id_stock');
        Stock::deleteStock($id_stock);
        return response()->json(['result' => true,'message' => 'Stock berhasil dihapus!']);
    }
}
