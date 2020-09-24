<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';

    public static function getList()
    {
        $data = DB::table('inventory')
                ->leftJoin('unit', 'inventory.id_unit', 'unit.id_unit')
                ->leftJoin('category', 'inventory.id_category','category.id_category')
                ->select('inventory.*', 'unit.unit', 'category.category')
                ->paginate(5);

        return $data;
    }
}
