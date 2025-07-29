@include('layouts.header')
@include('layouts.footer')
@include('sections')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Интернет-магазин donato.kz: женская и мужская бредовая одежда, обувь и аксессуары Marella, TrussardiJeans, Pal Zileri. Быстрая доставка. Новое поступление Платья, Верхняя одежда, Деним">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Donato.kz - Online fashion store. Интернет магазин одежды и обуви, верхней одежды</title>

    <!-- Scripts -->
    <script src="{{ mix('/js/manifest.js') }}" defer></script>
    <script src="{{ mix('/js/vendor.js') }}" defer></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <meta name="google-site-verification" content="GbAavx0Ij2usc6GTx4au8RtTI9d0gWc-t3ccroc_l4A" />
</head>

<body>
    <div id="app">
        @yield('header')
        <main class="main {{ $route === 'home-women' || $route === 'home-men' ? 'main-media' : '' }}">
            @yield('content')
        </main>
        @yield('footer')
    </div>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-170463130-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-170463130-1');
    </script>
</body>

</html>
