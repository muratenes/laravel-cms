
@extends('errors::layout')

@section('title', 'Error')

@section('message', 'Üzgünüz, bir hata oluştu .'.(isset($incidentCode) ? ' Bu kodu site yöneticisine iletirseniz size hata hakkında yardımcı olabiliriz: '.$incidentCode : ''))
