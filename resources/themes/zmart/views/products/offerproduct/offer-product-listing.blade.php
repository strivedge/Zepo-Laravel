@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('toolbarHelper', 'Webkul\Product\Helpers\Toolbar')
@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

@push('css')
    <style type="text/css">
        .list-card .wishlist-icon i {
            padding-left: 10px;
        }

        .product-price span:first-child, .product-price span:last-child {
            font-size: 18px;
            font-weight: 600;
        }
    </style>
@endpush

@php
    if (isset($checkmode) && $checkmode && $toolbarHelper->getCurrentMode() == "list") {
        $list = true;
    }

    $productBaseImage = $productImageHelper->getProductBaseImage($product);
    $totalReviews = $reviewHelper->getTotalReviews($product);
    $avgRatings = ceil($reviewHelper->getAverageRating($product));

    $galleryImages = $productImageHelper->getGalleryImages($product);
    $priceHTML = view('shop::products.price', ['product' => $product])->render();
    
    $product->__set('priceHTML', $priceHTML);
    $product->__set('avgRating', $avgRatings);
    $product->__set('totalReviews', $totalReviews);
    $product->__set('galleryImages', $galleryImages);
    $product->__set('shortDescription', $product->short_description);
    $product->__set('firstReviewText', trans('velocity::app.products.be-first-review'));
    $product->__set('star_icon',asset('/themes/zmart/assets/images/star-gray.png'));
    $product->__set('baseUrl',url('/'));
    $product->__set('addToCartHtml', view('shop::products.add-to-cart', [
        'product'           => $product,
        'addWishlistClass'  => ! (isset($list) && $list) ? '' : '',

        'showCompare'       => core()->getConfigData('general.content.shop.compare_option') == "1"
                                ? true : false,

        'btnText'           => null,
        'moveToCart'        => null,
        'addToCartBtnClass' => '',
    ])->render());

@endphp

{!! view_render_event('bagisto.shop.products.list.card.before', ['product' => $product]) !!}
    
    @if (isset($list) && $list)
        <div class="col-12 lg-card-container list-card product-card row">
            <div class="product-image">
                <a
                    title="{{ $product->name }}"
                    href="{{ route('shop.productOrCategory.index', $product->url_key) }}">

                    <img
                        src="{{ $productBaseImage['medium_image_url'] }}"
                        :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" />
                    <div class="quick-view-in-list">
                        <product-quick-view-btn :quick-view-details="{{ json_encode($product) }}"></product-quick-view-btn>
                    </div>
                </a>
            </div>

            <div class="product-information">
                <div>
                    <div class="product-name">
                        <a
                            href="{{ route('shop.productOrCategory.index', $product->url_key) }}"
                            title="{{ $product->name }}" class="unset">

                            <span class="fs16">{{ $product->name }}</span>
                        </a>
                    </div>

                    <div class="product-price">
                        @include ('shop::products.price', ['product' => $product])
                    </div>

                    @if( $totalReviews )
                        <div class="product-rating">
                            <star-ratings ratings="{{ $avgRatings }}"></star-ratings>
                            <span>{{ $totalReviews }} {{ __('shop::app.products.ratings') }}</span>
                        </div>
                    @endif

                    <div class="cart-wish-wrap mt5">
                        @include ('shop::products.add-to-cart', [
                            'addWishlistClass'  => 'pl10',
                            'product'           => $product,
                            'addToCartBtnClass' => 'medium-padding',
                            'showCompare'       => core()->getConfigData('general.content.shop.compare_option') == "1"
                                                   ? true : false,
                        ])
                    </div>
                </div>
            </div>
        </div>
    @else
        
            <li class="items">
                <div class="content-wrap">
                    <div class="product-code">{{$product->sku}}</div>
                        <div class="img">
                            
                                 @if ($product->getTypeInstance()->haveSpecialPrice())
                                 
                                    <div class="sticker new">
                                      
                                       <span class="save">{{ __('shop::app.products.save') }}</span><span class="percentage">{{$product->getTypeInstance()->getOfferPercentage()}}%</span>
                                    </div>
                                @endif
                            @if(count($galleryImages) > 0)
                                <div class="product-imgs">
                                    @foreach($galleryImages as $image)
                                    <a
                                        href="{{ route('shop.productOrCategory.index', $product->url_key) }}"
                                        title="{{ $product->name }}"
                                        class="product-image-container">
                                            <img
                                                loading="lazy"
                                                class="card-img-top items"
                                                alt="{{ $product->name }}"
                                                src="{{ $image['large_image_url'] }}"
                                                :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" />
                                    </a>
                                    @endforeach
                                </div>
                            @else
                                <img
                                    loading="lazy"
                                    class="card-img-top"
                                    alt="{{ $product->name }}"
                                    src="{{ $productBaseImage['large_image_url'] }}"
                                    :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" />
                                @endif

                            
                        </div>    
                           
                            <div class="content">
                                <div class="star">
                                    @if ($totalReviews)
                                        <div class="product-rating">
                                            <star-ratings ratings="{{ $avgRatings }}"></star-ratings>
                                            <span class="align-top">
                                                {{ __('velocity::app.products.ratings', ['totalRatings' => $totalReviews ]) }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="product-rating">
                                            <img src="{{ asset('themes/zmart/assets/images/star-gray.png') }}">
                                        </div>
                                    @endif
                                </div>
                                <div class="product-name title">
                                    <a
                                        href="{{ route('shop.productOrCategory.index', $product->url_key) }}"
                                        title="{{ $product->name }}"
                                        class="unset">

                                        <span class="">{{ $product->name }}</span>
                                    </a>
                                </div>

                                <div class="product-price price">
                                    @include ('shop::products.offerproduct.price', ['product' => $product])
                                    <span class="including-tax">({{ __('shop::app.products.including-tax') }})</span>
                                </div>
                            </div>
                                
                                    <div class="cart-wish-wrap">
                                        @include ('shop::products.offerproduct.offer-product-add-to-cart', [
                                            'product'           => $product,
                                            'btnText'           => $btnText ?? null,
                                            'moveToCart'        => $moveToCart ?? null,
                                            'reloadPage'        => $reloadPage ?? null,
                                            'addToCartForm'     => $addToCartForm ?? false,
                                            'addToCartBtnClass' => $addToCartBtnClass ?? '',
                                            'showCompare'       => core()->getConfigData('general.content.shop.compare_option') == "1"
                                                                    ? true : false,
                                        ])
                                    </div>
                            
                </div>
            </li>
        
    @endif


{!! view_render_event('bagisto.shop.products.list.card.after', ['product' => $product]) !!}
