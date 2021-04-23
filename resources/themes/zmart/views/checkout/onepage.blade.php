@extends('shop::layouts.master')

@section('page_title')
    {{ __('velocity::app.checkout.checkout') }}
@stop

@section('content-wrapper')
    <checkout></checkout>
@endsection

@push('scripts')
    @include('shop::checkout.cart.coupon')

    <script type="text/x-template" id="checkout-template">
        
            <div id="checkout" class="checkout-process  col-lg-12 col-md-12">
                <h2 class="col-12">{{ __('velocity::app.checkout.checkout') }}</h2>
                
                <div class="col-lg-8 col-md-12">
                    <div class="step-content information" id="address-section">
                        @include('shop::checkout.onepage.customer-info')
                    </div>

                    <div
                        class="step-content shipping"
                        id="shipping-section"
                        v-if="showShippingSection">

                        <shipping-section @onShippingMethodSelected="shippingMethodSelected($event)">
                        </shipping-section>
                    </div>

                    <div
                        class="step-content payment"
                        v-if="showPaymentSection"
                        id="payment-section">

                        <payment-section @onPaymentMethodSelected="paymentMethodSelected($event)">
                        </payment-section>

                        <coupon-component
                            @onApplyCoupon="getOrderSummary"
                            @onRemoveCoupon="getOrderSummary">
                        </coupon-component>
                    </div>

                    <div
                        class="step-content review"
                        v-if="showSummarySection"
                        id="summary-section">

                        <review-section :key="reviewComponentKey">
                            
                            <div slot="place-order-btn">
                                <div class="mb20 text-center">
                                    <button
                                        type="button"
                                        class="theme-btn"
                                        @click="placeOrder()"
                                        :disabled="!isPlaceOrderEnabled"
                                        id="checkout-place-order-button">
                                        {{ __('shop::app.checkout.onepage.place-order') }}
                                    </button>
                                </div>
                            </div>
                        </review-section>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 order-summary-container top pt0">
                    <summary-section :key="summeryComponentKey"></summary-section>
                </div>
            </div>
        
    </script>

    <script type="text/javascript" src="https://checkout.razorpay.com/v1/checkout.js"></script>
      <script type="text/javascript">
         var SITEURL = '{{URL::to('')}}';
         var logo = "{{ asset('themes/zmart/assets/images/logo-text.png') }}";
         var key = "{{ Config::get('custom.razor_key') }}";
         $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         }); 
         function razorPay(cart_data){
            console.log("razorPay function call")
            console.log(cart_data)
               var totalAmount = cart_data.grand_total;
               var sub_total = cart_data.sub_total;
               var tax_total = cart_data.tax_total;
               var discount_amount = cart_data.discount_amount;
               var currency = cart_data.base_currency_code;
               var cust_email = cart_data.customer_email;
               var customer_id = cart_data.customer_id;
               
               var options = {
               "key": key,
               "amount": (totalAmount*100), //amt in paisa, 2000 paise = INR 20
               "name": cart_data.customer_first_name,
               "description": "Payment",
               "currency" : "INR",
               "image": logo,
               "handler": function (response){
                     $.ajax({
                       url: SITEURL + '/payment',
                       type: 'post',
                       dataType: 'json',
                       data: {
                        cart_id:cart_data.id,customer_id:customer_id,
                        razorpay_payment_id: response.razorpay_payment_id,sub_total: sub_total,
                        totalAmount : totalAmount,currency : currency,is_guest:cart_data.is_guest,
                        customer_first_name:cart_data.customer_first_name, customer_last_name:cart_data.customer_last_name
                       }, 
                       success: function (res) {
                        console.log(res)
                            if (res.success) {
                                console.log("SITEURL:"+SITEURL)
                                window.location.href = SITEURL + '/checkout/success';
                            }else{
                                this.disable_button = true;
                                
                                window.showAlert(`alert-danger`, 'Danger', res.msg);
                            }
              
                       }
                   });
                 
               },
                "modal": {
                    "ondismiss": function(){
                        $('#checkout-place-order-button').removeAttr('disabled');
                         console.log("ondismiss")
                          window.showAlert(`alert-danger`, 'Danger', 'Payment Failed');
                     }
                },
               "prefill": {
                   "contact": '9898989898',
                   "email":   cust_email,
                },
                "theme": {
                   "color": "#274985"
                }
         };
         var rzp1 = new Razorpay(options);
             rzp1.open();
             e.preventDefault();

         }
    

    $( document ).ready(function() {

        $(document).on("click", "#checkout-place-order-button" , function() {
            console.log("on click event")
            placeOrder();
        });
    });

      </script>

    <script type="text/javascript">
        (() => {
            var reviewHtml = '';
            var paymentHtml = '';
            var summaryHtml = '';
            var shippingHtml = '';
            var paymentMethods = '';
            var customerAddress = '';
            var shippingMethods = '';

            var reviewTemplateRenderFns = [];
            var paymentTemplateRenderFns = [];
            var summaryTemplateRenderFns = [];
            var shippingTemplateRenderFns = [];

            @auth('customer')
                @if(auth('customer')->user()->addresses)
                    customerAddress = @json(auth('customer')->user()->addresses);
                    customerAddress.email = "{{ auth('customer')->user()->email }}";
                    customerAddress.first_name = "{{ auth('customer')->user()->first_name }}";
                    customerAddress.last_name = "{{ auth('customer')->user()->last_name }}";
                @endif
            @endauth

            Vue.component('checkout', {
                template: '#checkout-template',
                inject: ['$validator'],

                data: function () {
                    return {
                        allAddress: {},
                        current_step: 1,
                        completed_step: 0,
                        isCheckPayment: true,
                        isRazorPayPayment:false,
                        is_customer_exist: 0,
                        disable_button: false,
                        reviewComponentKey: 0,
                        summeryComponentKey: 0,
                        showPaymentSection: false,
                        showSummarySection: false,
                        isPlaceOrderEnabled: false,
                        new_billing_address: false,
                        showShippingSection: false,
                        new_shipping_address: false,
                        selected_payment_method: '',
                        selected_shipping_method: '',
                        country: @json(core()->countries()),
                        countryStates: @json(core()->groupedStatesByCountries()),

                        step_numbers: {
                            'information': 1,
                            'shipping': 2,
                            'payment': 3,
                            'review': 4
                        },

                        address: {
                            billing: {
                                address1: [''],

                                use_for_shipping: true,
                            },

                            shipping: {
                                address1: ['']
                            },
                        },
                    }
                },

                created: function () {
                    this.getOrderSummary();

                    if (! customerAddress) {
                        this.new_shipping_address = true;
                        this.new_billing_address = true;
                    } else {
                        this.address.billing.first_name = this.address.shipping.first_name = customerAddress.first_name;
                        this.address.billing.last_name = this.address.shipping.last_name = customerAddress.last_name;
                        this.address.billing.email = this.address.shipping.email = customerAddress.email;

                        if (customerAddress.length < 1) {
                            this.new_shipping_address = true;
                            this.new_billing_address = true;
                        } else {
                            this.allAddress = customerAddress;

                            for (var country in this.country) {
                                for (var code in this.allAddress) {
                                    if (this.allAddress[code].country) {
                                        if (this.allAddress[code].country == this.country[country].code) {
                                            this.allAddress[code]['country'] = this.country[country].name;
                                        }
                                    }
                                }
                            }
                        }
                    }
                },

                methods: {
                    navigateToStep: function (step) {
                        if (step <= this.completed_step) {
                            this.current_step = step
                            this.completed_step = step - 1;
                        }
                    },

                    haveStates: function (addressType) {
                        if (this.countryStates[this.address[addressType].country] && this.countryStates[this.address[addressType].country].length)
                            return true;

                        return false;
                    },

                    validateForm: function (scope) {
                        var isManualValidationFail = false;

                        if (scope == 'address-form') {
                            isManualValidationFail = this.validateAddressForm();
                        }

                        if (! isManualValidationFail) {
                            this.$validator.validateAll(scope)
                            .then(result => {
                                if (result) {
                                    this.$root.showLoader();

                                    switch (scope) {
                                        case 'address-form':
                                            this.saveAddress();
                                            break;

                                        case 'shipping-form':
                                            if (this.showShippingSection) {
                                                this.$root.showLoader();
                                                this.saveShipping();
                                                break;
                                            }

                                        case 'payment-form':
                                            this.$root.showLoader();
                                            this.savePayment();

                                            this.isPlaceOrderEnabled = ! this.validateAddressForm();
                                            break;

                                        default:
                                            break;
                                    }

                                } else {
                                    this.isPlaceOrderEnabled = false;
                                }
                            });
                        } else {
                            this.isPlaceOrderEnabled = false;
                        }
                    },

                    validateAddressForm: function () {
                        var isManualValidationFail = false;

                        let form = $(document).find('form[data-vv-scope=address-form]');

                        // validate that if all the field contains some value
                        if (form) {
                            form.find(':input').each((index, element) => {
                                let value = $(element).val();
                                let elementId = element.id;

                                if(value != "" && elementId == "billing[phone]") {
                                    if(value.length <= 7) {
                                        var billingPhone = "Billing Telephone not less than 8 digit.";
                                        console.log(billingPhone);
                                        $("#errorsNumBilling").html(billingPhone);
                                        isManualValidationFail = true;
                                    } else if(value.length > 12) {
                                        var billingPhone = "Billing Telephone not greater than 12 digit.";
                                        console.log(billingPhone);
                                        $("#errorsNumBilling").html(billingPhone);
                                        isManualValidationFail = true;
                                    } else {
                                        $("#errorsNumBilling").html("");
                                    }
                                }

                                if(value != "" && elementId == "shipping[phone]") {
                                    if(value.length <= 7) {
                                        var billingPhone = "Shipping Telephone not less than 8 digit.";
                                        console.log(billingPhone);
                                        $("#errorsNumShipping").html(billingPhone);
                                        isManualValidationFail = true;
                                    } else if(value.length > 12) {
                                        var billingPhone = "Shipping Telephone not greater than 12 digit.";
                                        console.log(billingPhone);
                                        $("#errorsNumShipping").html(billingPhone);
                                        isManualValidationFail = true;
                                    } else {
                                        $("#errorsNumShipping").html("");
                                    }
                                }

                                if (value == ""
                                    && element.id != 'sign-btn'
                                    && element.id != 'billing[company_name]'
                                    && element.id != 'shipping[company_name]'
                                ) {
                                    // check for multiple line address
                                    if (elementId.match('billing_address_')
                                        || elementId.match('shipping_address_')
                                    ) {
                                        // only first line address is required
                                        if (elementId == 'billing_address_0'
                                            || elementId == 'shipping_address_0'
                                        ) {
                                            isManualValidationFail = true;
                                        }
                                    } else {
                                        isManualValidationFail = true;
                                    }
                                }
                            });
                        }

                        // validate that if customer wants to use different shipping address
                        if (! this.address.billing.use_for_shipping) {
                            if (! this.address.shipping.address_id && ! this.new_shipping_address) {
                                isManualValidationFail = true;
                            }
                        }

                        return isManualValidationFail;
                    },

                    isCustomerExist: function() {
                        this.$validator.attach('address-form.billing[email]', 'required|email');

                        this.$validator.validate('address-form.billing[email]', this.address.billing.email)
                        .then(isValid => {
                            if (! isValid)
                                return;

                            this.$http.post("{{ route('customer.checkout.exist') }}", {email: this.address.billing.email})
                            .then(response => {
                                this.is_customer_exist = response.data ? 1 : 0;
                                console.log(this.is_customer_exist);

                                if (response.data)
                                    this.$root.hideLoader();
                            })
                            .catch(function (error) {})
                        })
                        .catch(error => {})
                    },

                    loginCustomer: function () {
                        this.$http.post("{{ route('customer.checkout.login') }}", {
                                email: this.address.billing.email,
                                password: this.address.billing.password
                            })
                            .then(response => {
                                if (response.data.success) {
                                    window.location.href = "{{ route('shop.checkout.onepage.index') }}";
                                } else {
                                    window.showAlert(`alert-danger`, this.__('shop.general.alert.danger'), response.data.error);
                                }
                            })
                            .catch(function (error) {})
                    },

                    getOrderSummary: function () {
                        this.$http.get("{{ route('shop.checkout.summary') }}")
                            .then(response => {
                                summaryHtml = Vue.compile(response.data.html)

                                this.summeryComponentKey++;
                                this.reviewComponentKey++;
                            })
                            .catch(function (error) {})
                    },

                    saveAddress: function () {
                        this.disable_button = true;

                        if (this.allAddress.length > 0) {
                            let address = this.allAddress.forEach(address => {
                                if (address.id == this.address.billing.address_id) {
                                    this.address.billing.address1 = [address.address1];

                                    if (address.email) {
                                        this.address.billing.email = address.email;
                                    }

                                    if (address.first_name) {
                                        this.address.billing.first_name = address.first_name;
                                    }

                                    if (address.last_name) {
                                        this.address.billing.last_name = address.last_name;
                                    }
                                }

                                if (address.id == this.address.shipping.address_id) {
                                    this.address.shipping.address1 = [address.address1];

                                    if (address.email) {
                                        this.address.shipping.email = address.email;
                                    }

                                    if (address.first_name) {
                                        this.address.shipping.first_name = address.first_name;
                                    }

                                    if (address.last_name) {
                                        this.address.shipping.last_name = address.last_name;
                                    }
                                }
                            });
                        }

                        this.$http.post("{{ route('shop.checkout.save-address') }}", this.address)
                            .then(response => {
                                this.disable_button = false;
                                this.isPlaceOrderEnabled = true;

                                if (this.step_numbers[response.data.jump_to_section] == 2) {
                                    this.showShippingSection = true;
                                    shippingHtml = Vue.compile(response.data.html);
                                } else {
                                    paymentHtml = Vue.compile(response.data.html)
                                }

                                this.completed_step = this.step_numbers[response.data.jump_to_section] + 1;
                                this.current_step = this.step_numbers[response.data.jump_to_section];

                                if (response.data.jump_to_section == "payment") {
                                    this.showPaymentSection = true;
                                    paymentMethods  = response.data.paymentMethods;
                                }

                                shippingMethods = response.data.shippingMethods;

                                this.getOrderSummary();

                                this.$root.hideLoader();
                            })
                            .catch(error => {
                                this.disable_button = false;
                                this.$root.hideLoader();

                                this.handleErrorResponse(error.response, 'address-form')
                            })
                    },

                    saveShipping: function () {
                        this.disable_button = true;

                        this.$http.post("{{ route('shop.checkout.save-shipping') }}", {'shipping_method': this.selected_shipping_method})
                            .then(response => {
                                this.$root.hideLoader();
                                this.disable_button = false;
                                this.showPaymentSection = true;

                                paymentHtml = Vue.compile(response.data.html)

                                this.completed_step = this.step_numbers[response.data.jump_to_section] + 1;

                                this.current_step = this.step_numbers[response.data.jump_to_section];

                                paymentMethods = response.data.paymentMethods;

                                if (this.selected_payment_method) {
                                    this.savePayment();
                                }

                                this.getOrderSummary();
                            })
                            .catch(error => {
                                this.disable_button = false;
                                this.$root.hideLoader();
                                this.handleErrorResponse(error.response, 'shipping-form')
                            })
                    },

                    savePayment: function () {
                        this.disable_button = true;

                        if (this.isCheckPayment) {
                            this.isCheckPayment = false;

                            this.$http.post("{{ route('shop.checkout.save-payment') }}", {'payment': this.selected_payment_method})
                            .then(response => {
                                this.isCheckPayment = true;
                                this.disable_button = false;

                                this.showSummarySection = true;
                                this.$root.hideLoader();

                                reviewHtml = Vue.compile(response.data.html)
                                this.completed_step = this.step_numbers[response.data.jump_to_section] + 1;
                                this.current_step = this.step_numbers[response.data.jump_to_section];

                                document.body.style.cursor = 'auto';

                                this.getOrderSummary();
                            })
                            .catch(error => {
                                this.disable_button = false;
                                this.$root.hideLoader();
                                this.handleErrorResponse(error.response, 'payment-form')
                            });
                        }
                    },

                    placeOrder: function () {
                        if (this.isPlaceOrderEnabled) {
                            this.disable_button = false;
                            this.isPlaceOrderEnabled = false;

                            this.$root.showLoader();

                            this.$http.post("{{ route('shop.checkout.save-order') }}", {'_token': "{{ csrf_token() }}"})
                            .then(response => {
                                console.log("placeOrder",response)
                                if (response.data.success) {
                                    if (response.data.redirect_url) {
                                        this.$root.hideLoader();
                                        if (response.data.redirect_url == "razorpay") {
                                            console.log("razorpay call..")
                                            console.log(response)
                                            
                                            this.isRazorPayPayment = true;
                                            this.razorPayPayment(response.data.cart);
                                            //razorPay(response.data.cart);

                                        }else{
                                            window.location.href = response.data.redirect_url;
                                        }
                                    } else {
                                        this.$root.hideLoader();
                                        window.location.href = "{{ route('shop.checkout.success') }}";
                                    }
                                }
                            })
                            .catch(error => {
                                this.disable_button = true;
                                this.$root.hideLoader();
                                console.log('error',error)
                                window.showAlert(`alert-danger`, this.__('shop.general.alert.danger'), "{{ __('shop::app.common.error') }}");
                            })
                        } else {
                            this.disable_button = true;
                        }
                    },

                    razorPayPayment: function (cart_data) {
                        console.log("this razorpay")
                        if (this.isRazorPayPayment) {
                            this.disable_button = false;
                            this.isRazorPayPayment = false;

                            //this.$root.showLoader();
                         console.log("razorPayPayment function call")
            console.log(cart_data)
               var totalAmount = cart_data.grand_total;
               var sub_total = cart_data.sub_total;
               var tax_total = cart_data.tax_total;
               var discount_amount = cart_data.discount_amount;
               var currency = cart_data.base_currency_code;
               var cust_email = cart_data.customer_email;
               var customer_id = cart_data.customer_id;
               
               var options = {
               "key": key,
               "amount": (totalAmount*100), //amt in paisa, 2000 paise = INR 20
               "name": cart_data.customer_first_name,
               "description": "Payment",
               "currency" : "INR",
               "image": logo,
               "handler": function (response){
                     $.ajax({
                       url: SITEURL + '/payment',
                       type: 'post',
                       dataType: 'json',
                       data: {
                        cart_id:cart_data.id,customer_id:customer_id,
                        razorpay_payment_id: response.razorpay_payment_id,sub_total: sub_total,
                        totalAmount : totalAmount,currency : currency,is_guest:cart_data.is_guest,
                        customer_first_name:cart_data.customer_first_name, customer_last_name:cart_data.customer_last_name
                       }, 
                       success: function (res) {
                        console.log(res)
                            if (res.success) {
                                console.log("SITEURL:"+SITEURL)
                                window.location.href = SITEURL + '/checkout/success';
                            }else{
                                this.disable_button = true;
                            
                                window.showAlert(`alert-danger`, 'Danger', res.msg);
                            }
              
                       }
                   });
                 
               },
                "modal": {
                    "ondismiss": function(){
                        //this.$parent.hideLoader();
                        $('#checkout-place-order-button').removeAttr('disabled');
                         console.log("ondismiss")
                         this.placeOrder();
                         this.disable_button = true;
                          window.showAlert(`alert-danger`, 'Danger', 'Payment Failed');
                     }
                },
               "prefill": {
                   "contact": '9898989898',
                   "email":   cust_email,
                },
                "theme": {
                   "color": "#274985"
                }
         };
            var rzp1 = new Razorpay(options);
             rzp1.open();
             //e.preventDefault();                            
                            
                        } else {
                            this.disable_button = true;
                        }
                    },
                    modalDismiss: function () {
                        this.$root.hideLoader();
                        //$('#checkout-place-order-button').removeAttr('disabled');
                         console.log("ondismiss")
                         this.disable_button = true;
                          window.showAlert(`alert-danger`, 'Danger', 'Payment Failed');
                    },

                    handleErrorResponse: function (response, scope) {
                        if (response.status == 422) {
                            serverErrors = response.data.errors;
                            this.$root.addServerErrors(scope)
                        } else if (response.status == 403) {
                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            }
                        }
                    },

                    shippingMethodSelected: function (shippingMethod) {
                        this.selected_shipping_method = shippingMethod;
                    },

                    paymentMethodSelected: function (paymentMethod) {
                        this.selected_payment_method = paymentMethod;
                    },

                    newBillingAddress: function () {
                        this.new_billing_address = true;
                        this.isPlaceOrderEnabled = false;
                        this.address.billing.address_id = null;
                    },

                    newShippingAddress: function () {
                        this.new_shipping_address = true;
                        this.isPlaceOrderEnabled = false;
                        this.address.shipping.address_id = null;
                    },

                    backToSavedBillingAddress: function () {
                        this.new_billing_address = false;
                        this.validateFormAfterAction()
                    },

                    backToSavedShippingAddress: function () {
                        this.new_shipping_address = false;
                        this.validateFormAfterAction()
                    },

                    validateFormAfterAction: function () {
                        setTimeout(() => {
                            this.validateForm('address-form');
                        }, 0);
                    }
                }
            });

            Vue.component('shipping-section', {
                inject: ['$validator'],

                data: function () {
                    return {
                        templateRender: null,

                        selected_shipping_method: '',

                        first_iteration : true,
                    }
                },

                staticRenderFns: shippingTemplateRenderFns,

                mounted: function () {
                    this.templateRender = shippingHtml.render;

                    for (var i in shippingHtml.staticRenderFns) {
                        shippingTemplateRenderFns.push(shippingHtml.staticRenderFns[i]);
                    }

                    eventBus.$emit('after-checkout-shipping-section-added');
                },

                render: function (h) {
                    return h('div', [
                        (this.templateRender ?
                            this.templateRender() :
                            '')
                        ]);
                },

                methods: {
                    methodSelected: function () {
                        this.$parent.validateForm('shipping-form');

                        this.$emit('onShippingMethodSelected', this.selected_shipping_method)

                        eventBus.$emit('after-shipping-method-selected');
                    }
                }
            })

            Vue.component('payment-section', {
                inject: ['$validator'],

                data: function () {
                    return {
                        templateRender: null,

                        payment: {
                            method: ""
                        },

                        first_iteration : true,
                    }
                },

                staticRenderFns: paymentTemplateRenderFns,

                mounted: function () {
                    this.templateRender = paymentHtml.render;

                    for (var i in paymentHtml.staticRenderFns) {
                        paymentTemplateRenderFns.push(paymentHtml.staticRenderFns[i]);
                    }

                    eventBus.$emit('after-checkout-payment-section-added');
                },

                render: function (h) {
                    return h('div', [
                        (this.templateRender ?
                            this.templateRender() :
                            '')
                        ]);
                },

                methods: {
                    methodSelected: function () {
                        this.$parent.validateForm('payment-form');

                        this.$emit('onPaymentMethodSelected', this.payment)

                        eventBus.$emit('after-payment-method-selected');
                    }
                }
            })

            Vue.component('review-section', {
                data: function () {
                    return {
                        error_message: '',
                        templateRender: null,
                    }
                },

                staticRenderFns: reviewTemplateRenderFns,

                render: function (h) {
                    return h(
                        'div', [
                            this.templateRender ? this.templateRender() : ''
                        ]
                    );
                },

                mounted: function () {
                    this.templateRender = reviewHtml.render;

                    for (var i in reviewHtml.staticRenderFns) {
                        reviewTemplateRenderFns[i] = reviewHtml.staticRenderFns[i];
                    }

                    this.$forceUpdate();
                }
            });

            Vue.component('summary-section', {
                inject: ['$validator'],

                staticRenderFns: summaryTemplateRenderFns,

                props: {
                    discount: {
                        default: 0,
                        type: [String, Number],
                    }
                },

                data: function () {
                    return {
                        changeCount: 0,
                        coupon_code: null,
                        error_message: null,
                        templateRender: null,
                        couponChanged: false,
                    }
                },

                mounted: function () {
                    this.templateRender = summaryHtml.render;

                    for (var i in summaryHtml.staticRenderFns) {
                        summaryTemplateRenderFns[i] = summaryHtml.staticRenderFns[i];
                    }

                    this.$forceUpdate();
                },

                render: function (h) {
                    return h('div', [
                        (this.templateRender ?
                            this.templateRender() :
                            '')
                        ]);
                },

                methods: {
                    onSubmit: function () {
                        var this_this = this;
                        const emptyCouponErrorText = "Please enter a coupon code";
                    },

                    changeCoupon: function () {
                        if (this.couponChanged == true && this.changeCount == 0) {
                            this.changeCount++;

                            this.error_message = null;

                            this.couponChanged = false;
                        } else {
                            this.changeCount = 0;
                        }
                    },
                }
            });

        })()
    </script>

@endpush