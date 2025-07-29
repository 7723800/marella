@extends("layouts.app")

@section("content")
<div class="container">
    <div class="my-account-verify">
        <div class="my-account__breadcrumbs">
            <div class="title">Аутентификация</div>
        </div>
        <div class="my-account__content-verify">
            <img class="mail-auth-img" src="/images/mail-auth.svg" alt="">
            <div class="verify-body">
                @if (session("resent"))
                    <div class="alert-success">Новое письмо со ссылкой подтверждения отправлено!</div>
                @endif
                    <p>Прежде чем войти в аккаунт, поищите письмо со ссылкой подтверждения, отправленное на почту</p>
                    <p>Нет в папке Входящие или в спаме?</p>
                    <a href="{{ route("verification.resend") }}">
                        <button id="resend" class="btn">Отправить снова</button>
                    </a>
            </div>

        </div>
    </div>
</div>
@endsection
