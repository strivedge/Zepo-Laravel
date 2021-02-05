@extends('shop::layouts.master')

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

@section('content-wrapper')
<!-- <div class="section-title"><h2>{{ __('shop::app.home.blog-details') }}</h2></div>
<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    <tr>
</table> -->
<main id="main" class="site-main single single-blog-post">
    <div class="container">
                
        <article class="post type-post has-post-thumbnail">
            <div class="post-thumbnail-wrap">
            
                    <div class="post-thumbnail">
                        <img src="{{ asset('uploadImages/'.$posts->image) }}" alt="{{ __('shop::app.home.blog-details') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'" >  
                    </div><!-- .post-thumbnail -->

                    <div class="entry-meta">
                        <span class="posted-on">Posted on <time class="updated">{{ $posts->updated_at }}</time></span>
                        <span class="byline"> by <span class="author vcard"><a class="url fn n" href="#">admin</a></span></span>
                    </div>
                    <!-- .entry-meta -->
            </div>  
            <header class="entry-header"><!--  section-title -->
                <!-- <h1 class="entry-title">{{ $posts->title }}</h1>  -->
                <h2 class="entry-title">{{ $posts->title }}</h2>  
            </header><!-- .entry-header -->

            <div class="entry-content">
                <p>{{ $posts->content }}</p>
            </div><!-- .entry-content -->

        </article>
    </div>
</main>

@endsection



