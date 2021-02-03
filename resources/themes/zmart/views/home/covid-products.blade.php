 <?php $categoryDetails = app('Webkul\Category\Repositories\CategoryRepository')->findByPath('covid19');

//$products = app('Webkul\Product\Repositories\ProductRepository')->getAll($categoryDetails->id)->count();

 //echo "<pre>";print_r(app('Webkul\Category\Repositories\categoryRepository')->findByPath('covid19')->count());exit; ?>
 @if(!empty($categoryDetails))
    @if (app('Webkul\Product\Repositories\ProductRepository')->getAll($categoryDetails->id)->count())
        <section class="featured-products product-box">

            <ul class="row">
                <?php //echo"<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getNewProducts());exit(); ?>

                @foreach (app('Webkul\Product\Repositories\ProductRepository')->getAll($categoryDetails->id) as $productFlat)

                <?php //echo"covid<pre>";print_r($product);exit(); ?>

                    @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])

                @endforeach

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
@endif