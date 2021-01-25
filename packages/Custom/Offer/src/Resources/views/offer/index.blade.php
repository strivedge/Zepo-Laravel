@extends('admin::layouts.content')

@section('page_title')
{{__('offer::app.offer.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('offer::app.offer.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="addOffer" class="btn btn-lg btn-primary">
                    {{ __('offer::app.offer.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('offerGrid','Webkul\Admin\DataGrids\OfferDataGrid')

            {!! $offerGrid->render() !!}
        </div>
    </div>
@stop