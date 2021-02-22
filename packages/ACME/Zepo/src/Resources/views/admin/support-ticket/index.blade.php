@extends('admin::layouts.content')

@section('page_title')
    {{__('zepo::app.support-ticket.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('zepo::app.support-ticket.title') }}</h1>
            </div>
            <div class="page-action">
                <!-- <a href="{{ route('admin.blog.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.support-ticket.add-title') }}
                </a> -->
            </div>
        </div>

        <div class="page-content">
            @inject('supportTicketGrid','Webkul\Admin\DataGrids\SupportTicketDataGrid')

            {!! $supportTicketGrid->render() !!}
        </div>
    </div>
@stop