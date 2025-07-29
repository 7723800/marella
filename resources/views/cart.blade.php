@extends('layouts.app')

@section('content')

<div id="cart">
    <cart-component :data="{{json_encode($data)}}"></cart-component>
</div>

@endsection
