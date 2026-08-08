@extends('layouts.landing.app')

@section('title', translate('messages.terms_and_condition'))

@section('content')
    @include('partials.public-content-page', [
        'pageTitle' => translate('messages.terms_and_condition'),
        'pageSubtitle' => translate('messages.Please review the terms that apply when using Zaqoota.'),
        'pageContent' => $data,
    ])
@endsection
