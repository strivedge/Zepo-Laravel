{!! view_render_event('bagisto.shop.products.add_to_cart.before', ['product' => $product]) !!}

<div class="buttons">
    <div class="add-to-cart-btn  add-to-cart btn btn-primary">
        @if (isset($form) && !$form)
            <button
                type="submit"
                {{ ! $product->isSaleable() ? 'disabled' : '' }}
                class="theme-btn {{ $addToCartBtnClass ?? '' }}">

                @if (! (isset($showCartIcon) && !$showCartIcon))
                    <i class="material-icons text-down-3">shopping_cart</i>
                @endif

                {{ ($product->type == 'booking') ?  __('shop::app.products.book-now') :  __('shop::app.products.add-to-cart') }}
            </button>
        @elseif(isset($addToCartForm) && !$addToCartForm)
        <!-- offer add to cart -->
            <form
                method="POST"
                action="{{ route('cart.add', $product->product_id) }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                <input type="hidden" name="quantity" value="1">
                <button
                    type="submit"
                    {{ ! $product->isSaleable() ? 'disabled' : '' }}
                    class="btn btn-add-to-cart {{ $addToCartBtnClass ?? '' }}">

                    @if (! (isset($showCartIcon) && !$showCartIcon))
                        <i class="material-icons text-down-3">shopping_cart</i>
                    @endif

                    <span class="text-uppercase">
                        {{ ($product->type == 'booking') ?  __('shop::app.products.book-now') : $btnText ?? __('shop::app.products.add-to-cart') }}
                    </span>
                </button>
            </form>
        @else
            <add-to-cart
                form="true"
                csrf-token='{{ csrf_token() }}'
                product-flat-id="{{ $product->id }}"
                product-id="{{ $product->product_id }}"
                reload-page="{{ $reloadPage ?? false }}"
                move-to-cart="{{ $moveToCart ?? false }}"
                add-class-to-btn="{{ $addToCartBtnClass ?? '' }}"
                is-enable={{ ! $product->isSaleable() ? 'false' : 'true' }}
                show-cart-icon={{ !(isset($showCartIcon) && !$showCartIcon) }}
                btn-text="{{ ($product->type == 'booking') ?  __('shop::app.products.book-now') : $btnText ?? __('shop::app.products.add-to-cart') }}">
            </add-to-cart>
        @endif
    </div>
</div>

{!! view_render_event('bagisto.shop.products.add_to_cart.after', ['product' => $product]) !!}