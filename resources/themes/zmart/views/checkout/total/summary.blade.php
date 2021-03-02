<div class="order-summary fs16">
    <h3 class="fw6">{{ __('velocity::app.checkout.cart.cart-summary') }}</h3>

    <div class="order-summary-content">
        <span class="col-7">{{ __('velocity::app.checkout.sub-total') }}</span>
        <b class="com-md-1">:</b>
        <span class="col-4 text-right prices">{{ core()->currency($cart->base_sub_total) }}</span>
    </div>

    @if ($cart->selected_shipping_rate)
        <div class="order-summary-content">
            <span class="col-7">{{ __('shop::app.checkout.total.delivery-charges') }}</span>
            <b class="com-md-1">:</b>
            <span class="col-4 text-right prices">{{ core()->currency($cart->selected_shipping_rate->base_price) }}</span>
        </div>
    @endif

    @if ($cart->base_tax_total)
        @foreach (Webkul\Tax\Helpers\Tax::getTaxRatesWithAmount($cart, true) as $taxRate => $baseTaxAmount )
            <div class="order-summary-content">
                <span class="col-7" id="taxrate-{{ core()->taxRateAsIdentifier($taxRate) }}">{{ __('shop::app.checkout.total.tax') }} {{ $taxRate }} %</span>
                <b class="com-md-1">:</b>
                <span class="col-4 text-right prices" id="basetaxamount-{{ core()->taxRateAsIdentifier($taxRate) }}">{{ core()->currency($baseTaxAmount) }}</span>
            </div>
        @endforeach
    @endif

    @if (
        $cart->base_discount_amount
        && $cart->base_discount_amount > 0
    )
        <div
            id="discount-detail"
            class="order-summary-content">

            <span class="col-7">{{ __('shop::app.checkout.total.disc-amount') }}</span>
            <b class="com-md-1">:</b>
            <span class="col-4 text-right">
                -{{ core()->currency($cart->base_discount_amount) }}
            </span>
        </div>
    @endif

    <div class="payable-amount row" id="grand-total-detail">
        <div class="col-6">{{ __('shop::app.checkout.total.grand-total') }}</div>
        <div class="col-6 text-center fw6 prices" id="grand-total-amount-detail">
            {{ core()->currency($cart->base_grand_total) }}
        </div>
    </div>

    
</div>
<div class="row checkout-buttons">
        <a
            href="{{ route('shop.checkout.onepage.index') }}"
            class="theme-btn text-uppercase col-12 remove-decoration fw6 text-center">
            {{ __('velocity::app.checkout.proceed') }}
        </a>
</div>