{!! view_render_event('bagisto.shop.layout.header.account-item.before') !!}
    <login-header></login-header>
{!! view_render_event('bagisto.shop.layout.header.account-item.after') !!}

<script type="text/x-template" id="login-header-template">
    <div class="pull-right login-register">
        <div class="dropdown">
            <div id="account">


                        @auth('customer')
                        <div class="welcome-content login-content" @click="togglePopup">
                            {{ __('velocity::app.header.welcome-message', ['customer_name' => auth()->guard('customer')->user()->first_name]) }}
                        </div>
                        @endauth 
                        @guest('customer')
                        <div class="welcome-content pull-right">
                            <div class="modal-content">

                                        <a href="{{ route('user.support-ticket') }}" class="login">
                                            <button
                                                type="button"
                                                class="">

                                                {{ __('shop::app.header.support-ticket') }}
                                            </button>
                                        </a>
                                
                                        <a href="{{ route('customer.session.index') }}" class="login">
                                            <button
                                                type="button"
                                                class="">

                                                {{ __('shop::app.header.sign-in') }}
                                            </button>
                                        </a>

                                        <a href="{{ route('customer.register.index') }}" class="register">
                                            <button
                                                type="button"
                                                class="">
                                                {{ __('shop::app.header.sign-up') }}
                                            </button>
                                        </a>
                                
                            </div>
                        </div>
                    @endguest

                    
            </div>

            <div class="account-modal sensitive-modal hide mt5">
                <!--Content-->
                    

                    @auth('customer')
                        <div class="modal-content customer-options">
                            <div class="customer-session">
                                
                                   @if(auth()->guard('customer')->user()->image)
                                      <div class="customer-name customer-img text-uppercase">
                                        <img src="{{ asset('/').auth()->guard('customer')->user()->image }}" class="logo custom-logo">
                                      </div>
                                    @else
                                      <div class="customer-name text-uppercase">
                                        {{ substr(auth('customer')->user()->first_name, 0, 1) }}
                                      </div>
                                    @endif
                                
                                <label class="">
                                    {{ auth()->guard('customer')->user()->first_name }}
                                </label>
                            </div>

                            <ul type="none">
                                <li><span><i class="icon profile text-down-3 profile"></i></span>
                                    <a href="{{ route('customer.profile.index') }}" class="unset">{{ __('shop::app.header.profile') }}</a>
                                </li>

                                <li><span><i class="icon orders text-down-3 order"></i></span>
                                    <a href="{{ route('customer.orders.index') }}" class="unset">{{ __('velocity::app.shop.general.orders') }}</a>
                                </li>

                                <li><span><i class="icon wishlist text-down-3 wishlist"></i></span>
                                    <a href="{{ route('customer.wishlist.index') }}" class="unset">{{ __('shop::app.header.wishlist') }}</a>
                                </li>

                                @php
                                    $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;
                                    
                                @endphp
                                
                                @if ($showCompare)
                                    <li><span><i class="icon compare text-down-3 compare"></i></span>
                                        <a href="{{ route('velocity.customer.product.compare') }}" class="unset">{{ __('velocity::app.customer.compare.text') }}</a>
                                    </li>
                                @endif

                                <li><span class="material-icons">logout</span>
                                    <a href="{{ route('customer.session.destroy') }}" class="unset">{{ __('shop::app.header.logout') }}</a>
                                </li>
                            </ul>
                        </div>
                    @endauth
                <!--/.Content-->
            </div>
        </div>
    </div>
</script>

@push('scripts')
    <script type="text/javascript">

        Vue.component('login-header', {
            template: '#login-header-template',

            methods: {
                togglePopup: function (event) {
                    let accountModal = this.$el.querySelector('.account-modal');
                    let modal = $('#cart-modal-content')[0];

                    if (modal)
                        modal.classList.add('hide');

                    accountModal.classList.toggle('hide');

                    event.stopPropagation();
                }
            }
        })

    </script>
@endpush

