@extends('layouts.app')

@section('content')
<div id="search">
    <search-component :data="{{json_encode($data)}}"></search-component>
</div>

@endsection
