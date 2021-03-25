
	<label>{{ __('shop::app.products.check-availability') }}</label>
	<div class="row">
		<input type="number" name="zipcode" class="control" id="zipcode" placeholder="{{ __('shop::app.products.zip-placeholder') }}">
		<input type="button" class="theme-btn" id="check" value="{{ __('shop::app.products.check-now') }}">
		<span id="success"></span>
		<span id="errors"></span>
	</div>


<script type="text/javascript">
$(document).ready(function() {
	$("#check").click(function() {
		var zipcode = $("#zipcode").val();
		if(zipcode.length == 0) {
			$("#errors").html("{{ __('shop::app.products.zip-placeholder') }}");
			$("#success").html("");
		} else if(zipcode.length <= 5) {
			$("#errors").html("{{ __('shop::app.products.lessthan-six-error') }}");
			$("#success").html("");
		} else if(zipcode.length > 10) {
			$("#errors").html("{{ __('shop::app.products.greaterthan-ten-error') }}");
			$("#success").html("");
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
						$("#errors").html("{{ __('shop::app.products.zip-not-provide') }}"+zipcode);
						$("#success").html("");
					}
			    }
			});
		}

	});
});
</script>