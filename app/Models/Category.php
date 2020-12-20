<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $primaryKey = 'id_category';
    public $timestamps = false;

    public static function getList()
    {
        $data = DB::table('category')
                ->select('*')
                ->paginate(5);

        return $data;
    }
}
