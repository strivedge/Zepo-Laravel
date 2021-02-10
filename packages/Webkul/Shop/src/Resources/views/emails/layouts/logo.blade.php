@if ($logo = core()->getCurrentChannel()->logo_url)
    <img src="{{ $logo }}" alt="{{ config('app.name') }}" style="height: 40px; width: 110px;"/>
@else
	<img src="{{ asset('themes/zmart/assets/images/logo-text.png') }}" alt="Zepomart" class="logo custom-logo" style="height: 40px; width: 110px;">
@endif