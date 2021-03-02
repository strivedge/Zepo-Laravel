
@if (
    $velocityMetaData
    && $velocityMetaData->subscription_bar_content
    || core()->getConfigData('customer.settings.newsletter.subscription')
)
    <div class="newsletter-subscription footer-middle-content">
        <div class="newsletter-wrapper">
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
    </div>
@endif
