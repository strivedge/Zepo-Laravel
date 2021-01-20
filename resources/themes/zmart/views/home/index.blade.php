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
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
    <div class="item active">
      <img src="https://www.w3schools.com/bootstrap/la.jpg" alt="Chania">
      <div class="carousel-caption">
        <h3>Los Angeles</h3>
        <p>LA is always so much fun!</p>
      </div>
    </div>

    <div class="item">
      <img src="https://www.w3schools.com/bootstrap/chicago.jpg" alt="Chicago">
      <div class="carousel-caption">
        <h3>Chicago</h3>
        <p>Thank you, Chicago!</p>
      </div>
    </div>

    <div class="item">
      <img src="https://www.w3schools.com/bootstrap/ny.jpg" alt="New York">
      <div class="carousel-caption">
        <h3>New York</h3>
        <p>We love the Big Apple!</p>
      </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
    <!-- @include('shop::home.slider') -->

@endsection

@section('full-content-wrapper')
    <div class="full-content-wrapper">

        <div class="container">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">New product</a></li>
            <li><a data-toggle="tab" href="#menu1">Featured Product</a></li>
            <li><a data-toggle="tab" href="#menu2">Recently Viewed</a></li>
            <li><a data-toggle="tab" href="#menu3">Offers</a></li>
            <li><a data-toggle="tab" href="#menu4">Blogs</a></li>
          </ul>

          <div class="tab-content">
            <div id="home" class="tab-pane  in active">
              @include('shop::home.new-products')
            </div>
            <div id="menu1" class="tab-pane ">
              @include('shop::home.featured-products')
            </div>
            <div id="menu2" class="tab-pane ">
              @include('shop::products.list.recently-viewed',['quantity' => 1])
            </div>
            <div id="menu3" class="tab-pane ">
              <h3>Offers</h3>
              <!-- offers files -->
              @include('shop::home.offer-products')
              <!-- <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p> -->
            </div>
            <div id="menu4" class="tab-pane ">
              <h3>Blogs</h3>
              <!-- blogs files -->
              @include('shop::home.blog-products')
            </div>
          </div>
        </div>


        <!-- {!! view_render_event('bagisto.shop.home.content.before') !!} -->

            <!-- @if ($velocityMetaData)
                {!! DbView::make($velocityMetaData)->field('home_page_content')->render() !!}
            @else
                @include('shop::home.advertisements.advertisement-four')
                @include('shop::home.featured-products')
                @include('shop::home.advertisements.advertisement-three')
                @include('shop::home.new-products')
                @include('shop::home.advertisements.advertisement-two')
            @endif -->

                <!-- @include('shop::home.offer-products') -->
                <!-- @include('shop::home.featured-products') -->
                <!-- @include('shop::home.advertisements.advertisement-three') -->
                <!--  @include('shop::home.new-products') -->
                @include('shop::products.list.recently-viewed')
                @include('shop::products.list.testinominal-view')
                <!-- @include('shop::home.advertisements.advertisement-two') -->

        <!-- {{ view_render_event('bagisto.shop.home.content.after') }} -->
    </div>

@endsection

