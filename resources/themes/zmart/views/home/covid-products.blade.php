 <?php //$categoryDetails = app('Webkul\Category\Repositories\categoryRepository')->findByPath('covid19');

 //$products = app('Webkul\Product\Repositories\ProductRepository')->getAll($categoryDetails->id)->count();


 //echo "<pre>";print_r(app('Webkul\Category\Repositories\categoryRepository')->generateIncrementId());exit; ?>
    @if (app('Webkul\Product\Repositories\ProductRepository')->getAll(5)->count())
        <section class="featured-products product-box">

            <!-- <div class="featured-heading">
                {{ __('shop::app.home.new-products') }}<br/>

                <span class="featured-seperator" style="color:lightgrey;">_____</span>
            </div> -->
            <!-- <div class="featured-grid product-grid-4"> -->
            <ul class="row">
                <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getNewProducts());exit(); ?>

                @foreach (app('Webkul\Product\Repositories\ProductRepository')->getAll(5) as $productFlat)

                    @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])

                @endforeach

            <!-- </div> -->
            </ul>

        </section>
    @else
        <div class="product-list empty">
            <h2>{{ __('shop::app.products.whoops') }}</h2>

            <p>
                No products available
            </p>
        </div>
    @endif