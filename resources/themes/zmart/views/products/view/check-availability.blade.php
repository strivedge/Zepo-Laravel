
	<label>{{ __('shop::app.products.check-availability') }}</label>
	<div class="row">
		<input type="number" name="zipcode" class="control" id="zipcode" placeholder="{{ __('shop::app.products.zip-placeholder') }}">
		<input type="button" class="theme-btn" id="check" value="{{ __('shop::app.products.check-now') }}">
		<span id="successZip" class="success-msg"></span>
		<span id="errorsZip" class="error-msg"></span>
	</div>

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	$("#check").click(function() {
		var zipcode = $("#zipcode").val();
		if(zipcode.length == 0) {
			$("#errorsZip").html("{{ __('shop::app.products.zip-placeholder') }}");
			$("#successZip").html("");
		} else if(zipcode.length <= 5) {
			$("#errorsZip").html("{{ __('shop::app.products.lessthan-six-error') }}");
			$("#successZip").html("");
		} else if(zipcode.length > 10) {
			$("#errorsZip").html("{{ __('shop::app.products.greaterthan-ten-error') }}");
			$("#successZip").html("");
		} else {
			var testUrl = "{{ URL::to('/') }}/check-zipcodes/"+zipcode;
			$("#errorsZip").html("");
				$.ajax({
			    url: testUrl,
			    type: "GET",
			    dataType: 'json',
			    async: false,
			    success: function(response) {
					console.log(response.data.length);
					if(response.data.length == 0) {
						$("#successZip").html("{{ __('shop::app.products.zip-success') }}"+zipcode);
						$("#errorsZip").html("");
					} else {
						$("#errorsZip").html("{{ __('shop::app.products.zip-not-provide') }}"+zipcode);
						$("#successZip").html("");
					}
			    }
			});
		}

	});
});
</script>
@endpush