@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.zipcodes.title') }}
@stop

@section('content')
	<div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('admin::app.catalog.zipcodes.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="{{ route('admin.catalog.zipcode.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.catalog.zipcodes.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('zipcodesGrid','Webkul\Admin\DataGrids\ZipCodeDataGrid')

            {!! $zipcodesGrid->render() !!}
        </div>
    </div>
@stop