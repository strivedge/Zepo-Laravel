@php
    $basicDiscounts = $product->basicDiscount;
    $bulkDiscounts = $product->bulkDiscount;
@endphp

@auth('customer')
@if((isset($basicDiscounts) && count($basicDiscounts) > 0) && (isset($bulkDiscounts) && count($bulkDiscounts) > 0))
	<h2>Get Discount</h2>
	<div class="row">
		@if(isset($basicDiscounts) && count($basicDiscounts) > 0)
		<div class="basic-discount">
			<table class="table-discount">
				<tr align="center">
					<th colspan="3">
						Basic Discount
					</th>
				</tr>
				<tr>
				@foreach($basicDiscounts as $key => $basicDiscount)
					<td>
						{{ $basicDiscount->name }}
	@php $getBasicJsons = json_decode($basicDiscount->conditions); @endphp
		<input type="hidden" id="getBPieceCondition{{ $key }}" value="{{ $getBasicJsons[0]->value }}">
		<input type="hidden" id="bPercentDis{{ $key }}" value="{{ $basicDiscount->discount_amount }}">
					</td>
				@endforeach
				</tr>
			</table>
		</div>
		@endif

		@if(isset($bulkDiscounts) && count($bulkDiscounts) > 0)
		<div class="extra-bulk-discount">
			<table class="table-discount">
				<tr align="center">
					<th colspan="3">
						Extra Bulk Discount
					</th>
				</tr>
				<tr>
				@foreach($bulkDiscounts as $key => $bulkDiscount)
					<td>
						{{ $bulkDiscount->name }} 
	@php $getBulkJsons = json_decode($bulkDiscount->conditions); @endphp
		<input type="hidden" id="getExBPieceCondition{{ $key }}" value="{{ $getBulkJsons[0]->value }}">
		<input type="hidden" id="exBpercentDis{{ $key }}" value="{{ $bulkDiscount->discount_amount }}">
					</td>
				@endforeach
				</tr>
			</table>
		</div>
		@endif
	</div>
	
	<div class="calculation">
		<table border="1" class="table-discount">
			<tr class="calculation-heading">
				<th colspan="6">
					Price
				</th>
				<th colspan="2">
					Amount
				</th>
			</tr>

			<tr class="calculation-sub-heading" align="right">
				<th>SKU</th>
				<th>EXTRA BULK DIS. PRICE</th>
				<th>BASIC DIS. PRICE</th>
				<th>BASIC PRICE</th>
				<th>QTY</th>
				<th>ADD PACKS TO CART</th>
				<th></th>
				<th></th>
			</tr>

			<tr align="right">
				<td>{{ $product->sku }}</td>
				<td><span id="ebulkDPrice">0.00 Piece</span></td>
				<td><span id="bDPrice">0.00 Piece</span></td>
				<td class="row">@include ('shop::products.price', ['product' => $product]) Piece</td>
				<td id="qty">0 Piece</td>
				<td>
					<input type="number" name="getPiece" id="getPiece" min="0">
				</td>
				<td id="billPiece">0 Piece Basic Amount : </td>
				<td id="billPrice">0.00 </td>
			</tr>

			<tr align="right">
				<td colspan="6"></td>
				<td>Total Basic Amount : </td>
				<td id="totalPrice">0.00 </td>
			</tr>

			<tr align="right">
				<td colspan="6"></td>
				<td class="total-sub-discount">Total Discount Amount :</td>
				<td id="disAmount">0.00 </td>
			</tr>

			<tr align="right">
				<td colspan="6">
					<span class="total-heading">Total Order Qty : </span>
					<span id="orderPiece">0 Piece </span>
				</td>
				<td class="total-sub-basic-amount">Total Dis. Basic Amount :</td>
				<td id="totalDisBscAmt">0.00 </td>
			</tr>
		</table>
	</div>

