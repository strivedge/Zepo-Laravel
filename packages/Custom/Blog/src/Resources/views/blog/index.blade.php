@extends('admin::layouts.content')

@section('page_title')
{{__('blog::app.blogs.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{__('blog::app.blogs.title') }}</h1>
            </div>
            <div class="page-action">

                <a href="{{ route('admin.blog.create') }}" class="btn btn-lg btn-primary">
                    {{ __('blog::app.blogs.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('blogGrid','Webkul\Admin\DataGrids\BlogDataGrid')

            {!! $blogGrid->render() !!}
        </div>
    </div>
@stop