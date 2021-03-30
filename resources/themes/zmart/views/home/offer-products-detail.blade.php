@extends('shop::layouts.master')

@section('page_title')
	{{ __('festival::app.festival.more-about-promotion') }}
@endsection

@section('content-wrapper')

<?php $festival = app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts()->count())
<b>{{ __('festival::app.festival.more-about-promotion') }}</b>
	<p>{{ $festival[0]->title }}<br/>
	    {{ $festival[0]->short_desc }}<br/>
	    {{ $festival[0]->long_desc }}<br/>
	    {{ $festival[0]->start_date }}<br/>
	    {{ $festival[0]->end_date }}<br/>
    </p>
@endif
@endsection