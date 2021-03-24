@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.zipcodes.edit-title') }}
@stop

@section('content')
<div class="content">
    <form method="POST" action="{{ route('admin.catalog.zipcode.update', [$zipcodes->id]) }}" @submit.prevent="onSubmit">
        
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('admin::app.catalog.zipcodes.edit-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('admin::app.catalog.zipcodes.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">
            <div class="form-container">
                @csrf()
                <div class="control-group" :class="[errors.has('area_name') ? 'has-error' : '']">
                    <label for="area_name" class="required">{{ __('admin::app.catalog.zipcodes.area-name') }}</label>
                    <input type="text" class="control" name="area_name" v-validate="'required'" value="{{ $zipcodes->area_name }}" data-vv-as="&quot;{{__('admin::app.catalog.zipcodes.area-name') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('area_name')">
                        @{{ errors.first('area_name') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('zipcode') ? 'has-error' : '']">
                    <label for="zipcode" class="required">{{ __('admin::app.catalog.zipcodes.zipcode') }}</label>
                    <input type="zipcode" class="control" name="zipcode" v-validate="'required'" value="{{ $zipcodes->zipcode }}" data-vv-as="&quot;{{__('admin::app.catalog.zipcodes.zipcode') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('zipcode')">
                        @{{ errors.first('zipcode') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                    <label for="status" class="required">{{ __('admin::app.catalog.zipcodes.status') }}</label>
                    <select name="status" class="control" v-validate="'required'" data-vv-as="&quot;{{__('offer::app.offer.offer-status') }}&quot;">
                        <option value="1" {{$zipcodes->status == '1' ? 'selected' : ''}}>{{ __('admin::app.catalog.zipcodes.active') }}</option>
                        <option value="0" {{$zipcodes->status == '0' ? 'selected' : ''}}>{{ __('admin::app.catalog.zipcodes.inactive') }}</option>
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