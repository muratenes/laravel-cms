@extends('site.layouts.base')
@section('title','Referanslar | '.$site->title)
@section('header')
    <title>Referanslar | {{ $site->title }}</title>
    <meta name="description" content="{{ $site->title }} referanslar sayfasında birlikte çalışmış olduğumuz firmaları referansları görebilirsiniz"/>
    <meta name="keywords" content="{{ $site->title }},referanslar,markalar,{{ $site->keywords }}"/>
    <meta property="og:type" content="info"/>
    <meta property="og:url" content="{{ route('sss') }}"/>
    <meta property="og:title" content="Referanslar | {{ $site->title }}"/>
    <meta property="og:image" content="{{ $site->domain.'/img/logo.png'}}"/>
    <meta name="twitter:card" content="product"/>
    <meta name="twitter:site" content="Referanslar | {{ $site->title }}"/>
    <meta name="twitter:creator" content="Referanslar | {{ $site->title }}"/>
    <meta name="twitter:title" content="Referanslar | {{ $site->title }}"/>
    <meta name="twitter:description" content="{{ $site->title }} referanslar sayfasında birlikte çalışmış olduğumuz firmaları referansları görebilirsiniz"/>
    <meta name="twitter:domain" content="{{$site->domain}}"/>
    <link rel="canonical" href="{{ route('referanslar') }}"/>
@endsection
@section('content')
<h1>Referanslar</h1>
@endsection

