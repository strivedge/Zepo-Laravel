@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.discounts.edit-title') }}
@stop

@section('content')
<div class="content">
 	<form method="POST" action="{{ route('admin.catalog.discount.update', [$discount->id]) }}" @submit.prevent="onSubmit">

    	<div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('admin::app.catalog.discounts.edit-title') }}
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
                    <input type="radio" class="control" name="discount_type" value="{{__('admin::app.catalog.discounts.basic-discount') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.basic-discount') }}&quot;"/ {{ $discount->discount_type == 'Basic Discount' ? 'checked' : ''}}>{{__('admin::app.catalog.discounts.basic-discount') }}
                    <input type="radio" class="control" name="discount_type" value="{{__('admin::app.catalog.discounts.extra-bulk-discount') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.extra-bulk-discount') }}&quot;"/ {{ $discount->discount_type == 'Extra Bulk Discount' ? 'checked' : ''}}>{{__('admin::app.catalog.discounts.extra-bulk-discount') }}
                    </div>
                    <span class="control-error" v-if="errors.has('discount_type')">
                        @{{ errors.first('discount_type') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('percentage') ? 'has-error' : '']">
                    <label for="percentage" class="required">{{ __('admin::app.catalog.discounts.percentage') }}</label>
                    <input type="text" class="control" name="percentage" v-validate="'required'" value="{{ $discount->percentage }}" placeholder="{{ __('admin::app.catalog.discounts.percen-placeholder') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.percentage') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('percentage')">
                        @{{ errors.first('percentage') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('discount_condition') ? 'has-error' : '']">
                    <label for="discount_condition" class="required">{{ __('admin::app.catalog.discounts.condition') }}</label>
                    <select name="discount_condition" class="control" v-validate="'required'" data-vv-as="&quot;{{__('admin::app.catalog.discounts.condition') }}&quot;">
                        <option value=">=" {{ $discount->discount_condition == '>=' ? 'selected' : ''}}>{{ __('admin::app.catalog.discounts.greater-equal') }}</option>
                    </select>
                    <span class="control-error" v-if="errors.has('discount_condition')">
                        @{{ errors.first('discount_condition') }}
                    </span>
                </div>

                <div class="control-group" id="discount_qty" :class="[errors.has('discount_qty') ? 'has-error' : '']">
                    <label for="discount_qty" class="required">{{ __('admin::app.catalog.discounts.qty') }}</label>
                    <input type="text" class="control" name="discount_qty" value="{{ $discount->discount_qty }}" placeholder="{{ __('admin::app.catalog.discounts.qty-placeholder') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.qty') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('discount_qty')">
                        @{{ errors.first('discount_qty') }}
                    </span>
                </div>

                <div class="control-group" id="purchase" :class="[errors.has('discount_purchase') ? 'has-error' : '']">
                    <label for="discount_purchase" class="required">{{ __('admin::app.catalog.discounts.purchase') }}</label>
                    <input type="text" class="control" name="discount_purchase" value="{{ $discount->discount_purchase }}" placeholder="{{ __('admin::app.catalog.discounts.purchase-placeholder') }}" data-vv-as="&quot;{{__('admin::app.catalog.discounts.purchase') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('discount_purchase')">
                        @{{ errors.first('discount_purchase') }}
                    </span>
                </div>

                <div class="control-group">
                    <input type="hidden" class="control" name="discount_by" value="{{ $discount->discount_by }}">
                </div>

                <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                    <label for="status" class="required">{{ __('admin::app.catalog.discounts.status') }}</label>
                    <select name="status" class="control" v-validate="'required'" data-vv-as="&quot;{{__('admin::app.catalog.discounts.status') }}&quot;">
                        <option value="1" {{ $discount->status == '1' ? 'selected' : ''}}>{{ __('admin::app.catalog.discounts.active') }}</option>
                        <option value="0" {{ $discount->status == '0' ? 'selected' : ''}}>{{ __('admin::app.catalog.discounts.inactive') }}</option>
                    </select>
                    <span class="control-error" v-if="errors.has('status')">
                        @{{ errors.first('status') }}
                    </span>
                </div>

                </div>
        </div>
    </form>
</div>
@stop

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	var inputValue = $('input[name="discount_type"]:checked').attr("value");
	discountForm(inputValue);

	function discountForm(inputValue) {
		if(inputValue == "Basic Discount") {
			$("#discount_qty").show();
			$("#purchase").hide();
            $('input[name="purchase"]').val("");
			$("input[name='discount_by']").val("Peace");
		} else {
			$("#purchase").show();
			$("#discount_qty").val("").hide();
            $('input[name="discount_qty"]').val("");
			$("input[name='discount_by']").val("Amount");
		}
	}

	$('input[name="discount_type"]').click(function() {
		var inputValue = $(this).attr("value");
		// console.log(inputValue);
		discountForm(inputValue);
	});
});
</script>
@endpush