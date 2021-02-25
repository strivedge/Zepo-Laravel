{!! view_render_event('bagisto.shop.products.view.description.before', ['product' => $product]) !!}

    <accordian :title="'{{ __('shop::app.products.description') }}'" :active="true">
        <div slot="header">
            <h3 class="no-margin display-inbl">
                {{ __('velocity::app.products.details') }}
            </h3>

            <i class="rango-arrow"></i>
        </div>

        <div slot="body">
            <div class="full-description">
                {!! $product->description !!}
            </div>

            @if($product->catalog != "")
            <div>{{ __('velocity::app.products.catalog') }}</div>
            <div>
                <a href="{{ asset('/').$product->catalog }}" target="_blank">{{ __('velocity::app.products.catalog-view') }}</a>
                <a href="{{ asset('/').$product->catalog }}" download="{{ __('velocity::app.products.catalog').'_'.$product->url_key }}">{{ __('velocity::app.products.catalog-download') }}</a>
            </div>
            @endif
            @if($product->datasheet != "")
            <div>{{ __('velocity::app.products.datasheet') }}</div>
            <div>
                <a href="{{ asset('/').$product->datasheet }}" target="_blank">{{ __('velocity::app.products.datasheet-view') }}</a>
                <a href="{{ asset('/').$product->datasheet }}" download="{{ __('velocity::app.products.datasheet').'_'.$product->url_key }}">{{ __('velocity::app.products.datasheet-download') }}</a>
            </div>
            @endif
            
        </div>
    </accordian>

{!! view_render_event('bagisto.shop.products.view.description.after', ['product' => $product]) !!}