@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.settings.offer-gallary.edit-title') }}
@stop

@section('content')
    <div class="content">
        <form
            method="POST"
            @submit.prevent="onSubmit"
            enctype="multipart/form-data"
            action="{{ route('admin.offer-gallary.update', $offerGallary->id) }}">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

                        {{ __('admin::app.settings.offer-gallary.edit-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.settings.offer-gallary.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                        <label for="title" class="required">{{ __('admin::app.settings.offer-gallary.name') }}</label>
                        <input type="text" class="control" name="title" v-validate="'required'" value="{{ $offerGallary->title }}" data-vv-as="&quot;{{ __('admin::app.settings.offer-gallary.name') }}&quot;">
                        <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('image') ? 'has-error' : '']">
	                    <label for="image">{{ __('admin::app.settings.offer-gallary.image') }}</label>
	                    <div class="preview">
	                        <img src="{{ asset('/').$offerGallary->image }}" id="file-ip-1-preview" height="30%" width="35%">
	                    </div>
	                    <input type="file" name="image" id="file-ip-1" class="control" accept="image/*" onchange="showPreview(event);" v-validate="''" data-vv-as="&quot;{{ __('admin::app.settings.offer-gallary.image') }}&quot;"/>
	                    <span class="control-error" v-if="errors.has('image')">@{{ errors.first('image') }}</span>
	                </div>

	                <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
	                    <label for="status" class="required">{{ __('admin::app.settings.offer-gallary.status') }}</label>
	                    <select name="status" class="control" v-validate="'required'" data-vv-as="&quot;{{__('admin::app.settings.offer-gallary.status') }}&quot;">
	                        <option value="1" {{ $offerGallary->status == '1' ? 'selected' : '' }}>{{ __('admin::app.settings.offer-gallary.active') }}</option>
	                        <option value="0" {{ $offerGallary->status == '0' ? 'selected' : '' }}>{{ __('admin::app.settings.offer-gallary.inactive') }}</option>
	                    </select>
	                    <span class="control-error" v-if="errors.has('status')">
	                        @{{ errors.first('status') }}
	                    </span>
	                </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
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
@endpush