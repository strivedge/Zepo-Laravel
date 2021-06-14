{!! view_render_event('bagisto.shop.products.add_to_cart.before', ['product' => $product]) !!}


@if (! (isset($showWishlist) && !$showWishlist))
    @include('shop::products.offerproduct.offer-product-wishlist', [
        'addClass' => $addWishlistClass ?? ''
    ])
@endif

{!! view_render_event('bagisto.shop.products.add_to_cart.after', ['product' => $product]) !!}