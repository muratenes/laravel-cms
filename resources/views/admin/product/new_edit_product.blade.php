@extends('admin.layouts.master')
@section('title',$product->title)

@section('header')
    <style>
        .productVariantItem {
            margin-bottom: 10px;
        }
    </style>
    <!-- Currencies -->
@endsection

@section('content')
    <form role="form" method="post" action="{{ route('admin.product.save',$product->id != null ? $product->id : 0) }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <x-breadcrumb :first="__('admin.products')" first-route="admin.products" :second="$product->title">
            @if(!is_null($product->slug))
                <a target="_blank" href="{{ route('product.detail',$product->slug) }}">@lang('admin.product.show_on_site') <i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                &nbsp;
            @endif
        </x-breadcrumb>

        <div class="row">
            <div class="col-md-12">
                <!-- DİL BILGİLERİ -->
                <div class="nav-tabs-custom">
                    <div class="box-header with-border">
                        <h3 class="box-title">Genel Bilgiler</h3>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_product_default_language">
                            <!-- varsayılan dil bilgileri -->
                            <div class="row">
                                <div class="col-md-12">
                                    <x-input name="title" label="Başlık" width="6" :value="$product->name" required maxlength="200"/>
                                    <x-input name="qty" label="Güncel Stok" disabled="" width="2" :value="$product->qty" type="number" step="any"/>
                                    <div class="form-group col-md-1">
                                        <label>Yayında Mı ?</label><br>
                                        <input type="checkbox" class="minimal" name="is_active" {{ $product->is_active == 1 ? 'checked': '' }}>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Alış Fiyatı <i class="fa fa-info-circle" title="Ürünün stoğa giriş fiyatı"></i></label>
                                        <input type="number" step="any" class="form-control" name="purchase_price" placeholder="Ürün Alış Fiyatı" required
                                               value="{{ old('purchase_price', $product->purchase_price) }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Satış Fiyatı <i class="fa fa-info-circle" title="Ürünün satış fiyatı"></i></label>
                                        <input type="number" step="any" class="form-control" name="price" placeholder="Satış Fiyatı"
                                               value="{{ old('price', $product->price) }}">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box box-footer">
                        <button type="submit" class="btn btn-success pull-right" style="margin-bottom:10px">@lang('admin.save')</button>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
    </form>

    <form role="form" method="post" action="{{ route('admin.product.save-custom-prices',$product->id) }}" id="form" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border d-flex align-items-center">
                        <div>
                            <h3 class="box-title mb-0">Esnafa Özel Fiyat Belirle</h3>
                            <span class="help-block">Bu bölümden esnafa özel ürün bazlı fiyat bilgisi girebilirsiniz. <button class="btn btn-success" style="float: right"><i class="fa fa-save"></i> Fiyat Değişikliklerini Kaydet</button></span>

                        </div>
                        <div class="float-right">

                        </div>
                    </div>


                    <div class="box-body">
                        <table class="table table-bordered" id="customPricesContainer">
                            <thead>
                            <tr>
                                <th style="width: 30%">Esnaf</th>
                                <th style="width: 25%">Özel Fiyat <i class="fa fa-info-circle" title="Özel fiyat alış fiyatından küçük olamaz"></i></th>
                                <th style="width: 15%">İşlem</th>
                            </tr>
                            </thead>
                            <tbody id="esnaf-rows">
                            @foreach($customPrices as $customPrice)
                                <tr class="esnaf-row">
                                    <td>
                                        <select name="vendor_id[]" id="" class="form-control vendorSelect">
                                            @foreach($vendors as $vendor)
                                                <option value="{{$vendor['id']}}" {{ $customPrice->vendor_id == $vendor['id'] ? 'selected' : '' }}>{{$vendor['title']}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control" value="{{$customPrice->price}}" name="price[]" required placeholder="Alış Fiyatı">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">Sil</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                        <!-- Ekle butonu -->
                        <div class="text-end my-2">
                            <button type="button" class="btn btn-primary btn-sm" id="add-row">
                                <i class="fa fa-plus"></i> Yeni Özel Fiyat Ekle
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Gizli template satır -->
    <table class="d-none" style="display: none">
        <tbody class="esnaf-template">
        <tr>
            <td>
                <select name="vendor_id[]" class="form-control vendorSelect">
                    @foreach($vendors as $vendor)
                        <option value="{{$vendor['id']}}">{{$vendor['title']}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" step="any" class="form-control" name="price[]" required placeholder="Alış Fiyatı">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">Sil</button>
            </td>
        </tr>
        </tbody>
    </table>

@endsection
@section('footer')
    <script>
        // $(".vendorSelect").select2({
        //     placeholder: 'Esnaf Seçiniz'
        // });
    </script>

    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

    <script src="{{ asset('admin_files/js/adminProductDetailVehicles.js') }}"></script>
    <script src="{{ asset('admin_files/js/pages/admin.product.js') }}"></script>
    <script src="{{ asset('admin_files/js/.js') }}"></script>
@endsection
