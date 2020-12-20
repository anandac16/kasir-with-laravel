<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stock';
    protected $primaryKey = 'id_stock';

    public static function getList()
    {
        $data = DB::table('stock')
                ->leftJoin('inventory', 'stock.id_inventory', 'inventory.id_inventory')
                ->leftJoin('supplier', 'stock.id_supplier', 'supplier.id_supplier')
                ->leftJoin('unit', 'stock.id_unit', 'unit.id_unit')
                ->select('stock.*', 'inventory.item_name', 'supplier.nama', 'unit.unit')
                ->paginate(5);

        return $data;
    }

    public static function createPO($data = null)
    {
        $detail = array();
        $getInv = DB::table('inventory')->where('id_inventory', $data->id_inventory)->first();
        $purchase = new Purchase;
        $purchase->no_po =Stock::generateNoPO();
        $purchase->id_supplier = $data->id_supplier;
        $purchase->id_inventory = $data->id_inventory;
        $purchase->id_stock = $data->id_stock;
        $purchase->qty = $data->stock;
        $purchase->price = $getInv->price_buy;
        $purchase->created_by = Session()->get('username');
        return $purchase->save();
    }

    public static function generateNoPO(Type $var = null)
    {
        // No PO Patern PO/YY/MM/0001
        $getLastPO = DB::table('purchases')->where('created_at', '>=', now()->subDays(30)->toDateTimeString())->orderBy('created_at', 'desc')->first();

        if(!empty($getLastPO)) {
            $split = explode('/', $getLastPO->no_po);
            $number = sprintf('%04d',$split[3]+1);
        }else{
            $number = '0001';
        }
        return $no_po = 'PO/'.date('y/m/') . $number;
    }

    public static function deleteStock($id_stock)
    {
        $id_stock = (int) $id_stock;
        Stock::find($id_stock)->delete();
        $purchase = Purchase::get()->where('id_stock', $id_stock)->first();
        Purchase::find($purchase->id_po)->delete();
    }
}
