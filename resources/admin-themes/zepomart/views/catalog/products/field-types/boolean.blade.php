<?php $selectedOption = old($attribute->code) ?: $product[$attribute->code] ?>

@if(auth()->guard('admin')->user()->role->id == 1)
    @if($attribute->code == "guest_checkout")
        <input type="hidden" class="control" id="{{ $attribute->code }}" name="{{ $attribute->code }}" data-vv-as="&quot;{{ $attribute->admin_name }}&quot;" value="1">
    @else
        <label class="switch">
            <input type="checkbox" class="control" id="{{ $attribute->code }}" name="{{ $attribute->code }}" data-vv-as="&quot;{{ $attribute->admin_name }}&quot;" {{ $selectedOption ? 'checked' : ''}} value="1">
            <span class="slider round"></span>
        </label>
    @endif
@endif

@if(auth()->guard('admin')->user()->role->id != 1)
    @if($attribute->code == "status")
    <input type="hidden" class="control" id="{{ $attribute->code }}" name="{{ $attribute->code }}" data-vv-as="&quot;{{ $attribute->admin_name }}&quot;" value="0">
    @elseif($attribute->code == "guest_checkout")
        <input type="hidden" class="control" id="{{ $attribute->code }}" name="{{ $attribute->code }}" data-vv-as="&quot;{{ $attribute->admin_name }}&quot;" value="1">
    @else
    <label class="switch">
        <input type="checkbox" class="control" id="{{ $attribute->code }}" name="{{ $attribute->code }}" data-vv-as="&quot;{{ $attribute->admin_name }}&quot;" {{ $selectedOption ? 'checked' : ''}} value="1">
        <span class="slider round"></span>
    </label>
    @endif
@endif