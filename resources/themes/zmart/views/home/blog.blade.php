@inject ('blogRepository', 'Custom\Blog\Repositories\BlogRepository')
@php
    $posts = $blogRepository->getAll();
@endphp

@extends('shop::layouts.master')

@section('page_title')
    {{ __('blog::app.blogs.title') }}
@endsection

@section('content-wrapper')

<div class="page-header">
    <div class="page-title">
        <h1>
            <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('shop.home.index') }}';"></i>
            {{ __('blog::app.blogs.title') }}
        </h1>
    </div>
</div>

@if(isset($posts) && count($posts) > 0)
	<table>
	@foreach($posts as $post)
	<tr>
		<td><a href="{{ route('blog-detail', [$post->slug]) }}">{{ $post->title }}</a></td>
		<td><img src="{{ asset('/').$post->image }}" alt="{{ __('blog::app.blogs.title') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'" ></td>
		<td>{{ $post->content }}</td>
	</tr>
	@endforeach
	</table>
@endif

@endsection