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
                    <div class="imgs"><img src="{{ asset('themes/zmart/assets/images/sales-timing.png') }}"></div>
                    <a href="#" class="active-promotion btn btn-primary">
                        Active promotions<span><i class="bx bx-right-arrow-alt"></i></span>
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
   
@else
    <!-- <div class="product-list empty">
        <h2>{{ __('shop::app.products.whoops') }}</h2>

        <p>
            No products available
        </p>
    </div> -->
@endif