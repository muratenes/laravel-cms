<footer class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="footer-ribbon">
                İletişimde Kal
            </div><!-- End .footer-ribbon -->
            <div class="row">
                <div class="col-lg-3">
                    <div class="widget">
                        <h4 class="widget-title">Iletisim</h4>
                        <ul class="contact-info">
                            <li>
                                <span class="contact-info-label">Adres:</span>{{$site->adres}}
                            </li>
                            <li>
                                <span class="contact-info-label">İletişim:</span><a href="tel:">{{$site->phone}}</a>
                            </li>
                            <li>
                                <span class="contact-info-label">Email:</span> <a href="mailto:mail@example.com">{{$site->email}}</a>
                            </li>
                            <li>
                                <span class="contact-info-label">Çalışma Gün/Saatleri:</span>
                                Pazartesi - Pazar / 9:00 - 22:00
                            </li>
                        </ul>
                        <div class="social-icons">
                            <a href="{{ $site->facebook }}" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                            <a href="{{ $site->twitter }}" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                            <a href="{{ $site->instagram}}" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
                        </div><!-- End .social-icons -->
                    </div><!-- End .widget -->
                </div><!-- End .col-lg-3 -->

                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="widget">
                                <h4 class="widget-title">Hesabım</h4>

                                <div class="row">
                                    <div class="col-sm-6 col-md-5">
                                        <ul class="links">
                                            <li><a href="{{route('user.login')}}">Giriş</a></li>
                                            <li><a href="{{route('user.orders')}}">Siparislerim</a></li>
                                            <li><a href="{{route('user.addresses')}}">Adreslerim</a></li>
                                            <li><a href="{{ route('basket') }}">Sepet</a></li>
                                            <li><a href="{{ auth()->check() ? route('user.favorites') : route('favoriler.anonimList') }}">Favorilerim</a></li>
                                            <li><a href="{{route('user.detail')}}">Hesabım</a></li>
                                        </ul>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-md-5 -->
                    </div><!-- End .row -->
                </div><!-- End .col-lg-9 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .footer-middle -->

    <div class="container">
        <div class="footer-bottom">
            <p class="footer-copyright">{{$site->title}}. &copy; {{date('Y')}}. Tüm hakları saklıdır</p>

            <img src="/site/assets/images/payments.png" alt="payment methods" class="footer-payments">
        </div><!-- End .footer-bottom -->
    </div><!-- End .container -->
</footer><!-- End .footer -->
