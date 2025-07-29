<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\OrderController;
use App\Models\Order;
use Illuminate\Http\Request;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class PaymentController extends Controller
{
    public function success(Request $request) {
        $is_test = $request->IsTest;
        $mrh_pass1 = $is_test ? Configuration::get('ROBO_TEST_PASS1') : Configuration::get('ROBO_PAY_PASS1');
        $out_summ = $request->OutSum;
        $inv_id = $request->InvId;
        $crc = strtoupper($request->SignatureValue);
        $my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1"));
        if ($my_crc != $crc) return response()->json('fail');

        $query = Order::where('id', '=', $inv_id);
        $query->update(['is_paid' => 1]);
        $order = $query->first();
        $orderController = new OrderController();
        $orderController->sendNotification($order);

        return view('cart-confirm')->with('order' , $order->order_number);
    }

    public function fail(Request $request) {
        $is_test = $request->IsTest;
        $inv_id = $request->InvId;
        $mrh_pass1 = $is_test ? Configuration::get('ROBO_TEST_PASS1') : Configuration::get('ROBO_PAY_PASS1');
        $order = Order::where('id', '=', $inv_id)->first();
        if ($order->is_paid) return response()->json('fail');
        $out_summ = $order->total;
        $my_crc = strtoupper(md5("DONATOKZ:$out_summ:$inv_id:$mrh_pass1"));
        $robo_string = "https://auth.robokassa.kz/Merchant/Index.aspx?MerchantLogin=DONATOKZ&Culture=ru&Description=Оплата заказа № {$order->order_number} в интернет магазине&Encoding=utf-8&OutSum={$out_summ}&InvId={$inv_id}&SignatureValue={$my_crc}&IsTest={$is_test}";
        $data = array (
            'order_number' => $order->order_number,
            'pass' => $mrh_pass1,
            'isTest' => $is_test,
            'outSum' => $out_summ,
            'robo_string' => $robo_string
        );
        $orderController = new OrderController();
        $orderController->sendNotification($order);
        return view('payment.fail', compact('data'));
    }

    public function robokassa() {
        $is_test = (int) Configuration::get('ROBO_IS_TEST');
        $mrh_pass1 = $is_test ? Configuration::get('ROBO_TEST_PASS1') : Configuration::get('ROBO_PAY_PASS1');
        return array (
            'isTest' => $is_test,
            'pass' => $mrh_pass1,
        );
    }
}
