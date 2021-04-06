@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.discounts.add-title') }}
@stop

@section('content')
<div class="content">
    <form method="POST" action="{{ route('admin.catalog.discount.save') }}" @submit.prevent="onSubmit">

    	<div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('admin::app.catalog.discounts.add-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('admin::app.catalog.discounts.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">
            <div class="form-container">
                @csrf()
                <div class="control-group" :class="[errors.has('discount_type') ? 'has-error' : '']">
                    <label for="discount_type" class="required">{{ __('admin::app.catalog.discounts.discount-type') }}</label>
                    <div class="row">
                    <input type="radio" class="control" name="discount_type" value="{{ old('discount_type') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.basic-discount') }}&quot;"/ onclick="basicDiscount()" checked>{{__('admin::app.catalog.discounts.basic-discount') }} 
                    <input type="radio" class="control" name="discount_type" value="{{ old('discount_type') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.extra-bulk-discount') }}&quot;"/ onclick="bulkDiscount()">{{__('admin::app.catalog.discounts.extra-bulk-discount') }} 
                    </div>
                    <span class="control-error" v-if="errors.has('discount_type')">
                        @{{ errors.first('discount_type') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('percentage') ? 'has-error' : '']">
                    <label for="percentage" class="required">{{ __('admin::app.catalog.discounts.percentage') }}</label>
                    <input type="text" class="control" name="percentage" v-validate="'required'" value="{{ old('percentage') }}" placeholder="{{ __('admin::app.catalog.discounts.percen-placeholder') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.percentage') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('percentage')">
                        @{{ errors.first('percentage') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('discount_condition') ? 'has-error' : '']">
                    <label for="discount_condition" class="required">{{ __('admin::app.catalog.discounts.condition') }}</label>
                    <select name="discount_condition" class="control" v-validate="'required'" data-vv-as="&quot;{{__('admin::app.catalog.discounts.condition') }}&quot;">
                        <option value=">=">{{ __('admin::app.catalog.discounts.greater-equal') }}</option>
                    </select>
                    <span class="control-error" v-if="errors.has('discount_condition')">
                        @{{ errors.first('discount_condition') }}
                    </span>
                </div>

                <div class="control-group" id="discount_qty" :class="[errors.has('discount_qty') ? 'has-error' : '']">
                    <label for="discount_qty" class="required">{{ __('admin::app.catalog.discounts.qty') }}</label>
                    <input type="text" class="control" name="discount_qty" v-validate="'required'" value="{{ old('discount_qty') }}" placeholder="{{ __('admin::app.catalog.discounts.qty-placeholder') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.qty') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('discount_qty')">
                        @{{ errors.first('discount_qty') }}
                    </span>
                </div>

                <div class="control-group" id="purchase" :class="[errors.has('discount_purchase') ? 'has-error' : '']">
                    <label for="discount_purchase" class="required">{{ __('admin::app.catalog.discounts.purchase') }}</label>
                    <input type="text" class="control" name="discount_purchase" v-validate="'required'" value="{{ old('discount_purchase') }}" placeholder="{{ __('admin::app.catalog.discounts.purchase-placeholder') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.purchase') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('discount_purchase')">
                        @{{ errors.first('discount_purchase') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('discount_by') ? 'has-error' : '']">
                    <label for="discount_by" class="required">{{ __('admin::app.catalog.discounts.discount-by') }}</label>
                    <input type="text" class="control" name="discount_by" v-validate="'required'" value="{{ old('discount_by') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.discount-by') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('discount_by')">
                        @{{ errors.first('discount_by') }}
                    </span>
                </div>

            </div>
        </div>
    </form>
</div>
@stop

<script>
	var radios = document.getElementsByName('discount_type');
	function basicDiscount() {
		var getQty = document.getElementById("discount_qty");
		var getPurchase = document.getElementById("purchase");
		console.log(radios);
		// if(radios[0].checked = true)
			getQty.style.display = "block";
	    	getPurchase.style.display = "none";
	}

	function bulkDiscount() {
		var getQty = document.getElementById("discount_qty");
		var getPurchase = document.getElementById("purchase");
		getQty.style.display = "none";
		getPurchase.style.display = "block";
	}
</script>