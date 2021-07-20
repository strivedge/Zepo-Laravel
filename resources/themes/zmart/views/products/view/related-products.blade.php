<?php
    $relatedProducts = $product->related_products()->get();
?>

@if ($relatedProducts->count())
    <!-- <card-list-header
        heading="{{ __('shop::app.products.related-product-title') }}"
        view-all="false"
        row-class="pt20"
    ></card-list-header> -->
    <!-- <h2>{{ __('shop::app.products.related-product-title') }}</h2> -->

    <div class="carousel-products vc-full-screen product-box linked-products">
        
            <ul class="linked-products-content">
            @foreach ($relatedProducts as $index => $relatedProduct)
                
                    
                        @include ('shop::products.newproduct.new-product-listing', [
                            'product' => $relatedProduct
                        ])
                    
                
            @endforeach
            </ul>
    </div>

    <div class="carousel-products vc-small-screen product-box linked-products">

        
            <ul class="linked-products-content">
            @foreach ($relatedProducts as $index => $relatedProduct)
               
                    
                        @include ('shop::products.newproduct.new-product-listing', [
                            'product' => $relatedProduct
                        ])
                    
                
            @endforeach
            </ul>
    </div>
@endif