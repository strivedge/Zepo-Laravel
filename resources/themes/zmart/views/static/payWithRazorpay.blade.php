@extends('shop::layouts.master')

@section('content-wrapper')
    <div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            @if($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Error!</strong> {{ $message }}
                </div>
            @endif
            {!! Session::forget('error') !!}
            @if($message = Session::get('success'))
                <div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Success!</strong> {{ $message }}
                </div>
            @endif
            {!! Session::forget('success') !!}
            <div class="panel panel-default">
                <div class="panel-heading">Pay With Razorpay</div>

                <div class="panel-body text-center">
                   
                    <form action="{{ route('payment') }}" method="POST" >
                        @csrf
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ Config::get('custom.razor_key') }}"
                                data-amount="100"
                                data-currency="INR"
                                data-buttontext="Pay 1 INR"
                                data-name="Zepomart"
                                data-description="Rozerpay"
                                data-image="{{ asset('/image/nice.png') }}"
                                data-prefill.name="Payal"
                                data-prefill.email="payal@gmail.com"
                                data-theme.color="#ff7529">
                        </script>
                    </form>

                    <input class="buy_plan1" data-id="5" data-amount="1" type="button" id="razorpay" name="payment" value="payment">

                               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
           
        });
    </script>
     <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
      <script>
         var SITEURL = '{{URL::to('')}}';
         var logo = "{{ asset('themes/zmart/assets/images/logo-text.png') }}";
         var key = "{{ Config::get('custom.razor_key') }}";
         $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         }); 
         $('body').on('click', '.buy_plan1', function(e){
            console.log("click event")
           var totalAmount = $(this).attr("data-amount");
           var product_id =  $(this).attr("data-id");
           var options = {
           "key": key,
           "amount": (totalAmount*100), // 2000 paise = INR 20
           "name": "Test Name",
           "description": "Payment",
           "currency" : "INR",
           "image": logo,
           "handler": function (response){
             console.log("response",response)
                 $.ajax({
                   url: SITEURL + '/payment',
                   type: 'post',
                   dataType: 'json',
                   data: {

                    razorpay_payment_id: response.razorpay_payment_id , 
                     totalAmount : totalAmount ,product_id : product_id,
                   }, 
                   success: function (msg) {
          
                       window.location.href = SITEURL + '/checkout/success';
                   }
               });
             
           },
          "prefill": {
               "contact": '9898989898',
               "email":   'test@gmail.com',
           },
           "theme": {
               "color": "#274985"
           }
         };
         var rzp1 = new Razorpay(options);
             rzp1.open();
             e.preventDefault();
         });
         /*document.getElementsClass('buy_plan1').onclick = function(e){
           rzp1.open();
           e.preventDefault();
         }*/
      </script>
@endpush
