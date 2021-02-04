<?php 
//echo"payal<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getTopSellingProducts());exit(); ?>
@if (app('Webkul\Product\Repositories\ProductRepository')->getTopSellingProducts()->count())
    <section class="featured-products product-box">
        <ul class="row">
            <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getNewProducts());exit(); ?>

            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getTopSellingProducts() as $productFlat)

            <?php //echo"<pre>";print_r($product);exit(); ?>

                @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])

            @endforeach

        </ul>

    </section>
@endif
