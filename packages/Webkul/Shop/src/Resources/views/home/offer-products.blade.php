<section class="featured-products">

    <div class="featured-heading">
        {{ __('shop::app.home.offers-products') }}<br/>
        <span class="featured-seperator" style="color:lightgrey;">_____</span>
    </div>

    <div class="featured-grid product-grid-4">
        <div class="row">
        @foreach($offers as $offer)
            <div class="column">
                <div class="container">
                    <div class="card-4">
                        <img src="{{ asset('uploadImages/offer/'.$offer->image) }}" alt="{{ __('shop::app.home.offers-products') }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                        <h3>{{ $offer->title }}</h3>
                        <p>{{ $offer->desc }}</p>
                        <p>{{ $offer->start_date }}</p>
                        <p>{{ $offer->end_date }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>

</section>