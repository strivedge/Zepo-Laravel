@extends('shop::customers.account.index')

@section('page_title')
    {{ __('shop::app.customer.account.profile.index.title') }}
@endsection

@push('css')
    <style>
        .account-head {
            height: 50px;
        }
    </style>
@endpush


@section('page-detail-wrapper')
<div class="account-details">
    <div class="account-head mb-0">
        <span class="back-icon">
            <a href="{{ route('customer.account.index') }}">
                <i class="icon icon-menu-back"></i>
            </a>
        </span>
        <span class="account-heading">
            <span class="user-icon"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAABCklEQVRIS72U4RFBMRCEv1cBHaADJdCBDtCBVlRACTqgBCXQARUwaxKTyctLLpkhf3PZvdvdXMePT/djfHIEC+AATCubuAFb4KJ3OQIVTirBfbnezkoErwHwJ3BydytgNFD3aT43QYpA4JLu6kDnTooUSRPBHthFHR+BdWKK/xN4SbxsKYkewDKS6AyMLRNYCIQjktDkFPjX39BkK4E1uT0PLAQyWaaGKZLpJpNzBHE84ylSca2aQF9fnefOxq0WX1NFYF2KYfKqCKzGhnVFAsVxaM+UCO9+C+diqp0j3Ws3qsDlR29dxykqdWm6z01gAigVhQStmmcTFl62am4mKE3bdG/9QE3gevQGa6U7GUKNWbsAAAAASUVORK5CYII="/></span>
            {{ __('shop::app.customer.account.profile.index.title') }}
        </span>

        <span class="account-action">
            <a href="{{ route('customer.profile.edit') }}" class="theme-btn light unset pull-right">
             <!-- <span class="material-icons">
                edit
             </span>  --> 
             <span class="edit-action">{{ __('shop::app.customer.account.profile.index.edit') }}</span>
            </a>
        </span>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.profile.view.before', ['customer' => $customer]) !!}

    <div class="account-table-content profile-page-content">
        
           
                    {!! view_render_event(
                    'bagisto.shop.customers.account.profile.view.table.before', ['customer' => $customer])
                    !!}

                    <div class="form-group">
                   <label>{{ __('shop::app.customer.account.profile.fname') }}  <b>:</b></label>
                    <span>{{ $customer->first_name }}</span></div>
                    

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.first_name.after', ['customer' => $customer]) !!}

                    <div class="form-group">
                    <label>{{ __('shop::app.customer.account.profile.lname') }}  <b>:</b></label>
                      <span>{{ $customer->last_name }}</span></div>
                    

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.last_name.after', ['customer' => $customer]) !!}

                     <div class="form-group">
                    <label>{{ __('shop::app.customer.account.profile.gender') }}  <b>:</b></label>
                      <span>{{ $customer->gender ?? '-' }}</span></div>

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.gender.after', ['customer' => $customer]) !!}

                     <div class="form-group">
                    <label>{{ __('shop::app.customer.account.profile.dob') }}  <b>:</b></label>
                      <span>{{ $customer->date_of_birth ?? '-' }}</span></div>
                    

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.date_of_birth.after', ['customer' => $customer]) !!}

                     <div class="form-group">
                    <label>{{ __('shop::app.customer.account.profile.email') }}  <b>:</b></label>
                      <span>{{ $customer->email }}</span></div>
                    

                    {!! view_render_event('bagisto.shop.customers.account.profile.view.table.email.after', ['customer' => $customer]) !!}

                     <div class="form-group">
                    <label>{{ __('shop::app.customer.account.profile.phone') }} <b>:</b></label>
                       <span>{{ $customer->phone ?? '-' }}</span></div>

                    {!! view_render_event(
                    'bagisto.shop.customers.account.profile.view.table.after', ['customer' => $customer])
                    !!}
                
        
        <div class="buttons">
            <button
                type="submit"
                class="theme-btn" @click="showModal('deleteProfile')" >
                {{ __('shop::app.customer.account.address.index.delete') }}
            </button>
        </div>

        <form method="POST" action="{{ route('customer.profile.destroy') }}" @submit.prevent="onSubmit">
            @csrf

            <modal id="deleteProfile" :is-open="modalIds.deleteProfile">
                <h3 slot="header">{{ __('shop::app.customer.account.address.index.enter-password') }}
                </h3>
                <i class="rango-close"></i>

                <div slot="body">
                    <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                        <label for="password" class="required">{{ __('admin::app.users.users.password') }}</label>
                        <input type="password" v-validate="'required|min:6|max:18'" class="control" id="password" name="password" data-vv-as="&quot;{{ __('admin::app.users.users.password') }}&quot;"/>
                        <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
                    </div>

                    <div class="page-action">
                        <button type="submit"  class="theme-btn mb20">
                        {{ __('shop::app.customer.account.address.index.delete') }}
                        </button>
                    </div>
                </div>
            </modal>
        </form>
    </div>
</div>
    {!! view_render_event('bagisto.shop.customers.account.profile.view.after', ['customer' => $customer]) !!}
@endsection