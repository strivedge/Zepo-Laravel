<?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getFeaturedProductsImages(102)); exit(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getFeaturedProducts()->count())
    <section class="featured-products product-box">

        <!-- <div class="featured-heading">
            {{ __('shop::app.home.new-products') }}<br/>

            <span class="featured-seperator" style="color:lightgrey;">_____</span>
        </div> -->
        <!-- <div class="featured-grid product-grid-4"> -->
        <ul class="row">
            <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getNewProducts());exit(); ?>

            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getFeaturedProducts() as $productFlat)

                @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])

            @endforeach

        <!-- </div> -->
        </ul>

    </section>
@endif

