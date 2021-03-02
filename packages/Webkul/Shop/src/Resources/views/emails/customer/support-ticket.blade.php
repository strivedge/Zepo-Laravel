@component('shop::emails.layouts.master')

    <div>
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}">
                @include ('shop::emails.layouts.logo')
            </a>
        </div>

        <div style="font-size:16px; color:#242424; font-weight:600; margin-top: 60px; margin-bottom: 15px">
            {!! __('shop::app.contact.greeting') !!}
        </div>

        <div>
            <b>{{__('zepo::app.support-ticket.customer') }} : </b>{{ $data['name'] }}
        </div>

        <div>
            <b>{{__('zepo::app.support-ticket.customer-email') }} : </b><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
        </div>

        <div>
            <b>{{__('zepo::app.support-ticket.customer-message') }} : </b>{{ $data['message'] }}
        </div>

        <div>
            <a href="{{ route('zepo.support-ticket.edit', [$data['id']]) }}">
                {{__('zepo::app.support-ticket.go-action') }}
            </a>
        </div>
        
    </div>

@endcomponent