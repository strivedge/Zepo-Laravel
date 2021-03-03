@extends('admin::layouts.content')

@section('page_title')
{{__('testinominal::app.testinominal.add-title') }}
@stop
@section('content')
@if(session()->get('errors'))
    @php
        $errors = session()->get('errors');
    @endphp
@endif
<div class="content">
    <form method="POST" action="{{ route('admin.testinominal.save') }}" enctype="multipart/form-data" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('testinominal::app.testinominal.add-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('testinominal::app.testinominal.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">
            <div class="form-container">
                @csrf()
                <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                    <label for="title" class="required">{{ __('testinominal::app.testinominal.testi-title') }}</label>
                    <input type="text" class="control" name="title" placeholder="{{ __('testinominal::app.testinominal.title-placeholder') }}" v-validate="'required'" data-vv-as="&quot;{{ __('testinominal::app.testinominal.testi-title') }}&quot;">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="image" class="required">{{ __('testinominal::app.testinominal.upload-image') }}</label>
                    <div class="preview">
                        <img id="file-ip-1-preview" style="display: none;" height="30%" width="35%">
                    </div>
                    <input type="file" name="image" id="file-ip-1" accept="image/*" onchange="showPreview(event);" v-validate="'required'"  data-vv-as="&quot;{{ __('testinominal::app.testinominal.image') }}&quot;">
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('desc') ? 'has-error' : '']">
                    <label for="desc" class="required">{{ __('testinominal::app.testinominal.desc') }}</label>
                    <textarea type="text" class="control" name="desc" placeholder="{{ __('testinominal::app.testinominal.desc-placeholder') }}" v-validate="'required'" data-vv-as="&quot;{{ __('testinominal::app.testinominal.desc') }}&quot;"></textarea>
                    <span class="control-error" v-if="errors.has('desc')">@{{ errors.first('desc') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('testinominal::app.testinominal.date') }}</label>
                    <input type="date" class="control" name="date" value='<?php echo date("Y-m-d"); ?>'  v-validate="'required'" data-vv-as="&quot;{{ __('testinominal::app.testinominal.date') }}&quot;">
                    <span class="control-error" v-if="errors.has('date')">@{{ errors.first('date') }}</span>
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