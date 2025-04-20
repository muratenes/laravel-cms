@extends('admin.layouts.master')
@section('title',__('admin.products'))
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


    <div class="row">
        <div class="col-xs-12">
            <div class="box ">
                <!-- /.box-header -->
                <div class="box-body table-responsive">

                    <table class="table table-hover table-bordered display" id="productList">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ürün</th>
                            <th>Alış Fiyatı</th>
                            <th>Satış Fiyatı</th>
                            <th>Özel Fiyat Tanımlı Esnaf</th>
                            <th>Stok</th>
                            <th>Son Güncelleme</th>
                            <th>#</th>
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
