{!! view_render_event('bagisto.shop.products.price.before', ['product' => $product]) !!}

<!-- <div class="product-price"> -->
    <!-- {!! $product->getTypeInstance()->getPriceHtml() !!} -->
    {!! $product->getTypeInstance()->getOfferPriceHtml() !!}
<!-- </div> -->

{!! view_render_event('bagisto.shop.products.price.after', ['product' => $product]) !!}