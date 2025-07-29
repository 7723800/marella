@extends("layouts.app")

@section("content")
<div class="container">
        <div class="my-account">
            <div class="my-account__breadcrumbs">
                    <div class="title">{{ __("Регистрация")}}</div>
            </div>
                <div class="my-account__content my-account__widescreen">
                    <form method="POST" action="{{ route("register") }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __("Имя") }}<span class="form-control-required">*</span></label>
                            <input id="name" type="text" class="form-control @error("name") is-invalid @enderror" name="name" value="{{ old("name") }}" required autocomplete="name" autofocus>
                            @error("name")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="lastname">{{ __("Фамилия") }}<span class="form-control-required">*</span></label>
                            <input id="lastname" type="text" class="form-control @error("lastname") is-invalid @enderror" name="lastname" value="{{ old("lastname") }}" required autocomplete="lastname" autofocus>
                            @error("lastname")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __("Номер телефона") }}<span class="form-control-required">*</span></label>
                            <input id="phone" type="text" class="form-control @error("phone") is-invalid @enderror" name="phone" value="{{ old("phone") }}" required autocomplete="phone" autofocus>
                            @error("phone")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __("Эл. адрес") }}<span class="form-control-required">*</span></label>
                            <input id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email" value="{{ old("email") }}" required autocomplete="email">
                            @error("email")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="city">{{ __("Город") }}<span class="form-control-required">*</span></label>
                            <input id="city" type="text" class="form-control @error("city") is-invalid @enderror" name="city" value="{{ old("city") }}" required autocomplete="city">
                            @error("city")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">{{ __("Адрес") }}<span class="form-control-required">*</span></label>
                            <input id="address" type="text" class="form-control @error("address") is-invalid @enderror" name="address" value="{{ old("address") }}" required autocomplete="address">
                            @error("address")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="area">{{ __("Регион/Область") }}<span class="form-control-required">*</span></label>
                            <input id="area" type="text" class="form-control @error("area") is-invalid @enderror" name="area" value="{{ old("area") }}" required autocomplete="area">
                            @error("area")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __("Пароль") }}<span class="form-control-required">*</span></label>
                            <input id="password" type="password" class="form-control @error("password") is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error("password")
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">{{ __("Подтвердить пароль") }}<span class="form-control-required">*</span></label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="my-account__action">
                            <div class="reg-reset">
                                <button id="register" type="submit" class="btn">{{ __("Зарегистрироваться") }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
