@inject ('offerRepository', 'Custom\Offer\Repositories\OfferRepository')
<?php
$offers = $offerRepository->all();
?>
<section class="offers featured-products">

    <div class="container">
    <div class="section-title"><h2>Active Offers</h2></div>
        <ul>
    @if(isset($offers) && count($offers) > 0)
        @foreach($offers as $offer)
           <!--  <li class="column"> -->
                
                        <li class="col-md-3 img">
                            <img src="{{ asset('uploadImages/offer/'.$offer->image) }}" alt="{{ __('shop::app.home.offers-products') }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                        </li>
                        <li class="col-md-7 content-offers">
                            <div class="content">
                                {{ $offer->desc }}
                                <span>From {{ $offer->start_date }} to {{ $offer->end_date }}</span>
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