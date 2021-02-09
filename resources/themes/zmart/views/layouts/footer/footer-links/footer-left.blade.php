
    <div class="col-12 col-md-6 col-lg-6 col-xl-4 footer-block software-description">

         <h3 class="footer-block-title">Newsletter</h3>

<div class="footer-block-content">
        <div class="newsletter-content">
            <p>We love to craft softwares and solve the real world problems with the binaries. We are highly committed to our goals. We invest our resources to create world class easy to use softwares and applications for the enterprise business with the top notch, on the edge technology expertise.</p>
        </div>
        <form action="{{ route('shop.subscribe') }}">
            <div class="subscriber-form-div">
                <div class="control-group">
                    <input
                        type="email"
                        name="subscriber_email"
                        class="control subscribe-field email"
                        placeholder="{{ __('velocity::app.customer.login-form.your-email-address') }}"
                        required />

                    <button class="theme-btn subscribe-btn fw6 btn btn-primary email-button"><span class="material-icons">near_me</span> {{ __('shop::app.subscription.subscribe') }}
                    </button>
                </div>
            </div>
        </form>
     
</div>