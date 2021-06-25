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
            <b>{{__('zepo::app.sellers.seller') }} : </b>{{ $data['name'] }}
        </div>

        <div>
            <b>{{__('zepo::app.sellers.seller-email') }} : </b><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
        </div>

        <div>
            <a href="{{ route('admin.users.edit', [$data['id']]) }}">
                {{__('zepo::app.sellers.go-action') }}
            </a>
        </div>
        
    </div>

@endcomponent