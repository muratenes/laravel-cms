@extends('admin.layouts.master')
@section('title','Firma detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> @lang('admin.home')</a>
                    › <a href="{{ route('admin.product.company.list') }}"> @lang('admin.modules.product_company.plural')</a>
                    › {{ $item->title }}
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a type="submit" onclick="document.getElementById('form').submit()" class="btn btn-success btn-sm">@lang('admin.save')</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.modules.product_company.title') Detay</h3>
                </div>
                <form role="form" method="post" action="{{ route('admin.product.company.save',$item->id != null ? $item->id : 0) }}" id="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-row">
                            <x-input name="title" label="Firma Adı" width="3" :value="$item->title" required maxlength="50"/>
                            <x-input name="email" type="email" label="Email" width="2" :value="$item->email"  maxlength="50"/>
                            <x-input name="slug" type="text" label="Slug" width="2" :value="$item->slug"  disabled/>
                            <x-input name="address" type="text" label="Adres" width="4" :value="$item->address"  maxlength="250"/>
                            <x-input name="phone" type="phone" label="Telefon" width="3" :value="$item->phone"  maxlength="30"/>
                            <x-input name="active" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->active" class="minimal"/>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Kayıt Tarihi</label>
                                <p>{{$item->created_at}}</p>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Son Güncelleme</label>
                                <p>{{$item->updated_at}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">@lang('admin.save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
