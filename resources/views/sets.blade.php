@extends('layouts.app')
@include('sections')

@section('content')
<div id="sets" class="sets">
    <div class="container">
        @yield('breadcrumb')
        @yield('dummy-products')
        <sets-component :data="{{json_encode($data)}}"></sets-component>
    </div>
</div>
@endsection
