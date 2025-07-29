<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Mail\OrderFormed;
use App\Mail\OrderPlaced;
use App\Models\Promocode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\KaspiQrController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SmsMessageController;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestOrder = Order::orderBy('created_at', 'DESC')->first();
        // $latestOrder = Order::limit(1)->orderBy('id','DESC')->first();
        $order_number = 'DNT-' . str_pad($latestOrder->id + 1, 6, '0', STR_PAD_LEFT);
        $paymentMethods = ['cash' => 'Наличными', 'online' => 'Online оплата', 'kaspiRed' => 'Kaspi Red', 'kaspiQr' => 'Kaspi QR'];
        $order = Order::create([
            'user_id' => $request->user_id,
            'order_number' => $order_number,
            'customer_name' => $request->name,
            'customer_lastname' => $request->lastname,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'customer_city' => $request->city,
            'customer_address' => $request->address,
            'customer_area' => $request->area,
            'customer_comment' => $request->comment,
            'discount' => $request->discount,
            'discount_code' => $request->promocode,
            'delivery_price' => $request->delivery_price,
            'delivery_method' => $request->delivery_method,
            'payment_method' => $paymentMethods[$request->payment_method],
            'total' => $request->total,
            'total_with_discount' => $request->total_with_discount,
        ]);

        if (!$order) {
            return response()->json(['error' => 'Ошибка. Попробуйте позже.']);
        }

        foreach ($request->items as $item) {
            $order->items()->create([
                'order_id' => $order['id'],
                'item_data' => $item,
            ]);
        }

        $email = Configuration::get('MANAGER_EMAIL');

        if ($request->isNotification) {
            return $this->sendNotification($order);
        } else if ($request->payment_method == 'kaspiQr') {
            try {
                $kaspiQrController = new KaspiQrController();
                $data = $kaspiQrController->createLink($order->order_number, $request->total);
                $order->update([
                    "kaspi_payment_id" => $data->paymentId
                ]);

                Mail::to($email)->send(new OrderFormed($order));
                return response()->json(['kaspi' => $data]);
            } catch (\Throwable $th) {
                report($th);
                return response()->json(['error' => 'Ошибка оплаты. Попробуйте позже.']);
            }
        } else {
            Mail::to($email)->send(new OrderFormed($order));
            return response()->json(['order' => $order->order_number]);
        }
    }

    /**
     * Send notification after order placed.
     *
     * @param  Order  $order
     * @return @return \Illuminate\Http\Response
     */
    public function sendNotification($order)
    {
        $customerMsg = "Заказ № {$order->order_number} успешно оформлен. Ваш donato.kz";
        // $managerMsg = "Оформили заказ № {$order->order_number}. ({$order->created_at})";
        $emails = array($order->customer_email, Configuration::get('MANAGER_EMAIL'));
        Mail::to($emails)->send(new OrderPlaced($order));
        SmsMessageController::send($order->customer_phone, $customerMsg); // send sms to customer
        // SmsMessageController::send(Configuration::get('MANAGER_PHONE'), $managerMsg); // send sms to manager
        if ($order->discount_code) Promocode::where('number', $order->discount_code)->update(['is_valid' => 0]);
        return response()->json(['order' => $order->order_number]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
