@inject ('offerRepository', 'Custom\Offer\Repositories\OfferRepository')
@php
    $offers = $offerRepository->all();
@endphp
<section class="offers featured-products">

    <div class="container">
    <div class="section-title"><h2>{{ __('shop::app.home.active-offers') }}</h2></div>
        <ul>
    @if(isset($offers) && count($offers) > 0)
        @foreach($offers as $offer)
                
                        <li class="col-lg-4 col-xl-3 img">
                            <img src="{{ asset('/').$offer->image }}" alt="{{ __('shop::app.home.active-offers') }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                        </li>
                        <li class="col-lg-8 col-xl-9 content-offers">
                            <div class="content col-lg-12 col-xl-9">
                                {{ $offer->title }}
                                <!-- for date formatting -->
                                @php 
                                    $start_date = new DateTime($offer->start_date);
                                    $end_date = new DateTime($offer->end_date);
                                @endphp
                                <span>From {{ $start_date->format('d/m/Y') }} to {{ $end_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="col-lg-12 col-xl-3 buttons">
                                <a href="#">View all Offers</a>
                            </div>
                        </li>

        @endforeach
        @else
        <li class="column content-offers col-12 errors">
            <div class="content col-12 text-center">
                No Offers...!
            </div>
        </li>
        @endif
        </ul>
    </div>

</section>