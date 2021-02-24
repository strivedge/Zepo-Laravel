@extends('admin::layouts.content')

@section('page_title')
{{__('festival::app.festival.edit-title') }}
@stop

@section('content')
<div class="content">

    <form method="POST" action="{{route('admin.festival.update', [$festival['id']])}}" enctype="multipart/form-data" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('festival::app.festival.edit-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('festival::app.festival.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">

            <div class="form-container">
                @csrf()
                <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                    <label for="title" class="required">{{ __('festival::app.festival.festival-title') }}</label>
                    <input type="text" class="control" name="title" value="{{$festival['title']}}" v-validate="'required'">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>

                 <div class="control-group" :class="[errors.has('short_desc') ? 'has-error' : '']">
                    <label for="short_desc" class="required">{{ __('festival::app.festival.short_desc') }}</label>
                    <textarea type="text" class="control" name="short_desc" placeholder="Enter short description here" v-validate="'required'">{{$festival['short_desc']}}</textarea>
                    <span class="control-error" v-if="errors.has('short_desc')">@{{ errors.first('short_desc') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('long_desc') ? 'has-error' : '']">
                    <label for="long_desc" class="required">{{ __('festival::app.festival.long_desc') }}</label>
                    <textarea type="text" class="control" name="long_desc" placeholder="Enter long description here" v-validate="'required'">{{$festival['long_desc']}}</textarea>
                    <span class="control-error" v-if="errors.has('long_desc')">@{{ errors.first('long_desc') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="file-ip-1" class="required">{{ __('festival::app.festival.upload-image') }}</label>
                    <div class="preview">
                        <img src="{{ asset($festival['image']) }}" id="file-ip-1-preview" alt="{{ __('festival::app.festival.image') }}" height="70" width="110">
                    </div>
                    <div>
                        <input type="file" name="image" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
                    </div>
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                    <label for="status" class="required">{{ __('festival::app.festival.status') }}</label>
                    <select name="status" class="control" v-validate="'required'">
                        <option value="1" {{$festival['status'] == '1' ? 'selected' : ''}}>Active</option>
                        <option value="0" {{$festival['status'] == '0' ? 'selected' : ''}}>Inactive</option>
                    </select>
                    <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('festival::app.festival.start-date') }}</label>
                    <input type="date" class="control" name="start_date" value="{{$festival['start_date']}}"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('date')">@{{ errors.first('date') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('festival::app.festival.end-date') }}</label>
                    <input type="date" class="control" name="end_date" value="{{$festival['end_date']}}"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('date')">@{{ errors.first('date') }}</span>
                </div>


                <div slot="body">

                    <linked-products></linked-products>

                </div>

            </div>
        </div>
    </form>
</div>

@stop

<script>
    function showPreview(event)
    {
        if(event.target.files.length > 0)
        {
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("file-ip-1-preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }
</script>



@push('scripts')

<script type="text/x-template" id="linked-products-template">
    <div>

        <div class="control-group" v-for='(key) in linkedProducts'>
            <label for="up-selling" v-if="(key == 'up_sells')">
                {{ __('festival::app.festival.festival_product') }}
            </label>
           
            <input type="text" class="control" autocomplete="off" v-model="search_term[key]" placeholder="{{ __('admin::app.catalog.products.product-search-hint') }}" v-on:keyup="search(key)">

            <div class="linked-product-search-result">
                <ul>
                    <li v-for='(product, index) in products[key]' v-if='products[key].length' @click="addProduct(product, key)">
                        @{{ product.name }}
                    </li>

                    <li v-if='! products[key].length && search_term[key].length && ! is_searching[key]'>
                        {{ __('admin::app.catalog.products.no-result-found') }}
                    </li>

                    <li v-if="is_searching[key] && search_term[key].length">
                        {{ __('admin::app.catalog.products.searching') }}
                    </li>
                </ul>
            </div>

            <input type="hidden" name="up_sell[]" v-for='(product, index) in addedProducts.up_sells' v-if="(key == 'up_sells') && addedProducts.up_sells.length" :value="product.id"/>

            
            <span class="filter-tag linked-product-filter-tag" v-if="addedProducts[key].length">
                <span class="wrapper linked-product-wrapper " v-for='(product, index) in addedProducts[key]'>
                    <span class="do-not-cross-linked-product-arrow">
                        @{{ product.name }}
                    </span>
                    <span class="icon cross-icon" @click="removeProduct(product, key)"></span>
                </span>
            </span>
        </div>

    </div>
</script>


<script>

    Vue.component('linked-products', {

        template: '#linked-products-template',

        data: function() {
            return {
                products: {
                    'up_sells': []
                },

                search_term: {
                    'up_sells': ''
                },

                addedProducts: {
                    'up_sells': []
                },

                is_searching: {
                    'up_sells': false
                },

                linkedProducts: ['up_sells'],

                upSellingProducts: @json($product),
            }
        },

        created: function () {
            console.log(this.upSellingProducts)
            if (this.upSellingProducts.length >= 1) {
                for (var index in this.upSellingProducts) {
                    this.addedProducts.up_sells.push(this.upSellingProducts[index]);
                }

            }
        },

        methods: {
            addProduct: function (product, key) {
                this.addedProducts[key].push(product);
                this.search_term[key] = '';
                this.products[key] = []
            },

            removeProduct: function (product, key) {
                for (var index in this.addedProducts[key]) {
                    if (this.addedProducts[key][index].id == product.id ) {
                        this.addedProducts[key].splice(index, 1);
                    }
                }
            },

            search: function (key) {
                this_this = this;

                this.is_searching[key] = true;

                if (this.search_term[key].length >= 1) {
                    this.$http.get ("{{ route('admin.catalog.products.productlinksearch') }}", {params: {query: this.search_term[key]}})
                        .then (function(response) {

                            for (var index in response.data) {
                                if (response.data[index].id == this_this.productId) {
                                    response.data.splice(index, 1);
                                }
                            }

                            if (this_this.addedProducts[key].length) {
                                for (var product in this_this.addedProducts[key]) {
                                    for (var productId in response.data) {
                                        if (response.data[productId].id == this_this.addedProducts[key][product].id) {
                                            response.data.splice(productId, 1);
                                        }
                                    }
                                }
                            }

                            this_this.products[key] = response.data;

                            this_this.is_searching[key] = false;
                        })

                        .catch (function (error) {
                            this_this.is_searching[key] = false;
                        })
                } else {
                    this_this.products[key] = [];
                    this_this.is_searching[key] = false;
                }
            }
        }
    });

</script>



@endpush