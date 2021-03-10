@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.sales.cart-products.title') }}
@stop

@section('content')
	<div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.sales.cart-products.title') }}</h1>
            </div>
        </div>

        <div class="page-content">
        	@inject('cartProductGrid', 'Webkul\Admin\DataGrids\CartProductDataGrid')
            {!! $cartProductGrid->render() !!}
        </div>
    </div>
@stop