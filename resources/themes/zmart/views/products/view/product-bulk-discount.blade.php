@php
    $basicDiscounts = $product->basicDiscount;
    $bulkDiscounts = $product->bulkDiscount;
@endphp

@auth('customer')
@if((isset($basicDiscounts) && count($basicDiscounts) > 0) && (isset($bulkDiscounts) && count($bulkDiscounts) > 0))
<div class="col-lg-12">
	<div class="row">
		@if(isset($basicDiscounts) && count($basicDiscounts) > 0)
		<div class="basic-discount" style="margin-right: 10px;">
			<table border="1" style="width: 100%;">
				<tr align="center">
					<th colspan="3" style="padding: 7px;">
						Basic Discount
					</th>
				</tr>
				<tr>
				@foreach($basicDiscounts as $key => $basicDiscount)
					<td style="padding: 8px;">
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
			<table border="1" style="width: 100%;">
				<tr align="center">
					<th colspan="3" style="padding: 7px;">
						Extra Bulk Discount
					</th>
				</tr>
				<tr>
				@foreach($bulkDiscounts as $key => $bulkDiscount)
					<td style="padding: 8px;">
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
	
	<div class="calculation" style="margin-top: 20px;">
		<table border="1" style="width: 100%;">
			<tr style="padding: 8px;" align="center">
				<th colspan="6">
					Price
				</th>
				<th colspan="2">
					Amount
				</th>
			</tr>

			<tr style="padding: 8px;" align="right">
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
				<td style="color: #239154;" id="ebulkDPrice">0.00 Piece</td>
				<td style="color: #ff6700;" id="bDPrice">0.00 Piece</td>
				<td>{!! $product->getTypeInstance()->getPriceHtml() !!} Piece</td>
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
				<td style="color: #239154;">Total Discount Amount :</td>
				<td style="color: #239154;" id="disAmount">0.00 </td>
			</tr>

			<tr align="right">
				<td colspan="6">
					<span>Total Order Qty : </span>
					<span id="orderPiece">0 Piece </span>
				</td>
				<td style="color: #ff6700;">Total Dis. Basic Amount :</td>
				<td style="color: #ff6700;" id="totalDisBscAmt">0.00 </td>
			</tr>
		</table>
	</div>
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
		if(totalPiece >= bDcondition1 && totalPiece <= bDcondition2-1) {
			var dpercent1 = (totalPrice*bPercentDis1)/100;
			var discountAmount = (dpercent1).toFixed(2);
			totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var	basicDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#bDPrice").html(basicDPrice);

		} if(totalPiece >= bDcondition2 && totalPiece <= bDcondition3-1) {
			var dpercent2 = (totalPrice*bPercentDis2)/100;
			var discountAmount = (dpercent2).toFixed(2);
			totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var	basicDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#bDPrice").html(basicDPrice);

		} if(totalPiece >= bDcondition3) {
			var dpercent3 = (totalPrice*bPercentDis3)/100;
			var discountAmount = (dpercent3).toFixed(2);
			totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var	basicDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#bDPrice").html(basicDPrice);
		}

		// Conditions for Extra Bulk Discount
		if(totalPrice >= exBDcondition1 && totalPrice <= exBDcondition2-1) {
			var bulkpercent1 = (totalPrice*exBpercentDis1)/100;
			var discountAmount = (bulkpercent1).toFixed(2);
			totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#ebulkDPrice").html(bulkDPrice);
			console.log("Bulk 1",bulkpercent1);

		} if(totalPrice >= exBDcondition2 && totalPrice <= exBDcondition3-1) {
			var bulkpercent2 = (totalPrice*exBpercentDis2)/100;
			var discountAmount = (bulkpercent2).toFixed(2);
			totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#ebulkDPrice").html(bulkDPrice);
			console.log("Bulk 2",bulkpercent2);

		} if(totalPrice >= exBDcondition3-1) {
			var bulkpercent3 = (totalPrice*exBpercentDis3)/100;
			var discountAmount = (bulkpercent3).toFixed(2);
			totalPriceDis = (totalPrice-discountAmount).toFixed(2);
			var bulkDPrice = (totalPriceDis/totalPiece).toFixed(2);
			$("#ebulkDPrice").html(bulkDPrice);
			console.log("Bulk 3",bulkpercent3);
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