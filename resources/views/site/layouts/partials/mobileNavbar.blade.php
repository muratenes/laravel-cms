<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
        <nav class="mobile-nav">
            <ul class="mobile-menu">
                <li class="active"><a href="{{ route('homeView') }}">Anasayfa</a></li>
                @foreach($cacheCategories as $index=>$cat)

                    <li>
                        <a href="{{ route('categoryDetail',$cat->slug) }}">{{ $cat->title }}</a>
                        @if(count($cat->sub_categories) > 0)
                            <ul>
                                @foreach($cat->sub_categories as $sub)
                                    <li>
                                        <a href="{{ route('categoryDetail',$sub->slug) }}">{{ $sub->title }}</a>
                                        @if(count($sub->sub_categories) > 0)
                                            <ul>
                                                @foreach($sub->sub_categories as $sub2)
                                                    <li><a href="{{ route('categoryDetail',$sub2->slug) }}">{{ $sub2->title }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                <li><a href="{{ route('iletisim') }}">İletişim</a></li>
            </ul>
        </nav>

        <div class="social-icons">
            <a href="{{ $site->facebook }}" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
            <a href="{{ $site->twitter }}" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
            <a href="{{ $site->instagram }}" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->
