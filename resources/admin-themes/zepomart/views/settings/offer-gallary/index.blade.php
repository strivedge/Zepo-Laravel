@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.settings.offer-gallary.title') }}
@stop

@section('content')
	<div class="content">
		<div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.settings.offer-gallary.title') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.offer-gallary.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.settings.offer-gallary.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('offerGallary','Webkul\Admin\DataGrids\OfferGallaryDataGrid')
            {!! $offerGallary->render() !!}
        </div>
    </div>
@stop