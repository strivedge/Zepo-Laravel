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

@push('scripts')
    <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/610778bf649e0a0a5ccf06c3/1fc2ivclj';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
    <!--End of Tawk.to Script-->
 
@endpush


