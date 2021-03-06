<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'unit';
    protected $primaryKey = 'id_unit';
    public $timestamps = false;

    public static function getList()
    {
        $data = DB::table('unit')
                ->select('*')
                ->paginate(5);

        return $data;
    }
}
