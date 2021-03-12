@extends('shop::layouts.master')

@section('page_title')
    {{__('zepo::app.support-ticket.title') }}
@stop

@section('content-wrapper')

    <div class="account-content row no-margin velocity-divide-page support-ticket-content">
        <div class="support-ticket-form">
            <div class="account-head">
                <h2 class="account-heading">
                	{{__('zepo::app.support-ticket.create') }}
                </h2>
            </div>
            <div class="body">
				<form method="post" action="{{ route('support-ticket.send') }}" enctype="multipart/form-data" @submit.prevent="onSubmit">
				@csrf()
				@auth('customer')
					@if(auth()->guard('customer')->user()->id)
					<div class="control-group form-group" :class="[errors.has('name') ? 'has-error' : '']">
				        <label for="name" class="required label-style">
				        	{{__('zepo::app.support-ticket.name') }}
				        </label>
				        <input type="text" class="form-style" name="name" v-validate="'required'" value="{{ auth()->guard('customer')->user()->first_name.' '. auth()->guard('customer')->user()->last_name }}" data-vv-as="&quot;{{__('zepo::app.support-ticket.name') }}&quot;"/>
						<span class="control-error" v-if="errors.has('name')">
							@{{ errors.first('name') }}
						</span>
					</div>
				
					<div class="control-group form-group" :class="[errors.has('email') ? 'has-error' : '']">
						<label for="email" class="required label-style">
							{{__('zepo::app.support-ticket.email') }}
						</label>
						<input type="email" class="form-style" name="email" v-validate="'required|email'" value="{{ auth()->guard('customer')->user()->email }}" data-vv-as="&quot;{{__('zepo::app.support-ticket.email') }}&quot;" />
				        <span class="control-error" v-if="errors.has('email')">
							@{{ errors.first('email') }}
						</span>
					</div>
				@endauth
					@else
					<div class="control-group form-group" :class="[errors.has('name') ? 'has-error' : '']">
				        <label for="name" class="required label-style">
				            {{__('zepo::app.support-ticket.name') }}
				        </label>
				        <input type="text" class="form-style" name="name" v-validate="'required'" placeholder="{{__('zepo::app.support-ticket.full-name') }}" data-vv-as="&quot;{{__('zepo::app.support-ticket.name') }}&quot;"/>
						<span class="control-error" v-if="errors.has('name')">
							@{{ errors.first('name') }}
						</span>
					</div>

					<div class="control-group form-group" :class="[errors.has('email') ? 'has-error' : '']">
						<label for="email" class="required label-style">
							{{__('zepo::app.support-ticket.email') }}
						</label>
						<input type="email" class="form-style" name="email" v-validate="'required|email'" placeholder="{{__('zepo::app.support-ticket.email') }}" data-vv-as="&quot;{{__('zepo::app.support-ticket.email') }}&quot;" />
				        <span class="control-error" v-if="errors.has('email')">
							@{{ errors.first('email') }}
						</span>
					</div>	
					@endif
					<div class="control-group form-group" :class="[errors.has('message') ? 'has-error' : '']">
						<label for="message" class="required label-style">
							{{__('zepo::app.support-ticket.message') }}
						</label>
						<textarea type="text" class="form-style" name="message" placeholder="{{__('zepo::app.support-ticket.message-placeholder') }}" cols="30" rows="5" v-validate="'required'" data-vv-as="&quot;{{__('zepo::app.support-ticket.message') }}&quot;"></textarea>
						<span class="control-error" v-if="errors.has('message')">
							@{{ errors.first('message') }}
						</span>
					</div>

					<div class="control-group form-group" :class="[errors.has('attachment') ? 'has-error' : '']">
						<label for="attachment">
							{{__('zepo::app.support-ticket.attachment') }}
						</label>
						<input type="file" name="attachment" id="file-ip-1" accept="image/*" onchange="showPreview(event);" v-validate="''" data-vv-as="&quot;{{__('zepo::app.support-ticket.attachment') }}&quot;" />
						<span class="control-error" v-if="errors.has('attachment')">
							@{{ errors.first('attachment') }}
						</span>
						<div class="preview">
				            <img id="file-ip-1-preview" style="display: none;">
				        </div>
						
					</div>

					<div class="control-group form-group" :class="[errors.has('status') ? 'has-error' : '']">
						<input type="hidden" class="form-style" name="status" value="0" data-vv-as="&quot;{{__('zepo::app.support-ticket.status') }}&quot;" />
					</div>

					<div class="login-register-buttons">
						<button class="theme-btn" type="submit">
							{{__('zepo::app.support-ticket.btn-send') }}
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