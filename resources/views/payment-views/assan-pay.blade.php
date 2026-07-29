@extends('payment-views.layouts.master')

@section('content')
    <div class="text-center py-5">
        @isset($errorMessage)
            <h2 class="text-danger mb-3">AssanPay</h2>
            <p class="mb-4">{{ $errorMessage }}</p>
            <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        @else
            <h1>Please wait…</h1>
            <p>Redirecting to AssanPay.</p>
        @endisset
    </div>
@endsection
