@extends('shop::layouts.master')

@section('page_title')
    {{__('zepo::app.sellers.title') }}
@stop

@section('content-wrapper')
<div class="account-content row no-margin velocity-divide-page support-ticket-content">
    <div class="support-ticket-form">
        <div class="account-head">
            <h2 class="account-heading">
                {{__('zepo::app.sellers.title') }}
            </h2>
        </div>
        <div class="body">
            <form method="post" action="{{ route('seller-register.store') }}" enctype="multipart/form-data" @submit.prevent="onSubmit">
            @csrf()
            @auth('customer')
                @if(auth()->guard('customer')->user()->id)
                <!-- <div class="control-group form-group" :class="[errors.has('name') ? 'has-error' : '']">
                    <label for="name" class="required label-style">
                        {{__('zepo::app.sellers.name') }}
                    </label>
                    <input type="text" class="form-style" name="name" v-validate="'required'" value="{{ auth()->guard('customer')->user()->first_name.' '. auth()->guard('customer')->user()->last_name }}" data-vv-as="&quot;{{__('zepo::app.sellers.name') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('name')">
                        @{{ errors.first('name') }}
                    </span>
                </div> -->
            
                <!-- <div class="control-group form-group" :class="[errors.has('email') ? 'has-error' : '']">
                    <label for="email" class="required label-style">
                        {{__('zepo::app.sellers.email') }}
                    </label>
                    <input type="email" class="form-style" name="email" v-validate="'required|email'" value="{{ auth()->guard('customer')->user()->email }}" data-vv-as="&quot;{{__('zepo::app.sellers.email') }}&quot;" />
                    <span class="control-error" v-if="errors.has('email')">
                        @{{ errors.first('email') }}
                    </span>
                </div> -->
            @endauth
                @else
                <div class="control-group form-group" :class="[errors.has('name') ? 'has-error' : '']">
                    <label for="name" class="required label-style">
                        {{__('zepo::app.sellers.name') }}
                    </label>
                    <input type="text" class="form-style" name="name" v-validate="'required'" placeholder="{{__('zepo::app.support-ticket.full-name') }}" data-vv-as="&quot;{{__('zepo::app.sellers.name') }}&quot;"/>
                    <span class="control-error" v-if="errors.has('name')">
                        @{{ errors.first('name') }}
                    </span>
                </div>

                <div class="control-group form-group" :class="[errors.has('email') ? 'has-error' : '']">
                    <label for="email" class="required label-style">
                        {{__('zepo::app.sellers.email') }}
                    </label>
                    <input type="email" class="form-style" name="email" v-validate="'required|email'" placeholder="{{__('zepo::app.sellers.email') }}" data-vv-as="&quot;{{__('zepo::app.sellers.email') }}&quot;" />
                    <span class="control-error" v-if="errors.has('email')">
                        @{{ errors.first('email') }}
                    </span>
                </div>
                @endif

                <div class="control-group form-group" :class="[errors.has('password') ? 'has-error' : '']">
                    <label for="password" class="required label-style">
                        {{__('zepo::app.sellers.password') }}
                    </label>
                    <input type="password" class="form-style" name="password" v-validate="'required|min:6'" ref="password" value="{{ old('password') }}" data-vv-as="&quot;{{ __('zepo::app.sellers.password')}}&quot;" />
                    <span class="control-error" v-if="errors.has('password')">
                        @{{ errors.first('password') }}
                    </span>
                </div>

                <div class="control-group form-group" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                    <label for="password_confirmation" class="required label-style">
                        {{__('zepo::app.sellers.cpassword') }}
                    </label>
                    <input type="password" class="form-style" name="password_confirmation" v-validate="'required|min:6|confirmed:password'" data-vv-as="&quot;{{ __('zepo::app.sellers.cpassword') }}&quot;" />
                    <span class="control-error" v-if="errors.has('password_confirmation')">
                        @{{ errors.first('password_confirmation') }}
                    </span>
                </div>  

                <div class="control-group form-group" :class="[errors.has('status') ? 'has-error' : '']">
                    <input type="hidden" class="form-style" name="status" value="0" data-vv-as="&quot;{{__('zepo::app.sellers.status') }}&quot;" />
                </div>

                <div class="control-group form-group" :class="[errors.has('role_id') ? 'has-error' : '']">
                    <input type="hidden" class="form-style" name="role_id" value="2" data-vv-as="&quot;{{__('zepo::app.sellers.role') }}&quot;" />
                </div>

                <div class="login-register-buttons">
                    <button class="theme-btn" type="submit">
                        {{__('zepo::app.sellers.btn-register') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@stop