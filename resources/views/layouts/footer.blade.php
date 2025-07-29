@section("footer")
@include("sections")
<footer class="footer">
    {{-- <subscribe-component></subscribe-component> --}}
    <div class="footer-content">
        <div class="container">
            <div class="footer-info footer-info__security">
                <img class="visa"src="/images/visa.svg">
                <img src="/images/mc.svg">
            </div>
            <div class="footer-info footer-info__apps">
                <img src="/images/app_store.svg">
                <img src="/images/google_play.svg">
            </div>
            <div class="footer-info footer-info__vendor">
                <span>© {{ now()->year }}</span>
                @yield('social')
                <span>Donato</span>
            </div>
        </div>
    </div>
    <div class="message-snackbar">
        <div class="message-text"></div>
    </div>
</footer>
@endsection
