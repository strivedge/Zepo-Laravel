@if (core()->getConfigData('customer.settings.social_login.enable_facebook')
    || core()->getConfigData('customer.settings.social_login.enable_google')
)
@push('css')
    <link rel="stylesheet" href="{{ bagisto_asset('css/social-login.css') }}">
@endpush

<div class="social-login-links">
    @if (core()->getConfigData('customer.settings.social_login.enable_facebook'))
        <div class="control-group col-md-6">
            <a href="{{ route('customer.social-login.index', 'facebook') }}" class="link facebook-link">
                <span class="icon icon-facebook-login"></span>
                {{ __('sociallogin::app.shop.customer.login-form.continue-with-facebook') }}
            </a>
        </div>
    @endif

    @if (core()->getConfigData('customer.settings.social_login.enable_google'))
        <div class="control-group col-md-6">
            <a href="{{ route('customer.social-login.index', 'google') }}" class="link google-link">
                <span class="icon icon-google-login"></span>
                {{ __('sociallogin::app.shop.customer.login-form.continue-with-google') }}
            </a>
        </div>
    @endif

</div>

<div class="social-link-seperator">
    <span>{{ __('sociallogin::app.shop.customer.login-form.or') }}</span>
</div>
@endif