@extends('site.layouts.base')
@section('title','Kullanıcı Kayıt')

@section('content')
    @include('site.layouts.partials.messages')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Kullanıcı Kayıt</li>
            </ol>
        </div><!-- End .container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <ul class="checkout-steps">
                    <li>
                        <h2 class="step-title">Kullanıcı Kayıt</h2>

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('user.register') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group required-field col-md-6">
                                    <label>Adınız </label>
                                    <div class="form-control-tooltip">
                                        <input id="name" type="text" class="form-control" name="name"
                                               value="{{ old('name') }}"
                                               required=""
                                               autofocus="">
                                        @if($errors -> has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors ->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div><!-- End .form-control-tooltip -->
                                </div><!-- End .form-group -->
                                <div class="form-group required-field col-md-6">
                                    <label>Soyadınız </label>
                                    <div class="form-control-tooltip">
                                        <input id="surname" type="text" class="form-control" name="surname"
                                               value="{{ old('surname') }}"
                                               required=""
                                               autofocus="">
                                        @if($errors -> has('surname'))
                                            <span class="help-block">
                                        <strong>{{ $errors ->first('surname') }}</strong>
                                    </span>
                                        @endif
                                    </div><!-- End .form-control-tooltip -->
                                </div><!-- End .form-group --></div>

                            <div class="form-group required-field">
                                <label>Email</label>
                                <div class="form-control-tooltip">
                                    <input id="email" type="text" class="form-control" name="email"
                                           value="{{ old('email') }}"
                                           required=""
                                           autofocus="">
                                    @if($errors -> has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors ->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div><!-- End .form-control-tooltip -->
                            </div><!-- End .form-group -->
                            <div class="form-group required-field">
                                <label>Parola </label>
                                <input id="password" type="password" class="form-control" name="password"
                                       required="">
                            </div>
                            <div class="form-group required-field">
                                <label>Parola Tekrar </label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"
                                       required="">
                            </div><!-- End .form-group -->
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary">Kaydol</button>
                                {{--<a class="btn btn-link help-block" href="/redirect/facebook"><i class="fa fa-facebook" style="font-size: 20px"></i> ile bağlan</a>--}}
                                <a class="btn btn-link help-block" href="/redirect/google"><i class="icon-gplus" style="font-size: 20px"></i> ile bağlan</a>
                            </div>
                            <p>Mevcut bir hesabınız varsa <a href="{{route('user.login')}}">giriş</a> yapabilirsiniz.</p>
                        </form>

                    </li>
                </ul>
            </div><!-- End .col-lg-8 -->
            <div class="col-lg-4">
                @include('site.sepet.partials.summaryCard')
            </div><!-- End .col-lg-4 -->
        </div>
    </div>


@endsection
