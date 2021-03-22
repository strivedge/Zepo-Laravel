@inject ('blogRepository', 'Custom\Blog\Repositories\BlogRepository')

@php
    $posts = $blogRepository->all();
@endphp

@if(isset($posts) && count($posts) > 0)
<section class="category-overlay">
    <div class="container">
        <ul class="row">
        @foreach($posts as $post)
            <li class="col-md-6 col-lg-4 col-xl-3 imgs">
                <div class="content-wrap">
                    <div class="image-wrap">
                        <a href="{{ route('blog-detail', [$post->slug]) }}">
                            <img src="{{ asset('/').$post->image }}" alt="{{ __('blog::app.blogs.title') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                            <div class="overlay"><span>{{ $post->title }}</span></div>
                        </a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>
@endif