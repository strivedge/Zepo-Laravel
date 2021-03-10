@inject ('blogRepository', 'Custom\Blog\Repositories\BlogRepository')
@php
    $posts = $blogRepository->getAll();
@endphp

@extends('shop::layouts.master')

@section('page_title')
    {{ __('blog::app.blogs.title') }}
@endsection

@section('content-wrapper')
	<section class="blog">
			<div class="page-header">
			    <div class="page-title">
			        <h2>
			            {{ __('blog::app.blogs.title') }}
			        </h2>
			    </div>
			</div>

			@if(isset($posts) && count($posts) > 0)
				<div class="post-wrapper">
						<ul class="row">
							@foreach($posts as $post)
									<li class="blog-post col-md-6 col-lg-4 col-xl-3">
										<div class="content-wrap">
											<div class="post-thumb-wrap">
												<a href="{{ route('blog-detail', [$post->slug]) }}">
													<img src="{{ asset('/').$post->image }}" alt="{{ __('blog::app.blogs.title') }}" onerror="this.src='{{ asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png') }}'">
												</a>
											</div>
											<div class="content">
												<div class="post-title">
													<a href="{{ route('blog-detail', [$post->slug]) }}">{{ $post->title }}</a>
												</div>
												<div class="post-content"><p>{{ $post->content }}</p></div>
											</div>
											<div class="post-footer">
												<div class="buttons">
													<p>
														<a href="{{ route('blog-detail', [$post->slug]) }}" class="btn btn-primary">
														 Read More
														</a>
													</p>
												</div>
											</div>
										</div>
									</li>
								
							@endforeach
						</ul>
				</div>
			@endif
	</section>

@endsection