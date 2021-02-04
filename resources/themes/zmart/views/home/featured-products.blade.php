<?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getFeaturedProductsImages(102)); exit(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getFeaturedProducts()->count())
    <section class="featured-products product-box">

        <ul class="row">
            <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getNewProducts());exit(); ?>

            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getFeaturedProducts() as $productFlat)
            
                @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])

            @endforeach
        </ul>

    </section>
@endif

