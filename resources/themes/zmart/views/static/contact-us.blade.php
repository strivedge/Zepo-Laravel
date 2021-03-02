@extends('shop::layouts.master')

@section('content-wrapper')

    <div class="account-content row no-margin velocity-divide-page contact-us-content">
        <div class="contact-details col-md-5">
            <div class="account-head">
        
                <h2 class="account-heading">
                    {{ __('shop::app.contact-us.title') }}
                </h2>
            </div>
            <ul>
                <li class="email"><span class="material-icons"> {{ __('shop::app.contact-us.email') }} </span><a href="mailto:{{ __('shop::app.contact-us.email-addr') }}">{{ __('shop::app.contact-us.email-addr') }}</a></li> <li class="phone"><span class="material-icons"> {{ __('shop::app.contact-us.phone') }} </span><a href="tel:{{ __('shop::app.contact-us.phone-num') }}">{{ __('shop::app.contact-us.phone-num') }} </a></li><li class="addresses"><span class="material-icons"> {{ __('shop::app.contact-us.location-on') }} </span>{{ __('shop::app.contact-us.address') }}</li>
            </ul>
        </div>

         <div class="profile-update-form col-md-7">
            <div class="account-head">
        
                <h2 class="account-heading">
                    {{ __('shop::app.contact-us.title') }}
                </h2>
            </div>

            <form
                method="POST"
                @submit.prevent="onSubmit"
                class="account-table-content"
                action="{{ route('contact-us.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group col-md-12">
                        <label class="col-12 no-padding mandatory">
                            {{ __('shop::app.contact.name') }}
                        </label>

                        <div class="col-12 no-padding">
                            <input name="name" type="text" v-validate="'required'" placeholder="{{ __('shop::app.contact.name') }}" />
                            <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                        </div>
                    
                
                </div>
               
                <div class="form-group col-md-12">
                    <label class="col-12 no-padding mandatory">
                        {{ __('shop::app.contact.email') }}
                    </label>

                    <div class="col-12 no-padding">
                        <input name="email" type="email" v-validate="'required'" placeholder="{{ __('shop::app.contact.email') }}" />
                        <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="col-12 no-padding">
                        {{ __('shop::app.contact.phone') }}
                    </label>

                    <div class="col-12 no-padding">
                        <input name="phone" type="number" placeholder="{{ __('shop::app.contact.phone') }}" />
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label class="col-12 no-padding">
                        {{ __('shop::app.contact.message') }}
                    </label>

                    <div class="col-12 no-padding">
                         <textarea name="message" id="message" cols="30" rows="5" placeholder="{{__('shop::app.contact.message')}}"></textarea>
                    </div>
                </div>

                <button
                    type="submit"
                    class="theme-btn mb20">
                    {{ __('shop::app.contact.submit') }}
                </button>
            </form>
        </div>
        
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
           
        });
    </script>
@endpush
