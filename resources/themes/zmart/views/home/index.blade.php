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

@section('home-banner-content-wrapper')
<div class="col-12 no-padding content" id="home-right-bar-container">
  <section id="slider" class="slider-img">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
    @php 
      $scount=0;
      $textTitle = '';
      $textContent = '';
    @endphp
    <ol class="carousel-indicators">
    @foreach ($sliderData as $index => $slider)
      @php 
        $scount+=1;
      @endphp
        <li data-target="#myCarousel" data-slide-to="{{ $scount }}" class="{{$scount == '1' ? 'active' : ''}}"></li>
      @endforeach
    </ol>
        <!-- <li data-target="#myCarousel" data-slide-to="1" class="active"></li> -->
        <!-- <li data-target="#myCarousel" data-slide-to="2"></li> -->
        
        <!-- Slider Image URL from Admin Side Uploaded -->
        <!-- src="{{ url()->to('/') . '/storage/' . $slider['path'] }}" -->

      <!-- Wrapper for slides -->
      <div class="carousel-inner">
      @foreach ($sliderData as $index => $slider)
        @php 
          $textTitle = str_replace("\r\n", '', $slider['title']);
          $textContent = str_replace("\r\n", '', $slider['content']);
        @endphp
        <div class="item active">
          
          <div class="container">
            <div class="custom-slider-caption">
              
              <div class="col-left col-lg-7 col-xl-8">
                <h1>{{ $textTitle }}</span></h1>
                <p>{{ $textContent }}</p>
                <div class="buttons">
                    <button type="button" class="btn btn-primary">Shop Now</button>
                </div>
              </div>
              <div class="image-wrapper col-lg-5 col-xl-4">
                  <img src="{{ asset('/themes/zmart/assets/images/thermometer.png') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
              </div>
            </div>
          </div>
        </div>
        @endforeach
        <!-- <div class="item">
          <div class="container">
            <div class="custom-slider-caption">
              <div class="col-left col-lg-7 col-xl-8">
                <h1>Face Mask  Thermometer</span></h1>
                <p>Suspendisse turpis dui, posuere eget scelerisque a, porta eu elit. </p>
                <div class="buttons">
                    <button type="button" class="btn btn-primary">Shop Now</button>
                </div>
              </div>
              <div class="image-wrapper col-lg-5 col-xl-4">
                  <img src="{{ asset('/themes/zmart/assets/images/thermometer.png') }}">
              </div>
            </div>
          </div>
        </div> -->

        <!-- <div class="item">
          
          <div class="container">
            <div class="custom-slider-caption">
              <div class="col-left col-lg-7 col-xl-8">
                <h1>Face Mask  Thermometer</span></h1>
                <p>Suspendisse turpis dui, posuere eget scelerisque a, porta eu elit. </p>
                <div class="buttons">
                    <button type="button" class="btn btn-primary">Shop Now</button>
                </div>
              </div>
              <div class="image-wrapper col-lg-5 col-xl-4">
                  <img src="{{ asset('/themes/zmart/assets/images/thermometer.png') }}">
              </div>
            </div>
          </div>
        </div> -->
      </div>

      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
        <span class="arrows"><img src="{{ asset('/themes/zmart/assets/images/bx-bx-right-arrow-alt.png') }}"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#myCarousel" data-slide="next">
        <span class="arrows"><img src="{{ asset('/themes/zmart/assets/images/bx-bx-left-arrow-alt.png') }}"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
      <!-- @include('shop::home.slider') -->
  </section>
</div>

@endsection

@section('home-full-content-wrapper')
    <div class="full-content-wrapper">
        <div class="new-product">
          <div class="container">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#covid">COVID19 PRODUCTS</a></li>
              <li><a data-toggle="tab" href="#popular">MOST POPULAR</a></li>
              <li><a data-toggle="tab" href="#new-releases">NEW RELEASES</a></li>
              <li><a data-toggle="tab" href="#bestseller">BESTSELLERS ACCESSORIES</a></li>
            </ul>
                        
            <div class="tab-content">
              <div id="covid" class="tab-pane  in active">
                @include('shop::home.covid-products')
                <!-- @include('shop::home.category', ['category' => 'covid19']) -->
              </div>
              <div id="popular" class="tab-pane ">
                @include('shop::home.featured-products')
              </div>
              <div id="new-releases" class="tab-pane ">
                @include('shop::home.new-products')
              </div>
              <div id="bestseller" class="tab-pane ">
                 @include('shop::home.new-products')
              </div>
            </div>
          </div>
        </div>


                @include('shop::home.offer-products')
                @include ('shop::products.list.recently-viewed', [
                                'quantity'          => 6,
                                'addClass'          => 'col-lg-3 col-md-12',
                            ])
                
                @include('shop::home.category-overlay')
                @include('shop::home.offer-view')
                @include('shop::home.testinominal-view')
                @include('shop::home.shipping-payment')
                
               
        <!-- {{ view_render_event('bagisto.shop.home.content.after') }} -->
    </div>

@endsection

