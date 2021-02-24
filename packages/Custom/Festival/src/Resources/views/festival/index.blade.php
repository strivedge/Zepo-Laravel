@extends('admin::layouts.content')

@section('page_title')
{{__('festival::app.festival.title') }}
@stop

@section('content')

<?php //echo "<pre>"; print_r($festival);exit(); ?>

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('festival::app.festival.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="{{ route('admin.festival.create') }}" class="btn btn-lg btn-primary">
                    {{ __('festival::app.festival.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('festivalGrid','Webkul\Admin\DataGrids\FestivalDataGrid')

            {!! $festivalGrid->render() !!}
        </div>
    </div>
@stop