@if(isset($product->bulk))
	@if($product->bulk == 1)
	<div class="bluk-buy-request">
	    <button type="button" class="theme-btn" name="bulk_buy_request" data-toggle="modal" data-target=".bd-example-modal-xl">{{ __('shop::app.products.bulk-buy-request') }}
	    </button>
	</div>
	@endif
@endif

<div class="modal bd-example-modal-xl" id="myBulkRequest" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" style="padding: 130px 0px 50px;z-index: 100005;">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
			    <h2 class="modal-title" id="exampleModalLongTitle">{{ __('shop::app.products.bulk-buy-request') }}</h2>
			    
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			      <span aria-hidden="true">&times;</span>
			    </button>
			</div>
		  	<div class="modal-body">
		  		<span id="success"></span>
		  		<form method="POST" action="{{ route('shop.home.bulk-buy.sending') }}" id="bulk_form">
		  			@csrf()
		  			<div class="form-group">
						<input type="text" placeholder="Name" name="name" id="name" required>
						<span id="nameError"></span>
					</div>

					<div class="form-group">
						<input type="email" placeholder="Email" name="email" id="email" required>
						<span id="emailError"></span>
					</div>

					<div class="form-group">
						<input type="tel" placeholder="Contact No." name="contact" id="contact" required>
						<span id="contactError"></span>
					</div>

					<div class="form-group">
						<select name="quantity" id="quantity" required>
							<option value="">Select minimum quantity</option>
							<option value="5-10">5-10</option>
							<option value="10-20">10-20</option>
							<option value="20-50">20-50</option>
							<option value="50+">More than 50</option>
						</select>
						<span id="quantityError"></span>
					</div>

					<div class="form-group">
						<input type="text" placeholder="Product Name" name="product_name" id="product_name" value="{{ $product->name }}" readonly>
					</div>

					<div class="form-group">
						<input type="text" placeholder="Additional Info" name="additional" id="additional">
					</div>
					
					<div class="form-group buttons">
						<input type="button" class="theme-btn" value="Submit" id="bulk_send">
						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $("#bulk_send").click(function() {
    	var name = $("#name").val();
    	var email = $("#email").val();
    	var contact = $("#contact").val();
    	var quantity = $("#quantity option:selected").attr('value');
    	var product_name = $("#product_name").val();
    	var additional = $("#additional").val();

    	function IsEmail(email) {
	        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	        if(!regex.test(email)) {
	           return false;
	        } else {
	           return true;
	        }
      	}

    	if(name == "") {
    		$("#nameError").html("Name Required!");
    	} else {
    		$("#nameError").html("");
    	} if(email == "") {
    		$("#emailError").html("Email Required!");
    	} else if(!IsEmail(email)) {
    		$("#emailError").html("Email not valid!");
    	} else {
    		$("#emailError").html("");
    	} if(contact == "") {
    		$("#contactError").html("Contact Required!");
    	} else if(contact.length < 10) {
    		$("#contactError").html("Contact not less than 10 digit");
    	} else {
    		$("#contactError").html("");
    	} if(quantity == "") {
    		$("#quantityError").html("Quantity Required!");
    	} else {
    		$("#quantityError").html("");
    	}

    	if(name != "" && email != "" && contact != "" && quantity != "") {
    		var testUrl = $("#bulk_form").attr('action');
    		var testMethod = $("#bulk_form").attr('method');
    		$.ajax({
			    url: testUrl,
			    type: testMethod,
			    data: {
			    	"_token": "{{ csrf_token() }}",
			    	"name": name,
			    	"email": email,
			    	"contact": contact,
			    	"quantity": quantity,
			    	"product_name": product_name,
			    	"additional": additional
			    },

			    dataType: 'json',
			    async: false,
			    success: function(response) {
					console.log(response.data);
					$("#success").html("Your request sended successfully, will get in touch soon!");
					if(response.message == "Success!") {
						$("#name").val("");
						$("#email").val("");
						$("#contact").val("");
						$("#quantity").val("");
						$("#additional").val("");
					}
			    }
			});
    	}
    	return false;
    });
});
</script>
@endpush