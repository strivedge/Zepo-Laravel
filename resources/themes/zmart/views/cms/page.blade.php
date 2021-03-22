@extends('shop::layouts.master')

@section('page_title')
    {{ $page->page_title }}
@endsection

@section('head')
    @isset($page->meta_title)
        <meta name="title" content="{{ $page->meta_title }}" />
    @endisset

    @isset($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}" />
    @endisset

    @isset($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}" />
    @endisset
@endsection

@section('content-wrapper')
    <div class="account-content velocity-divide-page common-us-content">
        <div class="cms-page-container common-page">
            <div class="account-head">
        
                <h2 class="account-heading">
                    <!-- {{ __('shop::app.contact-us.title') }} -->{{ $page->page_title }}
                </h2>
            </div>
            
            {!! DbView::make($page)->field('html_content')->render() !!}
        </div>
    </div>
@endsection