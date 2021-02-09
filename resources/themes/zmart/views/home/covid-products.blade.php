 <?php $categoryDetails = app('Webkul\Category\Repositories\CategoryRepository')->findByPath('covid19');


 //echo "<pre>";print_r(app('Webkul\Category\Repositories\categoryRepository')->findByPath('covid19')->count());exit; ?>
 @if(!empty($categoryDetails))
    @if (app('Webkul\Product\Repositories\ProductRepository')->getAll($categoryDetails->id)->count())
        <section class="featured-products product-box">

            <ul class="row">

                @foreach (app('Webkul\Product\Repositories\ProductRepository')->getAll($categoryDetails->id) as $productFlat)

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