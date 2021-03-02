@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.reviews.product-review-page-title') }}
@endsection

@php
    $ratings = [
        '', '', '', ''
    ];

    $ratings = [
        10, 30, 20, 15, 25
    ];

    $totalReviews = 25;
    $totalRatings = array_sum($ratings);

@endphp

@push('css')
    <style>
        .reviews {
            display: none !important;
        }
    </style>
@endpush

@section('content-wrapper')
    <div class="row review-page-container review-page">
        @include ('shop::products.view.small-view', ['product' => $product])
        
        <div class="col-lg-7 col-md-12 review-page-details">
            <h2 class="full-width mb30">{{ __('shop::app.reviews.rating-reviews') }}</h2>
            @include ('shop::products.view.reviews')
        </div>
    </div>
@endsection