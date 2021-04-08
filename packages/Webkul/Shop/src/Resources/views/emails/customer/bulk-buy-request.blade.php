@component('shop::emails.layouts.master')

    <div>
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </div>

        <div  style="font-size:16px; color:#242424; font-weight:600; margin-top: 60px; margin-bottom: 15px">
            {!! __('shop::app.contact.greeting') !!}
        </div>
        
        <div>
            <h3>{{ __('shop::app.products.bulk-buy-request') }}</h3>
        </div>

        <div>
            <b>{{ __('shop::app.products.name') }}: </b>{{ $data['name'] }}
        </div>
        <div>
            <b>{{ __('shop::app.products.email') }}: </b>{{ $data['email']}}
        </div>
        <div>
            <b>{{ __('shop::app.products.contact') }}: </b>{{ $data['contact'] }}
        </div>
        <div>
            <b>{{ __('shop::app.products.quantity') }}: </b>{{ $data['quantity'] }}
        </div> 
        <div>
            <b>{{ __('shop::app.products.product-name') }}: </b>{{ $data['product_name'] }}
        </div> 
        @if($data['additional'] != "")
        <div>
            <b>{{ __('shop::app.products.additional') }}: </b>{{ $data['additional'] }}
        </div>      
        @endif
    </div>

@endcomponent