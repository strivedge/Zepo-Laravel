@inject ('offerRepository', 'Custom\Offer\Repositories\OfferRepository')

@php
    $offers = $offerRepository->all();
@endphp

@if(isset($offers) && count($offers) > 0)
<section class="offers featured-products">

    <div class="container">
    <div class="section-title"><h2>{{__('offer::app.offer.active-offers') }}</h2></div>
        <ul>
            @foreach($offers as $offer)  
                <li class="col-lg-4 col-xl-3 img">
                    <img src="{{ asset('/').$offer->image }}" alt="{{__('offer::app.offer.active-offers') }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                </li>
                <li class="col-lg-8 col-xl-9 content-offers">
                    <div class="content col-lg-12 col-xl-9">
                        {{ $offer->title }}
                        <!-- for date formatting -->
                        @php 
                            $start_date = new DateTime($offer->start_date);
                            $end_date = new DateTime($offer->end_date);
                        @endphp
                        <span>{{__('offer::app.offer.from') }} {{ $start_date->format('d/m/Y') }} {{__('offer::app.offer.to') }} {{ $end_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="col-lg-12 col-xl-3 buttons">
                        <a href="{{ route('shop.home.offer') }}">{{__('offer::app.offer.view-all-offers') }}</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

</section>
@endif