<?php
    $productUpSells = $product->up_sells()->get();
?>

@if ($productUpSells->count())
    <card-list-header
        heading="{{ __('shop::app.products.up-sell-title') }}"
        view-all="false"
        row-class="pt20"
    ></card-list-header>

    <div class="carousel-products vc-full-screen product-box linked-products">
        
            <ul class="linked-products-content">
            @foreach ($productUpSells as $index => $upSellProduct)
                
                        @include ('shop::products.newproduct.new-product-listing', [
                            'product' => $upSellProduct
                        ])
                   
            @endforeach
            </ul>
    </div>

    <div class="carousel-products vc-small-screen product-box linked-products">
        
            <ul class="linked-products-content">
            @foreach ($productUpSells as $index => $upSellProduct)
                
                        @include ('shop::products.newproduct.new-product-listing', [
                            'product' => $upSellProduct
                        ])
                    
            @endforeach
            </ul>
    </div>
@endif