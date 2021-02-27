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
            @if($product->datasheet != "")
                @php
                    $file1 = $product->catalog;
                    $file2 = $product->datasheet;
                    $ext1 = pathinfo($file1);
                    $ext2 = pathinfo($file2);
                    $icons1 = $ext1['extension'];
                    $icons2 = $ext2['extension'];

                    if($icons1 == 'doc' || $icons1 == 'docx'){
                        $icons1 = 'word-icon.png';
                    }
                    if($icons2 == 'doc' || $icons2 == 'docx'){
                        $icons2 = 'word-icon.png';
                    }
                    if($icons1 == 'pdf'){
                        $icons1 = 'pdf-icon.png';
                    }
                    if($icons2 == 'pdf'){
                        $icons2 = 'pdf-icon.png';
                    }
                    if($icons1 == 'xls' || $icons1 == 'xlsx'){
                        $icons1 = 'excel-icon.png';
                    }
                    if($icons2 == 'xls' || $icons2 == 'xlsx'){
                        $icons2 = 'excel-icon.png';
                    }
                @endphp
            @endif
        @endif
            @if($product->catalog != "")
            <div>{{ __('velocity::app.products.catalog') }}</div>
            <div>
                <a href="{{ asset('/').$product->catalog }}" download="{{ __('velocity::app.products.catalog').'_'.$product->url_key }}">
                <img src="{{ asset('themes/default/assets/images/product/icons/'.$icons1) }}" alt="{{ __('velocity::app.products.catalog-download') }}"></a>
            </div>
            @endif
            @if($product->datasheet != "")
            <div>{{ __('velocity::app.products.datasheet') }}</div>
            <div>
                <a href="{{ asset('/').$product->datasheet }}" download="{{ __('velocity::app.products.datasheet').'_'.$product->url_key }}">
                <img src="{{ asset('themes/default/assets/images/product/icons/'.$icons2) }}" alt="{{ __('velocity::app.products.datasheet-download') }}">
                </a>
            </div>
            @endif
            
        </div>
    </accordian>

{!! view_render_event('bagisto.shop.products.view.description.after', ['product' => $product]) !!}