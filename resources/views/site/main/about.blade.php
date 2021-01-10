@extends('site.layouts.base')
@section('title',$site->title)
@section('header')
    <title>@lang('lang.commercial') | {{ $site->title }}</title>
    <meta name="description" content="{{ $site->spot }}"/>
    <meta name="keywords" content="{{ $site->keywords }}"/>
    <meta property="og:type" content="website "/>
    <meta property="og:url" content="{{ $site->domain }}"/>
    <meta property="og:title" content="{{ $site->title }}"/>
    <meta property="og:image" content="{{ $site->domain.'/img/logo.png'}}"/>
    <meta name="twitter:card" content="website"/>
    <meta name="twitter:site" content="@siteadi"/>
    <meta name="twitter:creator" content="@siteadi"/>
    <meta name="twitter:title" content="{{ $site->title }}"/>
    <meta name="twitter:description" content="{{ $site->spot }}"/>
    <meta name="twitter:image:src" content="{{ $site->domain.'/img/logo.png'}}"/>
    <meta name="twitter:domain" content="{{$site->domain}}"/>
    <link rel="canonical" href="{{ $site->domain }}"/>
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
@endsection
@section('content')
   <h1>kurumsal</h1>
@endsection
