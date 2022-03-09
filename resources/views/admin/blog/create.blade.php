@extends('admin.layouts.master')
@section('title','Blog detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.blog') }}"> @lang('admin.navbar.blog')</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <form role="form" method="post" action="{{ $item->id ?  route('admin.blog.update',$item->id) : route('admin.blog.store') }}" id="form" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method($item->id ? 'PUT' : 'POST')
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_default_language" data-toggle="tab">
                                <img src="{{ langIcon(defaultLangID()) }}"/>
                            </a>
                        </li>
                        @foreach($item->languages as $index => $language)
                            <li>
                                <a href="#tab_panel_{{ $index }}" data-toggle="tab" title="{{ langTitle($language->lang) }}">
                                    <img src="{{ langIcon($language->lang) }}"/>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_default_language">
                            <div class="box-body">
                                <div class="form-row">
                                    <x-input name="title" label="Başlık" width="12" horizontal :value="$item->title" required maxlength="200"/>
                                    @if(admin('modules.blog.category'))
                                        <x-select
                                            name="category_id"
                                            horizontal
                                            label="Kategori"
                                            :options="$categories->toArray()" width="12"
                                            :value="$item->category_id"
                                            onchange="subCategoriesByCategoryId(this.value)"
                                            {{--                                        required--}}
                                        />
                                        <x-select
                                            name="sub_category_id"
                                            horizontal
                                            label="Alt Kategori"
                                            :options="$subCategories" width="12"
                                            :value="$item->sub_category_id"
                                        />
                                        {{--                                    @include('admin.layouts.components.category-morph-many-select')--}}
                                    @endif
                                    <x-input horizontal name="is_active" type="checkbox" label="Aktif Mi ?" width="12" :value="$item->is_active" class="minimal"/>
                                    <div class="form-group col-md-12">
                                        @if(admin('modules.blog.image'))
                                            <x-input name="image" type="file" label="Görsel" width="2" :value="$item->image" path="blog"/>
                                        @endif
                                        @if(admin('modules.blog.tag'))
                                            <div class="form-group col-md-8">
                                                <label for="exampleInputEmail1">Kelimeler(Tags)</label>
                                                <select class="form-control" multiple="multiple" id="tags" name="tags[]">
                                                    @if($item->tags)
                                                        @foreach($item->tags as $tag)
                                                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-12">
                                            <label for="exampleInputEmail1">Açıklama</label>
                                            <textarea name="description" class="form-control" id="default_description" cols="30" rows="20">{{ old('description',$item->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- OTHER LANGUAGES  -->
                        @foreach($item->languages as $index => $language)
                            <div class="tab-pane" id="tab_panel_{{ $index }}">
                                <div class="box-body">
                                    <div class="form-row">
                                        <x-input name="title_{{ $language->lang }}" label="Başlık {{ langTitle($language->lang) }}"
                                                 width="12" horizontal value='{{ old("title_{{ $language->lang }", $language->data["title"]) }}' maxlength="200"/>
{{--                                        <x-input name="tags[]" multiple="multiple" label="Kelimeler" width="12" horizontal :value="$item->title"  id="tags_{{ $language->lang }}"/>--}}
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-2 control-label">Kelimeler(Tags)</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" multiple="multiple" id="tags_{{ $language->lang }}" name="tags_{{ $language->lang }}[]">
                                                    @if($language->data['tags'] and is_array($language->data['tags']))
                                                        @foreach($language->data['tags'] as $tag)
                                                            <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="col-sm-2 control-label">Açıklama</label>
                                            <div class="col-sm-10">
                                                <textarea name="description_{{ $language->lang }}" class="form-control col-md-10" id="ck_description_{{ $language->lang }}" cols="30"
                                                          rows="20">{{ old("description_{{ $language->lang }", $language->data["description"]) }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                         @endforeach
                    <!-- OTHER LANGUAGES -->
                    </div>
                </div>
                @include('laravel-meta-tags::meta-tags')
                {{-- Blog Images --}}
                @if(config('admin.modules.blog.images'))
                    <x-images title="Görseller" folder-path="public/blog/gallery/" :images="$item->images"/>
                @endif

                <div class=" text-right">
                    <button type="submit" class="btn btn-success">Kaydet</button>
                </div>

            </form>
        </div>
    </div>

@endsection
@section('footer')
    <script src="//cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>
        $(function () {
            var options = {
                language: 'tr',
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
                height: 380,
                allowedContent: true
            };
            CKEDITOR.replace('default_description', options);
            $('#tags').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                width: '100%'
            })


            @foreach($item->languages as $language)
            CKEDITOR.replace('ck_description_{{ $language->lang }}', options);
            $('#tags_{{ $language->lang }}').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                width: '100%'
            })
            @endforeach


        })
        $('select[id*="categories"]').select2({
            placeholder: 'kategori seçiniz'
        });
    </script>
@endsection

