<nav id="top" class="">
	<div class="navbar-top">
		<div class="container">
			<div class="navbar-top-wrapper">
			    <div class="navbar-left-wrapper col-lg-5 col-xl-6">
			        <!-- @include('velocity::layouts.top-nav.locale-currency') -->
			        <ul>
	                    <li class="email"><span class="material-icons"> email </span><a href="mailto:support@zepomart.com">support@zepomart.com</a></li>
			        	<li class="phone"><span class="material-icons"> phone </span><a href="tel:021 269 962">021 269 962 </a></li>
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

