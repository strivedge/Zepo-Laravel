@extends('admin::layouts.content')

@section('page_title')
{{__('testinominal::app.testinominal.add-title') }}
@stop
@section('content')
<div class="content">
    <form method="POST" action="saveTestinominal" enctype="multipart/form-data" @submit.prevent="onSubmit">

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
                    <label for="title" class="required">{{ __('testinominal::app.testinominal.title') }}</label>
                    <input type="text" class="control" name="title" placeholder="Enter Testinominal title here" v-validate="'required'">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="image" class="required">{{ __('testinominal::app.testinominal.image') }}</label>
                    <input type="file" class="control" name="image"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('desc') ? 'has-error' : '']">
                    <label for="desc" class="required">{{ __('testinominal::app.testinominal.desc') }}</label>
                    <textarea type="text" class="control" name="desc" placeholder="Enter desc here" v-validate="'required'"></textarea>
                    <span class="control-error" v-if="errors.has('desc')">@{{ errors.first('desc') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('testinominal::app.testinominal.date') }}</label>
                    <input type="date" class="control" name="date" value="2021-01-01"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('date')">@{{ errors.first('date') }}</span>
                </div>
                
            </div>
        </div>
    </form>
</div>
@stop