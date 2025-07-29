@extends('layouts.app')

@section('content')
    <item-component :data="{{json_encode($data)}}"></item-component>
@endsection
