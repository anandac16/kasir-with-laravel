<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    public $timestamps = false;

    public static function getList()
    {
        $data = DB::table('supplier')
                ->select('*')
                ->paginate(5);

        return $data;
    }
}
