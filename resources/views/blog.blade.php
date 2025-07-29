@extends('layouts.app')
@include('sections')

@section('content')
<div class="blog">
    <div class="container">
        @yield('breadcrumb')
        <div class="blogHolder">
            @foreach ($data['blogs'] as $blog)
            <div id="post{{$blog->id}}" class="blogBlock">
                <div class="blogBlock-date">{{ $blog->created_at->format('d/m/Y') }}</div>
                <div class="blogBlock-image">
                    <img src="{{ config('app.url'). '/storage/' .$blog->image }}" alt="{{ $blog->title }}">
                </div>
                <h2>{{ $blog->title }}</h2>
                <div class="blogBlock-text">{!! $blog->text !!}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
