@extends('site.layouts.base')
@section('title',$site->title)
@section('header')

    <title>{{ $site->title }}</title>
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

@endsection
@section('content')
    <h4><a href="{{ route('home.setLocale','en') }}">English</a></h4>
    <h4><a href="{{ route('home.setLocale','tr') }}">Turkish</a></h4>
    <h1> {{ __('lang.welcome') }}</h1>
    <h4> {{ __('lang.contact') }}</h4>
@endsection
