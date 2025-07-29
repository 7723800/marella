<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inani\LaravelNovaConfiguration\Helpers\Configuration;

class CartController extends Controller
{
    public function index()
    {
        $id = Auth::user() ? Auth::user()->id : null;
        $data = array(
            'id' => $id,
            'delivery' => (object) array(
                'pickup' => 0,
                'max' => (int) Configuration::get('DELIVERY_PRICE'),
                'courier' => (int) Configuration::get('DELIVERY_TAX'),
                'tryon' => (int) Configuration::get('DELIVERY_TAX'),
                'qazaqstan' => (int) Configuration::get('DELIVERY_QAZAQSTAN'),
                'russia' => (int) Configuration::get('DELIVERY_RUSSIA'),
                'express' => (int) Configuration::get('DELIVERY_EXPRESS'),
                'promocode' => (int) Configuration::get('PROMOCODE_MIN_SUM'),
            )
        );
        return view('cart', compact('data'));
    }

    public function confirm(Request $request)
    {
        return view('cart-confirm')->with('order', $request->order);
    }
}
