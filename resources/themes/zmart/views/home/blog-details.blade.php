@extends('shop::layouts.master')

@section('page_title')
    {{ __('blog::app.blogs.blog-detail') }}
@endsection

@section('content-wrapper')

<main id="main" class="site-main single single-blog-post">
    <div class="container">
                
        <article class="post type-post has-post-thumbnail">
            <div class="post-thumbnail-wrap">
            
                    <div class="post-thumbnail">
                        <img src="{{ asset('/').$posts->image }}" alt="{{ __('shop::app.home.blog-details') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'" >  
                    </div>

                    <div class="entry-meta">
                        <span class="posted-on">{{ __('blog::app.blogs.posted-on') }} <time class="updated">{{ $posts->updated_at }}</time></span>
                        <span class="byline"> {{ __('blog::app.blogs.by') }} <span class="author vcard"><a class="url fn n" href="#">{{ __('blog::app.blogs.admin') }}</a></span></span>
                    </div>
            </div>  
            <header class="entry-header">
                <h2 class="entry-title">{{ $posts->title }}</h2>  
            </header>

            <div class="entry-content">
                <p>{{ $posts->content }}</p>
            </div>

        </article>
    </div>
</main>

@endsection



