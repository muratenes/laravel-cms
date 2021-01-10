@extends('site.layouts.base')
@section('title','İletişim')
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">İletişim</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        @include('site.layouts.partials.messages')
        <div class="mb-3"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('iletisim.sendMail') }}" method="post">
                        @csrf
                        <div class="form-group required-field">
                            <label for="contact-name">Tam Adınız</label>
                            <input type="text" class="form-control" id="contact-name" name="name" required="">
                        </div><!-- End .form-group -->

                        <div class="form-group required-field">
                            <label for="contact-email">Email</label>
                            <input type="email" class="form-control" id="contact-email" name="email" required="">
                        </div><!-- End .form-group -->

                        <div class="form-group">
                            <label for="contact-phone">Telefon numarası</label>
                            <input type="tel" class="form-control" id="contact-phone" name="phone">
                        </div><!-- End .form-group -->

                        <div class="form-group required-field">
                            <label for="contact-message">Mesaj</label>
                            <textarea cols="30" rows="1" class="form-control" name="message" required=""></textarea>
                        </div><!-- End .form-group -->

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">Gönder</button>
                        </div><!-- End .form-footer -->
                    </form>
                </div><!-- End .col-md-8 -->

                <div class="col-md-4">
                    <h2 class="light-title">İletişim <strong>Bilgileri</strong></h2>

                    <div class="contact-info">
                        <div>
                            <i class="icon-phone"></i>
                            <p><a href="tel:">{{$site->phone }}</a></p>
                        </div>
                        <div>
                            <i class="icon-mail-alt"></i>
                            <p><a href="mailto:#">{{ $site->mail }}</a></p>
                            <p><a href="mailto:#">{{ $site->mail2 }}</a></p>
                        </div>
                        <div>
                            <i class="icon-phone"></i>
                            <p><a href="https://wa.me/{{$site->phone}}/?text=merhaba {{$site->title}}'dan yazıyorum">Whatsapp</a></p>
                            <p><a href="https://wa.me/{{$site->phone}}/?text=merhaba {{$site->title}}'dan yazıyorum">{{$site->phone}}</a></p>
                        </div>
                    </div><!-- End .contact-info -->
                </div><!-- End .col-md-4 -->
            </div>
        </div>
    </div>
@endsection
