@extends('payment-views.layouts.master')

@push('script')

@endpush

@section('content')
    <div class="text-center">
        <h1>{{ translate('Please do not refresh this page...') }}</h1>
    </div>

    <form method="POST" action="{{ $base_url }}" accept-charset="UTF-8" class="form-horizontal" role="form" id="payfast-form">
        @foreach($data_array as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <button class="btn btn-block" id="pay-button" type="submit" style="display:none"></button>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("pay-button").click();
        });
    </script>

@endsection
