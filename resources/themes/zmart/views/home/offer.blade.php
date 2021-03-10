@inject ('offerRepository', 'Custom\Offer\Repositories\OfferRepository')
@php
    $offers = $offerRepository->getAllHome();
@endphp

@extends('shop::layouts.master')

@section('page_title')
	{{ __('offer::app.offer.title') }}
@endsection

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
								<div class="content">
									<div class="post-title">{{ $offer->title }}</div>
									<div class="post-content"><p>{{ $offer->desc }}</p></div>
									@php 
							            $start_date = new DateTime($offer->start_date);
							            $end_date = new DateTime($offer->end_date);
							        @endphp
									<div class="start-date"><label>{{__('offer::app.offer.from') }}</label> <b>:</b> {{ $start_date->format('d/m/Y') }}</div>
									<div class="end-date"><label>{{__('offer::app.offer.to') }}</label> <b>:</b> {{ $end_date->format('d/m/Y') }}</div>
								</div>
								<div class="buttons">
									<a data-val="{{$offer->id}}" class="open-modal btn btn-primary" data-toggle="modal" data-target="#exampleModal">
									Offer Details
									</a>
								</div>
						</div>
					</li>
					@endforeach
				</ul>
        </div>
	@endif
	</section>
	<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style=" z-index: 100005; ">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	      </div>
	      <div class="modal-body">
	    	
	      </div>
	      
	    </div>
	  </div>
	  <script type="text/javascript">
	$(document).ready(function(){
		/*$(document).on("click",".open-modal", function () {
		    var myBookId = $(this).data('id');
		    console.log(myBookId);
		    $("#exampleModal .modal-body").val( myBookId );
		});*/
		$('#exampleModal').on('show.bs.modal', function(e) {
		    var bookId = $(".open-modal").val();
		    console.log(bookId);
		    /*$(e.currentTarget).find('.modal-body').text(bookId);
		    var str = "You Have Entered "  
                + "bookId: " + bookId;*/
            $(".modal_body").html(bookId);

		});
	});
</script>
@endsection
