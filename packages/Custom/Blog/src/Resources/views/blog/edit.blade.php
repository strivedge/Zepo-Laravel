@extends('admin::layouts.content')

@section('page_title')
{{__('blog::app.blogs.edit-title') }}
@stop

@section('content')
<div class="content">
    @foreach($posts as $post)
    <form method="POST" action="{{route('blog_update', [$post->id])}}" enctype="multipart/form-data" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('blog::app.blogs.edit-title') }}
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
                <div class="control-group" :class="[errors.has('blog_title') ? 'has-error' : '']">
                    <label for="blog_title" class="required">{{ __('blog::app.blogs.blog_title') }}</label>
                    <input type="text" class="control" name="blog_title" value="{{$post->title}}" v-validate="'required'">
                    <span class="control-error" v-if="errors.has('blog_title')">@{{ errors.first('blog_title') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('blog_image') ? 'has-error' : '']">
                    <label for="blog_image" class="required">{{ __('blog::app.blogs.blog_image') }}</label>
                    <div>
                        <img src="{{ asset('uploadImages/'.$post->image) }}" alt="Image" height="30" width="60">
                    </div>
                    <div>
                        <input type="file" name="blog_image">
                    </div>
                    <span class="control-error" v-if="errors.has('blog_image')">@{{ errors.first('blog_image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('blog_content') ? 'has-error' : '']">
                    <label for="blog_content" class="required">{{ __('blog::app.blogs.blog_content') }}</label>
                    <textarea type="text" class="control" name="blog_content" v-validate="'required'">{{$post->content}}</textarea>
                    <span class="control-error" v-if="errors.has('blog_content')">@{{ errors.first('blog_content') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('blog_date') ? 'has-error' : '']">
                    <label for="blog_date" class="required">{{ __('blog::app.blogs.blog_date') }}</label>
                    <input type="date" class="control" name="blog_date" value="{{$post->date}}"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('blog_date')">@{{ errors.first('blog_date') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
@stop