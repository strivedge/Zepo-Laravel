@extends('admin::layouts.content')

@section('page_title')
{{__('blog::app.blogs.add-title') }}
@stop
<style>
    .errSpan
    {
        color: red;
    }
</style>
@section('content')
<div class="content">
    <form method="POST" action="saveBlog" enctype="multipart/form-data" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('blog::app.blogs.add-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('blog::app.blogs.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">

            <div class="form-container">
                @csrf()
                <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                    <label for="title" class="required">{{ __('blog::app.blogs.blog-title') }}</label>
                    <input type="text" class="control" name="title" placeholder="Enter blog title here" v-validate="'required'">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="image" class="required">{{ __('blog::app.blogs.blog-image') }}</label>
                    <input type="file" class="control" name="image"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                    <label for="content" class="required">{{ __('blog::app.blogs.blog-content') }}</label>
                    <textarea type="text" class="control" name="content" placeholder="Enter blog content here" v-validate="'required'"></textarea>
                    <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('blog::app.blogs.blog-date') }}</label>
                    <input type="date" class="control" name="date" value='<?php echo date("Y-m-d"); ?>'  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('date')">@{{ errors.first('date') }}</span>
                </div>
                
            </div>
        </div>
    </form>
</div>
@stop