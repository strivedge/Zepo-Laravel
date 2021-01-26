
@if (
    $velocityMetaData
    && $velocityMetaData->subscription_bar_content
    || core()->getConfigData('customer.settings.newsletter.subscription')
)
    <div class="newsletter-subscription footer-middle-content">
        <!-- <div class="newsletter-wrapper row col-12"> -->
            <div class="newsletter-wrapper">
            <!-- @if ($velocityMetaData && $velocityMetaData->subscription_bar_content)
                {!! $velocityMetaData->subscription_bar_content !!}
            @endif

            @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                <div class="subscribe-newsletter col-lg-6">
                    <div class="form-container">
                        <form action="{{ route('shop.subscribe') }}">
                            <div class="subscriber-form-div">
                                <div class="control-group">
                                    <input
                                        type="email"
                                        name="subscriber_email"
                                        class="control subscribe-field"
                                        placeholder="{{ __('velocity::app.customer.login-form.your-email-address') }}"
                                        required />

                                    <button class="theme-btn subscribe-btn fw6">
                                        {{ __('shop::app.subscription.subscribe') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif -->
            <!-- <div class="payment-methods col-lg-6">
                <div class="method-sticker">
                    Cash On Delivery
                </div>
                <div class="method-sticker">
                    Money Transfer
                </div>
                <div class="method-sticker">
                    Paypal Standard
                </div>
               
            </div> -->
            <div class="partner-logo col-md-12 col-lg-6">
                <ul>
                    <li><img src="{{ asset('/themes/zmart/assets/images/pay.png') }}"></li>
                    <li><img src="{{ asset('/themes/zmart/assets/images/discover.png') }}"></li>
                    <li><img src="{{ asset('/themes/zmart/assets/images/american-express.png') }}"></li>
                    <li><img src="{{ asset('/themes/zmart/assets/images/visa.png') }}"></li>
                    <li><img src="{{ asset('/themes/zmart/assets/images/mastercard.png') }}"></li>
                    <li><img src="{{ asset('/themes/zmart/assets/images/cash-delievery.png') }}"></li>
                </ul>
            </div>
            
            <div class="social-icons social-links col-md-12 col-lg-6">
                <ul>
                   <li>
                        <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                           <span> <i class="fs24 rango-facebook" title="facebook"></i> </span> <!-- within-circle -->
                        </a>
                    </li>
                    <li>
                        <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                           <span>  <i class="fs24 rango-twitter" title="twitter"></i> </span> <!-- within-circle --> 
                        </a> 
                    </li>
                    <li>
                        <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                           <span>  <i class="fs24 rango-linked-in" title="linkedin"></i> </span> <!-- within-circle -->
                        </a>
                    </li>
                    <li>
                         <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                           <span>  <i class="fs24 rango-pintrest" title="Pinterest"></i> </span> <!-- within-circle -->
                        </a>
                    </li>
                    <li>
                         <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                           <span>  <i class="fs24 rango-youtube" title="Youtube"></i> </span>  
                        </a> 
                    </li>
                    <li>
                        <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                           <span>  <i class="fs24 rango-instagram" title="instagram"></i> </span> 
                        </a>
                    </li>
            </div>
            

        </div>

        <!-- <div class="row col-12">
            <p class="copyrights">Copyright © 2021 Zepomart. All Rights Reserved.</p>
        </div> -->
    </div>
 
@endif
