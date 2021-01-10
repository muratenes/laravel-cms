@extends('site.layouts.base')
@section('title','Kullanıcı Giriş')

@section('content')
    @include('site.layouts.partials.messages')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Kullanıcı Giriş</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <ul class="checkout-steps">
                    <li>
                        <h2 class="step-title">Kullanıcı Giriş</h2>

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('user.login') }}">
                            {{ csrf_field() }}
                            <div class="form-group required-field">
                                <label>Email Adresi </label>
                                <div class="form-control-tooltip">
                                    <input type="email" class="form-control" required="" name="email" value="{{ config('app.debug') ? config('admin.username') : '' }}">
                                    <span class="input-tooltip" data-toggle="tooltip" title="" data-placement="right"
                                          data-original-title="We'll send your order confirmation here."><i class="icon-question-circle"></i></span>
                                </div><!-- End .form-control-tooltip -->
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label>Parola </label>
                                <input type="password" class="form-control" required="" name="password" value="{{ config('app.debug') ? config('admin.password') : '' }}">
                            </div><!-- End .form-group -->
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="rememberme" checked=""> Beni hatırla
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary">Giriş</button>
                                <a href="{{route('password.reset',null)}}" class="forget-pass"> Parolamı Unuttum?</a>
                                <a class="btn btn-link help-block" href="/redirect/google"><i class="icon-gplus" style="font-size: 20px"></i> ile bağlan</a>
                            </div><!-- End .form-footer -->
                            <p>Mevcut bir hesabınız yoksa <a href="{{route('user.register')}}">kaydolabilir</a> veya misafir olarak devam edebilirsin.</p>
                        </form>

                    </li>
                </ul>
            </div><!-- End .col-lg-8 -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h3>Sepet</h3>

                    <h4>
                        <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button" aria-expanded="false"
                           aria-controls="order-cart-section">Sepette {{ Cart::getContent()->count() }} ürün var</a>
                    </h4>

                    <div class="collapse" id="order-cart-section">
                        <table class="table table-mini-cart">
                            <tbody>
                            @foreach(Cart::getContent() as $item)
                                <tr>
                                    <td class="product-col">
                                        <figure class="product-image-container">
                                            <a href="product.html" class="product-image">
                                                <img src="{{config('constants.image_paths.product_image_folder_path').$item->attributes['product']['image']}}" alt="product">
                                            </a>
                                        </figure>
                                        <div>
                                            <h2 class="product-title">
                                                <a href="product.html">{{$item->name}}</a>
                                            </h2>

                                            <span class="product-qty">Adet: {{ $item->quantity }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- End #order-cart-section -->
                </div><!-- End .order-summary -->
            </div><!-- End .col-lg-4 -->
        </div>
    </div>
@endsection


