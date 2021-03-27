<?php $festival = app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts()->count())
   <section class="featured-products sales">
        <div class="container">
            <div class="salesoffers-addtocart">
                <div class="col-md-12 col-lg-3 salesoffers">
                    <div class="imgs"><img src="{{ asset($festival[0]->image) }}"></div>
                    <div class="salesoffers-content">
                    <p>{{ $festival[0]->title }}<br/>
                        {{ $festival[0]->short_desc }}<br/>
                        {{ $festival[0]->long_desc }}<br/>
                        <a href="#" class="promotion btn btn-primary">{{ __('festival::app.festival.more-about-promotion') }}</a></p>

                    @php $end_date = $festival[0]->end_date.' '.'00:00:00'; @endphp

                
                    <div class="countdown show" data-Date='{{ $end_date }}'>
                        <div class="running">
                            <timer class="imgs">
                            <div class="common-timing"> 
                                <div class="daysC1 timings"></div>
                                <div class="daysC2 timings"></div>
                                <span>Days</span>
                            </div>
                            <span class="colon">:</span>
                            <div class="common-timing">
                                <div class="hoursC1 timings"></div>
                                <div class="hoursC2 timings"></div>
                                <span>hours</span>
                            </div>
                            <span class="colon">:</span>
                             <div class="common-timing">
                                <div class="minutesC1 timings"></div>
                                <div class="minutesC2 timings"></div>
                                <span>minutes</span>
                            </div>
                            <span class="colon">:</span>
                             <div class="common-timing">
                                <div class="secondsC1 timings"></div>
                                <div class="secondsC2 timings"></div>
                                <span>seconds</span>
                            </div>
                           
                            </timer>
                            <div class="break"></div>
                        <div class="ended">
                            <div class="text">Offer is ended</div>
                            <div class="break"></div>
                        </div>
                           
                        </div>
                    </div>
                        
                    
                    <a href="#" class="active-promotion btn btn-primary">
                        {{ __('festival::app.festival.active-promotions') }}<span><i class="bx bx-right-arrow-alt"></i></span>
                    </a>
                    </div>
                </div>

                <div class="featured-grid product-grid-4 col-md-12 col-lg-9">
                    <ul class="card grid-card product-card-new addtocart">
                    @foreach (app('Webkul\Product\Repositories\ProductRepository')->getFestivalProducts() as $productFlat)
                        @include ('shop::products.offerproduct.offer-product-listing', ['product' => $productFlat])
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endif
