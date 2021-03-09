@inject ('offerRepository', 'Custom\Offer\Repositories\OfferRepository')
@php
    $offers = $offerRepository->getAllHome();
@endphp

@extends('shop::layouts.master')

@section('page_title')
	{{ __('offer::app.offer.title') }}
@endsection

@section('content-wrapper')

<div class="page-header">
    <div class="page-header">
    	<div class="page-title">
        	<h2>{{__('offer::app.offer.active-offers') }}</h2>
        </div>
    </div>
</div>

@if(isset($offers) && count($offers) > 0)
	<table>
	@foreach($offers as $offer)
	<tr>
		<td>{{ $offer->title }}</a></td>
		<td><img src="{{ asset('/').$offer->image }}" alt="{{ __('blog::app.blogs.title') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'" ></td>
		<td>{{ $offer->desc }}</td>
		@php 
            $start_date = new DateTime($offer->start_date);
            $end_date = new DateTime($offer->end_date);
        @endphp
		<td>{{__('offer::app.offer.from') }} {{ $start_date->format('d/m/Y') }}</a></td>
		<td>{{__('offer::app.offer.to') }} {{ $end_date->format('d/m/Y') }}</a></td>
	</tr>
	@endforeach
	</table>
@endif

@endsection