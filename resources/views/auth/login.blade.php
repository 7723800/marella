@extends("layouts.app")

@section("content")
<div class="container">
    <div class="my-account">
        <div class="my-account__breadcrumbs">
                <div class="title">{{ __("Авторизация")}}</div>
        </div>
        <div class="my-account__content my-account__widescreen">
            <form method="POST" action="{{ route("login") }}">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __("Эл. адрес")}}</label>
                    <input name="email" type="email" class="form-control @error("email") is-invalid @enderror" value="{{ old("email") }}" required autocomplete="email" autofocus >
                </div>
                <div class="form-group">
                    <label for="password">{{ __("Пароль")}}</label>
                    <input id="password" type="password" class="form-control @error("password") is-invalid @enderror" name="password" required autocomplete="current-password">
                </div>
                <div class="form-group">
                    <input  type="checkbox" name="remember" id="remember" style="display:none" checked="checked">
                </div>
                <div class="my-account__action">
                    <div class="login">
                        <button id="login"class="btn">{{ __("Войти") }}</button>
                        <button id="login-success" type="submit" style="display: none"></button>
                    </div>
                    <div class="reg-reset">
                        @if (Route::has("register"))
                            <a class="" href="{{ route("register") }}">{{ __("Регистрация") }}</a>
                        @endif
                        <span>/</span>
                        @if (Route::has("password.request"))
                            <a class="" href="{{ route("password.request") }}">{{ __("Забыли пароль?") }}</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
