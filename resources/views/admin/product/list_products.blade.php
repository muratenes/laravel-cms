@extends('admin.layouts.master')
@section('title','Ürün Listesi')
@section('content')
    <input type="hidden" id="productImagePrefix" value="{{ config('filesystems.default') == 'local' ? '/storage/products/' : '' }}">
    <input type="hidden" id="productDetailPrefix" value="{{ route('product.detail',['product' => '_']) }}">
    <input type="hidden" id="useMultipleCategory" value="{{ admin('modules.product.multiple_category') ? 1 : 0 }}">
    <input type="hidden" id="useCompany" value="{{ admin('modules.product.company') ? 1 : 0 }}">
    <input type="hidden" id="useBrand" value="{{ admin('modules.product.brand') ? 1 : 0 }}">
    <input type="hidden" id="useCategory" value="{{ admin('modules.product.category') ? 1 : 0 }}">
    <input type="hidden" id="useImage" value="{{ admin('modules.product.image') ? 1 : 0 }}">
    <input type="hidden" id="useQty" value="{{ admin('modules.product.qty') ? 1 : 0 }}">
    <input type="hidden" id="usePrice" value="{{ admin('modules.product.prices') ? 1 : 0 }}">

    <x-breadcrumb :first="__('admin.products')">
        <a href="{{ route('admin.product.new') }}"> <i class="fa fa-plus"></i> @lang('admin.product.add_new_product')</a>
        <a href="{{ route('admin.products') }}"> <i class="fa fa-refresh"></i> @lang('admin.refresh')</a>
    </x-breadcrumb>
    <!-- filtreleme -->
    <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <form action="{{ route('admin.products') }}" method="get" id="form">
                    <div class="col-md-12">
                        <div class="col-md-1" style="padding-top: 8px"><strong>@lang('admin.filter') : </strong></div>
                        @if (admin('modules.product.category'))
                            <div class="col-md-2">
                                <select name="category" class="form-control" id="category_filter">
                                    <option value="">--@lang('admin.product.select_category')--</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->title  }} {{ $cat->parent_cat ? "({$cat->parent_cat->title})"  : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        @if(admin('modules.product.company'))
                            <div class="col-md-2">
                                <select name="company" class="form-control" id="company_filter">
                                    <option value="">--@lang('admin.product.filter_by_company')--</option>
                                    @foreach($companies as $com)
                                        <option value="{{ $com->id }}" {{ request('company') == $com->id ? 'selected' : '' }}>{{ $com->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        @if(admin('modules.product.brand'))
                            <div class="col-md-2">
                                <select name="brand" class="form-control" id="brand_filter">
                                    <option value="">--@lang('admin.product.filter_by_brand')--</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-md-2">
                            <button class="btn btn-sm btn-success">@lang('admin.filter')</button>
                            <a href="{{ route('admin.products') }}" class="btn btn-sm btn-danger">@lang('admin.clear')</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <!-- /.box-header -->
                <div class="box-body table-responsive">

                    <table class="table table-hover table-bordered display" id="productList">
                        <thead>
                        <tr>
                            <th>@lang('admin.id')</th>
                            <th>@lang('admin.title')</th>
                            <th class="{{ admin('modules.product.category') && admin('modules.product.multiple_category') ? '' : 'hidden' }}">@lang('admin.categories') <i class="fa fa-external-link"></i></th>
                            <th class="{{ admin('modules.product.category') && admin('modules.product.multiple_category') ? 'hidden' : '' }}">@lang('admin.parent_category') <i class="fa fa-external-link"></i></th>
                            <th class="{{ admin('modules.product.category') && admin('modules.product.multiple_category') ? 'hidden' : '' }}">@lang('admin.sub_category') <i class="fa fa-external-link"></i></th>
                            <th>Slug <i class="fa fa-question-circle" title="web sitesinde görüntüle"></i></th>
                            <th class="{{ admin('modules.product.company') ? '' : 'hidden' }}">@lang('admin.company')</th>
                            <th class="{{ admin('modules.product.brand') ? '' : 'hidden' }}">@lang('admin.brand')</th>
                            <th class="{{ admin('modules.product.qty') ? '' : 'hidden' }}">@lang('admin.stock')</th>
                            <th class="{{ admin('modules.product.prices') ? '' : 'hidden' }}">@lang('admin.price')</th>
                            <th class="{{ admin('modules.product.prices') ? '' : 'hidden' }}">@lang('admin.discount')</th>
                            <th class="{{ admin('modules.product.image') ? '' : 'hidden' }}">@lang('admin.image')</th>
                            <th>@lang('admin.status')</th>
                            <th>@lang('admin.created_at')</th>
                        </tr>
                        </thead>
                    </table>
                </div>

                <!-- /.box-body -->
            </div>

            <!-- /.box -->
        </div>
    </div>

@endsection
@section('footer')
    <script src="/admin_files/js/pages/admin.product.list.js"></script>
@endsection
