@extends('admin.layouts.master')
@section('title','Ürün Detay')

@section('header')
    <style>
        .productVariantItem {
            margin-bottom: 10px;
        }
    </style>
    <!-- Currencies -->
    <meta name="currencies" content="{{ json_encode($data['currencies']) }}">
@endsection

@section('content')
    <form role="form" method="post" action="{{ route('admin.product.save',$product->id != null ? $product->id : 0) }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <x-breadcrumb :first="__('admin.products')" first-route="admin.products" :second="$product->title">
            @if(!is_null($product->slug))
                <a target="_blank" href="{{ route('product.detail',$product->slug) }}">@lang('admin.product.show_on_site') <i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                &nbsp;@endif
        </x-breadcrumb>

        <div class="row">
            <div class="col-md-12">
                <!-- DİL BILGİLERİ -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_product_default_language" data-toggle="tab">
                                <img src="{{ langIcon(defaultLangID()) }}"/>
                            </a>
                        </li>
                        @foreach($product->descriptions as $index => $description)
                            <li>
                                <a href="#tab_product_{{ $index }}" data-toggle="tab" title="{{ langTitle($description->lang) }}">
                                    <img src="{{ langIcon($description->lang) }}"/>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_product_default_language">
                            <!-- varsayılan dil bilgileri -->
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="exampleInputEmail1">@lang('admin.title')</label>
                                    <input type="text" class="form-control" name="title" placeholder="@lang('admin.product.title')" maxlength="90"
                                           value="{{ old('title', $product->title) }}">
                                </div>


                                <div class="form-group col-md-1">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="ürün slug" disabled
                                           value="{{ old('slug', $product->slug) }}">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="exampleInputEmail1">@lang('admin.product.code')</label>
                                    <input type="text" class="form-control" name="code" placeholder="ürün kodu otomatik oluşur" {{ admin('modules.product.auto_code') ? 'disabled' :'' }}
                                    value="{{ old('code', $product->code) }}">
                                </div>

                                <div class="form-group col-md-1">
                                    <label for="exampleInputEmail1">@lang('admin.is_active')</label><br>
                                    <input type="checkbox" class="minimal" name="active" {{ $product->active == 1 ? 'checked': '' }}>
                                </div>
                                @if(admin('modules.product.image'))
                                    <div class="form-group col-md-2">
                                        <label for="image">@lang('admin.image')</label><br>
                                        <input type="file" class="form-control" name="image">
                                        @if($product->image)
                                            <span class="help-block"><a
                                                    href="{{ imageUrl('public/products',$product->image) }}">{{ $product->image }}</a></span>
                                        @endif
                                    </div>
                                @endif
                                @if(admin('modules.product.buying_price'))
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputEmail1">@lang('admin.product.buying_price')</label>
                                        <input type="number" class="form-control" name="buying_price" placeholder="firmadan alış fiyatı"
                                               value="{{ old('buying_price', $product->buying_price) }}">
                                    </div>
                                @endif
                                @if(admin('modules.product.cargo_price'))
                                    <div class="form-group col-md-2">
                                        <label for="cargo_price">@lang('admin.product.cargo_price')
                                            <i class="fa fa-question-circle" title="@lang('admin.product.cargo_if_empty')"></i>
                                        </label>
                                        <input type="number" class="form-control" name="cargo_price" placeholder="@lang('admin.product.cargo_price')"
                                               value="{{ old('cargo_price', $product->cargo_price) }}">
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                @if(admin('modules.product.qty'))
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputEmail1">@lang('admin.product.qty')</label>
                                        <input type="number" class="form-control" id="qty" name="qty" placeholder="@lang('admin.product.qty')"
                                               value="{{ old('qty', $product->qty) }}">
                                    </div>
                                @else
                                    <input type="hidden" name="qty" value="1">
                                @endif
                                @if(admin('modules.product.brand'))
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputEmail1">
                                            @lang('admin.brand')
                                            @if($product->brand_id)
                                                <a target="_blank" href="{{ route('admin.product.brands.edit',$product->brand_id) }}">
                                                    <i class="fa fa-eye text-blue"></i></a>
                                            @endif
                                        </label>
                                        <select name="brand_id" id="brand" class="form-control">
                                            <option value="">---@lang('admin.product.select_brand') --</option>
                                            @foreach($data['brands'] as $brand)
                                                <option {{  $product->brand_id == $brand->id ? 'selected' : ''  }}
                                                        value="{{ $brand->id }}">{{ $brand->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if(admin('modules.product.company'))
                                    <div class="form-group col-md-1">
                                        <label for="exampleInputEmail1">@lang('admin.product.suppliers')
                                            &nbsp;@if($product->company_id)
                                                <a target="_blank" href="{{ route('admin.product.company.edit',$product->company_id) }}"><i
                                                        class="fa fa-eye text-blue"></i></a>
                                            @endif
                                        </label>
                                        <select name="company_id" id="company" class="form-control">
                                            <option value="">---@lang('admin.product.select_company') --</option>
                                            @foreach($data['companies'] as $com)
                                                <option {{$product->company_id == $com->id ? 'selected' : '' }}
                                                        value="{{ $com->id }}">{{ $com->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if(admin('modules.product.category'))
                                    @include('admin.product.partials.product-categories')
                                @endif


                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1">@lang('admin.product.short_description')</label>
                                    <input type="text" class="form-control" id="spot" name="spot" placeholder="Kısa açıklama" maxlength="255"
                                           value="{{ old('spot', $product->spot) }}">
                                </div>
                            </div>
                            <div class="row">
                                @if(admin('modules.product.tag'))
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1">@lang('admin.product.keywords')</label>
                                        <select class="form-control" multiple="multiple" id="tags" name="tags[]">
                                            @if($product->tags)
                                                @foreach($product->tags as $tag)
                                                    <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @include('admin.product.partials.product-detail-languages')
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- ürün fiyat bilgileri -->
                @if(admin('modules.product.prices'))
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.product.partials.product-prices')
                        </div>
                    </div>
                @endif
            <!-- Ürün Açıklama -->
                <div class="row">
                    <div class="col-md-{{ admin('modules.product.attribute') ? '6': '12' }}">
                        <div class="box box-primary">
                            <div class="box-header" data-widget="collapse" data-toggle="tooltip">
                                <h3 class="box-title">@lang('admin.product.product_desc')
                                    <small>@lang('admin.product.desc_of_product')</small>
                                </h3>
                                <div class="pull-right box-tools">
                                    <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                            title="Daralt">
                                        <i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body pad">
                         <textarea class="textarea" placeholder="Place some text here" id="editor1"
                                   style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                   name="desc">{{ old('desc',$product->desc )}}</textarea>
                            </div>
                        </div>
                    </div>
                    @if(admin('modules.product.attribute'))
                        @include('admin.product.partials.product-attributes')
                    @endif
                </div>
                @if(admin('modules.product.feature'))
                    @include('admin.product.partials.product-features')
                @endif
                @if(admin('modules.product.variant'))
                    @include('admin.product.partials.product-variants')
                @endif
                @if(admin('modules.product.gallery'))
                    @include('admin.product.partials.product-gallery')
                @endif
            </div>

        </div>


        <button type="submit" class="btn btn-success pull-right" style="margin-bottom:10px">@lang('admin.save')</button>
    </form>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>

        $(function () {
            $('select[id*="categories"]').select2({
                placeholder: 'kategori seçiniz'
            });
            $('select[name*="parent_category_id"],select[name*="sub_category_id"]').select2({
                placeholder: 'kategori seçiniz'
            });
            $('select#company').select2({
                placeholder: 'firma seçiniz'
            });
            $('select#brand').select2({
                placeholder: 'marka seçiniz'
            });

            $('select[id*="attributes"]').select2({
                placeholder: 'özellik seçiniz'
            });
            $('select[id*="subAttributes"]').select2({
                placeholder: 'alt özellik seçiniz'
            });
            // $('#subAttributes').select2({
            //     placeholder: 'Alt Özellikler seçiniz'
            // });

            $('#tags').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })

            // dil tags
            $('#tags_2').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })
            $('#tags_3').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })
            var options = {
                language: 'tr',
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
                allowedContent: true
            };
            CKEDITOR.replace('editor1', options);
            CKEDITOR.replace('editor_lang_2', options);
            CKEDITOR.replace('editor_lang_3', options);

        })
    </script>
    <script src="{{ asset('admin_files/js/adminProductDetailVehicles.js') }}"></script>
    <script src="{{ asset('admin_files/js/pages/admin.product.js') }}"></script>
    <script src="{{ asset('admin_files/js/.js') }}"></script>
@endsection
