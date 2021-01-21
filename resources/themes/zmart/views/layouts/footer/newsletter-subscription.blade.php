
@if (
    $velocityMetaData
    && $velocityMetaData->subscription_bar_content
    || core()->getConfigData('customer.settings.newsletter.subscription')
)
    <div class="newsletter-subscription">
        <div class="newsletter-wrapper row col-12">
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
            <div class="payment-methods col-lg-6">
                <div class="method-sticker">
                    Cash On Delivery
                </div>
                <div class="method-sticker">
                    Money Transfer
                </div>
                <div class="method-sticker">
                    Paypal Standard
                </div>
               
            </div>
            
            <div class="social-icons col-lg-6">
                <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                    <i class="fs24 within-circle rango-facebook" title="facebook"></i> 
                </a>
                <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                    <i class="fs24 within-circle rango-twitter" title="twitter"></i> 
                </a> 
                <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                    <i class="fs24 within-circle rango-linked-in" title="linkedin"></i>
                </a>
                 <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                    <i class="fs24 within-circle rango-pintrest" title="Pinterest"></i>
                </a>
                 <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                    <i class="fs24 within-circle rango-youtube" title="Youtube"></i> 
                </a> 
                <a href="#" target="_blank" class="unset" rel="noopener noreferrer">
                    <i class="fs24 within-circle rango-instagram" title="instagram"></i>
                </a>
            </div>
            

        </div>

        <div class="row col-12">
            <p class="copyrights">Copyright © 2021 Zepomart. All Rights Reserved.</p>
        </div>
    </div>
 
@endif
