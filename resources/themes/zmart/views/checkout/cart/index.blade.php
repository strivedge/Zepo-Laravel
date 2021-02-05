@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.checkout.cart.title') }}
@stop

@section('content-wrapper')
    <cart-component></cart-component>
@endsection

@push('css')
    <style type="text/css">
        .quantity {
            width: unset;
            float: right;
        }
    </style>
@endpush

@push('scripts')
    @include('shop::checkout.cart.coupon')

    <script type="text/x-template" id="cart-template">
        
            <section class="cart-details cart-details-full no-margin col-12">
                <h2 class="fw6 col-12">{{ __('shop::app.checkout.cart.title') }}</h2>

                @if ($cart)
                    <div class="cart-details-header col-md-12">
                        <div class="row cart-header col-12 no-padding">
                            <span class="col-9 fw6 fs16 pr0">
                                {{ __('velocity::app.checkout.items') }}
                            </span>

                            <span class="col-1 fw6 fs16 no-padding">
                                {{ __('velocity::app.checkout.qty') }}
                            </span>

                            <span class="col-2 fw6 fs16 pr0">
                                {{ __('velocity::app.checkout.subtotal') }}
                            </span>
                        </div>

                        <div class="cart-content col-12">
                            <form
                                method="POST"
                                @submit.prevent="onSubmit"
                                action="{{ route('shop.checkout.cart.update') }}">

                                <div class="cart-item-list">
                                    @csrf

                                    @foreach ($cart->items as $key => $item)

                                        @php
                                            $productBaseImage = $item->product->getTypeInstance()->getBaseImage($item);
                                            $product = $item->product;

                                            $productPrice = $product->getTypeInstance()->getProductPrices();

                                            if (is_null ($product->url_key)) {
                                                if (! is_null($product->parent)) {
                                                    $url_key = $product->parent->url_key;
                                                }
                                            } else {
                                                $url_key = $product->url_key;
                                            }

                                        @endphp

                                        <div class="col-12 cart-product-details no-padding" v-if="!isMobileDevice">
                                            <div class="col-2 no-padding product-image">
                                                <a
                                                    title="{{ $product->name }}"
                                                    class="product-image-container col-2"
                                                        href="{{ route('shop.productOrCategory.index', $url_key) }}">

                                                    <img
                                                        class="card-img-top"
                                                        alt="{{ $product->name }}"
                                                        src="{{ $productBaseImage['large_image_url'] }}"
                                                        :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`">
                                                </a>
                                            </div>

                                            <div class="product-details-content col-7">
                                                <div class="item-title no-margin">
                                                    <a
                                                        href="{{ route('shop.productOrCategory.index', $url_key) }}"
                                                        title="{{ $product->name }}"
                                                        class="unset col-12">

                                                        <span class="fs20 fw6 link-color prodcut-name">{{ $product->name }}</span>
                                                    </a>
                                                </div>

                                                @if (isset($item->additional['attributes']))
                                                    @foreach ($item->additional['attributes'] as $attribute)
                                                        <div class="col-12 no-padding no-margin display-block">
                                                            <label class="no-margin">
                                                                {{ $attribute['attribute_name'] }} :
                                                            </label>
                                                            <span>
                                                                {{ $attribute['option_label'] }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                @endif

                                                <div class="col-12 no-padding no-margin">
                                                    @include ('shop::products.price', ['product' => $product])
                                                </div>

                                                @php
                                                    $moveToWishlist = trans('shop::app.checkout.cart.move-to-wishlist');
                                                @endphp

                                                <div class="no-padding col-12 wishlist-delete cursor-pointer fs16">
                                                    @auth('customer')
                                                        @if ($item->parent_id != 'null' ||$item->parent_id != null)
                                                            @include('shop::checkout.cart.wishlist', [
                                                                'route' => route('shop.movetowishlist', $item->id),
                                                                'text' => ""
                                                            ])
                                                        @else
                                                            @include('shop::checkout.cart.wishlist', [
                                                                'route' => route('shop.movetowishlist', $item->child->id),
                                                                'text' => ""
                                                            ])
                                                        @endif
                                                    @endauth

                                                    @guest('customer')
                                                        @include('shop::checkout.cart.wishlist', [
                                                            'isMoveToWishlist' => route('shop.checkout.cart.remove', ['id' => $item->id]),
                                                            'text' => ""
                                                        ])
                                                    @endguest

                                                    <a
                                                        class="unset
                                                            @auth('customer')
                                                                ml10
                                                            @endauth
                                                        "
                                                        href="{{ route('shop.checkout.cart.remove', ['id' => $item->id]) }}"
                                                        @click="removeLink('{{ __('shop::app.checkout.cart.cart-remove-action') }}')">

                                                        <span class="rango-delete fs24"></span>
                                                        
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="product-quantity col-1 no-padding">
                                                <quantity-changer
                                                    :control-name="'qty[{{$item->id}}]'"
                                                    quantity="{{ $item->quantity }}">
                                                </quantity-changer>
                                            </div>

                                            <div class="product-price fs18 col-2 text-center">
                                                <span class="card-current-price fw6 mr10">
                                                    {{ core()->currency( $item->base_total) }}
                                                </span>
                                            </div>

                                            @if (! cart()->isItemHaveQuantity($item))
                                                <div class="control-error mt-4 fs16 fw6">
                                                    * {{ __('shop::app.checkout.cart.quantity-error') }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-12 cart-product-details" v-else>
                                            <div class="col-2 no-padding product-image">
                                                <a
                                                    title="{{ $product->name }}"
                                                    class="product-image-container"
                                                    href="{{ route('shop.productOrCategory.index', $url_key) }}">

                                                    <img
                                                        src="{{ $productBaseImage['medium_image_url'] }}"
                                                        class="card-img-top"
                                                        alt="{{ $product->name }}">
                                                </a>
                                            </div>

                                            <div class="col-10 item-title">
                                                <a
                                                    href="{{ route('shop.productOrCategory.index', $url_key) }}"
                                                    title="{{ $product->name }}"
                                                    class="unset col-12">

                                                    <span class="fs20 fw6 link-color prodcut-name">{{ $product->name }}</span>
                                                </a>

                                                @if (isset($item->additional['attributes']))
                                                    <div class="col-12 no-padding no-margin">

                                                        @foreach ($item->additional['attributes'] as $attribute)
                                                            <b>{{ $attribute['attribute_name'] }} : </b>{{ $attribute['option_label'] }}</br>
                                                        @endforeach

                                                    </div>
                                                @endif

                                                <div class="col-12 no-padding">
                                                    @include ('shop::products.price', ['product' => $product])
                                                </div>

                                                <div class="col-12 remove-padding-margin actions">
                                                    <div class="product-quantity col-lg-4 col-6 no-padding">
                                                        <quantity-changer
                                                            :control-name="'qty[{{$item->id}}]'"
                                                            quantity="{{ $item->quantity }}">
                                                        </quantity-changer>
                                                    </div>

                                                    <div class="col-4 cursor-pointer text-down-4">
                                                        <a href="{{ route('shop.checkout.cart.remove', ['id' => $item->id]) }}" class="unset">
                                                            <i class="material-icons fs24">delete</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    @endforeach
                                </div>
                                <div class="col-md-12 coupon-buttons"><!-- row  -->
                                    <div class="col-md-8">
                                        <coupon-component></coupon-component>
                                    </div>
                                    <div class="col-md-4 continue-update-buttons">
                                        {!! view_render_event('bagisto.shop.checkout.cart.controls.after', ['cart' => $cart]) !!}
                                            <a
                                                class="link-color remove-decoration fs16 no-padding theme-btn"
                                                href="{{ route('shop.home.index') }}">
                                                {{ __('shop::app.checkout.cart.continue-shopping') }}
                                            </a>

                                            <button
                                                type="submit"
                                                class="theme-btn light pull-right unset">

                                                {{ __('shop::app.checkout.cart.update-cart') }}
                                            </button>
                                        {!! view_render_event('bagisto.shop.checkout.cart.controls.after', ['cart' => $cart]) !!}
                                    </div>
                                </div>
                            </form>
                        </div>

                        @include ('shop::products.view.cross-sells')
                    </div>
                @endif

                {!! view_render_event('bagisto.shop.checkout.cart.summary.after', ['cart' => $cart]) !!}

                    @if ($cart)
                        <div class="col-lg-4 col-md-12 order-summary-container pull-right">
                            @include('shop::checkout.total.summary', ['cart' => $cart])

                            
                        </div>
                    @else
                        <div class="text-center">
                            <div class="fs16 col-12 empty-cart-message">
                                {{ __('shop::app.checkout.cart.empty') }}
                            </div>
                            <div class="mt15 col-12">
                                <a
                                    class="fs16 remove-decoration continue-shopping"
                                    href="{{ route('shop.home.index') }}">

                                    <button type="button" class="theme-btn remove-decoration">
                                        {{ __('shop::app.checkout.cart.continue-shopping') }}
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif

                {!! view_render_event('bagisto.shop.checkout.cart.summary.after', ['cart' => $cart]) !!}

            </section>
        
    </script>

    <script type="text/javascript" id="cart-template">
        (() => {
            Vue.component('cart-component', {
                template: '#cart-template',
                data: function () {
                    return {
                        isMobileDevice: this.isMobile(),
                    }
                },

                methods: {
                    removeLink(message) {
                        if (! confirm(message))
                            event.preventDefault();
                    }
                }
            })
        })()
    </script>
@endpush