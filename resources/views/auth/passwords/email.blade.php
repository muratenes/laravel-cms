@extends('site.layouts.base')

@section('content')
    @include('site.layouts.partials.messages')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="#">Hesabım</a></li>
                <li class="breadcrumb-item active" aria-current="page">Parola Sıfırla</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        <div class="heading mb-4">
            <h2 class="title">Parola Sıfırla</h2>
            <p>Parola sıfırlama isteği almak için aşağıdaki kutucuğa mail adresini giriniz. <br> Eğer mail sistemde kayıtlı ise size parola sıfırlama linki göndereceğiz</p>
        </div><!-- End .heading -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" aria-label="Parola Sıfırla">
            @csrf
            <div class="form-group required-field">
                <label for="reset-email">Email</label>
{{--                <input type="email" class="form-control" id="reset-email" name="reset-email" required="">--}}
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="mail@example.com"
                       value="{{ old('email') }}"
                       required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
            </div><!-- End .form-group -->

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">Parolamı Sıfırla</button>
            </div><!-- End .form-footer -->
        </form>
    </div>
@endsection
