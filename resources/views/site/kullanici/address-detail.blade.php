@extends('site.layouts.base')
@section('title','Parola Güncelleme')

@section('content')
    <div class="block-space block-space--layout--after-header"></div>
    <div class="block">
        <div class="container container--max--xl">
            <div class="row">
                @include('site.kullanici.partials.myAccountLeftSidebar')
                <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                    @include('site.layouts.partials.messages')
                    <div class="card">
                        <div class="card-header"><h5>Adres {{ $address->id ? 'Güncelle' : 'Ekle' }}</h5></div>
                        <div class="card-divider"></div>
                        <div class="card-body card-body--padding--2">
                            <form action="{{ route('user.address.save',$address->id ?? 0) }}" method="POST">
                                @csrf
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-10 col-xl-8">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="address-company-name">Adres Başlığı</label>
                                                <input type="text" class="form-control" required id="address-company-name" name="title" placeholder="Örnek : Evim" value="{{ old('title',$address->title) }}" maxlength="50">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address-company-name">Adres Tipi</label>
                                                <select id="address-country" class="form-control" name="type" required>
                                                    <option value="">-- adres tipi seçiniz --</option>
                                                    <option value="1" {{ old('type',$address->type) == 1 ? 'selected' : '' }}>Teslimat Adresi</option>
                                                    <option value="2" {{ old('type',$address->type) == 2 ? 'selected' : '' }}>Fatura Adresi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6"><label for="address-first-name">Ad</label>
                                                <input type="text" class="form-control" id="address-first-name" name="name" placeholder="Adınız" value="{{ old('name',$address->name) ?? $user->name}}" required maxlength="50">
                                            </div>
                                            <div class="form-group col-md-6"><label for="address-last-name">Soyad</label>
                                                <input type="text" name="surname" class="form-control" id="address-last-name" placeholder="Soyad" value="{{ old('surname',$address->surname) ?? $user->surname }}" required maxlength="50">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6"><label>İl</label>
                                                <select class="form-control form-control-select2" name="state_id" required onchange="citySelectOnChange(this)">
                                                    <option value="">-- il seçiniz --</option>
                                                    @foreach($states as $state)
                                                        <option value="{{ $state->id }}" {{ $state->id  == $address->state_id ? 'selected' : '' }}>
                                                            {{ $state->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6"><label>İlçe</label>
                                                <select class="form-control form-control-select2" required name="district_id" id="district">
                                                    <option value="">-- ilçe seçiniz --</option>
                                                    @foreach($districts as $district)
                                                        <option value="{{ $district->id }}" {{ $district->id  == $address->district_id ? 'selected' : '' }}>
                                                            {{ $district->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address-address1">Adres</label>
                                            <textarea type="text" class="form-control" id="address-address1" placeholder="Sokak,Mahalle,Bina Daire Numarası" required name="adres" maxlength="255">{{ old('adres',$address->adres) }}</textarea>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6 mb-0">
                                                <label for="address-email">Email</label>
                                                <input type="email" class="form-control" id="address-email" placeholder="user@site.com" name="email" value="{{ old('email',$address->email) ?? $user->email }}" required maxlength="50">
                                            </div>
                                            <div class="form-group col-md-6 mb-0">
                                                <label for="address-phone">Telefon Numarası</label>
                                                <input type="text" class="form-control" id="address-phone" placeholder="531 111 11 11" required name="phone" maxlength="20" value="{{ old('phone',$address->phone) ?? $user->phone }}">
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <div class="form-check">
                                            <span class="input-check form-check-input"><span class="input-check__body">
                                                    <input class="input-check__input" type="checkbox" id="default-address" name="setAsDefault"
                                                        {{ $user->{$address->type == \App\Models\KullaniciAdres::TYPE_INVOICE ? 'default_invoice_address_id' : 'default_address_id'} == $address->id ? 'checked' :'' }}>
                                                    <span class="input-check__box"></span> <span class="input-check__icon">
                                                        <svg width="9px" height="7px"><path d="M9,1.395L3.46,7L0,3.5L1.383,2.095L3.46,4.2L7.617,0L9,1.395Z"></path></svg>
                                                    </span>
                                                </span>
                                            </span>
                                            <label class="form-check-label" for="default-address">Varsayılan olarak ayarla</label></div>
                                        </div>
                                        <div class="form-group mb-0 pt-3 mt-3">
                                            <a class="btn btn-danger" href="{{ route('user.addresses') }}">Vazgeç</a>
                                            <button type="submit" class="btn btn-success">Kaydet</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-space block-space--layout--before-footer"></div>
@endsection
@section('footer')
    <script src="/js/userAdresDetailPage.js"></script>
@endsection
