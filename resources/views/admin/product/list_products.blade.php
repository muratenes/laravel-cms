@extends('admin.layouts.master')
@section('title','Ürün Listesi')
@section('content')
    <input type="hidden" id="productImagePrefix" value="{{ config('filesystems.default') == 'local' ? '/storage/products/' : '' }}">
    <input type="hidden" id="productDetailPrefix" value="{{ route('product.detail',['product' => '_']) }}">
    <input type="hidden" id="useMultipleCategory" value="{{ config('admin.product.multiple_category') ? 1 : 0 }}">
    <input type="hidden" id="useCompany" value="{{ config('admin.product.use_companies') ? 1 : 0 }}">
    <input type="hidden" id="useBrand" value="{{ config('admin.product.use_brand') ? 1 : 0 }}">

    <div class="box box-default">
        <div class="box-body with-border">
            <div class="row">
                <div class="col-md-10">
                    <a href="{{ route('admin.home_page') }}"> <i class="fa fa-home"></i> Anasayfa</a>
                    › Ürünler
                </div>
                <div class="col-md-2 text-right mr-3">
                    <a href="{{ route('admin.product.new') }}"> <i class="fa fa-plus"></i> Yeni Ürün Ekle</a>&nbsp;
                    <a href="{{ route('admin.products') }}"><i class="fa fa-refresh"></i>&nbsp;Yenile</a>
                </div>
            </div>
        </div>
    </div>
    <!-- filtreleme -->
    <div class="box box-default {{ Request::hasAny(['category','company']) ? '' : 'collapsed-box' }}">
        <div class="box-header with-border">
            <h3 class="box-title">Filtreleme</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="{{ Request::hasAny(['category','company']) ? '' : 'display : none' }}" >
            <div class="row">
                <form action="{{ route('admin.products') }}" method="get" id="form">
                    <div class="col-md-12">
                        <div class="col-md-1" style="padding-top: 8px"><strong>Filtrele : </strong></div>
                        <div class="col-md-2">
                            <select name="category" class="form-control" id="category_filter">
                                <option value="">--Kategori Seçiniz--</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->title  }} {{ $cat->parent_cat ? "({$cat->parent_cat->title})"  : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if(config('admin.product.use_companies'))
                            <div class="col-md-2">
                                <select name="company" class="form-control" id="company_filter">
                                    <option value="">--Mağazaya Göre Filtrele--</option>
                                    @foreach($companies as $com)
                                        <option value="{{ $com->id }}" {{ request('company') == $com->id ? 'selected' : '' }}>{{ $com->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        @if(config('admin.product.use_brand'))
                            <div class="col-md-2">
                                <select name="brand" class="form-control" id="brand_filter">
                                    <option value="">--Markaya Göre Filtrele--</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-md-2">
                            <button class="btn btn-sm btn-success">Filtrele</button>
                            <a href="{{ route('admin.products') }}" class="btn btn-sm btn-danger">Temizle</a>
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
                            <th>ID</th>
                            <th>Başlık</th>
                            <th class="{{ config('admin.product.multiple_category') ? '' : 'hidden' }}">Kategoriler <i class="fa fa-external-link"></i></th>
                            <th class="{{ config('admin.product.multiple_category') ? 'hidden' : '' }}">Üst Kategori <i class="fa fa-external-link"></i></th>
                            <th class="{{ config('admin.product.multiple_category') ? 'hidden' : '' }}">Alt Kategori <i class="fa fa-external-link"></i></th>
                            <th>Slug <i class="fa fa-question-circle" title="web sitesinde görüntüle"></i></th>
                            <th class="{{ config('admin.product.use_companies') ? '' : 'hidden' }}">Firma</th>
                            <th class="{{ config('admin.product.use_brand') ? '' : 'hidden' }}">Marka</th>
                            <th>Fiyat</th>
                            <th>İndirimli</th>
                            <th>Fotoğraf</th>
                            <th>Durum</th>
                            <th>Oluşturma</th>
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
