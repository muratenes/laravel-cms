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
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Kategori Detay</h3>
                    </div>

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
                                            <option value="{{ $type }}" {{ $type == $item->categorizable_type ? 'selected' : '' }}>
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
    <script>
        $("#categorizable_type").on('change', function () {
            $.ajax({
                url: `/admin/category/type`,
                dataType: 'json',
                data: {
                    type : $(this).val()
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

