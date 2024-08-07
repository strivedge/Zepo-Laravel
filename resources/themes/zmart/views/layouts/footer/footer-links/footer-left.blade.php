<div class="col-12 col-md-6 col-lg-6 col-xl-4 footer-block software-description">
     <a href="{!! url('/contact-us') !!}"><h3 class="footer-block-title"><!--  -->{{ __('shop::app.footer-links.contact-us') }}</h3></a>
        <div class="footer-block-content">
            <ul type="none">
                <!-- <li><span class="material-icons"> location_on </span>B-905, Test City Center, Near test Tower, <br/> Testlite, Ahmedabad -380111, Gujarat, India</li> -->
                <li><span class="material-icons"> {{ __('shop::app.contact-us.location-on') }} </span>
                    {{ __('shop::app.contact-us.address1') }}<br>
                    {{ __('shop::app.contact-us.address2') }}<br>
                    {{ __('shop::app.contact-us.address3') }}
                </li>
                <li><span class="material-icons"> {{ __('shop::app.header.phone') }} </span><a href="tel:{{ __('shop::app.header.phone-num') }}"> {{ __('shop::app.header.phone-num') }} </a></li>
                <li><span class="material-icons"> {{ __('shop::app.header.email') }} </span><a href="mailto:{{ __('shop::app.header.email-address') }}">{{ __('shop::app.header.email-address') }}</a></li>
            </ul>
        </div>
     <h3 class="footer-block-title">
        {{ __('shop::app.newsletter.newsletter') }}
     </h3>
    <div class="footer-block-content">
            <!-- <div class="newsletter-content">
                <p>{{ __('shop::app.newsletter.content') }}</p>
            </div> -->
            <form action="{{ route('shop.subscribe') }}">
                <div class="subscriber-form-div">
                    <div class="control-group">
                        <input
                            type="email"
                            name="subscriber_email"
                            class="control subscribe-field email"
                            placeholder="{{ __('velocity::app.customer.login-form.your-email-address') }}"
                            required />

                        <button class="theme-btn subscribe-btn fw6 btn btn-primary email-button"><span class="material-icons">{{ __('shop::app.newsletter.near-me') }}</span> {{ __('shop::app.subscription.subscribe') }}
                        </button>
                    </div>
                </div>
            </form>
    </div>
</div>