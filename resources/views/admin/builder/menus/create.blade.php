@extends('admin.layouts.master')
@section('title','Hizmet detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.services') }}"> Hizmetler</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form role="form" method="POST" action="{{ $item->id != null ? route('admin.services.update',$item->id) : route('admin.services.store') }}" id="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method($item->id ? 'PUT' : 'POST')
        <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Hizmet Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <x-input name="title" label="Başlık" width="3" :value="$item->title" required maxlength="255"/>
                            <x-input name="slug" label="Slug" width="3" :value="$item->slug" maxlength="255" placeholder="Hizmet Url"/>
                            <x-input name="point" type="number" label="Puan" width="1" :value="$item->point" step="any"/>
                            <x-input name="status" type="checkbox" label="Aktif Mi ?" width="1" :value="$item->status" class="minimal"/>
                            <x-select name="type_id" label="Tip" :options="$types" :value="$item->type_id"/>
                            <x-input name="image" type="file" label="Görsel" width="2" :value="$item->image" path="services"/>
                        </div>
                        <div class="row">
                            <x-input name="address" label="Adres Bilgisi" width="3" :value="$item->address" maxlength="255"/>
                            <div class="form-group col-md-9">
                                <label for="exampleInputEmail1">Özellikler</label>
                                <select class="form-control" multiple="multiple" id="attributes" name="attributes[]">
                                        @foreach($attributes as $attribute)
                                            <option value="{{ $attribute->id }}" {{ (isset($selected)) ?  (in_array($attribute->id,$selected['attributes']) ? 'selected' : '') : '' }}>
                                                {{ $attribute->title }}
                                            </option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="exampleInputEmail1">Açıklama</label>
                                <textarea class="textarea" placeholder="" id="editor1"
                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                          name="description">{{ old('description',$item->description )}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Bölge Bilgileri</h3>
                        </div>
                        <div class="box-body">
                            <x-select name="country_id" label="Ülke" :options="$countries" width="12" :value="$item->country_id" onchange="countryOnChange(this)" required/>
                            <x-select name="state_id" label="Şehir" :options="$states" width="12" :value="$item->state_id" onchange="citySelectOnChange(this)"/>
                            <x-select name="district_id" label="İlce" :options="$districts" width="12" :value="$item->district_id"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Link Bilgileri</h3>
                        </div>
                        <div class="box-body">
                            <x-select name="store_type" label="Uygulama Tipi" :options="$storeTypes" width="12" key="0" option-value="1" :value="$item->store_type" required/>
                            <x-input name="redirect_to" label="Yönlendiricelek Url" width="12"
                                     :value="$item->redirect_to"
                                     maxlength="255"
                                     placeholder="Yönlendiricelek link"/>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>
        $(function () {
            $('select[id*="attributes"]').select2({
                placeholder: 'Tip seçiniz'
            });
            $('select[id*="id_country_id"]').select2({
                placeholder: 'Ülke seçiniz'
            });
            $('select[id*="id_state_id"]').select2({
                placeholder: 'Şehir seçiniz'
            });
            $('select[id*="id_district_id"]').select2({
                placeholder: 'İlçe seçiniz'
            });
            $("#id_store_type").on('change',function (){
                const val = $(this).val();
                console.log(val);
                if (val == 2){
                    $("#input_redirect_to").removeAttr('disabled')
                }else{
                    $("#input_redirect_to").prop('disabled',true)
                }
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
        })
    </script>
@endsection
