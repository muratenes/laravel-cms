@extends('site.layouts.base')
@section('title','Hata Kodları')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('homeView')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Hata Kodları</li>
            </ol>
        </div><!-- End .container -->
    </nav>
    <div class="container">
        @include('site.layouts.partials.messages')
        <div class="row">
            <div class="col-lg-3">
                @include('site.kullanici.partials.myAccountLeftSidebar')
            </div>
            <div class="col-lg-9">
                <h3>Hata Kodları</h3>
                <div class="alert alert-warning alert-intro" role="alert">
                    Hata kodları kullanıcının sitede dolaşırken aldığı bir hata sonucunda verilen benzersiz kodlardır.
                    Bu kodlar sayesinde site sahibiyle iletişime geçerek hata veya işlem hakkında bilgi alabilirsiniz
                </div>
                <div class="row">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Level</th>
                            <th scope="col">Kod</th>
                            <th scope="col">Url</th>
                            <th scope="col">Hata Tarihi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <th scope="row">{{$log->id}}</th>
                                <td>{{$log->level}}</td>
                                <td>{{$log->code}}</td>
                                <td>{{$log->url}}</td>
                                <td>{{$log->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
