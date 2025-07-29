<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ReturnedProduct;
use Illuminate\Http\Request;

class ReturnedProductController extends Controller
{
    public function store(Request $request)
    {
        ReturnedProduct::create($request->all());
        return response()->json(['success' => 'Спасибо, ваша заявка принята.']);
    }
}
