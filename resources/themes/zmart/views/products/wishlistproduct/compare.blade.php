{!! view_render_event('bagisto.shop.products.add_to_cart.before', ['product' => $product]) !!}

<?php //print_r($addToCartForm);exit; ?>
@if (isset($showCompare) && $showCompare)
    <compare-component
        @auth('customer')
            customer="true"
        @endif

        @guest('customer')
            customer="false"
        @endif

        slug="{{ $product->url_key }}"
        product-id="{{ $product->id }}"
        add-tooltip="{{ __('velocity::app.customer.compare.add-tooltip') }}"
    ></compare-component>
@endif

{!! view_render_event('bagisto.shop.products.add_to_cart.after', ['product' => $product]) !!}