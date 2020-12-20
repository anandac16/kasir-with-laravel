<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';
    protected $primaryKey = 'id_inventory';
    public $timestamps = false;

    public static function getList()
    {
        $data = DB::table('inventory')
                ->leftJoin('unit', 'inventory.id_unit', 'unit.id_unit')
                ->leftJoin('category', 'inventory.id_category','category.id_category')
                ->leftJoin('stock', 'inventory.id_inventory', 'stock.id_inventory')
                ->select('inventory.*', 'unit.unit', 'category.category', 'stock.stock')
                ->paginate(5);

        return $data;
    }

    public static function isExist($column, $value)
    {
        return DB::table('inventory')->where($column, $value)->exists();
    }
}
