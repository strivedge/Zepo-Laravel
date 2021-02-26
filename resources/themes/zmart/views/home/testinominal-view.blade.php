@inject ('testinominalRepository', 'Custom\Testinominal\Repositories\TestinominalRepository')
<section id="our-customer" class="featured-products slider-img our-customer" style="background-image: url('{{ asset('/themes/zmart/assets/images/testimonial-bg.png') }}');">
@php
    $testinominals = $testinominalRepository->all();
@endphp

    <div class="container">
        <div class="section-title"><h2>{{__('testinominal::app.testinominal.home-title') }}</h2></div>
        <div class="our-customer-content">
            @if(isset($testinominals) && count($testinominals) > 0)
                @foreach($testinominals as $testinominal)
                    <div class="items">
                        <div class="item-inner-wrapper">
                            <div class="image-wrap">
                                <span class="testimonial-commet"><img src="{{ asset('/themes/zmart/assets/images/testimonial-commet.png') }}"></span>
                                <img src="{{ asset('/').$testinominal->image }}" alt="{{ $testinominal->title }}" height="100" width="100" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
                            </div>
                           <div class="content-wrap">
                                <div class="title">{{ $testinominal->title }}</div>
                                <p>{{ $testinominal->desc }}</p>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                <div class="items">
                    <div class="container">
                        <p>{{__('testinominal::app.testinominal.no-testinominals') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

</section>

