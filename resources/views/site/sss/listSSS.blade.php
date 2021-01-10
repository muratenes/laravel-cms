@extends('site.layouts.base')
@section('title','Sık Sorulan Sorular')
@section('header')
    <title>Sık Sorulan Sorular | {{ $site->title }}</title>
    <meta name="description" content="{{ $site->title }} üzerinde aklınıza takılan her türlü sorunun cevabını {{ $site->title }} Sık Sorulan Sorular sayfasında bulabilirsin"/>
    <meta name="keywords" content="{{ $site->title }},bilgi,nasıl yapılır"/>
    <meta property="og:type" content="info"/>
    <meta property="og:url" content="{{ $site->domain.''.route('sss') }}"/>
    <meta property="og:title" content="Sık Sorulan Sorular | {{ $site->title }}"/>
    <meta property="og:image" content="{{ $site->domain.'/img/logo.png'}}"/>
    <meta name="twitter:card" content="product"/>
    <meta name="twitter:site" content="Sık Sorulan Sorular | {{ $site->title }}"/>
    <meta name="twitter:creator" content="Sık Sorulan Sorular | {{ $site->title }}"/>
    <meta name="twitter:title" content="Sık Sorulan Sorular | {{ $site->title }}"/>
    <meta name="twitter:description" content="{{ $site->title }} üzerinde aklınıza takılan her türlü sorunun cevabını {{ $site->title }} Sık Sorulan Sorular sayfasında bulabilirsin"/>
    <meta name="twitter:domain" content="{{$site->domain}}"/>
    <link rel="canonical" href="{{ route('sss') }}"/>
@endsection
@section('content')
<h1>SSS</h1>
@endsection

