@component('shop::emails.layouts.master')

    <div>
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </div>

        <div style="font-size:16px; color:#242424; font-weight:600; margin-top: 60px; margin-bottom: 15px">
            {!! __('shop::app.contact.greeting') !!}
        </div>

        <div>
            <b>{{ __('admin::app.catalog.products.requested-by') }} : </b>{{ $data['user_name'] }} ({{ $data['user_role'] }})
        </div>

        <div>
            <b>{{ __('admin::app.catalog.products.email') }} : </b><a href="mailto:{{ $data['user_email'] }}">{{ $data['user_email'] }}</a>
        </div>

        <div>
            <b>{{ __('admin::app.catalog.products.product-sku') }} : </b>{{ $data['sku'] }}
        </div>

        <div>
            <b>{{ __('admin::app.catalog.products.product-name') }} : </b>{{ $data['pname'] }}
        </div>
        <div>
            <a href="{{ route('admin.catalog.products.edit', [$data['id']]) }}">
                {{ __('admin::app.catalog.products.activate-product') }}
            </a>
        </div>
        
    </div>

@endcomponent