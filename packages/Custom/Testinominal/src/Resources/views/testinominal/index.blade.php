@extends('admin::layouts.content')

@section('page_title')
{{__('testinominal::app.testinominal.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('testinominal::app.testinominal.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="addTestinominal" class="btn btn-lg btn-primary">
                    {{ __('testinominal::app.testinominal.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('testinominalGrid','Webkul\Admin\DataGrids\TestinominalDataGrid')

            {!! $testinominalGrid->render() !!}
        </div>
    </div>
@stop