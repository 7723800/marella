@extends('layouts.app')
@include('sections')

@section('content')
<div id="office" class="office">
    <div class="container">
        @yield('breadcrumb')
        @yield('dummy-products')
        <office-component :data="{{json_encode($data)}}"></office-component>
    </div>
</div>
@endsection
