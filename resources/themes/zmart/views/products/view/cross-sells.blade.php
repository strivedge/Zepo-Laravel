@foreach ($cart->items as $item)
    <?php
        $product = $item->product;

        if ($product->cross_sells()->count()) {
            $products[] = $product;
            $products = array_unique($products);
        }
    ?>
@endforeach

@if (isset($products))

    <card-list-header
        heading="{{ __('shop::app.products.cross-sell-title') }}"
        view-all="false"
        row-class="pt20"
    ></card-list-header>

    <div class="carousel-products vc-full-screen product-box">
        <carousel-component
            slides-per-page="6"
            navigation-enabled="hide"
            pagination-enabled="hide"
            id="upsell-products-carousel"
            :slides-count="{{ $product->cross_sells()->count() }}">
            
            @foreach($products as $product)
                @foreach ($product->cross_sells()->paginate(2) as $index => $crossSellProduct)
                    <slide slot="slide-{{ $index }}">
                        <ul class="row">
                            @include ('shop::products.newproduct.new-product-listing', [
                                'product' => $crossSellProduct
                            ])
                        </ul>
                    </slide>
                @endforeach
            @endforeach
        </carousel-component>
    </div>

    <div class="carousel-products vc-small-screen product-box">
        <carousel-component
            :slides-count="{{ $product->cross_sells()->count() }}"
            slides-per-page="2"
            id="upsell-products-carousel"
            navigation-enabled="hide"
            pagination-enabled="hide">

            @foreach($products as $product)
                @foreach ($product->cross_sells()->paginate(2) as $index => $crossSellProduct)
                    <slide slot="slide-{{ $index }}">
                        <ul class="row">
                            @include ('shop::products.newproduct.new-product-listing', [
                                'product' => $crossSellProduct
                            ])
                        </ul>
                    </slide>
                @endforeach
            @endforeach
        </carousel-component>
    </div>
@endif