{!! view_render_event('bagisto.shop.products.price.before', ['product' => $product]) !!}
    {!! $product->getTypeInstance()->getOfferPriceHtml() !!}
{!! view_rend1er_event('bagisto.shop.products.price.after', ['product' => $product]) !!}