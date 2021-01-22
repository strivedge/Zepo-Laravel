@if (app('Webkul\Product\Repositories\ProductRepository')->getNewProducts()->count())
    <section class="featured-products">

        <div class="featured-heading">
            {{ __('shop::app.home.new-products') }}<br/>

            <span class="featured-seperator" style="color:lightgrey;">_____</span>
        </div>
        <div class="featured-grid product-grid-4">
            <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getNewProducts());exit(); ?>

            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getNewProducts() as $productFlat)

                @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])

            @endforeach

        </div>

    </section>
@endif
