<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
Use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
    }

    public function profile(Request $request)
    {
        $data = array(
            'title' => 'Dashboard',
            'username' => $request->session()->get('username'),
            'role' => $request->session()->get('id_role'),
            'profile_data' => User::where('username', $request->session()->get('username'))->first(),
        );
        return view('user/profile', $data);
    }

    public function list()
    {
        $data = array(
            'title' => 'User list',
            'data' => User::getList(),
            'roles' => Role::all(),
        );
        return view('user/list', $data);
    }

    public function find(Request $request)
    {
        $id_user = (int) $request->input('id_user');
        return User::get()->where('id_user', $id_user)->first();
    }

    public function save(Request $request)
    {
        $data = json_decode($request->getContent());

        $exists = User::get()->where('username', $data->username)->first();
        if($exists && $data->id_user != $exists->id_user)
            return response()->json(['result' => false, 'message' => 'User Name sudah digunakan!']);
        if(!User::get()->where('id_user', $data->id_user)->first()) {
            $User = new User;
            $action = 'ditambahkan';
        }else{
            $User = User::find($data->id_user); 
            $action = 'diubah';
        }
        $User->username = $data->username;
        $User->password = Hash::make($data->password);
        $User->first_name = $data->first_name;
        $User->last_name = $data->last_name;
        $User->full_name = $data->first_name ." ". $data->last_name;
        $User->email = $data->email;
        $User->id_role = $data->id_role;
        $User->notes = (isset($data->notes) ? $data->notes : '');
        if($User->save()) {
            return response()->json(['result' => true,'message' => 'User berhasil '. $action .'!']);
        }else{
            return response()->json(['result' => false, 'message' => 'User gagal '. $action .'!']);
        }
    }

    public function delete(Request $request)
    {
        $id_user = (int) $request->input('id_user');
        User::find($id_user)->delete();
        return response()->json(['result' => true,'message' => 'User berhasil dihapus!']);
    }
}
