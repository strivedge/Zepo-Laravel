@inject ('blogRepository', 'Custom\Blog\Repositories\BlogRepository')
<?php
    $posts = $blogRepository->all();
?>
<section class="category-overlay">
    <div class="container">
        <ul class="row">
    @if(isset($posts) && count($posts) > 0)
        @foreach($posts as $post)
            <li class="col-md-3 imgs">
                <div class="content-wrap">
                    <a href="#">
                        <img src="{{ asset('uploadImages/'.$post->image) }}" alt="{{ __('shop::app.home.offers-products') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                        <div class="overlay"><span>{{ $post->title }}</span></div>
                    </a>
                </div>
            </li>
            @endforeach
        @else
        <li class="imgs">
            <div class="container">
                <p>No Posts...!</p>
            </div>
        </li>
        @endif
            <!-- <li class="col-md-3 imgs">
                <div class="content-wrap">
                    <a href="#">
                        <img src="{{ asset('themes/zmart/assets/images/category-image.png') }}">
                        <div class="overlay"><span>ECG</span></div>
                    </a>
                </div>
            </li>
            <li class="col-md-3 imgs">
                <div class="content-wrap">
                    <a href="#">
                        <img src="{{ asset('themes/zmart/assets/images/category-image.png') }}">
                        <div class="overlay"><span>ECG</span></div>
                    </a>
                </div>
            </li>
            <li class="col-md-3 imgs">
                <div class="content-wrap">
                    <a href="#">
                        <img src="{{ asset('themes/zmart/assets/images/category-image.png') }}">
                        <div class="overlay"><span>ECG</span></div>
                    </a>
                </div>
            </li> -->
        </ul>
    </div>
</section>