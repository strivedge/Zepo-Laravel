<?php 
	$segments = '';
	$i = 0;
	$len = count(Request::segments());
?>
@if($len > 0)
<div class="breadcrumb">
<ol class="container">
    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
    @foreach(Request::segments() as $segment)
        <?php $segments .= '/' .$segment; ?>
        @if($i == $len - 1)
        	<li class="active">
            <a>{{ ucwords(str_replace('-', ' ', $segment)) }}</a>
        </li>
        @else
            @if($segment != "checkout" && $segment != "customer" && $segment != "account" && $segment != "page")
            	<li>
                	<a href="{{ route('shop.home.index') }}{{ $segments }}">{{ ucwords(str_replace('-', ' ', $segment)) }}</a>
            	</li>
            @endif
        @endif
        <?php $i++; ?>
    @endforeach
</ol>
</div>
@endif