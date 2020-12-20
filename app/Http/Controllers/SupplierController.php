<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
    }

    public function index(Type $var = null)
    {
        $data = array(
            'data' => Supplier::getList(),
            'title' => 'Supplier',
        );
        return view('supplier/list', $data);
    }

    public function save(Request $request)
    {
        $data = json_decode($request->getContent());
        $id_supplier = $data->id_supplier;
        $supplier = new Supplier;
        if($id_supplier > 0) 
            $supplier = Supplier::find($id_supplier);
        $supplier->nama = $data->nama;
        $supplier->alamat = $data->alamat;
        $supplier->no_telp = $data->no_telp;
        $supplier->keterangan = $data->keterangan;
        if($supplier->save()) {
            return response()->json(['result' => true,'message' => 'Success!!']);
        }else{
            return response()->json(['result' => false, 'message' => 'Failed!!']);
        }
    }

    public function delete(Request $request)
    {
        $id_supplier = (int) $request->input('id_supplier');
        Supplier::find($id_supplier)->delete();
        return response()->json(['result' => true,'message' => 'Supplier berhasil dihapus!']);
    }
}
