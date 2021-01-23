<?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getOfferedProducts());exit(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getOfferedProducts()->count())
   <section class="featured-products sales">
        <div class="container">
            <!-- <div class="featured-heading">
                {{ __('shop::app.home.offer-products') }}<br/>

                <span class="featured-seperator" style="color:lightgrey;">_____</span>
            </div> -->

            <div class="salesoffers-addtocart">
                                <div class="col-md-3 salesoffers">
                                    <div class="imgs"><img src="{{ asset('themes/zmart/assets/images/sales-new-year.png') }}"></div>
                                    <div class="salesoffers-content">
                                    <p>New Year Sale is Live !<br/>
                                       Don't Missout.<br/>
                                       Lowest Price on selected products!<br/>
                                       <a href="#" class="promotion btn btn-primary">More about promotion</a></p>
                                    <div class="imgs"><img src="{{ asset('themes/zmart/assets/images/sales-timing.png') }}"></div>
                                    <a href="#" class="active-promotion btn btn-primary">
                                        Active promotions<span><i class="bx bx-right-arrow-alt"></i></span>
                                    </a>
                                    </div>
                                </div>

            
                                <div class="featured-grid product-grid-4 col-md-9">
                                    <ul class="card grid-card product-card-new addtocart">
                                    <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getOfferedProducts());exit(); ?>

                                    @foreach (app('Webkul\Product\Repositories\ProductRepository')->getOfferedProducts() as $productFlat)

                                        @include ('shop::products.offerproduct.offer-product-listing', ['product' => $productFlat])

                                    @endforeach
                                    </ul>

                                </div>
            </div>
        </div>

    </section>
    <!-- <section class="sales">
                    <div class="container">
                        <div class="salesoffers-addtocart">
                            <div class="col-md-3 salesoffers">
                                <div class="imgs"><img src="{{ asset('themes/zepomart/assets/images/sales-new-year.png') }}"></div>
                                <div class="salesoffers-content">
                                <p>New Year Sale is Live !<br/>
                                   Don't Missout.<br/>
                                   Lowest Price on selected products!<br/>
                                   <a href="#" class="promotion btn btn-primary">More about promotion</a></p>
                                <div class="imgs"><img src="{{ asset('themes/zepomart/assets/images/sales-timing.png') }}"></div>
                                <a href="#" class="active-promotion btn btn-primary">
                                    Active promotions<span><i class="bx bx-right-arrow-alt"></i></span>
                                </a>
                                </div>
                            </div>

                            <?php //echo "string<pre>"; print_r(app('Custom\Testinominal\Models\Testinominal')->getAll());exit(); ?>

                            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getOfferedProducts() as $productFlat)

                                @include ('shop::products.list.card', ['product' => $productFlat])

                            @endforeach

                        </div>
                    </div>
                </section> -->
@endif