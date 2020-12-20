<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id_transaksi_detail';
    public $timestamps = false;

    public static function getSubdetail($id)
    {
        return DB::table('transaksi_detail')
                ->leftJoin('inventory', 'inventory.id_inventory', 'transaksi_detail.id_inventory')
                ->select('*')
                ->where('id_transaksi', $id)
                ->get();
    }
}
