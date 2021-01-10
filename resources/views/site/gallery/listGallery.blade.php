@extends('site.layouts.base')
@section('title','Galeri | '.$site->title)
@section('header')
    <title>Galeri | {{ $site->title }}</title>
    <meta name="description" content="{{ $site->title }} galeri sayfasında faaliyet gösterdiğimiz {{ $site->keywords }} alanlarına ait görselleri bulabilirsiniz"/>
    <meta name="keywords" content="{{ $site->title }},galeri,resimler,{{ $site->keywords }}"/>
    <meta property="og:type" content="gallery"/>
    <meta property="og:url" content="{{ route('gallery.list') }}"/>
    <meta property="og:title" content="Galeri | {{ $site->title }}"/>
    <meta property="og:image" content="{{ $site->domain.'/img/logo.png'}}"/>
    <meta name="twitter:card" content="gallery"/>
    <meta name="twitter:site" content="Galeri | {{ $site->title }}"/>
    <meta name="twitter:creator" content="Galeri | {{ $site->title }}"/>
    <meta name="twitter:title" content="Galeri | {{ $site->title }}"/>
    <meta name="twitter:description" content="{{ $site->title }} galeri sayfasında faaliyet gösterdiğimiz {{ $site->keywords }} alanlarına ait görselleri bulabilirsiniz"/>
    <meta name="twitter:domain" content="{{$site->domain}}"/>
    <link rel="canonical" href="{{ route('gallery.list') }}"/>
@endsection
@section('content')

@endsection

