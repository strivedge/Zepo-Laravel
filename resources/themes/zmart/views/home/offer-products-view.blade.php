@extends('shop::layouts.master')

@section('page_title')
	{{ __('festival::app.festival.active-promotions') }}
@endsection

@section('content-wrapper')

<?php $festival = app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts()->count())
	<section class="featured-products product-box active-promotions">
		<div class="page-header">
			<div class="page-title">
	            <h2>{{ __('festival::app.festival.active-promotions') }}</h2>
	        </div>
	    </div>
		
        <ul class="row">
            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts() as $productFlat)
                @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])
            @endforeach
        </ul>
    </section>
@endif
@endsection