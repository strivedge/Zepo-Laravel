@extends('admin::layouts.content')

@section('page_title')
{{__('blog::app.blogs.edit-title') }}
@stop

@section('content')
<div class="content">
    <form method="POST" action="{{route('admin.blog.update', [$posts->id])}}" enctype="multipart/form-data" @submit.prevent="onSubmit">

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
                    <input type="text" class="control" name="title" value="{{$posts->title}}" v-validate="'required'">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="file-ip-1" class="required">{{ __('blog::app.blogs.blog-image') }}</label>
                    <div class="preview">
                        <img src="{{ asset('uploadImages/'.$posts->image) }}" id="file-ip-1-preview" alt="{{ __('blog::app.blogs.image') }}" height="70" width="110">
                    </div>
                    <div>
                        <input type="file" name="image" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
                    </div>
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('slug') ? 'has-error' : '']">
                    <label for="slug" class="required">{{ __('blog::app.blogs.blog-slug') }}</label>
                    <input type="text" class="control" name="slug" id="slug" value="{{$posts->slug}}" v-validate="'required'" data-vv-as="&quot;{{ __('blog::app.blogs.blog-slug') }}&quot;" v-slugify>
                    <span class="control-error" v-if="errors.has('slug')">@{{ errors.first('slug') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                    <label for="content" class="required">{{ __('blog::app.blogs.blog-content') }}</label>
                    <textarea type="text" class="control" name="content" v-validate="'required'">{{$posts->content}}</textarea>
                    <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('blog::app.blogs.blog-date') }}</label>
                    <input type="date" class="control" name="date" value="{{$posts->date}}"  v-validate="'required'">
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