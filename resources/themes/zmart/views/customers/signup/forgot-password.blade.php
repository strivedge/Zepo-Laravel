@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.customer.forgot-password.page_title') }}
@endsection

@section('content-wrapper')
    <div class="row">
        <div class="auth-content form-container login-rgister col-md-12">
            <div class="login-register-content">
                <div class="heading section-title">
                    <h2>
                        {{ __('velocity::app.customer.forget-password.forgot-password')}}
                    </h2>

                    <a href="{{ route('customer.session.index') }}" class="btn-new-customer">
                        <button type="button" class="theme-btn light">
                            {{  __('velocity::app.customer.signup-form.login') }}
                        </button>
                    </a>
                </div>

                <div class="body">
                    <h3>
                        {{ __('velocity::app.customer.forget-password.recover-password')}}
                    </h3>

                    <p>
                        {{ __('velocity::app.customer.forget-password.recover-password-text')}}
                    </p>

                    {!! view_render_event('bagisto.shop.customers.forget_password.before') !!}

                    <form
                        method="post"
                        action="{{ route('customer.forgot-password.store') }}"
                        @submit.prevent="onSubmit">

                        {{ csrf_field() }}

                        {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.before') !!}

                        <div class="control-group form-group" :class="[errors.has('email') ? 'has-error' : '']">
                            <label for="email" class="mandatory label-style">
                                {{ __('shop::app.customer.forgot-password.email') }}
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-style"
                                v-validate="'required|email'" />

                            <span class="control-error" v-if="errors.has('email')">
                                @{{ errors.first('email') }}
                            </span>
                        </div>

                        {!! view_render_event('bagisto.shop.customers.forget_password_form_controls.after') !!}
                    <div class="form-group login-register-buttons">
                        <button class="theme-btn" type="submit">
                            {{ __('shop::app.customer.forgot-password.submit') }}
                        </button>
                    </div>
                    </form>

                    {!! view_render_event('bagisto.shop.customers.forget_password.after') !!}
                </div>
            </div>
        </div>
    </div>
@endsection
