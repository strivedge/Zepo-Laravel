@component('shop::emails.layouts.master')

    <div>
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </div>

        <div  style="font-size:16px; color:#242424; font-weight:600; margin-top: 60px; margin-bottom: 15px">
            {!! __('shop::app.contact.greeting') !!}
        </div>

        <div>
            <b>{{ __('shop::app.contact-us.name') }}: </b>{{ $data['name'] }}
        </div>
        <div>
            <b>{{ __('shop::app.contact-us.phone-number') }}: </b>{{$data['phone']}}
        </div>
        <div>
            <b>{{ __('shop::app.contact-us.message') }}: </b>{{$data['message'] }}
        </div>

        
    </div>

@endcomponent