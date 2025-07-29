@extends('layouts.app')

@section('content')
<div class="container">
    <div class="my-account">
        <div class="my-account__breadcrumbs">
            <div class="title">{{ __('Сбросить пароль')}}</div>
        </div>
        <div class="my-account__content my-account__widescreen">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('Эл. адрес') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="my-account__action">
                    <div class="reg-reset">
                        <button id="sendlink" type="submit" class="btn">{{ __('Получить ссылку') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
