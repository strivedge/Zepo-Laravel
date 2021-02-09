@extends('shop::layouts.master')

@section('content-wrapper')
<div class="account-head">
        
        <h1 class="account-heading">
            Contact us page content
        </h1>
    </div>

    <div class="account-content row no-margin velocity-divide-page">

         <div class="profile-update-form">
            <form
                method="POST"
                @submit.prevent="onSubmit"
                class="account-table-content"
                action="{{ route('contact-us.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="col-12 mandatory">
                            {{ __('shop::app.contact.name') }}
                        </label>

                        <div class="col-12">
                            <input name="name" type="text" v-validate="'required'" placeholder="{{ __('shop::app.contact.name') }}" />
                            <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                        </div>
                    </div>
                
                </div>
               
                <div class="row">
                    <label class="col-12 mandatory">
                        {{ __('shop::app.contact.email') }}
                    </label>

                    <div class="col-12">
                        <input name="email" type="email" v-validate="'required'" placeholder="{{ __('shop::app.contact.email') }}" />
                        <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                    </div>
                </div>

               

                <div class="row">
                    <label class="col-12">
                        {{ __('shop::app.contact.phone') }}
                    </label>

                    <div class="col-12">
                        <input name="phone" type="number" placeholder="{{ __('shop::app.contact.phone') }}" />
                    </div>
                </div>

                 <div class="row">
                    <label class="col-12">
                        {{ __('shop::app.contact.message') }}
                    </label>

                    <div class="col-12">
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
