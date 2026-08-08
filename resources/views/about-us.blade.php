@extends('layouts.landing.app')

@section('title', translate('messages.about_us'))

@section('content')
    @include('partials.public-content-page', [
        'pageTitle' => $data_title ?: translate('messages.about_us'),
        'pageSubtitle' => translate('messages.Learn more about Zaqoota and the people we serve.'),
        'pageContent' => $data,
    ])
@endsection
