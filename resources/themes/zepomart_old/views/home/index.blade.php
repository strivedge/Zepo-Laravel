@extends('shop::layouts.master')

@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('productRatingHelper', 'Webkul\Product\Helpers\Review')

@php
    $channel = core()->getCurrentChannel();

    $homeSEO = $channel->home_seo;

    if (isset($homeSEO)) {
        $homeSEO = json_decode($channel->home_seo);

        $metaTitle = $homeSEO->meta_title;

        $metaDescription = $homeSEO->meta_description;

        $metaKeywords = $homeSEO->meta_keywords;
    }
@endphp

@section('page_title')
    {{ isset($metaTitle) ? $metaTitle : "" }}
@endsection

@section('head')

    @if (isset($homeSEO))
        @isset($metaTitle)
            <meta name="title" content="{{ $metaTitle }}" />
        @endisset

        @isset($metaDescription)
            <meta name="description" content="{{ $metaDescription }}" />
        @endisset

        @isset($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}" />
        @endisset
    @endif
@endsection

@push('css')
    <style type="text/css">
        .product-price span:first-child, .product-price span:last-child {
            font-size: 18px;
            font-weight: 600;
        }
    </style>
@endpush

@section('content-wrapper')
    <!-- @include('shop::home.slider') -->
@endsection

@section('full-content-wrapper')


