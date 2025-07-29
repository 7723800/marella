@extends('layouts.app')

@section('content')

<div class="cart-confirm">
    <div class="container">
        <div class="cart-confirm-pocket">
            <img src="/images/order-pocket.png">
        </div>
        <div class="cart-confirm-message">
            <h2>Спасибо</h2>
            <h3>Ваш заказ успешно оформлен!</h3>
            <p>Номер заказа <b>{{ $order }}</b></p>
            <p>Наш менеджер свяжется с Вами для уточнения деталей и доставки заказа.</p>
            <h3>Благодарим, что выбрали нас!</h3>
        </div>
        <div class="call-to-action">
            <p>Есть вопросы? Звоните!</p>
            <a href="tel:+77770015373">+7 (777) 001 53 73</a>
        </div>
        <div class="cart-confirm-action">
            <a href="{{ route('home') }}">
                <button class="btn">Вернуться в каталог</button>
            </a>
        </div>
    </div>
    <order-confirm-component></order-confirm-component>
</div>

@endsection
