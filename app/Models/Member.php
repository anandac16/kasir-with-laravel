<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    use HasFactory;
    protected $table = 'member';
    protected $primaryKey = 'id_member';
    public $timestamps = false;

    public static function getList()
    {
        $data = DB::table('member')
                ->select('*')
                ->paginate(5);

        return $data;
    }
}
