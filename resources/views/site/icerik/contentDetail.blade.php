@extends('site.layouts.base')
@section('title',$item->title . ' | '. $site->title)
@section('header')
    <meta name="description" content="{{ $site->spot }}"/>
    <meta name="keywords" content="{{ $site->title }},{{ $site->keywords }}"/>
    <meta property="og:type" content="info"/>
    <meta property="og:url" content="{{ route('content.detail',$item->slug) }}"/>
    <meta property="og:title" content="{{ $item->title . ' | '. $site->title }}"/>
    <meta property="og:image" content="{{ $site->domain.config('constants.image_paths.content_image_folder_path')}}"/>
    <meta name="twitter:card" content="gallery"/>
    <meta name="twitter:site" content="{{ $item->title . ' | '. $site->title }}"/>
    <meta name="twitter:creator" content="{{ $item->title . ' | '. $site->title }}"/>
    <meta name="twitter:title" content="{{ $item->title . ' | '. $site->title }}"/>
    <meta name="twitter:description" content="{{ $site->spot }}"/>
    <meta name="twitter:domain" content="{{$site->domain}}"/>
    <link rel="canonical" href="{{ route('content.detail',$item->id)}}"/>
@endsection
@section('content')

@endsection

