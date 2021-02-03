 @extends('shop::layouts.master')

@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('productRatingHelper', 'Webkul\Product\Helpers\Review')
<?php 

 //echo "<pre>";print_r($product->count());exit; ?>
 @section('full-content-wrapper')
   @if ($product->count() > 0)
        <div class="container">
            <section class="featured-products product-box">

                <!-- <div class="featured-heading">
                    {{ __('shop::app.home.new-products') }}<br/>

                    <span class="featured-seperator" style="color:lightgrey;">_____</span>
                </div> -->
                <!-- <div class="featured-grid product-grid-4"> -->
                <ul class="row">
                    <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getNewProducts());exit(); ?>

                    @foreach ($product as $productFlat)

                        @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])

                    @endforeach

                <!-- </div> -->
                </ul>

            </section>
        </div>
    @else
        <div class="product-list empty">
            <h2>{{ __('shop::app.products.whoops') }}</h2>

            <p>
                No products available
            </p>
        </div>
    @endif
@endsection