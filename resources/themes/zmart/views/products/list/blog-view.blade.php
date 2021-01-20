<section class="featured-products">

    <div class="featured-grid product-grid-4">
    <h2>{{ $posts_title }}</h2>
        <div class="row">
    @if(isset($posts) && count($posts) > 0)
        @foreach($posts as $post)
            <div class="column">
                <div class="container">
                    <div class="card-4">
                        <img src="{{ asset('uploadImages/'.$post->image) }}" alt="{{ __('shop::app.home.offers-products') }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->content }}</p>
                        <p>{{ $post->date }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        @else
        <div class="column">
            <div class="container">
                <p>No Posts...!</p>
            </div>
        </div>
        @endif
        </div>
    </div>

</section>