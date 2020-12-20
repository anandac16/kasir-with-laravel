<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Counter extends Model
{
    use HasFactory;
    protected $table = 'counter';
    protected $primaryKey = 'date';

    public static function updateCount($date, $no)
    {
        $date = date('Y-m-d', strtotime($date));
        $n = explode('-', $no);
        $number = $n[1];
        $get = DB::table('counter')->where('date', $date)->exists();
        if($get) {
            return DB::table('counter')->where('date', $date)->update(['number' => $number]);
        }else{
            return DB::table('counter')->insert(['date' => $date, 'number' => $number]);
        }
    }
}
