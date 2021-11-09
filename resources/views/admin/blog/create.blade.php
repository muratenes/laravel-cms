@extends('admin.layouts.master')
@section('title','Blog detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.blog') }}"> Blog</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <form role="form" method="post" action="{{ $item->id ?  route('admin.blog.update',$item->id) : route('admin.blog.store') }}" id="form" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method($item->id ? 'PUT' : 'POST')
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Blog Detay</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="exampleInputEmail1">Başlık</label>
                                <input type="text" class="form-control" name="title" placeholder="başlık" required max="200"
                                       value="{{ old('title', $item->title) }}">
                            </div>
                            <div class="form-group col-md-1">
                                <label for="exampleInputEmail1">Aktif Mi ?</label><br>
                                <input type="checkbox" class="minimal" name="is_active" {{ $item->is_active == 1 ? 'checked': '' }}>
                            </div>
                            @if(admin('modules.blog.image'))
                                <div class="form-group col-md-2">
                                    <label for="image">Fotoğraf</label><br>
                                    <input type="file" class="form-control" name="image">
                                    @if($item->image)
                                        <span class="help-block"><a target="_blank"
                                                                    href="{{ imageUrl('public/blog',$item->image) }}">{{ $item->image }}</a></span>
                                    @endif
                                </div>
                            @endif
                            @if(admin('multi_lang'))
                                <div class="form-group col-md-1">
                                    <label for="exampleInputEmail1">Dil</label>
                                    <select name="lang" id="languageSelect" class="form-control">
                                        @foreach($languages as $lang)
                                            <option value="{{ $lang[0] }}" {{ $item->lang == $lang[0] ? 'selected' : '' }}> {{ $lang[1] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if(admin('modules.blog.tag'))
                                <div class="col-md-6">
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
                            @if(admin('modules.blog.category'))
                                <div class="form-group col-md-4">
                                    <x-select
                                        name="category_id"
                                        label="Kategori"
                                        :options="$categories->toArray()" width="6"
                                        :value="$item->category_id"
                                        onchange="subCategoriesByCategoryId(this.value)"
                                        {{--                                        required--}}
                                    />
                                    <x-select
                                        name="sub_category_id"
                                        label="Alt Kategori"
                                        :options="$subCategories" width="6"
                                        :value="$item->sub_category_id"
                                    />
                                    {{--                                    @include('admin.layouts.components.category-morph-many-select')--}}
                                </div>
                            @endif
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1">Açıklama</label>
                                <textarea name="description" class="form-control" id="editor1" cols="30" rows="10">{{ old('description',$item->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>

                </div>
            </div>
        </div>
        {{--    {!! View::make('laravel-filemanager::crop') !!}--}}
        @include('laravel-meta-tags::meta-tags')

    </form>

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
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };
            CKEDITOR.replace('editor1', options);

            $('#tags').select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })
        })
        $('select[id*="categories"]').select2({
            placeholder: 'kategori seçiniz'
        });
    </script>
@endsection

