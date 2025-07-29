@extends('layouts.app')
@include('sections')
@section('content')
    <div class="hero">
        <div class="hero-image" style="background-image: url({{ url('storage/' . $pageContent['banner']['image']) }});">
            <div class="container">
                <div class="hero-inner">
                    <a href="{{ route('category', ['c' => $catalog->category_id, 'items' => 'all', 'is_discount' => 1]) }}">
                        <button class="btn hero-btn">Sale</button>
                    </a>
                    {{-- @yield('social') --}}
                    <div class="links">
                        <a href="{{ route('home-women') }}">Женщинам</a>
                        <a href="{{ route('home-men') }}">Мужчинам</a>
                    </div>
                    {{-- <div class="links">
                        <a href="{{ route('category', ['c' => 1, 'items' => 'all']) }}">В каталог</a>
                        <a href="{{ route('category', ['c' => 2, 'items' => 'all']) }}">В каталог</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="categories-buttons">
            <div class="categories-buttons__list">
                <a class="btn-link {{ Route::currentRouteName() == 'home-women' ? 'categories-buttons__activeRoute' : 'categories-buttons__inactiveRoute' }}"
                    href="{{ route('home-women') }}">Женщинам</a>
                <a class="btn-link {{ Route::currentRouteName() == 'home-men' ? 'categories-buttons__activeRoute' : 'categories-buttons__inactiveRoute' }}"
                    href="{{ route('home-men') }}">Мужчинам</a>
            </div>
            <div class="categories-buttons__list">
                <a class="btn-link {{ Route::currentRouteName() == 'home-women' ? 'categories-buttons__activeRoute' : 'categories-buttons__inactiveRoute' }}"
                    href="{{ route('category', ['c' => 1, 'items' => 'all']) }}">В каталог</a>
                <a class="btn-link {{ Route::currentRouteName() == 'home-men' ? 'categories-buttons__activeRoute' : 'categories-buttons__inactiveRoute' }}"
                    href="{{ route('category', ['c' => 2, 'items' => 'all']) }}">В каталог</a>
            </div>
        </div>
        <div class="categories-wrapper">
            <div class="categories-card categories-card__temp" style="margin-left: -1rem; margin-right: -1rem">
                @if (Request::path() == 'home-women')
                    <video autoplay muted loop playsinline width="100%" height="100%">
                        <source src="{{ url('storage/' . $pageContent['video']['video']) }}" type="video/mp4">
                    </video>
                @endif
                @if (Request::path() == 'home-men')
                    <video autoplay muted loop playsinline width="100%" height="100%">
                        <source src="{{ url('storage/' . $pageContent['video']['video']) }}" type="video/mp4">
                    </video>
                @endif
            </div>
            <div class="categories-card">
                <a class="card-head" href="{{ route('category', ['c' => $catalog->category_id, 'items' => 'all']) }}">
                    <div class="card-title">Вся коллекция</div>
                    <div class="card-href">Смотреть</div>
                </a>
                <a href="{{ route('category', ['c' => $catalog->category_id, 'items' => 'all']) }}" class="card-link">
                    <img src="{{ url('storage/' . $pageContent['all']['image']) }}" class="card-image">
                </a>
            </div>
            <div class="categories-card categories-card__widescreen">
                <a class="card-head"
                    href="{{ route('category', ['c' => $catalog->category_id, 'items' => 'all', 'is_new' => 1]) }}">
                    <div class="card-title">New</div>
                    <div class="card-href">Смотреть</div>
                </a>
                <a href="{{ route('category', ['c' => $catalog->category_id, 'items' => 'all', 'is_new' => 1]) }}"
                    class="card-link">
                    <img src="{{ url('storage/' . $pageContent['new']['image']) }}" class="card-image">
                </a>
            </div>
            <div class="categories-card categories-card__swiper">
                <new-on-week-component :items="{{ json_encode($newItems) }}"></new-on-week-component>
            </div>
            <div class="categories-card categories-card__mobile">
                <a class="card-head"
                    href="{{ route('category', ['c' => $catalog->category_id, 'items' => 'all', 'is_new' => 1]) }}">
                    <div class="card-title">New</div>
                    <div class="card-href">Смотреть</div>
                </a>
                <a href="{{ route('category', ['c' => $catalog->category_id, 'items' => 'all', 'is_new' => 1]) }}"
                    class="card-link">
                    <img src="{{ url('storage/' . $pageContent['new']['image']) }}" class="card-image">
                </a>
            </div>
            {{-- <div class="categories-card">
            <a class="card-head" href="{{ route('category', ['c' => 2, 'items' => 'all', 'is_new' => 1]) }}">
                <div class="card-title">New мужчинам</div>
                <div class="card-href">Перейти</div>
            </a>
            <a href="{{ route('category', ['c' => 2, 'items' => 'all', 'is_new' => 1]) }}" class="card-link">
                <img src="{{ asset('images/men-new.jpg') }}" class="card-image">
            </a>
        </div> --}}
        </div>
        <div class="categories-card categories-card__swiper">
            <sale-component :items="{{ json_encode($saleItems) }}"></sale-component>
        </div>
        @if (Route::currentRouteName() == 'home-women')
            <div class="categories-card categories-card__blog">
                <home-blog :posts="{{ json_encode($posts) }}"></home-blog>
            </div>
        @endif
        <div class="categories-buttons categories-buttons__bottom">
            @yield('categories-buttons')
        </div>
    </div>
@endsection
