@extends('admin::layouts.content')

@section('page_title')
	{{__('admin::app.catalog.customer.add-title') }}
@stop

@section('content')
<div class="content">
    <form method="POST" action="{{ route('admin.catalog.customer.save') }}" @submit.prevent="onSubmit" id="price_data_form">

        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.dashboard.index') }}';"></i>
                    {{ __('admin::app.catalog.customer.add-title') }}
                </h1>
            </div>

            <div class="page-action">
                <button id="save_customer_price" type="button" class="btn btn-lg btn-primary">
                    {{ __('admin::app.catalog.customer.save-btn-title') }}
                </button>
            </div>
        </div>

        <div class="page-content">
            <div class="form-container">
                @csrf()

                 <div class="control-group" :class="[errors.has('product_id') ? 'has-error' : '']">
                    <label for="area_name" class="required">{{ __('admin::app.catalog.customer.product') }}</label>
                     <select id="product_id" name="product_id" data-vv-as="&quot;{{ __('admin::app.catalog.customer.product') }}&quot;" class="control product_id" aria-invalid="false">
                        <option value="">Select Product</option> 
                        @foreach ($products as $ck=>$prod)
                            <option value="{{$prod->product_id}}">{{$prod->product_name}} </option> 
                        @endforeach
                    </select>
                    <div>
                        <span id="product_id_error" class="control-error">
                             {{ __('admin::app.catalog.customer.required') }}
                        </span>
                    </div>
                </div>

                <div id="customer_price_div">
                    <div class="customer_price_div" id="customer_price_div_1">
                        <div class="control-group" :class="[errors.has('customer_id') ? 'has-error' : '']">
                            <label for="area_name" class="required">{{ __('admin::app.catalog.customer.customer') }}</label>
                             <select data-id="customer_id_err" id="customer_id" name="customer_id[]" data-vv-as="&quot;{{ __('admin::app.catalog.customer.customer') }}&quot;"  value="" class="control customer_id" aria-invalid="false">
                                <option value="">Select Customer</option> 
                                @foreach ($customers as $ck=>$cust)
                                    <option value="{{$cust->customer_id}}">{{$cust->full_name}} </option> 
                                @endforeach
                            </select>
                            <div>
                                <span class="control-error" id="customer_id_err" style="display: none">
                                   {{ __('admin::app.catalog.customer.required') }}
                                </span>
                            </div>
                        </div>

                        <div class="control-group" :class="[errors.has('price') ? 'has-error' : '']">
                            <label for="customer_price" class="required">{{ __('admin::app.catalog.customer.price') }}</label>
                             <input type="text" data-id="customer_price" name="customer_price[]" value="" data-vv-as="&quot;{{__('offer::app.offer.price') }}&quot;" class="control customer_price" aria-required="true" aria-invalid="false"> 
                             <div>
                                <span class="control-error" id="customer_price" style="display: none">
                                    {{ __('admin::app.catalog.customer.required') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <button id="add_cutomer_price" type="button" class="btn btn-lg btn-primary" style="margin-bottom: 15px;">{{ __('admin::app.catalog.customer.add_more_customer') }}
                </button>

            </div>
        </div>
    </form>
</div>
@stop

@push('scripts')
    <script >
        $(document).ready(function () {
            //var products = <?php echo json_encode($products); ?>;
            var customer = <?php echo json_encode($customers); ?>;
            var required = "{{ __('admin::app.catalog.customer.required') }}";

           //console.log('customer',customer)

            function add_more_customer(){
                //console.log('add_more_customer')

                var items = $('.customer_price_div').length;
                //items = parseInt(items)+1;
                items = items + $.now();
                console.log('items',items)

                var fieldHTML = '<div class="customer_price_div" id="customer_price_div_'+items+'"><div class="control-group"><label for="customer_id_'+items+'">Customer <span style="color:red;text-align: right;" class="remove_div" id='+items+'>Remove</span> </label><select data-id="customer_id_err_'+items+'" id="customer_id_'+items+'" name="customer_id[]" data-vv-as="&quot;Seller&quot;" class="control customer_id" aria-invalid="false"></select><div><span class="control-error" id="customer_id_err_'+items+'" style="display: none">'+required+'</span></div></div><div class="control-group"><label for="customer_price_'+items+'" class="required">Price <span class="currency-code">($)</span></label> <input type="text" data-id="customer_price_'+items+'" name="customer_price[]" data-vv-as="&quot;Price&quot;" class="control customer_price" aria-required="true" aria-invalid="false"><div><span class="control-error" id="customer_price_'+items+'" style="display: none">'+required+'</span></div></div></div>';

                $('#customer_price_div').append(fieldHTML);

                // $.each(products, function(i, val){
                                    
                //     $('#product_id_'+items).append($('<option></option>').attr('value',val.product_id).text(val.product_name));
                // });

                $('#customer_id_'+items).append($('<option></option>').attr('value','').text('Select Customer'));
                $.each(customer, function(i, val){
                                    
                    $('#customer_id_'+items).append($('<option></option>').attr('value',val.customer_id).text(val.full_name));
                });

            }

            function save_customer_price(submit=false){
                console.log('save_customer_price')
                var inputs = $(".customer_id");
                var prices = $(".customer_price");
                var valid = true;
                    var customer_id = [];
                    var data = [];
                    if (inputs.length > 0) {
                        if ($('#product_id').val() == '') {
                            valid = false;
                            $('#product_id_error').show();
                         }else{
                            valid = true;
                            $('#product_id_error').hide();
                         }

                        for(var i = 0; i < inputs.length; i++){
                            var cust_id = $(inputs[i]).attr('data-id');
                            var price_id = $(prices[i]).attr('data-id');

                            console.log('cust val',$(inputs[i]).val());
                            console.log('price val',$(prices[i]).val());

                             if (!$(inputs[i]).val() || $(inputs[i]).val() == '') {
                                    valid = false;
                                console.log('cust_id',cust_id)
                                $('#'+cust_id).show();
                             }else{
                                $('#'+cust_id).hide();
                             }
                             if (!$(prices[i]).val() || $(prices[i]).val() == '') {
                                valid = false;
                                console.log('price_id',price_id)
                                $('#'+price_id).show();
                             }else{
                                $('#'+price_id).hide();
                             }
                            customer_id.push($(inputs[i]).val());
                            var obj = {customer_id:$(inputs[i]).val(),price:$(prices[i]).val()};
                            data.push(obj);
                        }
                    }else{
                        valid = false;
                    }
                    console.log('data',JSON.stringify(data))

                    if (valid && submit) {
                        $("#price_data_form").submit();
                    }
                    
                  
            }
           
            $(document.body).on('click','#save_customer_price', function(e) { 
                save_customer_price(true);
            });

            $(document.body).on('change','.customer_id, .customer_price, .product_id', function(e) {
                save_customer_price(false);
            });

            $(document).on("click", ".remove_div" , function(){
                var divid='customer_price_div_'+this.id;
                $('#'+divid).remove();
            });

            $(document.body).on('click','#add_cutomer_price', function(e) { 
                console.log('document add_cutomer_price');
                add_more_customer();
            });

         });
    </script>

@endpush