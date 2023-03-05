@extends('site.layouts.base')
@section('title','Hesabım')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Hesabım</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        @include('site.layouts.partials.messages')
        <div class="row">
            <div class="col-lg-3">
                @include('site.user.partials.myAccountLeftSidebar')
            </div>
            <div class="col-lg-9 order-lg-last dashboard-content">
                <h2>Hesap Bilgileri</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                İletişim Bilgileri
                                <a href="{{route('user.detail')}}" class="card-edit">Düzenle</a>
                            </div><!-- End .card-header -->

                            <div class="card-body">
                                <p>
                                    {{$user->full_name}}<br>
                                    {{$user->email}}<br>
                                    <a href="{{route('user.detail')}}">Parola Değiştir</a>
                                </p>
                            </div><!-- End .card-body -->
                        </div><!-- End .card -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                E-BÜLTEN
                                <a href="#" class="card-edit">Edit</a>
                            </div><!-- End .card-header -->

                            <div class="card-body">
                                <p>
                                    Şu anda herhangi bir bültene abone değilsiniz.Kampanyalardan ve özel indirimlerden haberdar olmak için e-bültene kayıt olabilirsiniz
                                </p>
                            </div><!-- End .card-body -->
                        </div><!-- End .card -->
                    </div><!-- End .col-md-6 -->
                </div>
                <div class="card">
                    <div class="card-header">
                        Adres Bilgileri
                        <a href="{{ route('user.addresses') }}" class="card-edit">Düzenle</a>
                    </div><!-- End .card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="">Varsayılan Teslimat Adresi</h4>
                                <address>
                                    @if(is_null($user->default_address))
                                        Henüz varsayılan bir adresiniz yok. <a href="{{  route('user.addresses')}}?type=1">Yeni ekle</a>
                                    @else
                                        <b>{{ $user->default_address->title }}</b> varsayılan adres olarak ayarlandı <br>
                                        <a href="{{ route('user.addresses') }}?type=1">Adresi Düzenle</a>
                                    @endif<br>

                                </address>
                            </div>
                            <div class="col-md-6">
                                <h4 class="">Varsayılan Fatura Adresi</h4>
                                <address>
                                    @if(is_null($user->default_invoice_address))
                                        Henüz varsayılan bir  fatura  adresiniz yok. <a href="{{  route('user.addresses')}}?type=2">Yeni ekle</a>
                                    @else
                                        <b>{{ $user->default_invoice_address->title }}</b> varsayılan fatura adres olarak ayarlandı <br>
                                        <a href="{{ route('user.addresses') }}?type=2">Adresi Düzenle</a>
                                    @endif<br>
                                </address>
                            </div>
                        </div>
                    </div><!-- End .card-body -->
                </div>

            </div>
        </div><!-- End .row -->
    </div>
@endsection
