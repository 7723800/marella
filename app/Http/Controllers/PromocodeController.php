<?php

namespace App\Http\Controllers;

use RandomLib\Factory;
use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function getPromocode($value, $info = null) {
        $code = $this->generatePromocode();
        $promocode = new Promocode();
        $promocode->number = $code;
        $promocode->value = $value;
        $promocode->data = $info;
        $promocode->save();
        return $promocode;
    }

    public function generatePromocode()
    {
        $latest = 0;
        $isLatest = Promocode::orderBy('created_at','DESC')->first();
        if ($isLatest) $latest = $isLatest->id;
        $currentID = $latest + 1;
        $factory = new Factory;
        $generator = $factory->getMediumStrengthGenerator();
        $code = $generator->generateString(8, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        return $code .'-'. $currentID;
    }

    public function check(Request $request)
    {
        $promocode = Promocode::where('number', trim($request->promocode))->first();
        if (!$promocode) return response()->json(['error' => 'Данный промокод не существует.']);
        if (!$promocode->is_valid) return response()->json(['error' => 'Данный промокод уже был использован.']);
        return response()->json(['success' => 'Данный промокод активирован.', 'promocode' => $promocode]);
    }
}
