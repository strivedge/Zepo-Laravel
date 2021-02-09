@extends('admin::layouts.content')

@section('page_title')
{{__('testinominal::app.testinominal.edit-title') }}
@stop

@section('content')
<div class="content">

    <form method="POST" action="{{route('admin.testinominal.update', [$posts->id])}}" enctype="multipart/form-data" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('testinominal::app.testinominal.edit-title') }}
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
                    <input type="text" class="control" name="title" value="{{$posts->title}}" v-validate="'required'">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="file-ip-1" class="required">{{ __('testinominal::app.testinominal.upload-image') }}</label>
                    <div class="preview">
                        <img src="{{ asset('uploadImages/'.$posts->image) }}" id="file-ip-1-preview" alt="{{ __('testinominal::app.testinominal.image') }}" height="70" width="110">
                    </div>
                    <div>
                        <input type="file" name="image" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
                    </div>
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('desc') ? 'has-error' : '']">
                    <label for="desc" class="required">{{ __('testinominal::app.testinominal.desc') }}</label>
                    <textarea type="text" class="control" name="desc" v-validate="'required'">{{$posts->desc}}</textarea>
                    <span class="control-error" v-if="errors.has('desc')">@{{ errors.first('desc') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('date') ? 'has-error' : '']">
                    <label for="date" class="required">{{ __('testinominal::app.testinominal.date') }}</label>
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