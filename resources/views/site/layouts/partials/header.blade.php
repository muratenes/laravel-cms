<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left header-dropdowns">

            </div><!-- End .header-left -->

            <div class="header-right">
                <p class="welcome-msg">Modayı Pixelledik! </p>

                <div class="header-dropdown dropdown-expanded">
                    <a href="#">Hızlı Linkler</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="{{route('user.dashboard')}}">Hesabım</a></li>
                            <li><a href="{{route('user.orders')}}">Siparislerim</a></li>
                            <li><a href="{{route('user.favorites')}}">Favorilerim </a></li>
                            <li><a href="{{route('sss')}}">Sık Sorulan Sorular </a></li>
                            {{--                            <li><a href="blog.html">Blog</a></li>--}}
                            <li><a href="{{ route('iletisim') }}">Iletisim</a></li>
                            <li>
                                <a href="{{ route('home.setLocale','en') }}">English</a>
                                <a href="{{ route('home.setLocale','tr') }}">Turkish</a>
                                <a href="{{ route('home.setLocale','de') }}">Germany</a>
                            </li>
                            @auth
                                <li><a href="#" onclick="event.preventDefault();document.getElementById('logout_form').submit()">Çıkış</a></li>
                                <form id="logout_form" action="{{ route('user.logout') }}" method="POST" style="display: none">
                                    {{ csrf_field() }}
                                </form>
                            @else
                                <li><a href="{{ route('favoriler.anonimList') }}">Favorilerim</a></li>
                                <li><a href="{{ route('user.login') }}">Oturum Aç</a></li>
                                <li><a href="{{ route('user.register') }}">Kaydol</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <a href="{{route('homeView')}}" class="logo">
                    <img src="/{{ config('constants.image_paths.config_image_folder_path'). $site->logo}}" alt="{{ $site->title }}" width="100" height="100">
                </a>
            </div><!-- End .header-left -->

            <div class="header-center">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                    <form action="{{route('searchView')}}" method="get">
                        <div class="header-search-wrapper">
                            <input type="search" class="form-control" name="q" id="q" placeholder="Ürün Adı,Kategori..." required value="{{old('q')}}">
                            <div class="select-custom">
                                <select id="cat" name="cat">
                                    <option value="">Tüm Kategoriler</option>
                                    @foreach($cacheCategories as $cat)
                                        <option value="{{$cat->id}}" {{ old('cat') == $cat->id ? 'selected' : '' }}>{{$cat->title_lang}}</option>
                                        @foreach($cat->sub_categories as $sub)
                                            <option value="{{$sub->id}}" {{ old('cat') == $sub->id ? 'selected' : '' }}> &nbsp;-{{$sub->title_lang}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div><!-- End .select-custom -->
                            <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div><!-- End .headeer-center -->

            <div class="header-right">
                <button class="mobile-menu-toggler" type="button">
                    <i class="icon-menu"></i>
                </button>
                <div class="header-contact">
                    <span>Şimdi iletişime Geç</span>
                    <a href="tel:{{$site->phone}}"><strong>{{$site->phone}}</strong></a>
                </div><!-- End .header-contact -->

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" id="openShoppingCart" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <span class="cart-count">{{ Cart::getContent()->count() }}</span>
                    </a>

                    <div class="dropdown-menu">
                        <div class="dropdownmenu-wrapper">
                            <div class="dropdown-cart-header">
                                <span class="cart-count">{{ Cart::getContent()->count() }}</span> &nbsp;ürün

                                <a href="{{route('basket')}}">Sepete git</a>
                            </div><!-- End .dropdown-cart-header -->
                            <div class="dropdown-cart-products" id="basketContainer">
                                @foreach(cartItems() as $item)
                                    <div class="product">
                                        <div class="product-details">
                                            <h4 class="product-title">
                                                <a href="#">{{$item->name}}</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                    <span class="cart-product-qty">{{$item->quantity}} | ({{ $item->id }})</span>
                                                    x <span class="cart-product-price">{{ $item->price }} {{ currentCurrencySymbol() }}</span><br>
                                                <span class="small">{{$item->attributes['attributes_text_lang']}}</span>
                                                </span>
                                        </div><!-- End .product-details -->

                                        <figure class="product-image-container">
                                            <a href="#" class="product-image">
                                                <img width="80" height="80" src="{{imageUrl('public/products',$item->attributes['product']['image'])}}"
                                                     alt="{{$item->title}}">
                                            </a>
                                            <a href="#" class="btn-remove" title="Ürünü kaldır" onclick="return removeBasketItem(this)" data-value="{{$item->id}}"><i
                                                    class="icon-cancel" data-value="{{$item->id}}"></i></a>
                                        </figure>
                                    </div><!-- End .product -->
                                @endforeach
                            </div><!-- End .cart-product -->

                            <div class="dropdown-cart-total">
                                <span>Toplam</span>

                                <span class="cart-total-price">{{Cart::getSubTotal()}} </span> &nbsp; {{ currentCurrencySymbol() }}
                            </div><!-- End .dropdown-cart-total -->

                            <div class="dropdown-cart-action  {{ Cart::getContent()->count() > 0 ? '' : 'd-lg-none' }}">
                                <a href="{{route('odemeView')}}" class="btn btn-block ">Ödeme</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom sticky-header">
        <div class="container">
            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    <li class="active"><a href="{{ route('homeView') }}">{{ __('lang.home') }}</a></li>
                    @if (isset($menus))
                        @foreach($menus as $menu)
                            <li class="megamenu-container">
                                <a href="">{{ $menu->lang['title'] }}</a>
                                @if (count($menu->children))
                                    <div class="megamenu">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <ul>
                                                        @foreach($menu->children as $child)
                                                            <li><a href="{{ $child->href }}">{{ $child->lang['title'] }} |</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    @endif
                    @foreach($cacheCategories as $index=>$cat)
                        <li class="megamenu-container">
                            <a href="{{ route('category.detail',$cat->slug) }}" class="{{ count($cat->sub_categories)>0 ? 'sf-with-ul' : '' }}">{{ $cat->title_lang }}</a>
                            @if(count($cat->sub_categories) > 0)
                                <div class="megamenu">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                @foreach($cat->sub_categories as $sub)
                                                    <div class="col-lg-4">
                                                        <div class="menu-title">
                                                            <a href="{{ route('category.detail',$sub->slug) }}">{{ $sub->title_lang }}</a>
                                                        </div>
                                                        <ul>
                                                            @foreach($sub->sub_categories as $sub2)
                                                                <li><a href="{{ route('category.detail',$sub2->slug) }}">{{ $sub2->title_lang }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach

                                            </div><!-- End .row -->
                                        </div><!-- End .col-lg-8 -->
                                    </div><!-- End .row -->
                                </div>
                            @endif
                        </li>
                    @endforeach
                    <li class="float-right"><a href="{{ route('campaigns.list') }}">Kampanyalar</a></li>
                </ul>
            </nav>
        </div><!-- End .header-bottom -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->

