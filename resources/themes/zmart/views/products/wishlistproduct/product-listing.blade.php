@inject ('reviewHelper', 'Webkul\Product\Helpers\Review')
@inject ('toolbarHelper', 'Webkul\Product\Helpers\Toolbar')
@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
<?php //echo "payal<pre>"; print_r($image_total);exit(); ?>
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
 //echo"<pre>";print_r($toolbarHelper->getCurrentMode());exit(); 
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
<?php //echo"<pre>";print_r($product);exit(); ?>
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
                            <span>{{ $totalReviews }} Ratings</span>
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
    <?php //echo "<pre>";print_r($product->sku);exit(); ?>
    <!-- offer add to cart -->
        <!-- <div class="card grid-card product-card-new"> -->
        <li class="">
            <div class="content-wrap">
                <div class="product-code">{{$product->sku}}</div>
                <div class="img">
                    <!-- <div class=""> -->
                        
                            
                                @if ($product->getTypeInstance()->haveSpecialPrice())
                                    <?php //echo"Test<pre>";print_r($product->getTypeInstance()->getOfferPercentage());exit; ?>
                                    <div class="sticker new">
                                      <!-- <span class="new"> {{ __('shop::app.products.new') }}</span> -->
                                       <span class="save">SAVE</span><span class="percentage">{{$product->getTypeInstance()->getOfferPercentage()}}%</span>
                                    </div>
                                @endif
                                 <?php //echo "<pre>ttt"; print_r($galleryImages);exit(); ?>
                                @if(count($galleryImages) > 0)
                                <div class="product-imgs">
                                   @foreach($galleryImages as $image)

                                   <?php //echo "<pre>ttt"; print_r($image['path']);
                                   //echo "<pre>"; print_r($productBaseImage['large_image_url']);exit(); ?>
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

                               <!--  <img
                                    loading="lazy"
                                    class="card-img-top"
                                    alt="{{ $product->name }}"
                                    src="{{ $productBaseImage['large_image_url'] }}"
                                    :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" /> -->

                                    <!-- {{-- <product-quick-view-btn :quick-view-details="product"></product-quick-view-btn> --}}
                                    <product-quick-view-btn :quick-view-details="{{ json_encode($product) }}"></product-quick-view-btn> -->
                            
                        
                    <!-- </div> -->
                </div>
                
                

                <!-- <div class="card-body"> -->
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
                                <!-- {{ __('velocity::app.products.be-first-review') }} -->
                            </div>
                        @endif
                    </div>
                    <!-- <div class="product-name"> -->
                    <div class="title">
                        <a
                            href="{{ route('shop.productOrCategory.index', $product->url_key) }}"
                            title="{{ $product->name }}"
                            class="unset">

                            {{ $product->name }}
                        </a>
                    </div>

                    <!-- <div class="product-price"> -->
                    <div class="price">
                        @include ('shop::products.newproduct.price', ['product' => $product])
                        <span class="including-tax">(Including tax)</span>
                    </div>
                </div>
                <div class="cart-wish-wrap">
                    @include ('shop::products.newproduct.new-product-add-to-cart', [
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
                   
                    
                <!-- </div> -->
        <!-- </div> -->
            </div>
        </li>
    @endif

{!! view_render_event('bagisto.shop.products.list.card.after', ['product' => $product]) !!}