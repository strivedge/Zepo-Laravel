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
                <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                    <label for="title" class="required">{{ __('blog::app.blogs.blog-title') }}</label>
                    <input type="text" class="control" name="title" value="{{$post->title}}" v-validate="'required'">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="image" class="required">{{ __('blog::app.blogs.blog-image') }}</label>
                    <div>
                        <img src="{{ asset('uploadImages/'.$post->image) }}" alt="Image" height="30" width="60">
                    </div>
                    <div>
                        <input type="file" name="image">
                    </div>
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                    <label for="content" class="required">{{ __('blog::app.blogs.blog-content') }}</label>
                    <textarea type="text" class="control" name="content" v-validate="'required'">{{$post->content}}</textarea>
                    <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('blog::app.blogs.blog-date') }}</label>
                    <input type="date" class="control" name="date" value="{{$post->date}}"  v-validate="'required'">
                    <span class="control-error" v-if="errors.has('date')">@{{ errors.first('date') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </form>
</div>
@stop