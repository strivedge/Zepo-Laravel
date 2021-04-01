@extends('shop::layouts.master')

@section('page_title')
	{{ __('festival::app.festival.more-about-promotion') }}
@endsection

@section('content-wrapper')

<?php $festival = app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts()->count())
<section class="more-promotions-details">
	
	<div class="page-header">
		<div class="page-title">
            <h2>{{ __('festival::app.festival.more-about-promotion') }}</h2>
        </div>
    </div>
	<div class="more-promotions-details-content row">
		<div class="imgs col-md-4">
			<img src="{{ asset($festival[0]->image) }}">
		</div>
		<div class="content col-md-8">
			<div class="title">
			<h3>{{ $festival[0]->title }}</h3>
			</div>
			<div class="short-desc">
			   <label>Short Description:</label>
		       {{ $festival[0]->short_desc }}
		    </div>
		    <div class="long-desc">
		       <label>Long Description:</label>
		       {{ $festival[0]->long_desc }}
		    </div>
		    <div class="dates">
		       <label>Date:</label>
			   {{ $festival[0]->start_date }}
			   <b> {{__('festival::app.festival.to') }} </b>
			   {{ $festival[0]->end_date }}
			</div>
	    </div> 
    </div>
	
</section>
@endif
@endsection