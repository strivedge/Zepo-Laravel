@inject ('discountRepository', 'Webkul\Product\Repositories\DiscountRepository')

@php
    $basics = $discountRepository->getBasicDiscount();
    $bulks = $discountRepository->getExtraBulkDiscount();
@endphp

<div class="col-lg-12">
	<div class="row">
		@if(isset($basics) && count($basics) > 0)
		<div class="basic-discount" style="margin-right: 10px;">
			<table border="1" style="width: 100%;">
				<tr align="center">
					<th colspan="3" style="padding: 7px;">
						Basic Discount
					</th>
				</tr>
				<tr>
				@foreach($basics as $basic)
					<td style="padding: 8px;">
						{{ $basic->percentage }}% if Qty 
						{{ $basic->discount_condition }} 
						{{ $basic->discount_qty }} 
						{{ $basic->discount_by }}
					</td>
				@endforeach
				</tr>
			</table>
		</div>
		@endif

		@if(isset($bulks) && count($bulks) > 0)
		<div class="extra-bulk-discount">
			<table border="1" style="width: 100%;">
				<tr align="center">
					<th colspan="3" style="padding: 7px;">
						Extra Bulk Discount
					</th>
				</tr>
				<tr>
				@foreach($bulks as $bulk)
					<td style="padding: 8px;">
						{{ $bulk->percentage }}% if Purchase 
						{{ $bulk->discount_condition }} 
						@if($bulk->discount_by == "Amount")
							@php echo "₹"; @endphp
						@endif
						{{ $bulk->discount_purchase }} 
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
				<th colspan="5">
					Price
				</th>
				<th colspan="2">
					Amount
				</th>
			</tr>

			<tr style="padding: 8px;" align="right">
				<th>PACK OF</th>
				<th>EXTRA BULK DIS. PRICE</th>
				<th>BASIC DIS. PRICE</th>
				<th>BASIC PRICE</th>
				<th>QTY</th>
				<th></th>
				<th></th>
			</tr>

			<tr align="right">
				<td>1200 Piece</td>
				<td style="color: #239154;">₹ 0.00 Piece</td>
				<td style="color: #ff6700;">₹ 0.00 Piece</td>
				<td>₹ 0.00 Piece</td>
				<td>0 Piece</td>
				<td>0 Piece Basic Amount : </td>
				<td>₹ 0.00 </td>
			</tr>

			<tr align="right">
				<td>2400 Piece</td>
				<td style="color: #239154;">₹ 0.00 Piece</td>
				<td style="color: #ff6700;">₹ 0.00 Piece</td>
				<td>₹ 0.00 Piece</td>
				<td>0 Piece</td>
				<td>0 Piece Basic Amount : </td>
				<td>₹ 0.00 </td>
			</tr>

			<tr align="right">
				<td>2400 Piece</td>
				<td style="color: #239154;">₹ 0.00 Piece</td>
				<td style="color: #ff6700;">₹ 0.00 Piece</td>
				<td>₹ 0.00 Piece</td>
				<td>0 Piece</td>
				<td>0 Piece Basic Amount : </td>
				<td>₹ 0.00 </td>
			</tr>

			<tr align="right">
				<td colspan="5"></td>
				<td>Total Basic Amount : </td>
				<td>₹ 0.00 </td>
			</tr>

			<tr align="right">
				<td colspan="5"></td>
				<td style="color: #239154;">Total Discount Amount :</td>
				<td style="color: #239154;">₹ 0.00 </td>
			</tr>

			<tr align="right">
				<td colspan="5">
					<span>Total Order Qty : </span>
					<span>0 Piece </span>
				</td>
				<td style="color: #ff6700;">Total Dis. Basic Amount :</td>
				<td style="color: #ff6700;">₹ 0.00 </td>
			</tr>
		</table>
	</div>
</div>