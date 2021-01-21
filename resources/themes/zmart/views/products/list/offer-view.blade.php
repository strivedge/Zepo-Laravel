<section class="offers featured-products">

    <div class="container">
    <div class="section-title"><h2>{{ $offers_title }}</h2></div>
        <ul>
    @if(isset($offers) && count($offers) > 0)
        @foreach($offers as $offer)
           <!--  <li class="column"> -->
                
                        <li class="col-md-3 img">
                            <img src="{{ asset('uploadImages/offer/'.$offer->image) }}" alt="{{ __('shop::app.home.offers-products') }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                        </li>
                        <!-- <h3>{{ $offer->title }}</h3> -->
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

<!-- <section class="offers featured-products">

    <div class="featured-grid product-grid-4 ">
        <div class="section-title"><h2>{{ $offers_title }}</h2></div>
        
            @if(isset($offers) && count($offers) > 0)
            <ul class="">
                @foreach($offers as $offer)
                <li class="col-md-3 img">
                            <img src="{{ asset('uploadImages/offer/'.$offer->image) }}" alt="{{ __('shop::app.home.offers-products') }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                </li>
                <li class="col-md-7 content-offers">
                                <div class="content">
                                    <p>{{ $offer->desc }}</p>
                                    <span>From {{ $offer->start_date }} to {{ $offer->end_date }}</span>
                                </div>
                            </li>
                             <h3>{{ $offer->title }}</h3>                      
                        </div>
                    </div>
                </li>
                <li class="col-md-2 buttons">
                                <a href="#">View all Offers</a>
                </li>
                @endforeach
                @else
                <li class="col-md-12">
                    
                        <p>No Offers...!</p>
                   
                </li>
                </ul>
                @endif
        
    </div>

</section>  -->