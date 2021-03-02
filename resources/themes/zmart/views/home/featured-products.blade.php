@if (app('Webkul\Product\Repositories\ProductRepository')->getFeaturedProducts()->count())
    <section class="featured-products product-box">
        <ul class="row">
            @foreach (app('Webkul\Product\Repositories\ProductRepository')->getFeaturedProducts() as $productFlat)
                @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])
            @endforeach
        </ul>
    </section>
@endif

