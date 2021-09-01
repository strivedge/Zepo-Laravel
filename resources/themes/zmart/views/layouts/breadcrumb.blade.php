<?php 
	$segments = '';
	$i = 0;
	$len = count(Request::segments());
?>
<?php //echo "<pre>"; print_r(Request::segments()); exit(); ?>
@if($len > 0)
<div class="breadcrumb">
    <div  class="container">
        <div class="row">
            <ol class="col-md-8">
                <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                @foreach(Request::segments() as $segment)
                    <?php $segments .= '/' .$segment; ?>
                    @if($i == $len - 1)
                    	<li class="active">
                            @if($segment == "onepage")
                                <a>Checkout</a>
                            @else
                                <a>{{ ucwords(str_replace('-', ' ', $segment)) }}</a>
                            @endif
                        </li>
                    @else
                        <!-- @if($segment != "checkout" && $segment != "customer" && $segment != "account" && $segment != "page")
                        	<li>
                            	<a href="{{ route('shop.home.index') }}{{ $segments }}">{{ ucwords(str_replace('-', ' ', $segment)) }}</a>
                        	</li>
                        @endif -->
                    @endif
                    <?php $i++; ?>
                @endforeach
            </ol>
            @if(isset($product->brand_logo) && !empty($product->brand_logo))
                <div class="col-md-4">
                    <div class="brand-logo">
                        <img src="{{ asset('/').$product->brand_logo }}">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endif