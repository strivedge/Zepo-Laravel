@extends('admin::layouts.content')

@section('page_title')
{{__('offer::app.offer.edit-title') }}
@stop

@section('content')
@if(session()->get('errors'))
    @php
        $errors = session()->get('errors');
    @endphp
@endif
<div class="content">
    <form method="POST" action="{{route('admin.offer.update', [$offers->id])}}" enctype="multipart/form-data" @submit.prevent="onSubmit">
        
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('offer::app.offer.edit-title') }}
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
                    <input type="text" class="control" name="title" value="{{$offers->title}}" v-validate="'required'" data-vv-as="&quot;{{ __('offer::app.offer.offer-title') }}&quot;">
                    <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('desc') ? 'has-error' : '']">
                    <label for="desc" class="required">{{ __('offer::app.offer.desc') }}</label>
                    <textarea type="text" class="control" name="desc" v-validate="'required'" data-vv-as="&quot;{{ __('offer::app.offer.desc') }}&quot;">{{$offers->desc}}</textarea>
                    <span class="control-error" v-if="errors.has('desc')">@{{ errors.first('desc') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
                    <label for="file-ip-1" class="required">{{ __('offer::app.offer.upload-image') }}</label>
                    <div class="preview">
                        <img src="{{ asset('/').$offers->image }}" id="file-ip-1-preview" alt="{{ __('offer::app.offer.image') }}">
                    </div>
                    <div>
                        <input type="file" name="image" id="file-ip-1" accept="image/*" onchange="showPreview(event);" v-validate="''" data-vv-as="&quot;{{ __('offer::app.offer.image') }}&quot;">
                    </div>
                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                    <label for="status" class="required">{{ __('offer::app.offer.offer-status') }}</label>
                    <select name="status" class="control" v-validate="'required'" data-vv-as="&quot;{{ __('offer::app.offer.offer-status') }}&quot;">
                        <option value="1" {{$offers->status == '1' ? 'selected' : ''}}>{{ __('offer::app.offer.active') }}</option>
                        <option value="0" {{$offers->status == '0' ? 'selected' : ''}}>{{ __('offer::app.offer.inactive') }}</option>
                    </select>
                    <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('start_date') ? 'has-error' : '']">
                    <label for="start_date" class="required">{{ __('offer::app.offer.start-date') }}</label>
                    <input type="date" class="control" name="start_date" value="{{$offers->start_date}}"  v-validate="'required'" data-vv-as="&quot;{{ __('offer::app.offer.start-date') }}&quot;">
                    <span class="control-error" v-if="errors.has('start_date')">@{{ errors.first('start_date') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('end_date') ? 'has-error' : '']">
                    <label for="end_date" class="required">{{ __('offer::app.offer.end-date') }}</label>
                    <input type="date" class="control" name="end_date" value="{{$offers->end_date}}"  v-validate="'required'" data-vv-as="&quot;{{ __('offer::app.offer.end-date') }}&quot;">
                    <span class="control-error" v-if="errors.has('end_date')">@{{ errors.first('end_date') }}</span>
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