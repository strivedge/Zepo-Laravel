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
            <b>Customer : </b>{{ $data['name'] }}
        </div>

        <div>
            <b>Customer Email : </b><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
        </div>

        <div>
            <b>Customer Message : </b>{{ $data['message'] }}
        </div>

        <div>
            <a href="{{ route('zepo.support-ticket.edit', [$data['id']]) }}">
                go to Support Ticket Action
            </a>
        </div>
        
    </div>

@endcomponent