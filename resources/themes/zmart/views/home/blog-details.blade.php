@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.home.blog-detail') }}
@endsection

@section('content-wrapper')

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



