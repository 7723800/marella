@include('sections')
@section('header')
    <header class="header {{ $route === 'home-women' || $route === 'home-men' ? 'header-media' : '' }}">
        <div class="container height-100">
            <div class="header__contain">
                <div class="left-contain">
                    <div class="mobile-wrapper">
                        <div class="hamburger header-titles">
                            <svg width="24" height="18" viewBox="0 0 24 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0 12.8791H16V10.7325H0V12.8791ZM0 7.51278L8.70146 7.51278V5.36627L0 5.36627V7.51278ZM0 0V2.14651H24V0L0 0Z" />
                                <path d="M24 18H0V15.8535H24V18Z" />
                                <path d="M24 7.51278H10V5.36627H24V7.51278Z" />
                                <path d="M24 12.8791H17.3441V10.7325H24V12.8791Z" />
                            </svg>
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg> --}}
                            <span class="icon-title">Меню</span>
                        </div>
                        <a href="{{ route('search') }}" class="search-icon header-titles">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                                <path d="M0 0h24v24H0z" fill="none" />
                            </svg>
                            <span class="icon-title">Поиск</span>
                        </a>
                    </div>
                    <div class="widescreen-wrapper">
                        <div class="menu-hamburger">
                            <input type="checkbox" />
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <a href="{{ route('login') }}">
                            <div class="login">
                                <svg class="login-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z" />
                                    <path d="M0 0h24v24H0z" fill="none" />
                                </svg>
                                <span class="login-title">
                                    @auth
                                        Привет, {{ Auth::user()->name }}
                                    @endauth

                                    @guest
                                        Войти
                                    @endguest
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <svg id="logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 339.55 29.86" width="160">
                            <g>
                                <path
                                    d="M0,29.86H41.64a8.42,8.42,0,0,0,8.7-8.7V8.7A8.43,8.43,0,0,0,41.64,0H0Zm5-4.94V5H41.64A3.68,3.68,0,0,1,45.39,8.7V21.16a3.68,3.68,0,0,1-3.75,3.76Z" />
                                <path
                                    d="M98.79,0H65.86a8.43,8.43,0,0,0-8.7,8.7V21.16a8.42,8.42,0,0,0,8.7,8.7H98.79a8.42,8.42,0,0,0,8.71-8.7V8.7A8.43,8.43,0,0,0,98.79,0ZM62.11,21.16V8.7A3.68,3.68,0,0,1,65.86,5H98.79a3.68,3.68,0,0,1,3.76,3.75V21.16a3.68,3.68,0,0,1-3.76,3.76H65.86A3.68,3.68,0,0,1,62.11,21.16Z" />
                                <path
                                    d="M159.71,8.7V29.86h4.95V8.7A8.43,8.43,0,0,0,156,0H123a8.43,8.43,0,0,0-8.7,8.7V29.86h5V8.7A3.68,3.68,0,0,1,123,5H156A3.68,3.68,0,0,1,159.71,8.7Z" />
                                <path
                                    d="M216.87,8.7v3.76H176.43V8.7A3.68,3.68,0,0,1,180.18,5h32.93A3.68,3.68,0,0,1,216.87,8.7ZM171.48,29.86h5V17.41h40.44V29.86h4.95V8.7A8.43,8.43,0,0,0,213.11,0H180.18a8.43,8.43,0,0,0-8.7,8.7Z" />
                                <path d="M253,29.86h5V5h24.4V0H228.64V5H253Z" />
                                <path
                                    d="M330.84,0H297.91a8.43,8.43,0,0,0-8.7,8.7V21.16a8.42,8.42,0,0,0,8.7,8.7h32.93a8.42,8.42,0,0,0,8.71-8.7V8.7A8.43,8.43,0,0,0,330.84,0ZM294.16,21.16V8.7A3.68,3.68,0,0,1,297.91,5h32.93A3.68,3.68,0,0,1,334.6,8.7V21.16a3.68,3.68,0,0,1-3.76,3.76H297.91A3.68,3.68,0,0,1,294.16,21.16Z" />
                            </g>
                        </svg>
                    </a>
                </div>
                <div class="right-contain">
                    <a href="{{ route('search') }}" class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                            <path d="M0 0h24v24H0z" fill="none" />
                        </svg>
                        <span class="icon-title">Поиск</span>
                    </a>
                    <wishes-component></wishes-component>
                    <basket-component></basket-component>
                </div>
            </div>
        </div>
        {{-- mobile nav start --}}
        <nav class="nav">
            <div class="sidebar">
                <div class="sidebar-user">
                    <div class="container">
                        <a href="{{ route('login') }}">
                            <div class="login">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    <path d="M0 0h24v24H0z" fill="none" />
                                </svg>
                                <div class="login-title">
                                    @auth
                                        Привет, {{ Auth::user()->name }}
                                    @endauth

                                    @guest
                                        Войти
                                    @endguest
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="container">
                        <div class="sidebar__close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 20">
                                <path
                                    d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                                <path d="M0 0h24v24H0z" fill="none" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    @include('nav')
                </div>
                <div class="call-to-action">
                    <p>Есть вопросы? Звоните!</p>
                    <a href="tel:+77770015373">+7 (777) 001 53 73</a>
                </div>
                <div class="container">
                    @yield('social')
                </div>
            </div>
            {{-- mobile nav end --}}
            {{-- desktop nav start --}}
            <div class="menu-holder">
                <div class="container">
                    <div class="menu-inner">
                        @include('nav')
                    </div>
                </div>
            </div>
            {{-- desktop nav end --}}

            <div class="sidebar-overlay">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 20">
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
                    <path d="M0 0h24v24H0z" fill="none" />
                </svg>
            </div>
        </nav>
    </header>
@endsection
