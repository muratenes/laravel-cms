@extends('site.layouts.base')
@section('title','Sepetim')
@section('header')
    <style>
        .DivToScroll {
            background-color: #F5F5F5;
            border: 1px solid #DDDDDD;
            border-radius: 4px 0 4px 0;
            color: #3B3C3E;
            font-size: 12px;
            font-weight: bold;
            left: -1px;
            padding: 10px 7px 5px;
        }

        .DivWithScroll {
            height: 250px;
            overflow: scroll;
            overflow-x: hidden;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Ödeme</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        <ul class="checkout-progress-bar">
            <li>
                <span>Adres Bilgileri</span>
            </li>
            <li class="active">
                <span>Ödeme</span>
            </li>
        </ul>
        @include('site.layouts.partials.messages')
        <div class="row">
            <div class="col-lg-5">
                @include('site.sepet.partials.summaryCard')

                <div class="checkout-info-box" style="display: none" id="taksitContainer">
                    <label for="installemnt">Taksit Bilgileri <span class="spBankName"> -</span></label>
                    <table class="table" id="iyzico_installment">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Taksit Tutarı</th>
                            <th scope="col">Taksit Sayısı</th>
                            <th scope="col">Toplam Tutar</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="checkout-info-box ">
                    <h3 class="step-title">Teslimat Adresi:
                        <a href="{{route('odeme.adres')}}" title="Düzenle" class="step-title-edit"><span class="sr-only">Düzenle</span><i class="icon-pencil"></i></a>
                    </h3>

                    <address>
                        {{$address->title}} <br>
                        {{$address->adres}} <br>
                        {{$address->state->title}} - {{$address->district->title}} <br>
                        +90{{$address->phone}}
                    </address>
                </div>
                @if($defaultInvoiceAddress)
                    <div class="checkout-info-box ">
                        <h3 class="step-title">Fatura Adresi:
                            <a href="{{route('odeme.adres')}}" title="Düzenle" class="step-title-edit"><span class="sr-only">Düzenle</span><i class="icon-pencil"></i></a>
                        </h3>

                        <address>
                            {{$defaultInvoiceAddress->title}} <br>
                            {{$defaultInvoiceAddress->adres}} <br>
                            {{$defaultInvoiceAddress->state->title}} - {{$defaultInvoiceAddress->district->title}} <br>
                            +90{{$defaultInvoiceAddress->phone}}
                        </address>
                    </div>
                @endif


                <div class="checkout-info-box">
                    <h3 class="step-title">Kargo:
                        <a href="#" title="Düzenle" class="step-title-edit"></a>
                    </h3>

                    <p>Standart Taşıma Kargo Ücreti - {{ cartTotalPrice() }} ₺ </p>
                </div><!-- End .checkout-info-box -->
            </div><!-- End .col-lg-4 -->

            <div class="col-lg-7 order-lg-first">
                <div class="checkout-payment">
                    <h2 class="step-title">Ödeme Bilgileri:</h2>
                    <form action="{{ route('payment.create') }}" method="POST" style="width: 100% !important;" id="paymentForm">
                        @csrf
                        <div class="col-md-12">
                            <input type="hidden" id="taksit_sayisi" name="taksit_sayisi" value="1">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="kartno">Kredi Kartı Numarası</label>
                                        <input type="text" class="form-control kredikarti" id="kartno" name="cardNumber" onchange="getInstallmentDetails({{ cartTotalPrice() }})"
                                               style="font-size:20px;" required value="5528790000000008">
                                    </div>
                                    <div class="form-group">
                                        <label for="holderName">Kart Üzerindeki İsim</label>
                                        <input type="text" class="form-control" id="holderName" name="holderName" value="mruat karabacak"
                                               style="font-size:20px;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cardexpiredatemonth">Son Kullanma Tarihi</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                Ay
                                                <select name="cardExpireDateMonth" id="cardexpiredatemonth" class="form-control"
                                                        required>
                                                    @foreach (range(1, 12) as $number)
                                                        <option {{ $number == 12 ? 'selected': '' }}>{{$number}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                Yıl
                                                <select name="cardExpireDateYear" class="form-control" required>
                                                    @foreach (range(2020, 2050) as $number)
                                                        <option {{ $number == 2030 ? 'selected': '' }}>{{$number}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cardcvv">CVV (Güvenlik Numarası)</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control kredikarti_cvv" name="cvv" id="cardcvv2" value="111"
                                                       required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-custom-control">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" id="inputSozlesme" class="custom-control-input" checked required>
                                            <label for="inputSozlesme" class="custom-control-label"><a style="text-decoration: underline" data-toggle="collapse" href="#onBilgilendirmeFormu" role="button" aria-expanded="false"
                                                                                                       aria-controls="collapseExample">Ön bilgilendirme formunu</a> okudum ve kabul
                                                ediyorum</label>
                                            <div class="collapse" id="onBilgilendirmeFormu">
                                                <div class="card card-body DivWithScroll">
                                                    @include('site.sozlesmeler.onBilgilendirmeFormu')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group-custom-control">
                                        <div class="custom-control custom-checkbox">
                                            <input id="inputMesafeliSatis" type="checkbox" class="custom-control-input" checked required>
                                            <label class="custom-control-label" for="inputMesafeliSatis"><a style="text-decoration: underline" data-toggle="collapse" href="#mesafeliSatisSozlesmesi" role="button" aria-expanded="false"
                                                                                   aria-controls="collapseExample">Mesafeli satış sözleşmesini</a> okudum ve kabul ediyorum.</label>
                                        </div>
                                        <div class="collapse" id="mesafeliSatisSozlesmesi">
                                            <div class="card card-body DivWithScroll">
                                                @include('site.sozlesmeler.satisSozlesmesi')
                                            </div>
                                        </div>
                                    </div>
                                    @if(!$defaultInvoiceAddress)
                                        <div class="form-group-custom-control">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="differentBillAddress" id="change-bill-address"
                                                       onclick="return invoiceFormAddOrRemoveRequired()">
                                                <label class="custom-control-label" for="change-bill-address">Teslimat ve Fatura Adresim farklı</label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div id="new-checkout-address" class="">
                                <h2 class="step-title">Fatura Adresi:</h2>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group required-field">
                                                    <label for="acc-name">Adres İsmi</label>
                                                    <input type="text" class="form-control" min="3" name="title" id="title" placeholder="Örnek : Evim" value="{{ old('title') }}">
                                                </div><!-- End .form-group -->
                                            </div><!-- End .col-md-4 -->
                                            <div class="col-md-4">
                                                <div class="form-group required-field">
                                                    <label for="acc-name">Adınız</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                                </div><!-- End .form-group -->
                                            </div><!-- End .col-md-4 -->

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="acc-mname">Soyadınız</label>
                                                    <input type="text" class="form-control" name="surname" id="surname" value="{{ old('surname') }}">
                                                </div><!-- End .form-group -->
                                            </div><!-- End .col-md-4 -->

                                            <div class="col-md-4">
                                                <label>Telefon </label>
                                                <div class="form-control-tooltip">
                                                    <input type="tel" class="form-control" id="phone" name="phone" maxlength="10" placeholder="5xx....." value="{{ old('phone') }}">
                                                    <span class="input-tooltip" data-toggle="tooltip" title="" data-placement="right"
                                                          data-original-title="For delivery questions."><i
                                                            class="icon-question-circle"></i></span>
                                                </div><!-- End .form-control-tooltip -->
                                            </div><!-- End .form-group -->
                                            <div class="col-md-4">
                                                <label>İl</label>
                                                <div class="select-custom">

                                                    <select class="form-control" name="city" id="city" onchange="citySelectOnChange(this)">
                                                        <option value="">Seçiniz</option>
                                                        @foreach($states as $city)
                                                            <option value="{{$city->id}}">{{$city->title}}</option>
                                                        @endforeach
                                                    </select>

                                                </div><!-- End .select-custom -->
                                            </div><!-- End .form-group -->
                                            <div class="col-md-4">
                                                <label>ilçe</label>
                                                <div class="select-custom">
                                                    <select class="form-control" name="town" id="town" onchange="townSelectOnChange(this)">
                                                        <option value="">Seçiniz</option>
                                                    </select>
                                                </div><!-- End .select-custom -->
                                            </div><!-- End .form-group -->
                                            <div class="col-md-12">
                                                <label>Adres </label>
                                                <textarea type="text" class="form-control" name="adres" id="adres">{{ old('adres') }}</textarea>
                                            </div>

                                        </div><!-- End .row -->

                                    </div><!-- End .col-sm-11 -->
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg">Ödeme Yap</button>
                        </div>
                    </form>
                </div><!-- End .checkout-payment -->
            </div><!-- End .col-lg-8 -->
        </div><!-- End .row -->
    </div>
@endsection
@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script src="/js/basketPage.js"></script>
    <script>
        $('.kredikarti').mask('0000-0000-0000-0000', {placeholder: "____-____-____-____"});
        $('.kredikarti_cvv').mask('000', {placeholder: "___"});
        $('.telefon').mask('(000) 000-00-00', {placeholder: "(___) ___-__-__"});
    </script>
    <script src="/js/userAdresDetailPage.js"></script>
@endsection
