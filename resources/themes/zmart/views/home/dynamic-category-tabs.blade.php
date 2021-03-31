 <?php $categoryDetails = app('Webkul\Category\Repositories\CategoryRepository')->findByPathDynamic($category); ?>

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
                {{ __('shop::app.products.no-products-available') }}
            </p>
        </div>
    @endif
@endif