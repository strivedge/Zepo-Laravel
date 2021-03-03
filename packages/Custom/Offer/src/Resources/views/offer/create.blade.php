@extends('admin::layouts.content')

@section('page_title')
{{__('offer::app.offer.add-title') }}
@stop
@section('content')
@if(session()->get('errors'))
    @php
        $errors = session()->get('errors');
    @endphp
@endif
<div class="content">
    <form method="POST" action="{{ route('admin.offer.save') }}" enctype="multipart/form-data" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('offer::app.offer.add-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('offer::app.offer.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">
            <div class="form-container">
                @csrf()
                <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                    <label for="title" class="required">{{ __('offer::app.offer.offer-title') }}</label>
                    <input type="text" class="control" name="title" v-validate="'required'" placeholder="{{ __('offer::app.offer.title-placeholder') }}" data-vv-as="&quot;{{__('offer::app.offer.offer-title') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('title')">
                        @{{ errors.first('title') }}
                    </span>
                </div>
                
                <div class="control-group" :class="[errors.has('desc') ? 'has-error' : '']">
                    <label for="desc" class="required">{{ __('offer::app.offer.desc') }}</label>
                    <textarea type="text" class="control" name="desc" v-validate="'required'" placeholder="{{ __('offer::app.offer.desc-placeholder') }}" data-vv-as="&quot;{{__('offer::app.offer.desc') }}&quot;">
                    </textarea>
                    <span class="control-error" v-if="errors.has('desc')">
                        @{{ errors.first('desc') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="image" class="required">{{ __('offer::app.offer.upload-image') }}</label>
                    <div class="preview">
                        <img id="file-ip-1-preview" style="display: none;" height="30%" width="35%">
                    </div>
                    <input type="file" name="image" id="file-ip-1" accept="image/*" onchange="showPreview(event);" v-validate="'required'" data-vv-as="&quot;{{__('offer::app.offer.image') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                    <label for="status" class="required">{{ __('offer::app.offer.offer-status') }}</label>
                    <select name="status" class="control" v-validate="'required'" data-vv-as="&quot;{{__('offer::app.offer.offer-status') }}&quot;">
                        <option value="1">{{ __('offer::app.offer.active') }}</option>
                        <option value="0" selected>{{ __('offer::app.offer.inactive') }}</option>
                    </select>
                    <span class="control-error" v-if="errors.has('status')">
                        @{{ errors.first('status') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('start_date') ? 'has-error' : '']">
                    <label for="start_date" class="required">{{ __('offer::app.offer.start-date') }}</label>
                    <input type="date" class="control" name="start_date" v-validate="'required'" data-vv-as="&quot;{{__('offer::app.offer.start-date') }}&quot;" value='<?php echo date("Y-m-d"); ?>'/>
                    <span class="control-error" v-if="errors.has('start_date')">
                        @{{ errors.first('start_date') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('end_date') ? 'has-error' : '']">
                    <label for="end_date" class="required">{{ __('offer::app.offer.end-date') }}</label>
                    <input type="date" class="control" name="end_date" v-validate="'required'" data-vv-as="&quot;{{__('offer::app.offer.end-date') }}&quot;" value='<?php echo date("Y-m-d", strtotime("+ 1 day")); ?>'/>
                    <span class="control-error" v-if="errors.has('end_date')">
                        @{{ errors.first('end_date') }}
                    </span>
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