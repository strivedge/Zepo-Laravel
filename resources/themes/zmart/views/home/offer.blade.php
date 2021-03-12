@inject ('offerRepository', 'Custom\Offer\Repositories\OfferRepository')
@php
    $offers = $offerRepository->getAllHome();
@endphp

@extends('shop::layouts.master')

@section('page_title')
	{{ __('offer::app.offer.title') }}
@endsection

<style type="text/css">
	.modal-backdrop.in { background-color:unset;height: auto;bottom: auto; }	
</style>

@section('content-wrapper')

<section class="offer">
	<div class="page-header">
    	<div class="page-title">
        	<h2>{{__('offer::app.offer.active-offers') }}</h2>
        </div>
	</div>

	@if(isset($offers) && count($offers) > 0)
		<div class="post-wrapper">
				<ul class="row">
					@foreach($offers as $offer)
					<li class="offer-post col-md-6 col-lg-4 col-xl-3">
						
						<div class="content-wrap">
								<div class="post-thumb-wrap">
									<img src="{{ asset('/').$offer->image }}" alt="{{ __('offer::app.offer.title') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'" >
								</div>
@php
	$str = strlen($offer->desc);
	if($str <= 50)
	{
		$content = $offer->desc; 
	}
	else
	{
		$content = substr($offer->desc, 0, 50).'....';
	}
@endphp
								<div class="content">
									<div class="post-title">{{ $offer->title }}</div>
									<div class="post-content"><p>{{ $content }}</p>
								@if($str >= 50)
									<a data-title="{{$offer->title}}" data-val="{{$offer->desc}}" class="open-modal btn" data-toggle="modal" data-target="#exampleModal">
									Read More</a>
								@endif
									</div>
									<div class="dates"> 
									@php 
							            $start_date = new DateTime($offer->start_date);
							            $end_date = new DateTime($offer->end_date);
							        @endphp
									<div class="start-date"> {{ $start_date->format('d/m/Y') }}</div>&nbsp;&nbsp;
									<label>{{__('offer::app.offer.to') }}</label>&nbsp;&nbsp;<div class="end-date"><label></label> {{ $end_date->format('d/m/Y') }}</div>
									</div>
								</div>
						</div>
					</li>
					@endforeach
				</ul>
        </div>
	@endif
	</section>
	<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" z-index: 100005; background-color: rgb(0, 0, 0,0.5); ">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h3></h3>
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	      </div>
	      <div class="modal-body">
	    	
	      </div>
	      
	    </div>
	  </div>
	 </div>
	  <script type="text/javascript">
	$(document).ready(function(){
		$('#exampleModal').on('show.bs.modal', function(e) {
			var title = $(e.relatedTarget).data('title');
            var bookval = $(e.relatedTarget).data('val');
  			$(this).find(".modal-body").text(bookval);
  			$(this).find(".modal-header h3").text(title);	
		});

	});
</script>

@endsection
