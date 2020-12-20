<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Counter;
use App\Models\Stock;
use App\Models\Member;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('isLogin');
    }

    public function index()
    {
        $no_trx = 'TRX-0001-'.date('dmy');
        $counter = Counter::find(date('Y-m-d'));
        if(!empty($counter)){
            $number = sprintf('%04d',$counter['number']+1);
            $no_trx = 'TRX-'.$number.'-'.date('dmy');
        }
        $data = array(
            'no_transaksi' => $no_trx
        );
        return view('transaction/index', $data);
    }

    public function proccess(Request $request)
    {
        $transaction = new Transaction;
        $transaction->no_transaksi = $request['no_transaksi'];
        $transaction->date = $request['date'];
        $transaction->cashier = $request['cashier'];
        if($request['nama_member'] != null) {
            $member = Member::get()->where('no_member', $request['no_member'])->first();
            $bonus_points = floatval(str_replace(',', '', $request['total'])) * 5 / 100;
            $bonus_points = ($bonus_points <= 50000) ? $bonus_points : 50000;   //set max bonus point to 50K
            $points = ($member->points - floatval(str_replace(',', '', $request['total']))) + $bonus_points;
            $member->points = $points;
            $member->save();
            $transaction->id_member = $member->id_member;
        }
        $transaction->bonus_points = isset($bonus_points) ? $bonus_points : 0;
        $transaction->sub_total = floatval(str_replace(',','',$request['sub_total']));
        $transaction->discount = floatval(str_replace(',','',$request['discount']));
        $transaction->total = floatval(str_replace(',','',$request['total']));
        $transaction->bayar =floatval(str_replace(',','', $request['bayar']));
        $transaction->kembalian =floatval(str_replace(',','', $request['kembalian']));
        $transaction->save();
        $id_trx = $transaction['id_transaksi'];
        if(is_array($request['id_inventory']))
        $keys = array('id_inventory', 'qty', 'price', 'discount_item', 'total_item');
        $list_filter = array('qty', 'price', 'discount_item', 'total_item');
        $subdetail = array();
        if(is_array($request['id_inventory']) && !empty($request['id_inventory']))
        {
            for($i = 0; $i < count($request['id_inventory']); $i++) {
                foreach($keys as $key){
                    $value = $request[$key][$i];
                    if(in_array($key, $list_filter))
                        $value = floatval(str_replace(',', '', $request[$key][$i]));
                    $subdetail[$i][$key] = $value;
                }
                $subdetail[$i]['id_transaksi'] = $id_trx;
            }
            unset($subdetail[0]);   //remove template
            if(empty($subdetail))
                return Response::json(array('success' => false, 'message' => 'Cart empty!'), 411);
            foreach($subdetail as $detail)
            {
                $tdetail = new TransactionDetail;
                foreach($detail as $key => $val)
                {
                    $tdetail->$key = $val;
                }
                if($tdetail->save())
                {
                    $data = array(
                        'detail' => $transaction,
                        'subdetail' => $subdetail
                    );
                }

                // update stock
                $checkStock = Stock::get()->where('id_inventory', $detail['id_inventory'])->first();
                $stock = Stock::find($checkStock->id_stock);
                $stock->stock = $checkStock->stock - $detail['qty'];
                $stock->save();
            }
            Counter::updateCount($request['date'], $request['no_transaksi']);
            return Response::json(array('success' => true, 'id' => $id_trx), 200);
        }
    }

    public function print($id)
    {
        $detail = Transaction::find($id);
        if(empty($detail))
            return redirect('/');
        $subdetail = TransactionDetail::getSubdetail($id);
        $member = ($detail->id_member > 0) ? Member::find($detail->id_member)->first() : null;
        $data = array(
            'detail' => $detail,
            'subdetail' => $subdetail,
            'member' => $member,
        );
        return view('transaction/print', $data);
    }
}
