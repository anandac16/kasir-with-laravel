<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
        $this->middleware('isAdmin');
    }

    public function index() {
        $data = array(
            'title' => 'Inventory > Category',
            'username' => Session()->get('username'),
            'role' => Session()->get('id_role'),
            'data' => Category::getList(),
        );
        return view('category/list', $data);
    }

    public function save(Request $request)
    {
        $data = json_decode($request->getContent());

        $exists = Category::get()->where('category', $data->category)->first();
        if($exists && $data->id_category != $exists->id_category)
            return response()->json(['result' => false, 'message' => 'Category Name sudah digunakan!']);
        if(!Category::get()->where('id_category', $data->id_category)->first()) {
            $category = new Category;
            $action = 'ditambahkan';
        }else{
            $category = Category::find($data->id_category); 
            $action = 'diubah';
        }
        $category->category = $data->category;
        if($category->save()) {
            return response()->json(['result' => true,'message' => 'Category berhasil '. $action .'!']);
        }else{
            return response()->json(['result' => false, 'message' => 'Category gagal '. $action .'!']);
        }
    }

    public function delete(Request $request)
    {
        $id_category = (int) $request->input('id_category');
        Category::find($id_category)->delete();
        return response()->json(['result' => true,'message' => 'Category berhasil dihapus!']);
    }
}
