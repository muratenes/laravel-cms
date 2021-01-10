@extends('site.layouts.base')
@section('title','Kullanıcı Detay')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Kullanıcı Bilgilerim</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        @include('site.layouts.partials.messages')
        <div class="row">
            <div class="col-lg-3">
                @include('site.kullanici.partials.myAccountLeftSidebar')
            </div>
            <div class="col-lg-9 order-lg-last dashboard-content">
                <h2>Hesap Bilgilerini Düzenle</h2>

                <form action="{{ route('user.detail') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-11">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group required-field">
                                        <label for="acc-name">Adınız</label>
                                        <input type="text" class="form-control" name="name" required="" value="{{$user->name}}">
                                    </div><!-- End .form-group -->
                                </div><!-- End .col-md-4 -->

                                <div class="col-md-4">
                                    <div class="form-group required-field">
                                        <label for="acc-mname">Soyadınız</label>
                                        <input type="text" class="form-control" name="surname" required value="{{$user->surname}}">
                                    </div><!-- End .form-group -->
                                </div><!-- End .col-md-4 -->
                            </div><!-- End .row -->
                        </div><!-- End .col-sm-11 -->
                    </div><!-- End .row -->

                    <div class="form-group required-field">
                        <label for="acc-email">Email</label>
                        <input type="email" class="form-control" disabled value="{{$user->email}}">
                    </div><!-- End .form-group -->


                    <div class="mb-2"></div><!-- margin -->

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="change-pass-checkbox" name="changePasswordCheckbox">
                        <label class="custom-control-label" for="change-pass-checkbox">Parola Değiştir</label>
                    </div><!-- End .custom-checkbox -->

                    <div id="account-chage-pass" class="">
                        <h3 class="mb-2">Parola Değiştir</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group required-field">
                                    <label for="acc-pass2">Parola</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div><!-- End .form-group -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="form-group required-field">
                                    <label for="acc-pass3">Parola Tekrar</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirm">
                                </div><!-- End .form-group -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End #account-chage-pass -->

                    <div class="required text-right">* Gerekli Alanlar</div>
                    <div class="form-footer">
                        <a href="1"><i class="icon-angle-double-left"></i>Geri</a>

                        <div class="form-footer-right">
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </div>
                    </div><!-- End .form-footer -->
                </form>
            </div>
        </div><!-- End .row -->
    </div>
@endsection
@section('footer')
    <script>
        $("#change-pass-checkbox").click(function () {
            console.log(this);
            if ($(this).prop('checked')) {
                $("#password,#password_confirm").attr('required', 'true')
            } else {
                $("#password,#password_confirm").removeAttr('required')
            }
        })
    </script>
@endsection
