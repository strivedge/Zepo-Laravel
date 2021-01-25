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
           <!--  <li class="column"> -->
                
                        <li class="col-md-3 img">
                            <img src="{{ asset('uploadImages/offer/'.$offer->image) }}" alt="{{ __('shop::app.home.active-offers') }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                        </li>
                        <li class="col-md-7 content-offers">
                            <div class="content">
                                {{ $offer->desc }}
                                <!-- for date formatting -->
                                @php 
                                    $start_date = new DateTime($offer->start_date);
                                    $end_date = new DateTime($offer->end_date);
                                @endphp
                                <span>From {{ $start_date->format('d-m-Y') }} to {{ $end_date->format('d-m-Y') }}</span>
                            </div>
                        </li>
                        <li class="col-md-2 buttons">
                                <a href="#">View all Offers</a>
                        </li>

            <!-- </li> -->
        @endforeach
        @else
        <li class="column">
            <p>No Offers...!</p>
        </li>
        @endif
        </ul>
    </div>

</section>