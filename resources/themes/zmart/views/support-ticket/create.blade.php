@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.header.support-ticket') }}
@stop

@section('content-wrapper')
<!-- <h2>
	{{ __('shop::app.support-ticket.create') }}
</h2> -->
    <div class="account-content row no-margin velocity-divide-page support-ticket-content">
        <div class="support-ticket-form">
            <div class="account-head">
                <h2 class="account-heading">
                   {{ __('shop::app.support-ticket.create') }}
                </h2>
            </div>
            <div class="body">
				<form method="post" action="{{ route('support-ticket.send') }}" enctype="multipart/form-data" @submit.prevent="onSubmit">
					@csrf()
					<div class="control-group form-group" :class="[errors.has('name') ? 'has-error' : '']">
				        <label for="name" class="required label-style">
				            {{ __('shop::app.support-ticket.name') }}
				        </label>
				        <input type="text" class="form-style" name="name" v-validate="'required'" placeholder="Full Name" data-vv-as="&quot;{{ __('shop::app.support-ticket.name') }}&quot;"/>
						<span class="control-error" v-if="errors.has('name')">
							@{{ errors.first('name') }}
						</span>
					</div>

					<div class="control-group form-group" :class="[errors.has('email') ? 'has-error' : '']">
						<label for="email" class="required label-style">
							{{ __('shop::app.support-ticket.email') }}
						</label>
						<input type="email" class="form-style" name="email" v-validate="'required|email'" placeholder="Email" data-vv-as="&quot;{{ __('shop::app.support-ticket.email') }}&quot;" />
				        <span class="control-error" v-if="errors.has('email')">
							@{{ errors.first('email') }}
						</span>
					</div>

					<div class="control-group form-group" :class="[errors.has('message') ? 'has-error' : '']">
						<label for="message" class="required label-style">
							{{ __('shop::app.support-ticket.message') }}
						</label>
						<textarea type="text" class="form-style" name="message" placeholder="Enter your message here..."cols="30" rows="5" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.support-ticket.message') }}&quot;"></textarea>
						<span class="control-error" v-if="errors.has('message')">
							@{{ errors.first('message') }}
						</span>
					</div>

					<div class="control-group form-group" :class="[errors.has('attachment') ? 'has-error' : '']">
						<label for="file-ip-1">
							{{ __('shop::app.support-ticket.attachment') }}
						</label>
						<input type="file" name="attachment" id="file-ip-1" accept="image/*" onchange="showPreview(event);" data-vv-as="&quot;{{ __('shop::app.support-ticket.attachment') }}&quot;" />
						<span class="control-error" v-if="errors.has('attachment')">
							@{{ errors.first('attachment') }}
						</span>
						<div class="preview">
				            <img id="file-ip-1-preview" style="display: none;">
				        </div>
						
					</div>

					<div class="control-group form-group" :class="[errors.has('status') ? 'has-error' : '']">
						<input type="hidden" class="form-style" name="status" value="0" data-vv-as="&quot;{{ __('shop::app.support-ticket.status') }}&quot;" />
					</div>

					<div class="login-register-buttons"><!-- form-group  -->
						<button class="theme-btn" type="submit">
							{{ __('shop::app.support-ticket.btn-send') }}
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
@stop
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