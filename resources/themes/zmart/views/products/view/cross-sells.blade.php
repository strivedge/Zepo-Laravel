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

    <div class="carousel-products vc-full-screen product-box linked-products">
        
            <ul class="linked-products-content">
            @foreach($products as $product)
                @foreach ($product->cross_sells()->paginate(2) as $index => $crossSellProduct)
                    
                            @include ('shop::products.newproduct.new-product-listing', [
                                'product' => $crossSellProduct
                            ])
                        
                @endforeach
            @endforeach
            </ul>
    </div>

    <div class="carousel-products vc-small-screen product-box linked-products">
        
            <ul class="linked-products-content">
            @foreach($products as $product)
                @foreach ($product->cross_sells()->paginate(2) as $index => $crossSellProduct)
                    
                            @include ('shop::products.newproduct.new-product-listing', [
                                'product' => $crossSellProduct
                            ])
                        
                @endforeach
            @endforeach
            </ul>
        
    </div>
@endif