@extends('layouts.landing.app')

@section('title', translate('messages.privacy_policy'))

@section('content')
    @include('partials.public-content-page', [
        'pageTitle' => translate('messages.privacy_policy'),
        'pageSubtitle' => translate('messages.How Zaqoota collects, uses and protects your information.'),
        'pageContent' => $data,
    ])
@endsection
