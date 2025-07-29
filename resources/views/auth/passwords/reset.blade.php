@extends('layouts.app')

@section('content')
<div class="container">
        <div class="container">
                <div class="my-account">
                    <div class="my-account__breadcrumbs">
                            <div class="title">{{ __("Сброс парля")}}</div>
                    </div>
                        <div class="my-account__content my-account__widescreen">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group">
                                    <label for="email">{{ __("Эл. адрес") }}</label>
                                    <input id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error("email")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ __("Пароль") }}</label>
                                    <input id="password" type="password" class="form-control @error("password") is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error("password")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">{{ __("Подтвердить пароль") }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="my-account__action">
                                    <div class="reg-reset">
                                        <button id="register" type="submit" class="btn">{{ __("Сбросить пароль") }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
