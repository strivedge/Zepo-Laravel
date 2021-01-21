<section class="featured-products">

    <div class="featured-grid product-grid-4">
    <h2>{{ $testi_title }}</h2>
        <div class="row">
    @if(isset($testinominals) && count($testinominals) > 0)
        @foreach($testinominals as $testinominal)
            <div class="column">
                <div class="container">
                    <div class="card-4">
                        <img src="{{ asset('uploadImages/'.$testinominal->image) }}" alt="{{ $testi_title }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                        <h3>{{ $testinominal->title }}</h3>
                        <p>{{ $testinominal->desc }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        @else
        <div class="column">
            <div class="container">
                <p>No Testinominals...!</p>
            </div>
        </div>
        @endif
        </div>
    </div>

</section>