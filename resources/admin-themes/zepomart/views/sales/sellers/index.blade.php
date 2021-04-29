@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.sales.sellers.title') }}
@stop

@section('content')
    <div class="content">
    	<div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.sales.sellers.title') }}</h1>
            </div>

            <div class="page-action">
            </div>
        </div>

        <div class="page-content">
            @inject('sellerOrderGrid', 'Webkul\Admin\DataGrids\SellerOrderDataGrid')
            {!! $sellerOrderGrid->render() !!}
        </div>
    </div>
@stop