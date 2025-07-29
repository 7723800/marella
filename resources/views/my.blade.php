@extends('layouts.app')

@section('content')

<div id="my-account">
    <my-component :data="{{json_encode($id)}}"></my-component>
</div>

@endsection