@endif
@endauth

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	$(".increase").click(function() {
		totalQuantity = $("input[name='quantity']").val();
		$("input[name='quantity']").val(totalQuantity);
	});

	$(".decrease").click(function() {
		totalQuantity = $("input[name='quantity']").val();
		$("input[name='quantity']").val(totalQuantity);
	});

	$("#getPiece").change(function() {
		var pack = 1;
		var price = {{ $product->price }};
		<?php if($product->getTypeInstance()->haveSpecialPrice()) {
		?>
			price = {{ $product->special_price }}
		<?php } ?>
		
		console.log("Price ",price);
		var inputPiece = $("#getPiece").val();
		var totalPiece = pack*inputPiece;
		var totalPrice = totalPiece*price;
		var showTotalPrice = totalPrice.toFixed(2);

		// Quantity value of Basic Discount from admin side
		var bDcondition1 = $("#getBPieceCondition0").val();
		var bDcondition2 = $("#getBPieceCondition1").val();
		var bDcondition3 = $("#getBPieceCondition2").val();

		// Percentage of Basic Discount
		var bPercentDis1 = $("#bPercentDis0").val();
		var bPercentDis2 = $("#bPercentDis1").val();
		var bPercentDis3 = $("#bPercentDis2").val();

		// Purchase value of Extra Bulk Discount from admin side
		var exBDcondition1 = $("#getExBPieceCondition0").val();
		var exBDcondition2 = $("#getExBPieceCondition1").val();
		var exBDcondition3 = $("#getExBPieceCondition2").val();

		// Percentage of Extra Bulk Discount
		var exBpercentDis1 = $("#exBpercentDis0").val();
		var exBpercentDis2 = $("#exBpercentDis1").val();
		var exBpercentDis3 = $("#exBpercentDis2").val();

		var totalPriceDis = showTotalPrice;

		// Conditions for Basic Discount
		// 1st if
		if(totalPiece >= bDcondition1 && totalPiece <= bDcondition2-1) {
			var dpercent1 = (totalPrice*parseFloat(bPercentDis1))/100;
			var discountAmount = (dpercent1).toFixed(2);
			var totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var	basicDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#bDPrice").html(basicDPrice);
			$("#bDPrice").removeClass("strike");
			$("#ebulkDPrice").addClass("strike");
			console.log("If 1 ", discountAmount);

			if(totalPrice >= exBDcondition1 && totalPrice <= exBDcondition2-1) {
				var bulkpercent1 = (totalPriceDis*parseFloat(exBpercentDis1))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent1)).toFixed(2);
				totalPriceDis = (totalPriceDis-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 1",bulkpercent1);
				console.log("If 1 in If ", discountAmount);

			} else if(totalPrice >= exBDcondition2 && totalPrice <= exBDcondition3-1) {
				var bulkpercent2 = (totalPriceDis*parseFloat(exBpercentDis2))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent2)).toFixed(2);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 2",bulkpercent2);
				console.log("If 1 in If ", discountAmount);

			} else if(totalPrice >= exBDcondition3) {
				var bulkpercent3 = (totalPriceDis*parseFloat(exBpercentDis3))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent3)).toFixed(2);
				console.log("discountAmount3 ", discountAmount);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 3",bulkpercent3);
				console.log("If 1 in If ", discountAmount);
			}

		} else if(totalPiece < bDcondition1) {
			if(totalPrice >= exBDcondition1 && totalPrice <= exBDcondition2-1) {
				var bulkpercent1 = (totalPrice*parseFloat(exBpercentDis1))/100;
				var discountAmount = (bulkpercent1).toFixed(2);
				console.log("discount ",discountAmount);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 1",bulkpercent1);

			} else if(totalPrice >= exBDcondition2 && totalPrice <= exBDcondition3-1) {
				var bulkpercent2 = (totalPrice*parseFloat(exBpercentDis2))/100;
				var discountAmount = (bulkpercent2).toFixed(2);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 2",bulkpercent2);

			} else if(totalPrice >= exBDcondition3) {
				var bulkpercent3 = (totalPrice*parseFloat(exBpercentDis3))/100;
				var discountAmount = (bulkpercent3).toFixed(2);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 3",bulkpercent3);
			} else {
				var discount = 0;
				var discountAmount = (discount).toFixed(2);
				console.log("Discount ",discountAmount);
			}

		}

		// 2nd if
		if(totalPiece >= bDcondition2 && totalPiece <= bDcondition3-1) {
			var dpercent2 = (totalPrice*parseFloat(bPercentDis2))/100;
			var discountAmount = (dpercent2).toFixed(2);
			totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var	basicDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#bDPrice").html(basicDPrice);
			$("#bDPrice").removeClass("strike");
			$("#ebulkDPrice").addClass("strike");

			if(totalPrice >= exBDcondition1 && totalPrice <= exBDcondition2-1) {
				var bulkpercent1 = (totalPriceDis*parseFloat(exBpercentDis1))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent1)).toFixed(2);
				totalPriceDis = (totalPriceDis-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 1",bulkpercent1);
				console.log("If 2 in If ", discountAmount);

			} else if(totalPrice >= exBDcondition2 && totalPrice <= exBDcondition3-1) {
				var bulkpercent2 = (totalPriceDis*parseFloat(exBpercentDis2))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent2)).toFixed(2);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 2",bulkpercent2);
				console.log("If 2 in If ", discountAmount);

			} else if(totalPrice >= exBDcondition3) {
				console.log("bulkpercent3 ",totalPriceDis);
				var bulkpercent3 = (totalPriceDis*parseFloat(exBpercentDis3))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent3)).toFixed(2);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 3",bulkpercent3);
				console.log("If 2 in If ", discountAmount);
			}

		}

		// 3rd if
		if(totalPiece >= bDcondition3) {
			var dpercent3 = (totalPrice*parseFloat(bPercentDis3))/100;
			var discountAmount = (dpercent3).toFixed(2);
			totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var	basicDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#bDPrice").html(basicDPrice);
			$("#bDPrice").removeClass("strike");
			$("#ebulkDPrice").addClass("strike");

			if(totalPrice >= exBDcondition1 && totalPrice <= exBDcondition2-1) {
				var bulkpercent1 = (totalPriceDis*parseFloat(exBpercentDis1))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent1)).toFixed(2);
				totalPriceDis = (totalPriceDis-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 1",bulkpercent1);
				console.log("If 3 in If ", discountAmount);

			} else if(totalPrice >= exBDcondition2 && totalPrice <= exBDcondition3-1) {
				var bulkpercent2 = (totalPriceDis*parseFloat(exBpercentDis2))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent2)).toFixed(2);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 2",bulkpercent2);
				console.log("If 3 in If ", discountAmount);

			} else if(totalPrice >= exBDcondition3) {
				var bulkpercent3 = (totalPriceDis*parseFloat(exBpercentDis3))/100;
				var discountAmount = (parseFloat(discountAmount)+parseFloat(bulkpercent3)).toFixed(2);
				console.log("discountAmount3 ", discountAmount);
				totalPriceDis = (totalPrice-discountAmount).toFixed(2);
				var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
				$("#ebulkDPrice").html(bulkDPrice);
				$("#ebulkDPrice").removeClass("strike");
				$("#bDPrice").addClass("strike");
				console.log("Bulk 3",bulkpercent3);
				console.log("If 3 in If ", discountAmount);
			}

		}

		console.log("Piece : ",totalPiece);
		console.log("totalPriceDis : ",totalPriceDis);

		$("#qty").html(totalPiece+" Piece");
		$("#billPiece").html(totalPiece+" Piece Basic Amount : ");
		$("#billPrice").html(showTotalPrice);
		$("#totalPrice").html(showTotalPrice);
		$("#orderPiece").html(totalPiece+" Piece");
		$("#disAmount").html(discountAmount);
		$("#totalDisBscAmt").html(totalPriceDis);
		$("input[name='quantity']").val(totalPiece);
	});
});
</script>
@endpush