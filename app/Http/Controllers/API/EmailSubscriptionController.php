<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SubscribePlaced;
use App\Models\EmailSubscription;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\PromocodeController;

class EmailSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $isEmail = EmailSubscription::where('email', $request->email)->first();
        if ($isEmail) return response()->json(['error' => 'Данный e-mail уже зарегистрирован.']);
        
        EmailSubscription::create($request->all());

        $promocodeController = new PromocodeController();
        $promocode = $promocodeController->getPromocode(3000, $request->email);

        Mail::to($request->email)->send(new SubscribePlaced($promocode));

        return response()->json(['success' => 'Спасибо, промокод отправлен на вашу почту.']);
    }
}
