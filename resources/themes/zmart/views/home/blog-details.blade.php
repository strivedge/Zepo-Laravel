@extends('shop::layouts.master')

@php
    $channel = core()->getCurrentChannel();

    $homeSEO = $channel->home_seo;

    if (isset($homeSEO)) {
        $homeSEO = json_decode($channel->home_seo);

        $metaTitle = $homeSEO->meta_title;

        $metaDescription = $homeSEO->meta_description;

        $metaKeywords = $homeSEO->meta_keywords;
    }
@endphp

@section('page_title')
    {{ isset($metaTitle) ? $metaTitle : "" }}
@endsection

@section('head')

    @if (isset($homeSEO))
        @isset($metaTitle)
            <meta name="title" content="{{ $metaTitle }}" />
        @endisset

        @isset($metaDescription)
            <meta name="description" content="{{ $metaDescription }}" />
        @endisset

        @isset($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}" />
        @endisset
    @endif
@endsection

@section('home-full-blog-content')
<div class="section-title"><h2>{{ __('shop::app.home.blog-details') }}</h2></div>
<table>
    <tr>
        <td>{{ $posts->title }}</td>
        <td><img src="{{ asset('uploadImages/'.$posts->image) }}" alt="{{ __('shop::app.home.blog-details') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'" height="50" width="50"></td>
        <td>{{ $posts->content }}</td>
        <td>{{ $posts->updated_at }}</td>
    <tr>
</table>

@endsection