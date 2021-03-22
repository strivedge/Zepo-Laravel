<nav id="top" class="">
	<div class="navbar-top">
		<div class="container">
			<div class="navbar-top-wrapper">
			    <div class="navbar-left-wrapper col-lg-5 col-xl-6">
			        <ul>
	                    <li class="email"><span class="material-icons notranslate"> {{ __('shop::app.header.email') }} </span><a href="mailto:{{ __('shop::app.header.email-address') }}">{{ __('shop::app.header.email-address') }}</a></li>
			        	<li class="phone"><span class="material-icons notranslate"> {{ __('shop::app.header.phone') }} </span><a href="tel:{{ __('shop::app.header.phone-num') }}">{{ __('shop::app.header.phone-num') }} </a></li>
	                </ul>
			    </div>

			    <div class="navbar-right-wrapper col-lg-7 col-xl-6">
			    	@include('velocity::layouts.top-nav.locale-currency')
			        @include('velocity::layouts.top-nav.login-section')
			    </div>
			</div>
		</div>
	</div>
</nav>

