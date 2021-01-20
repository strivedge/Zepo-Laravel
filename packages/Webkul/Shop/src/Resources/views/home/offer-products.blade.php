@if (app('Webkul\Product\Repositories\ProductRepository')->getOfferedProducts()->count())
    <section class="featured-products">

        <div class="featured-heading">
            {{ __('shop::app.home.featured-products') }}<br/>

            <span class="featured-seperator" style="color:lightgrey;">_____</span>
        </div>

        <div class="featured-grid product-grid-4">
            <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getOfferedProducts());exit(); ?>

            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getOfferedProducts() as $productFlat)

                @include ('shop::products.list.card', ['product' => $productFlat])

            @endforeach
</section>