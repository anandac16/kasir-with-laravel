<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
    }

    public function index()
    {
        $data = array(
            'title' => 'Member list',
            'data' => Member::getList(),
        );
        $url = url()->current();
        if(preg_match('/topup/', $url)) {
            return view('member/topup', $data);
        }
        return view('member/list', $data);
    }

    public function save(Request $request)
    {
        $data = json_decode($request->getContent());
        $id_member = $data->id_member;
        $member = new Member;
        if($id_member > 0) 
            $member = Member::find($id_member);
        $member->no_member = $data->no_member;
        $member->nama_lengkap = $data->nama_lengkap;
        $member->no_identitas = $data->no_identitas;
        $member->no_hp = $data->no_hp;
        $member->tanggal_lahir = $data->tanggal_lahir;
        if($member->save()) {
            return response()->json(['result' => true,'message' => 'Success!!']);
        }else{
            return response()->json(['result' => false, 'message' => 'Failed!!']);
        }
    }

    public function delete(Request $request)
    {
        $id_member = (int) $request->input('id_member');
        Member::find($id_member)->delete();
        return response()->json(['result' => true,'message' => 'Member berhasil dihapus!']);
    }

    public function find(Request $request)
    {
        $no_member = $request->input('no_member');
        $member = Member::get()->where('no_member', $no_member)->first();
        // die($no_member);
        $response = ['result' => false];
        if($member)
            $response = ['result' => true, 'data' => $member];
        return response()->json($response);
    }

    public function topup(Request $request)
    {
        $data = json_decode($request->getContent());
        $id_member = $data->id_member;
        $member = Member::find($id_member);
        $member->points += $data->points;
        if($member->save()) {
            $transaction = new Transaction;
            $transaction->no_transaksi = 'TU/'. date('y/m') .'/'. $data->no_member;
            $transaction->date = date('Y-m-d H:i:s');
            $transaction->cashier = Session()->get('username');
            $transaction->id_member = $id_member;
            $transaction->sub_total = $data->points;
            $transaction->total = $data->points;
            $transaction->bayar = $data->points;
            $transaction->kembalian = 0;
            $transaction->discount = 0;
            $transaction->ppn = 0;
            $transaction->save();
            $id_trx = $transaction['id_transaksi'];
            $subdetail = array(
                'id_transaksi' => $id_trx,
                'id_inventory' => 16,
                'qty' => 1,
                'price' => $data->points,
                'discount_item' => 0,
                'total_item' => $data->points,
            );
            $tdetail = new TransactionDetail;
            foreach($subdetail as $key => $val) {
                $tdetail->$key = $val;
            }
            $tdetail->save();


            return response()->json(['result' => true,'message' => 'Success!!']);
        }else{
            return response()->json(['result' => false, 'message' => 'Failed!!']);
        }
    }
}
