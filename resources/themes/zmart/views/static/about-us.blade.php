@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.about-us.title') }}
@stop

@section('content-wrapper')
    <div class="account-content row no-margin velocity-divide-page">
       {{ __('shop::app.about-us.page-content') }}
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
           
        });
    </script>
@endpush
