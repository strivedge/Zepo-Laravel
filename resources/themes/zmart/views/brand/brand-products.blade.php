 @extends('shop::layouts.master')

@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('productRatingHelper', 'Webkul\Product\Helpers\Review')

 @section('full-content-wrapper')
   @if ($product->count() > 0)
        <div class="container">
            <section class="featured-products product-box">

                <ul class="row">
                    @foreach ($product as $productFlat)

                        @include ('shop::products.newproduct.new-product-listing', ['product' => $productFlat])

                    @endforeach
                </ul>

            </section>
        </div>
    @else
        <div class="product-list empty">
            <h2>{{ __('shop::app.products.whoops') }}</h2>

            <p>
                {{ __('shop::app.home.brand-no-products') }}
            </p>
        </div>
    @endif
@endsection