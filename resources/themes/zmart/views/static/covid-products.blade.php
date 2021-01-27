@extends('shop::layouts.master')

@section('content-wrapper')
     @include('shop::home.covid-products')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
           
        });
    </script>
@endpush
