@extends('admin::layouts.content')

@section('page_title')
    {{__('zepo::app.support-ticket.view') }}
@stop

@section('content-wrapper')
	<div class="content full-page">
		<form method="POST" action="{{ route('zepo.support-ticket.updateStatus', [$supportTicket->id]) }}" @submit.prevent="onSubmit">
	        <div class="page-header">
	            <div class="page-title">
	                <h1>
	                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>

	                    {{ $supportTicket->name }}
	                </h1>
	            </div>

	            <div class="page-action">
	            	<button type="submit" class="btn btn-lg btn-primary">
                    	{{ __('zepo::app.support-ticket.update-status-btn-title') }}
                	</button>
	            </div>
	        </div>

	        <div class="page-content">
	            <div class="sale-container">

	                <accordian :title="'{{__('zepo::app.support-ticket.title') }}'" :active="true">
	                    <div slot="body">

	                        <div class="sale-section">
	                            <div class="secton-title">
	                                <span>
	                                	{{__('zepo::app.support-ticket.title') }} {{__('zepo::app.support-ticket.details') }}
	                                </span>
	                            </div>

	                            <div class="section-content">
	                                <div class="row">
	                                    <span class="title">
	                                        {{__('zepo::app.support-ticket.name') }}
	                                    </span>

	                                    <span class="value">
	                                        {{ $supportTicket->name }}
	                                    </span>
	                                </div>

	                                <div class="row">
	                                    <span class="title">
	                                        {{__('zepo::app.support-ticket.email') }}
	                                    </span>

	                                    <span class="value">
	                                        {{ $supportTicket->email }}
	                                    </span>
	                                </div>

	                                <div class="row">
	                                    <span class="title">
	                                        {{__('zepo::app.support-ticket.created-at') }}
	                                    </span>

	                                    <span class="value">
	                                        {{ $supportTicket->created_at }}
	                                    </span>
	                                </div>

	                                <div class="row">
	                                    <span class="title">
	                                        {{__('zepo::app.support-ticket.updated-at') }}
	                                    </span>

	                                    <span class="value">
	                                        {{ $supportTicket->updated_at }}
	                                    </span>
	                                </div>

	                                <div class="row">
	                                	<span class="title">
	                                    	{{ __('zepo::app.support-ticket.status') }}
	                					</span>
	                					<span class="value">
		                					<div class="control-group" :class="">
		                						@csrf()
		                                        <select name="status" class="control">
							                        <option value="0" {{$supportTicket->status == '0' ? 'selected' : ''}}>{{ __('zepo::app.support-ticket.pending') }}</option>
							                        <option value="1" {{$supportTicket->status == '1' ? 'selected' : ''}}>{{ __('zepo::app.support-ticket.process') }}</option>
							                        <option value="2" {{$supportTicket->status == '2' ? 'selected' : ''}}>{{ __('zepo::app.support-ticket.completed') }}</option>
		                   						</select>
		                					</div>
	                   					</span>
	                                </div>

	                            @if($supportTicket->attachment != "")
	                                <div class="row">
	                                    <span class="title">
	                                        {{__('zepo::app.support-ticket.attachment') }} <br>
	                                    </span>
	                                </div>
	                                <img src="{{ asset('/').$supportTicket->attachment }}" alt="{{__('zepo::app.support-ticket.attachment') }}" height="50%" width="50%">
	                            @endif

	                            	<div class="row">
	                                    <span class="title">
	                                        {{__('zepo::app.support-ticket.message') }} <br>
	                                    </span>
	                                </div>
	                                <p align="justify">{{ $supportTicket->message }}</p>

	                            </div>
	                        </div>

	                    </div>
	                </accordian>
	            </div>
	        </div>
	    </form>
    </div>

@stop