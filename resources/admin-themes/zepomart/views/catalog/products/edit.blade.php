@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.catalog.products.edit-title') }}
@stop

@section('content')
    <div class="content">
        <?php $locale = request()->get('locale') ?: app()->getLocale(); ?>
        <?php $channel = request()->get('channel') ?: core()->getDefaultChannelCode(); ?>

        {!! view_render_event('bagisto.admin.catalog.product.edit.before', ['product' => $product]) !!}

        <form method="POST" action="" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">

                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link"
                           onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

                        {{ __('admin::app.catalog.products.edit-title') }}
                    </h1>

                    <div class="control-group">
                        <select class="control" id="channel-switcher" name="channel">
                            @foreach (core()->getAllChannels() as $channelModel)

                                <option
                                    value="{{ $channelModel->code }}" {{ ($channelModel->code) == $channel ? 'selected' : '' }}>
                                    {{ $channelModel->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div class="control-group">
                        <select class="control" id="locale-switcher" name="locale">
                            @foreach (core()->getAllLocales() as $localeModel)

                                <option
                                    value="{{ $localeModel->code }}" {{ ($localeModel->code) == $locale ? 'selected' : '' }}>
                                    {{ $localeModel->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.catalog.products.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                @csrf()

                <input name="_method" type="hidden" value="PUT">

                @foreach ($product->attribute_family->attribute_groups as $index => $attributeGroup)
                    <?php $customAttributes = $product->getEditableAttributes($attributeGroup); ?>

                    @if (count($customAttributes))

                        {!! view_render_event('bagisto.admin.catalog.product.edit_form_accordian.' . $attributeGroup->name . '.before', ['product' => $product]) !!}

                        <accordian :title="'{{ __($attributeGroup->name) }}'"
                                   :active="{{$index == 0 ? 'true' : 'false'}}">
                            <div slot="body">
                                {!! view_render_event('bagisto.admin.catalog.product.edit_form_accordian.' . $attributeGroup->name . '.controls.before', ['product' => $product]) !!}

            @if($attributeGroup->name == "General")
                @if(auth()->guard('admin')->user()->role->id == 1)
                    <div class="control-group">
                        <label for="seller_id">{{ __('admin::app.catalog.products.sellers') }}</label>
                            <select class="control" id="seller_id" name="seller_id" data-vv-as="&quot;{{ __('admin::app.catalog.products.sellers') }}&quot;">
                                <option value="{{ auth()->guard('admin')->id() }}">
                                    {{ auth()->guard('admin')->user()->name }} 
                                    ({{ auth()->guard('admin')->user()->role->name }})
                                </option>
                                @foreach ($sellers as $seller)
                                    <option value="{{ $seller->id }}" {{ $seller->id == $product->seller_id ? 'selected' : ''}}>
                                        {{ $seller->name }} ({{ $seller->role_name }})
                                    </option>
                                @endforeach
                            </select>
                    </div>
                @else
                    <input type="hidden" name="seller_id" value="{{ auth()->guard('admin')->id() }}">
                @endif
            @endif
                                @foreach ($customAttributes as $attribute)

                                    @php
                                        if ($attribute->code == 'guest_checkout' && ! core()->getConfigData('catalog.products.guest-checkout.allow-guest-checkout')) {
                                            
                                        }

                                        $validations = [];

                                        if ($attribute->is_required) {
                                            array_push($validations, 'required');
                                        }

                                        if ($attribute->type == 'price') {
                                            array_push($validations, 'decimal');
                                        }

                                        if ($attribute->type == 'file') {
                                            $retVal = (core()->getConfigData('catalog.products.attribute.file_attribute_upload_size')) ? core()->getConfigData('catalog.products.attribute.file_attribute_upload_size') : '2048' ;
                                            array_push($validations, 'size:' . $retVal);
                                        }

                                        if ($attribute->type == 'image') { 
                                            $retVal = (core()->getConfigData('catalog.products.attribute.image_attribute_upload_size')) ? core()->getConfigData('catalog.products.attribute.image_attribute_upload_size') : '2048' ;
                                            array_push($validations, 'size:' . $retVal . '|mimes:jpeg, bmp, png, jpg');      
                                        }

                                        array_push($validations, $attribute->validation);

                                        $validations = implode('|', array_filter($validations));
                                    @endphp

                                @if (view()->exists($typeView = 'admin::catalog.products.field-types.' . $attribute->type))

                                    @if(auth()->guard('admin')->user()->role->id == 1)
                                        <div class="control-group {{ $attribute->type }}"
                                             @if ($attribute->type == 'multiselect') :class="[errors.has('{{ $attribute->code }}[]') ? 'has-error' : '']"
                                             @else :class="[errors.has('{{ $attribute->code }}') ? 'has-error' : '']" @endif>

                                        @if($attribute->code == "guest_checkout")
                                        @else
                                            <label
                                                for="{{ $attribute->code }}" {{ $attribute->is_required ? 'class=required' : '' }}>
                                                {{ $attribute->admin_name }}
                                        @endif

                                                @if ($attribute->type == 'price')
                                                    <span class="currency-code">({{ core()->currencySymbol(core()->getBaseCurrencyCode()) }})</span>
                                                @endif

                                                <?php
                                                $channel_locale = [];

                                                if ($attribute->value_per_channel) {
                                                    array_push($channel_locale, $channel);
                                                }

                                                if ($attribute->value_per_locale) {
                                                    array_push($channel_locale, $locale);
                                                }
                                                ?>

                                                @if (count($channel_locale))
                                                    <span class="locale">[{{ implode(' - ', $channel_locale) }}]</span>
                                                @endif
                                            </label>

                                            @include ($typeView)

                                            <span class="control-error"
                                                @if ($attribute->type == 'multiselect') v-if="errors.has('{{ $attribute->code }}[]')"
                                                  @else  v-if="errors.has('{{ $attribute->code }}')"  @endif>
                                                @if ($attribute->type == 'multiselect')
                                                    @{{ errors.first('{!! $attribute->code !!}[]') }}
                                                @else
                                                    @{{ errors.first('{!! $attribute->code !!}') }}
                                                @endif
                                            </span>
                                        </div>
                                    @endif

                                    @if(auth()->guard('admin')->user()->role->id != 1)
                                        @if($attribute->code == "status")
                                        <div class="control-group {{ $attribute->type }}"
                                             @if ($attribute->type == 'multiselect') :class="[errors.has('{{ $attribute->code }}[]') ? 'has-error' : '']"
                                             @else :class="[errors.has('{{ $attribute->code }}') ? 'has-error' : '']" @endif>

                                            <label for="{{ $attribute->code }}">

                                                @if ($attribute->type == 'price')
                                                    <span class="currency-code">({{ core()->currencySymbol(core()->getBaseCurrencyCode()) }})</span>
                                                @endif

                                                <?php
                                                $channel_locale = [];

                                                if ($attribute->value_per_channel) {
                                                    array_push($channel_locale, $channel);
                                                }

                                                if ($attribute->value_per_locale) {
                                                    array_push($channel_locale, $locale);
                                                }
                                                ?>

                                                @if (count($channel_locale))
                                                    <span class="locale">[{{ implode(' - ', $channel_locale) }}]</span>
                                                @endif
                                            </label>

                                            @include ($typeView)

                                            <span class="control-error"
                                                @if ($attribute->type == 'multiselect') v-if="errors.has('{{ $attribute->code }}[]')"
                                                  @else  v-if="errors.has('{{ $attribute->code }}')"  @endif>
                                                @if ($attribute->type == 'multiselect')
                                                    @{{ errors.first('{!! $attribute->code !!}[]') }}
                                                @else
                                                    @{{ errors.first('{!! $attribute->code !!}') }}
                                                @endif
                                            </span>
                                        </div>
                                        @elseif($attribute->code == "guest_checkout")
                                        <div class="control-group {{ $attribute->type }}"
                                             @if ($attribute->type == 'multiselect') :class="[errors.has('{{ $attribute->code }}[]') ? 'has-error' : '']"
                                             @else :class="[errors.has('{{ $attribute->code }}') ? 'has-error' : '']" @endif>

                                            <label for="{{ $attribute->code }}">

                                                @if ($attribute->type == 'price')
                                                    <span class="currency-code">({{ core()->currencySymbol(core()->getBaseCurrencyCode()) }})</span>
                                                @endif

                                                <?php
                                                $channel_locale = [];

                                                if ($attribute->value_per_channel) {
                                                    array_push($channel_locale, $channel);
                                                }

                                                if ($attribute->value_per_locale) {
                                                    array_push($channel_locale, $locale);
                                                }
                                                ?>

                                                @if (count($channel_locale))
                                                    <span class="locale">[{{ implode(' - ', $channel_locale) }}]</span>
                                                @endif
                                            </label>

                                            @include ($typeView)

                                            <span class="control-error"
                                                @if ($attribute->type == 'multiselect') v-if="errors.has('{{ $attribute->code }}[]')"
                                                  @else  v-if="errors.has('{{ $attribute->code }}')"  @endif>
                                                @if ($attribute->type == 'multiselect')
                                                    @{{ errors.first('{!! $attribute->code !!}[]') }}
                                                @else
                                                    @{{ errors.first('{!! $attribute->code !!}') }}
                                                @endif
                                            </span>
                                        </div>
                                        @else
                                        <div class="control-group {{ $attribute->type }}"
                                             @if ($attribute->type == 'multiselect') :class="[errors.has('{{ $attribute->code }}[]') ? 'has-error' : '']"
                                             @else :class="[errors.has('{{ $attribute->code }}') ? 'has-error' : '']" @endif>

                                            <label
                                                for="{{ $attribute->code }}" {{ $attribute->is_required ? 'class=required' : '' }}>
                                                {{ $attribute->admin_name }}

                                                @if ($attribute->type == 'price')
                                                    <span class="currency-code">({{ core()->currencySymbol(core()->getBaseCurrencyCode()) }})</span>
                                                @endif

                                                <?php
                                                $channel_locale = [];

                                                if ($attribute->value_per_channel) {
                                                    array_push($channel_locale, $channel);
                                                }

                                                if ($attribute->value_per_locale) {
                                                    array_push($channel_locale, $locale);
                                                }
                                                ?>

                                                @if (count($channel_locale))
                                                    <span class="locale">[{{ implode(' - ', $channel_locale) }}]</span>
                                                @endif
                                            </label>

                                            @include ($typeView)

                                            <span class="control-error"
                                                @if ($attribute->type == 'multiselect') v-if="errors.has('{{ $attribute->code }}[]')"
                                                  @else  v-if="errors.has('{{ $attribute->code }}')"  @endif>
                                                @if ($attribute->type == 'multiselect')
                                                    @{{ errors.first('{!! $attribute->code !!}[]') }}
                                                @else
                                                    @{{ errors.first('{!! $attribute->code !!}') }}
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    @endif

                            @if($attribute->code == "brand")
                                @if($product->catalog != "")
                                    @php
                                        $file1 = $product->catalog;
                                        $ext1 = pathinfo($file1);
                                        $icons1 = $ext1['extension'];

                                        if($icons1 == 'doc' || $icons1 == 'docx'){
                                            $icons1 = 'word-icon.png';
                                        }
                                        if($icons1 == 'pdf'){
                                            $icons1 = 'pdf-icon.png';
                                        }
                                        if($icons1 == 'xls' || $icons1 == 'xlsx'){
                                            $icons1 = 'excel-icon.png';
                                        }
                                    @endphp
                                @else
                                    @php
                                        $icons1 = '';
                                    @endphp
                                @endif

                                @if($product->datasheet != "")
                                    @php
                                        $file2 = $product->datasheet;
                                        $ext2 = pathinfo($file2);
                                        $icons2 = $ext2['extension'];

                                        if($icons2 == 'doc' || $icons2 == 'docx') {
                                            $icons2 = 'word-icon.png';
                                        }
                                        if($icons2 == 'pdf') {
                                            $icons2 = 'pdf-icon.png';
                                        }
                                        if($icons2 == 'xls' || $icons2 == 'xlsx') {
                                            $icons2 = 'excel-icon.png';
                                        }
                                    @endphp
                                @else
                                    @php
                                        $icons2 = '';
                                    @endphp
                                @endif
                                    <div class="control-group" :class="[errors.has('catalog') ? 'has-error' : '']">
                                        <label for="catalog" class="">{{ __('admin::app.catalog.products.catalog') }}
                                        @if($product->catalog != "")
                                            <a href="{{ asset('/').$product->catalog }}" download="{{ __('velocity::app.products.catalog').'_'.$product->url_key }}"><img src="{{ asset('themes/default/assets/images/product/icons/'.$icons1) }}" alt="{{ __('velocity::app.products.catalog-download') }}"></a> 
                                        @endif</label>
                                        <input type="file" class="control" name="catalog" v-validate="''">
                                        <span class="control-error" v-if="errors.has('catalog')">@{{ errors.first('catalog') }}</span>
                                    </div>

                                    <div class="control-group" :class="[errors.has('datasheet') ? 'has-error' : '']">
                                        <label for="datasheet" class="">{{ __('admin::app.catalog.products.datasheet') }}
                                        @if($product->datasheet != "")
                                            <a href="{{ asset('/').$product->datasheet }}" download="{{ __('velocity::app.products.datasheet').'_'.$product->url_key }}"><img src="{{ asset('themes/default/assets/images/product/icons/'.$icons2) }}" alt="{{ __('velocity::app.products.datasheet-download') }}"></a> 
                                        @endif</label>
                                        <input type="file" class="control" name="datasheet" v-validate="''">
                                        <span class="control-error" v-if="errors.has('datasheet')">@{{ errors.first('datasheet') }}</span>
                                    </div>
                            @endif
                                @endif

                                @endforeach

                                @if ($attributeGroup->name == 'Price')

                                    @include ('admin::catalog.products.accordians.customer-group-price')

                                @endif

                                {!! view_render_event('bagisto.admin.catalog.product.edit_form_accordian.' . $attributeGroup->name . '.controls.after', ['product' => $product]) !!}
                            </div>
                        </accordian>

                        {!! view_render_event('bagisto.admin.catalog.product.edit_form_accordian.' . $attributeGroup->name . '.after', ['product' => $product]) !!}

                    @endif

                @endforeach

                {!! view_render_event(
                  'bagisto.admin.catalog.product.edit_form_accordian.additional_views.before',
                   ['product' => $product])
                !!}
                @foreach ($product->getTypeInstance()->getAdditionalViews() as $view)
                    @include ($view)
                @endforeach

                {!! view_render_event(
                  'bagisto.admin.catalog.product.edit_form_accordian.additional_views.after',
                   ['product' => $product])
                !!}
            </div>

        </form>

        {!! view_render_event('bagisto.admin.catalog.product.edit.after', ['product' => $product]) !!}
    </div>
@stop

@push('scripts')
    <script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#channel-switcher, #locale-switcher').on('change', function (e) {
                $('#channel-switcher').val()
                var query = '?channel=' + $('#channel-switcher').val() + '&locale=' + $('#locale-switcher').val();

                window.location.href = "{{ route('admin.catalog.products.edit', $product->id)  }}" + query;
            })

            tinymce.init({
                selector: 'textarea#description, textarea#short_description',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor link hr | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true
            });
        });
    </script>
@endpush
