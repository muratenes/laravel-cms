@extends('admin.layouts.master')
@section('title', __('admin.navbar.categories') . 'Detay')

@section('content')
    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › <a href="{{ route('admin.categories.index') }}"> @lang('admin.navbar.categories')</a>
                    › {{ $item->title }}
                </div>
            </div>
        </div>
    </div>
    <form role="form" method="post" action="{{ $item->id ?  route('admin.categories.update',$item->id) : route('admin.categories.store') }}" id="form" enctype="multipart/form-data">
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
                            <x-input horizontal name="title" label="Başlık" width="12" :value="$item->title" required maxlength="255"/>
                            <div class="form-group col-md-12">
                                <label for="categorizable_type" class="control-label col-sm-2">
                                    Tür
                                </label>
                                <div class="col-sm-10">
                                    <select name="categorizable_type" id="categorizable_type" class="form-control">
                                        @foreach(\App\Models\Category::TYPES as $type)
                                            <option value="{{ $type }}" {{ $type == ($item->id ? $item->categorizable_type : request()->get('type')) ? 'selected' : '' }}>
                                                @lang('admin.modules.category.'.$type.'.title')
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <x-select
                                name="parent_category_id"
                                label="Üst Kategori"
                                horizontal
                                :options="$categories->toArray()" width="12"
                                :value="$item->parent_category_id"
                                onchange="subCategoriesByCategoryId(this.value)"
                                {{--                                        required--}}
                            />
                            <x-input horizontal name="is_active" type="checkbox" label="Aktif Mi ?" width="12" :value="$item->is_active" class="minimal"/>
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
                            </div>
                        </div>
                    </div>
                @endforeach
            <!-- OTHER LANGUAGES -->
            </div>
            <div class=" box-footer text-right">
                <button type="submit" class="btn btn-success">Kaydet</button>
            </div>
        </div>

        {{--    {!! View::make('laravel-filemanager::crop') !!}--}}
        @include('laravel-meta-tags::meta-tags')

    </form>

@endsection
@section('footer')
    <script>
        $("#categorizable_type").on('change', function () {
            $.ajax({
                url: `/admin/category/type`,
                dataType: 'json',
                data: {
                    type: $(this).val()
                },
                success: function (data) {
                    var options = "";
                    $("#id_parent_category_id option").not(':first').remove()
                    $.each(data, function (index, element) {
                        options += '<option value="' + element.id + '">' + element.title + '</option>';
                    });
                    $("#id_parent_category_id").append(options)
                }
            })
        })
    </script>
@endsection

