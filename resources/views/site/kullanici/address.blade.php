@extends('site.layouts.base')
@section('title','Adreslerim')

@section('content')
    <div class="block-space block-space--layout--after-header"></div>
    <div class="block">
        <div class="container container--max--xl">
            <div class="row">
                @include('site.kullanici.partials.myAccountLeftSidebar')
                <div class="col-12 col-lg-9 mt-4 mt-lg-0">
                    @include('site.layouts.partials.messages')
                    <div class="addresses-list"><a href="{{ route('user.address.edit',0) }}" class="addresses-list__item addresses-list__item--new">
                            <div class="addresses-list__plus"></div>
                            <div class="btn btn-secondary btn-sm">Adres Ekle</div>
                        </a>
                        <div class="addresses-list__divider"></div>
                        @foreach($addresses as $address)
                            <div class="addresses-list__item card address-card" data-index="{{ $address->id }}">
                                <div class=" flex float-right">
                                    @if (in_array($address->id,[$user->default_address_id,$user->default_invoice_address_id]))
                                        <div class="tag-badge tag-badge--theme mr-0">Varsayılan</div>
                                    @endif
                                    <div class="tag-badge tag-badge--{{ $address->type == \App\Models\KullaniciAdres::TYPE_INVOICE ? 'new' : 'hot' }}">{{ $address->type_label }}</div>
                                </div>
                                <div class="address-card__body">

                                    <div class="address-card__name">{{ $address->title }}</div>
                                    <div class="address-card__row">{{ $address->adres }}</div>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">Telefon Numarası</div>
                                        <div class="address-card__row-content">{{ $address->phone }}</div>
                                    </div>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title">Email Adresi</div>
                                        <div class="address-card__row-content">{{ $address->email }}</div>
                                    </div>
                                    <div class="address-card__footer"><a href="{{ route('user.address.edit',$address->id) }}">Düzenle</a>&nbsp;&nbsp;
                                        <a href="javascript:void(0);" onclick="deleteAddress({{ $address->id }})">Sil</a></div>
                                    <form action="{{ route('user.address.delete',$address->id) }}" id="address-delete-form-{{ $address->id }}" method="POST">
                                        {!! method_field('delete') !!}
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <div class="addresses-list__divider"></div>
                        @endforeach
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
