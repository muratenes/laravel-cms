@extends('site.layouts.base')
@section('title','Kampanyalar')

@section('content')
    <div class="page-header page-header-bg" style="background-image: url('/site/assets/images/page-header-bg.jpg');">
        <div class="container">
            <h1><span>Kampanyalar</span>
            </h1>
            <h3>Yüzlerce ürün ve kategoride birbirinden güzel kampanyalar</h3>
        </div>
    </div>
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Kampanyalar</li>
            </ol>
        </div>
    </nav>
    <div class="container">
        <div class="row row-sm">
            @foreach($list as $item)
                <div class="col-6 col-md-3">
                    <div class="product-default">
                        <figure>
                            <a href="{{route('campaigns.detail',[$item->slug,null])}}">
                                <img class="kampanyaResim" src="{{ config('constants.image_paths.campaign_image_folder_path').''. $item ->image }}">
                            </a>
                        </figure>
                        <div class="product-details">
                        </div><!-- End .product-container -->
                        <h2 class="product-title">
                            <a href="{{route('campaigns.detail',[$item->slug,null])}}">{{$item->title}}</a>
                        </h2>
                        <div class="product-action">
                            <a href="{{route('campaigns.detail',[$item->slug,null])}}" class="btn btn-default border"><i class="fa fa-link"></i>İncele</a>
                        </div>
                    </div><!-- End .product-details -->
                </div>

            @endforeach
        </div>
    </div>
    <div class="mb-6"></div>
@endsection

