<div class="col-6">
	<label>{{ __('shop::app.products.check-availability') }}</label>
	<div class="row">
		<input type="number" name="zipcode" class="control" id="zipcode" placeholder="{{ __('shop::app.products.zip-placeholder') }}" style="display:inline-block;width:50%;">
		<input type="button" class="theme-btn" id="check" value="{{ __('shop::app.products.check-now') }}" style="display:inline-block;width:auto;">
		<span id="success" style="color: #b1cc1e;"></span>
		<span id="errors" style="color: #ff0000;"></span>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("#check").click(function() {
		var zipcode = $("#zipcode").val();
		if(zipcode.length == 0) {
			$("#errors").html("{{ __('shop::app.products.zip-placeholder') }}");
		} else if(zipcode.length <= 5) {
			$("#errors").html("{{ __('shop::app.products.lessthan-six-error') }}");
		} else if(zipcode.length > 10) {
			$("#errors").html("{{ __('shop::app.products.greaterthan-ten-error') }}");
		} else {
			var testUrl = "{{ URL::to('/') }}/check-zipcodes/"+zipcode;
			$("#errors").html("");
				$.ajax({
			    url: testUrl,
			    type: "GET",
			    dataType: 'json',
			    async: false,
			    success: function(response) {
					console.log(response.data.length);
					if(response.data.length == 0) {
						$("#success").html("{{ __('shop::app.products.zip-success') }}"+zipcode);
					} else {
						$("#success").html("{{ __('shop::app.products.zip-not-provide') }}"+zipcode);
					}
			    }
			});
		}

	});
});
</script>