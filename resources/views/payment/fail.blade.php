@extends('layouts.app')

@section('content')
    <div class="payment-failed">
        <div class="container">
            <div class="payment-inner">
                <svg class="icon-failed" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><path d="M0 0h24v24H0z" fill="none"/><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                <div class="error-msg">ОШИБКА</div>
                <p class="error-text">Платеж не был совершен! Произошла техническая ошибка при обработке платежа.</p>
                <p>Номер вашего заказа № {{ $data['order_number'] }}</p>
                <p>Попробуйте ещё раз</p>
                <a href="{{ $data['robo_string'] }}" class="retry">
                    <button class="btn">Повторить платеж</button>
                </a>
            </div>
        </div>
        <order-confirm-component></order-confirm-component>
    </div>
@endsection
