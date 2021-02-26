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
  @if(isset($sliderData) && !empty($sliderData))
    <section id="slider" class="slider-img">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
      @php 
        $scount=0;
        $sscount=0;
        $textTitle = '';
        $textContent = '';
      @endphp
      <ol class="carousel-indicators">
      @foreach ($sliderData as $index => $slider)
        @php 
          $scount+=1;
        @endphp
          <li data-target="#myCarousel" data-slide-to="{{ $index }}" class="{{$scount == '1' ? 'active' : ''}}"></li>

        @endforeach
      </ol>
         

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
        @foreach ($sliderData as $index => $slider)
          @php 
          $sscount+=1;
            $textTitle = str_replace("\r\n", '', $slider['title']);
            $textContent = str_replace("\r\n", '', $slider['content']);
            $textContent = str_replace("<p>", '', $textContent);
            $textContent = str_replace("</p>", '', $textContent);
          @endphp
          <div class="item {{$sscount == '1' ? 'active' : ''}}">
            
            <div class="container">
              <div class="custom-slider-caption">
                
                <div class="col-left col-lg-7 col-xl-8">
                  <h1>{{ $textTitle }}</h1>
                  <p>{{ $textContent }}</p>
                  <div class="buttons">
                    <a @if($slider['slider_path']) href="{{ $slider['slider_path'] }}" @endif>
                      <button type="button" class="btn btn-primary">{{ __('shop::app.home.slider.shop-now') }}</button>
                    </a>
                  </div>
                </div>
                <div class="image-wrapper col-lg-5 col-xl-4">
                    <img src="{{ url()->to('/') . '/storage/' . $slider['path'] }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                </div>
              </div>
            </div>
          </div>
        @endforeach
          
        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
          <span class="arrows"><img src="{{ asset('/themes/zmart/assets/images/bx-bx-right-arrow-alt.png') }}"></span>
          <span class="sr-only">{{ __('shop::app.home.slider.previous') }}</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next">
          <span class="arrows"><img src="{{ asset('/themes/zmart/assets/images/bx-bx-left-arrow-alt.png') }}"></span>
          <span class="sr-only">{{ __('shop::app.home.slider.next') }}</span>
        </a>
      </div>
        <!-- @include('shop::home.slider') -->
    </section>
  @endif
</div>

@endsection

@section('home-full-content-wrapper')
    <div class="full-content-wrapper">
        <div class="new-product">
          <div class="container">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#covid">{{ __('shop::app.home.nav-tabs.covid19-products') }}</a></li>
              <li><a data-toggle="tab" href="#popular">{{ __('shop::app.home.nav-tabs.most-popular') }}</a></li>
              <li><a data-toggle="tab" href="#new-releases">{{ __('shop::app.home.nav-tabs.new-releases') }}</a></li>
              <li><a data-toggle="tab" href="#bestseller">{{ __('shop::app.home.nav-tabs.bestsellers-accessories') }}</a></li>
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
                 @include('shop::home.top-selling')
              </div>
            </div>
          </div>
        </div>

                @include('shop::home.offer-products')
                @include ('shop::products.list.recently-viewed')
                
                @include('shop::home.category-overlay')
                @include('shop::home.offer-view')
                @include('shop::home.testinominal-view')
                @include('shop::home.shipping-payment')
                 
    </div>

@endsection