<!-- Slider ============================================= -->
    <section id="slider" class="slider-img">
        <div id="carouselsliderIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselsliderIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselsliderIndicators" data-slide-to="1"></li>
                <li data-target="#carouselsliderpleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="image-wrapper">
                        <img src="{{ asset('themes/zepomart/assets/images/home-banner.png') }}">
                    </div>
                    <div class="container">
                        <div class="custom-slider-caption">
                            <div class="col-left">
                                <h1>Face Mask  Thermometer</span></h1>
                                <p>Suspendisse turpis dui, posuere eget scelerisque a, porta eu elit. </p>
                                <div class="buttons">
                                <button type="button" class="btn btn-primary">Shop Now</button>
                            </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="image-wrapper">
                        <img src="{{ asset('themes/zepomart/assets/images/home-banner.png') }}">
                    </div>
                    <div class="container">
                        <div class="custom-slider-caption">
                            <div class="col-left">
                                <h1>Face Mask  Thermometer</span></h1>
                                <p>Suspendisse turpis dui, posuere eget scelerisque a, porta eu elit. </p>
                                <div class="buttons">
                                <button type="button" class="btn btn-primary">Shop Now</button>
                            </div>  
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="carousel-item">
                    <div class="image-wrapper">
                        <img src="{{ asset('themes/zepomart/assets/images/home-banner.png') }}">
                    </div>
                    <div class="container">
                        <div class="custom-slider-caption">
                            <div class="col-left">
                                <h1>Face Mask  Thermometer</span></h1>
                                <p>Suspendisse turpis dui, posuere eget scelerisque a, porta eu elit. </p>
                                <div class="buttons">
                                <button type="button" class="btn btn-primary">Shop Now</button>
                            </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselsliderIndicators" role="button" data-slide="prev">
                <span class="arrows" aria-hidden="true"><img src="{{ asset('themes/zepomart/assets/images/bx-bx-right-arrow-alt.png') }}"></span>
                <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselsliderIndicators" role="button" data-slide="next">
                <span class="arrows" aria-hidden="true"><img src="{{ asset('themes/zepomart/assets/images/bx-bx-left-arrow-alt.png') }}"></span>
                <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        
    </section>
    <!-- Cntent ============================================= -->
    <div class="content" id="content">
        <section class="product-boxes">
            <div class="container">
                <!-- <div class="section-title"><h2>You Recently Viewed</h2></div> -->
                <ul class="row">
                    @if (app('Webkul\Product\Repositories\ProductRepository')->getAll()->count())

                        @foreach (app('Webkul\Product\Repositories\ProductRepository')->getAll() as $productFlat) 

                        <?php //echo "string<pre>"; print_r($productFlat);//exit; ?>

                            <?php $product = $productFlat; ?>

                            @inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')

                            <?php $productBaseImage = $productImageHelper->getProductBaseImage($product); ?>

                            <li class="product-box">
                                <div class="content-wrap">
                                    <div class="product-code">{{ $product->sku }}</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ $productBaseImage['medium_image_url'] }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                                    </div>
                                    <div class="content">
                                        <div class="star">
                                            <img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}">
                                        </div>
                                        <div class="title">
                                            <a href="{{ route('shop.productOrCategory.index', $product->url_key) }}" title="{{ $product->name }}">{{ $product->name }}
                                            </a>
                                        </div>
                                        <div class="price">
                                            <div class="product-price">
                                                {!! $product->getTypeInstance()->getPriceHtml() !!}
                                            </div>
                                      <!--       @if($product->special_price != '')
                                            <span class="amount">${{$product->special_price}}</span>
                                            @endif
                                            <span class="amount-price">${{$product->price}}</span>
                                            <span class="including-tax">(Including tax)</span> -->
                                        </div>
                                        <!-- <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                            <input type="hidden" name="quantity" value="1">

                                            <button type="submit" class="btn btn-lg btn-primary addtocart" {{ $product->isSaleable() ? '' : 'disabled' }}>{{ ($product->type == 'booking') ?  __('shop::app.products.book-now') :  __('shop::app.products.add-to-cart') }}</button>
                                        </form> -->
                                        @include('shop::products.add-buttons', ['product' => $product])
                                    </div>
                                </div>
                           </li>    

                        @endforeach

                    @endif

                </ul>
            </div>
        </section>
        <section class="sales">
            <div class="container">
                <div class="salesoffers-addtocart">
                    <div class="col-md-3 salesoffers">
                        <div class="imgs"><img src="{{ asset('themes/zepomart/assets/images/sales-new-year.png') }}"></div>
                       <div class="salesoffers-content">
                                <p>New Year Sale is Live !<br/>
                                   Don't Missout.<br/>
                                   Lowest Price on selected products!<br/>
                                   <a href="#" class="promotion btn btn-primary">More about promotion</a></p>
                                <div class="imgs"><img src="{{ asset('themes/zepomart/assets/images/sales-timing.png') }}">
                                </div>
                                <a href="#" class="active-promotion btn btn-primary">
                                    Active promotions<span><i class="bx bx-right-arrow-alt"></i></span>
                                </a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <ul class="addtocart">
                           <li class="items">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('themes/zepomart/assets/images/Biocare.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Biocare 3-channel electrocardiograph ECG-3010 ECG Machine</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                    <div class="buttons">
                                        <a href="#" class="quick-view btn btn-primary">Quick View</a>
                                        <a href="#" class="add-to-cart btn btn-primary">Add to cart</a>
                                    </div>
                                </div>
                            </li>
                            <li class="items">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('themes/zepomart/assets/images/Biocare.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Biocare 3-channel electrocardiograph ECG-3010 ECG Machine</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                    <div class="buttons">
                                        <a href="#" class="quick-view btn btn-primary">Quick View</a>
                                        <a href="#" class="add-to-cart btn btn-primary">Add to cart</a>
                                    </div>
                                </div>
                            </li>
                            <li class="items">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('themes/zepomart/assets/images/Biocare.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Biocare 3-channel electrocardiograph ECG-3010 ECG Machine</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                    <div class="buttons">
                                        <a href="#" class="quick-view btn btn-primary">Quick View</a>
                                        <a href="#" class="add-to-cart btn btn-primary">Add to cart</a>
                                    </div>
                                </div>
                            </li>
                            <li class="items">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('themes/zepomart/assets/images/Biocare.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Biocare 3-channel electrocardiograph ECG-3010 ECG Machine</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                    <div class="buttons">
                                        <a href="#" class="quick-view btn btn-primary">Quick View</a>
                                        <a href="#" class="add-to-cart btn btn-primary">Add to cart</a>
                                    </div>
                                </div>
                            </li>
                            <li class="items">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('themes/zepomart/assets/images/Biocare.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Biocare 3-channel electrocardiograph ECG-3010 ECG Machine</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                    <div class="buttons">
                                        <a href="#" class="quick-view btn btn-primary">Quick View</a>
                                        <a href="#" class="add-to-cart btn btn-primary">Add to cart</a>
                                    </div>
                                </div>
                            </li>
                            <li class="items">
                                <div class="content-wrap">
                                    <div class="product-code">ZM44841</div>
                                    <div class="img">
                                        <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                        <img src="{{ asset('themes/zepomart/assets/images/Biocare.png') }}">
                                    </div>
                                    <div class="content">
                                        <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                        <div class="title"><a href="#">Biocare 3-channel electrocardiograph ECG-3010 ECG Machine</a></div>
                                        <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                                    </div>
                                    <div class="buttons">
                                        <a href="#" class="quick-view btn btn-primary">Quick View</a>
                                        <a href="#" class="add-to-cart btn btn-primary">Add to cart</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section class="recently-viewed">
            <div class="container">
                <div class="section-title"><h2>You Recently Viewed</h2></div>
                <ul class="row">
                    <li class="col-md-2">
                        <div class="content-wrap">
                            <div class="product-code">ZM44841</div>
                            <div class="img">
                                <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                <img src="{{ asset('themes/zepomart/assets/images/venus-v4400-n95-face-mask.png') }}">
                            </div>
                            <div class="content">
                                <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                            </div>
                        </div>
                    </li>
                   <li class="col-md-2">
                        <div class="content-wrap">
                            <div class="product-code">ZM44841</div>
                            <div class="img">
                                <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                <img src="{{ asset('themes/zepomart/assets/images/venus-v4400-n95-face-mask.png') }}">
                            </div>
                            <div class="content">
                                <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-2">
                        <div class="content-wrap">
                            <div class="product-code">ZM44841</div>
                            <div class="img">
                                <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                <img src="{{ asset('themes/zepomart/assets/images/venus-v4400-n95-face-mask.png') }}">
                            </div>
                            <div class="content">
                                <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-2">
                        <div class="content-wrap">
                            <div class="product-code">ZM44841</div>
                            <div class="img">
                                <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                <img src="{{ asset('themes/zepomart/assets/images/venus-v4400-n95-face-mask.png') }}">
                            </div>
                            <div class="content">
                                <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-2">
                        <div class="content-wrap">
                            <div class="product-code">ZM44841</div>
                            <div class="img">
                                <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                <img src="{{ asset('themes/zepomart/assets/images/venus-v4400-n95-face-mask.png') }}">
                            </div>
                            <div class="content">
                                <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                            </div>
                        </div>
                    </li>
                     <li class="col-md-2">
                        <div class="content-wrap">
                            <div class="product-code">ZM44841</div>
                            <div class="img">
                                <div class="discount badge badge-secondary"><span class="save">SAVE</span><span class="percentage">26%</span></div>
                                <img src="{{ asset('themes/zepomart/assets/images/venus-v4400-n95-face-mask.png') }}">
                            </div>
                            <div class="content">
                                <div class="star"><img src="{{ asset('themes/zepomart/assets/images/star-gray.png') }}"></div>
                                <div class="title"><a href="#">Venus V4400 N95 Face mask , Protection from pollution and virus</a></div>
                                <div class="price"><span class="amount">$74.68</span><span class="amount-price">$80.35</span><span class="including-tax">(Including tax)</span></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <section class="category-overlay">
            <div class="container">
                <ul class="row">
                    <li class="col-md-3 imgs">
                        <div class="content-wrap">
                            <a href="#">
                                <img src="{{ asset('themes/zepomart/assets/images/category-image.png') }}">
                                <div class="overlay"><span>ECG</span></div>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 imgs">
                        <div class="content-wrap">
                            <a href="#">
                                <img src="{{ asset('themes/zepomart/assets/images/category-image.png') }}">
                                <div class="overlay"><span>ECG</span></div>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 imgs">
                        <div class="content-wrap">
                            <a href="#">
                                <img src="{{ asset('themes/zepomart/assets/images/category-image.png') }}">
                                <div class="overlay"><span>ECG</span></div>
                            </a>
                        </div>
                    </li>
                    <li class="col-md-3 imgs">
                        <div class="content-wrap">
                            <a href="#">
                                <img src="{{ asset('themes/zepomart/assets/images/category-image.png') }}">
                                <div class="overlay"><span>ECG</span></div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <section class="offers">
            <div class="container">
                <div class="section-title"><h2>Active Offers</h2></div>
                <ul>
                    <li class="col-md-3 img">
                                <img src="{{ asset('themes/zepomart/assets/images/offers.png') }}">
                    </li>
                   <li class="col-md-7 content-offers">
                        <div class="content">
                            FREE Shipping on All Equipments Value above Rs. 40000
                            <span>From 01/01/2021 to 31/03/2021</span>
                        </div>
                    </li>
                    <li class="col-md-2 buttons">
                        <a href="#">View all Offers</a>
                    </li>
                   
                </ul>
            </div>
        </section>
       
        <section class="our-customer" style="background-image: url('{{ asset('themes/zepomart/assets/images/testimonial-bg.png') }}">
            <div class="container">
                <div class="section-title"><h2>What Our Customers are Saying</h2></div>
                <div class="our-customer-content">
                    <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/julian-fernandez.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Julian Fernandez</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>
                     <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/nancy-rice.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Nancy Rice</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>
                     <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/nancy-rice.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Jordan Porter</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>
                     <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/nancy-rice.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Magentech</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>

                     <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/julian-fernandez.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Julian Fernandez</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>

                    <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/julian-fernandez.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Julian Fernandez</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>

                    <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/julian-fernandez.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Julian Fernandez</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>

                    <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/julian-fernandez.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Julian Fernandez</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>

                    <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/julian-fernandez.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Julian Fernandez</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>

                    <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                 <span class="testimonial-commet"><img src="{{ asset('themes/zepomart/assets/images/testimonial-commet.png') }}"></span>
                                 <img src="{{ asset('themes/zepomart/assets/images/julian-fernandez.png') }}">
                            </div>
                            <div class="content-wrap">
                                <div class="title">Julian Fernandez</div>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been1500s.</p>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </section>
        <section class="shipping-payment-price">
            <div class="container">
                <ul>
                    <li class="col-md-3">
                        <div class="content-wrap">
                            <div class="img">
                                <img src="{{ asset('themes/zepomart/assets/images/shipping.png') }}">
                            </div>
                            <div class="title">Free Shipping</div>
                        </div>
                    </li>
                    <li class="col-md-3">
                        <div class="content-wrap">
                            <div class="img">
                                <img src="{{ asset('themes/zepomart/assets/images/price-gaurntee.png') }}">
                            </div>
                            <div class="title">Best Price Guarantee</div>
                        </div>
                    </li>
                    <li class="col-md-3">
                        <div class="content-wrap">
                            <div class="img">
                                <img src="{{ asset('themes/zepomart/assets/images/return-undo.png') }}">
                            </div>
                            <div class="title">Easy Return</div>
                        </div>
                    </li>
                    <li class="col-md-3">
                        <div class="content-wrap">
                            <div class="img">
                                <img src="{{ asset('themes/zepomart/assets/images/verfied.png') }}">
                            </div>
                            <div class="title">100% Payment Secure</div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    </div>

    <div class="full-content-wrapper">
       <!--  {!! view_render_event('bagisto.shop.home.content.before') !!}

        <?php //echo "string<pre>"; print_r($velocityMetaData);exit; ?>

            @include('shop::home.featured-products')
            @include('shop::home.new-products')

        {{ view_render_event('bagisto.shop.home.content.after') }} -->

        <?php //echo "string<pre>"; print_r(app('Webkul\Product\Repositories\ProductRepository')->getNewProducts());exit(); ?>

         @include('shop::home.new-products')

  

        
</div>

@endsection

