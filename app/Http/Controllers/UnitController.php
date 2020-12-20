<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{

    public function __construct()
    {
        $this->middleware('isLogin');
        $this->middleware('isAdmin');
    }

    public function index() {
        $data = array(
            'title' => 'Inventory > Unit',
            'username' => Session()->get('username'),
            'role' => Session()->get('id_role'),
            'data' => Unit::getList(),
        );
        return view('unit/list', $data);
    }

    public function save(Request $request)
    {
        $data = json_decode($request->getContent());

        $exists = Unit::get()->where('unit', $data->unit)->first();
        if($exists && $data->id_unit != $exists->id_unit)
            return response()->json(['result' => false, 'message' => 'Unit Name sudah digunakan!']);
        if(!Unit::get()->where('id_unit', $data->id_unit)->first()) {
            $unit = new Unit;
            $action = 'ditambahkan';
        }else{
            $unit = Unit::find($data->id_unit); 
            $action = 'diubah';
        }
        $unit->unit = $data->unit;
        if($unit->save()) {
            return response()->json(['result' => true,'message' => 'Unit berhasil '. $action .'!']);
        }else{
            return response()->json(['result' => false, 'message' => 'Unit gagal '. $action .'!']);
        }
    }

    public function delete(Request $request)
    {
        $id_unit = (int) $request->input('id_unit');
        Unit::find($id_unit)->delete();
        return response()->json(['result' => true,'message' => 'Unit berhasil dihapus!']);
    }
}
