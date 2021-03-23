@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.zipcode.title') }}
@stop

@section('content')
	<div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('admin::app.catalog.zipcode.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="{{ route('admin.offer.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.catalog.zipcode.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">>
        </div>
    </div>
@stop