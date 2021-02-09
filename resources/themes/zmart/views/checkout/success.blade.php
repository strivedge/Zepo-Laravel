@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.checkout.success.title') }}
@stop

@section('content-wrapper')
        <div class="order-success-content col-md-12">
            <h1 class="col-12 no-padding">{{ __('shop::app.checkout.success.thanks') }}</h1>

            <p class="col-12 no-padding">
                {{ __('shop::app.checkout.success.order-id-info', ['order_id' => $order->increment_id]) }}
            </p>

            <p class="col-12 no-padding email-message">
                {{ __('shop::app.checkout.success.info') }}
            </p>

            {{ view_render_event('bagisto.shop.checkout.continue-shopping.before', ['order' => $order]) }}

            <div class="mt15 no-padding text-center row-col-12">
                <a href="{{ route('shop.home.index') }}" class="theme-btn remove-decoration">
                    {{ __('shop::app.checkout.cart.continue-shopping') }}
                </a>
            </div>

            {{ view_render_event('bagisto.shop.checkout.continue-shopping.after', ['order' => $order]) }}

        </div>
@endsection
