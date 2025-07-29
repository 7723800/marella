@extends('layouts.app')
@include('sections')

@section('content')
<div id="giftcard" class="giftcard">
    <div class="container">
        @yield('breadcrumb')
        @yield('dummy-products')
        <giftcard-component :data="{{json_encode($data)}}"></giftcard-component>
    </div>
</div>
@endsection
