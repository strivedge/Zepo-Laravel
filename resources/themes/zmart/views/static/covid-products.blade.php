@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.header.covid19-products') }}
@stop

@section('content-wrapper')
     @include('shop::home.covid-products')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
           
        });
    </script>
@endpush
