<?php
    $productUpSells = $product->up_sells()->get();
?>

@if ($productUpSells->count())
    <card-list-header
        heading="{{ __('shop::app.products.up-sell-title') }}"
        view-all="false"
        row-class="pt20"
    ></card-list-header>

    <div class="carousel-products vc-full-screen product-box">
        <carousel-component
            slides-per-page="6"
            navigation-enabled="hide"
            pagination-enabled="hide"
            id="upsell-products-carousel"
            :slides-count="{{ sizeof($productUpSells) }}">

            @foreach ($productUpSells as $index => $upSellProduct)
                <slide slot="slide-{{ $index }}">
                    <ul class="row">
                        @include ('shop::products.newproduct.new-product-listing', [
                            'product' => $upSellProduct
                        ])
                    </ul>
                </slide>
            @endforeach
        </carousel-component>
    </div>

    <div class="carousel-products vc-small-screen product-box">
        <carousel-component
            :slides-count="{{ sizeof($productUpSells) }}"
            slides-per-page="2"
            id="upsell-products-carousel"
            navigation-enabled="hide"
            pagination-enabled="hide">

            @foreach ($productUpSells as $index => $upSellProduct)
                <slide slot="slide-{{ $index }}">
                    <ul class="row">
                        @include ('shop::products.newproduct.new-product-listing', [
                            'product' => $upSellProduct
                        ])
                    </ul>
                </slide>
            @endforeach
        </carousel-component>
    </div>
@endif