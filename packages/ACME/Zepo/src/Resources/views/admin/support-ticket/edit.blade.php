@extends('admin::layouts.content')

@section('page_title')
    {{__('zepo::app.support-ticket.edit-title') }}
@stop

@section('content')
<div class="content">
    <form method="POST" action="{{ route('zepo.support-ticket.update', [$supportTicket->id]) }}" enctype="multipart/form-data" @submit.prevent="onSubmit">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{__('zepo::app.support-ticket.edit-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button type="submit" class="btn btn-lg btn-primary">
                    {{ __('zepo::app.support-ticket.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">
            <div class="form-container">
                @csrf()
                <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                    <label for="name" class="required">{{ __('zepo::app.support-ticket.name') }}</label>
                    <input type="text" class="control" name="name" value="{{ $supportTicket->name }}" v-validate="'required'" data-vv-as="&quot;{{__('zepo::app.support-ticket.name') }}&quot;">
                    <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                    <label for="email" class="required">{{ __('zepo::app.support-ticket.email') }}</label>
                    <input type="email" class="control" name="email" value="{{ $supportTicket->email }}" v-validate="'required'" data-vv-as="&quot;{{__('zepo::app.support-ticket.email') }}&quot;">
                    <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('message') ? 'has-error' : '']">
                    <label for="message" class="required">{{ __('zepo::app.support-ticket.message') }}</label>
                    <textarea type="text" class="control" name="message" v-validate="'required'" data-vv-as="&quot;{{__('zepo::app.support-ticket.message') }}&quot;">{{ $supportTicket->message }}</textarea>
                    <span class="control-error" v-if="errors.has('message')">@{{ errors.first('message') }}</span>
                </div>
                
                <div class="control-group" :class="[errors.has('attachment') ? 'has-error' : '']">
                    <label for="file-ip-1">{{ __('zepo::app.support-ticket.attachment') }}</label>
                    <div class="preview">
                        <img src="{{ asset('uploadImages/supportTicket/'.$supportTicket->attachment) }}" alt="{{ __('zepo::app.support-ticket.attachment') }}" :onerror="`this.src='${this.$root.baseUrl}/vendor/webkul/ui/assets/images/product/large-product-placeholder.png'`" id="file-ip-1-preview">
                    </div>
                    <div>
                        <input type="file" name="attachment" id="file-ip-1" accept="image/*" onchange="showPreview(event);" v-validate="''" data-vv-as="&quot;{{ __('zepo::app.support-ticket.attachment') }}&quot;" />
                    </div>
                    <span class="control-error" v-if="errors.has('attachment')">
                        @{{ errors.first('attachment') }}
                    </span>
                </div>

                <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                    <label for="status" class="required">{{ __('zepo::app.support-ticket.status') }}</label>
                    <select name="status" class="control" v-validate="'required'" data-vv-as="&quot;{{__('zepo::app.support-ticket.status') }}&quot;">
                        <option value="0" {{$supportTicket->status == '0' ? 'selected' : ''}}>{{ __('zepo::app.support-ticket.pending') }}</option>
                        <option value="1" {{$supportTicket->status == '1' ? 'selected' : ''}}>{{ __('zepo::app.support-ticket.process') }}</option>
                        <option value="2" {{$supportTicket->status == '2' ? 'selected' : ''}}>{{ __('zepo::app.support-ticket.completed') }}</option>
                    </select>
                    <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
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