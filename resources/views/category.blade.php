@extends('layouts.app')
@include('sections')

@section('content')
<div id="category" class="category">
    <div class="container">
        @yield('breadcrumb')
        @yield('dummy-products')
        <category-component :data="{{json_encode($data)}}"></category-component>
        <div class="categories-buttons__bottom">
            @yield("categories-buttons")
        </div>
    </div>
</div>
@endsection
