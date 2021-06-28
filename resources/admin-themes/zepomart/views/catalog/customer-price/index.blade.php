@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.customer.title') }}
@stop

@section('content')
	<div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('admin::app.catalog.customer.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="{{ route('admin.catalog.customer.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.catalog.customer.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('CustomerPriceDataGrid','Webkul\Admin\DataGrids\CustomerPriceDataGrid')

            {!! $CustomerPriceDataGrid->render() !!}
        </div>
    </div>
@stop