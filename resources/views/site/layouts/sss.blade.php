@extends('site.layouts.base')
@section('title','Sık Sorulan Sorular'.$site->title)
@section('header')
    <style></style>
@endsection
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Sık Sorulan Sorular</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        <div class="container">
            <div id="accordion">
                @foreach($sss as $s)
                    <div class="card">
                        <div class="card-header" id="heading{{$s->id}}">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$s->id}}" aria-expanded="true" aria-controls="collapse{{$s->id}}">
                                    {{ $s->title }}
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$s->id}}" class="collapse" aria-labelledby="heading{{$s->id}}" data-parent="#accordion">
                            <div class="card-body">
                                {{$s->desc}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-5"></div>


@endsection
