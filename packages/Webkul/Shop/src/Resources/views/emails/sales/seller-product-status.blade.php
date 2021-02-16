<?php //echo "<pre>"; print_r($data); exit(); ?>
@component('shop::emails.layouts.master')

    <div>
        <div style="text-align: center;">
            <a href="{{ route('admin.catalog.products.edit', [$data->id]) }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </div>

        <div style="font-size:16px; color:#242424; font-weight:600; margin-top: 60px; margin-bottom: 15px">
            {!! __('shop::app.contact.greeting') !!}
        </div>

        <div>
            <b>Product SKU : </b>{{ $data['sku'] }}
        </div>
        <div>
            <b>Product Name : </b>{{ $data['pname'] }}
        </div>
        
    </div>

@endcomponent