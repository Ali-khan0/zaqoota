@extends('layouts.landing.app')

@section('title', translate('messages.services_policy'))

@section('content')
    @include('partials.public-content-page', [
        'pageTitle' => translate('messages.services_policy'),
        'pageSubtitle' => translate('messages.The standards and policies that guide Zaqoota services.'),
        'pageContent' => $data,
    ])
@endsection
