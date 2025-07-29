@extends('layouts.app')
@include('sections')

@section('content')
<div id="perfume" class="perfume">
    <div class="container">
        @yield('breadcrumb')
        @yield('dummy-products')
        <perfume-component :data="{{json_encode($data)}}"></perfume-component>
    </div>
</div>
@endsection
