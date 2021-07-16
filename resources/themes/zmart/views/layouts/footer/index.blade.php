<div class="footer">
    <div class="footer-content footer-top">
        <div class="container">
            <div class="row">
                @include('shop::layouts.footer.footer-links')
                {{-- @if ($categories)
                    @include('shop::layouts.footer.top-brands')
                @endif --}}
                
                @if (core()->getConfigData('general.content.footer.footer_toggle'))
                    @include('shop::layouts.footer.copy-right')
                @endif
            </div>
        </div>
    </div>
    <div class="footer-middle">
        <div class="container">
                @include('shop::layouts.footer.newsletter-subscription')
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p class="copyrights">{{ __('shop::app.footer.copyrights') }}</p>
        </div>
    </div>
</div>


