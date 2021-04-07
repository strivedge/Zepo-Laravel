@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.discounts.title') }}
@stop

@section('content')
	<div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('admin::app.catalog.discounts.title') }}</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.catalog.discount.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.catalog.discounts.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('discountGrid','Webkul\Admin\DataGrids\DiscountDataGrid')

            {!! $discountGrid->render() !!}
        </div>
    </div>
@stop