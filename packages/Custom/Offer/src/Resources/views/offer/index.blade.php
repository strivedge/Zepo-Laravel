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

                <a href="addTestinominal" class="btn btn-lg btn-primary">
                    {{ __('offer::app.offer.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            <table>
                <tr>
                    <th>{{ __('offer::app.offer.offer_title') }}</th>
                    <th>{{ __('offer::app.offer.image') }}</th>
                    <th>{{ __('offer::app.offer.desc') }}</th>
                    <th>{{ __('offer::app.offer.date') }}</th>
                    <th>{{ __('offer::app.offer.action') }}</th>
                </tr>
                <?php  //echo "<pre>";print_r($posts);exit(); ?>
                

            </table>
        </div>
    </div>
@stop