@extends('admin::layouts.content')

@section('page_title')
    {{ __('velocity::app.admin.tabsections.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('velocity::app.admin.tabsections.title') }}</h1>
            </div>

            <div class="page-action">
                <!-- <a href="#" class="btn btn-lg btn-primary">
                </a> -->
            </div>
        </div>

        <div class="page-content">

        </div>
    </div>
@stop