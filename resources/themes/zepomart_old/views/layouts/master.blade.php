@php
    $velocityHelper = app('Webkul\Velocity\Helpers\Helper');
    $velocityMetaData = $velocityHelper->getVelocityMetaData();
    
    view()->share('velocityMetaData', $velocityMetaData);
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <title>Zapomart</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="{{ asset('themes/zepomart/assets/css/bootstrap.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('themes/zepomart/assets/css/style.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('themes/zepomart/assets/css/boxicons.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('themes/zepomart/assets/css/bootstrap-select.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('themes/zepomart/assets/css/slick-theme.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('themes/zepomart/assets/css/slick.css') }}" type="text/css" />
       
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

        <script 
            type="text/javascript"
            src="{{ asset('themes/zepomart/assets/js/jquery-3.5.1.min.js') }}" >  
        </script>

        <!-- <script
            type="text/javascript"
            baseUrl="{{ url()->to('/') }}"
            src="{{ asset('themes/zepomart/assets/js/velocity.js') }}">
        </script> -->
       
    </head>

    <body @if (core()->getCurrentLocale()->direction == 'rtl') class="rtl" @endif>
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        <div class="wrapper">
            <!-- Header ============================================= -->
            
                {{-- <responsive-sidebar v-html="responsiveSidebarTemplate"></responsive-sidebar> --}}

                <product-quick-view v-if="$root.quickView"></product-quick-view>

                    @section('body-header')

                        {!! view_render_event('bagisto.shop.layout.header.before') !!}

                            @include('shop::layouts.header.index')

                        {!! view_render_event('bagisto.shop.layout.header.after') !!}

                    @show


                        {!! view_render_event('bagisto.shop.layout.full-content.before') !!}

                            @yield('full-content-wrapper')

                        {!! view_render_event('bagisto.shop.layout.full-content.after') !!}

                <div class="modal-parent" id="loader" style="top: 0" v-show="showPageLoader">
                    <overlay-loader :is-open="true"></overlay-loader>
                </div>
           
            <!-- Footer ============================================= -->
            <!-- below footer -->
            @section('footer')
                {!! view_render_event('bagisto.shop.layout.footer.before') !!}

                    @include('shop::layouts.footer.index')

                {!! view_render_event('bagisto.shop.layout.footer.after') !!}
            @show

            {!! view_render_event('bagisto.shop.layout.body.after') !!}
        </div>

        <div id="alert-container"></div>

       <!--  <script type="text/javascript">
            (() => {
                window.showAlert = (messageType, messageLabel, message) => {
                    if (messageType && message !== '') {
                        let alertId = Math.floor(Math.random() * 1000);

                        let html = `<div class="alert ${messageType} alert-dismissible" id="${alertId}">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>${messageLabel ? messageLabel + '!' : ''} </strong> ${message}.
                        </div>`;

                        $('#alert-container').append(html).ready(() => {
                            window.setTimeout(() => {
                                $(`#alert-container #${alertId}`).remove();
                            }, 5000);
                        });
                    }
                }

                let messageType = '';
                let messageLabel = '';

                @if ($message = session('success'))
                    messageType = 'alert-success';
                    messageLabel = "{{ __('velocity::app.shop.general.alert.success') }}";
                @elseif ($message = session('warning'))
                    messageType = 'alert-warning';
                    messageLabel = "{{ __('velocity::app.shop.general.alert.warning') }}";
                @elseif ($message = session('error'))
                    messageType = 'alert-danger';
                    messageLabel = "{{ __('velocity::app.shop.general.alert.error') }}";
                @elseif ($message = session('info'))
                    messageType = 'alert-info';
                    messageLabel = "{{ __('velocity::app.shop.general.alert.info') }}";
                @endif

                if (messageType && '{{ $message }}' !== '') {
                    window.showAlert(messageType, messageLabel, '{{ $message }}');
                }

                window.serverErrors = [];
                @if (isset($errors))
                    @if (count($errors))
                        window.serverErrors = @json($errors->getMessages());
                    @endif
                @endif

                window._translations = @json(app('Webkul\Velocity\Helpers\Helper')->jsonTranslations());
            })();
        </script>

        <script
            type="text/javascript"
            src="{{ asset('vendor/webkul/ui/assets/js/ui.js') }}">
        </script> -->

       
        <script type="text/javascript"
            src="{{ asset('themes/zepomart/assets/js/bootstrap.js') }}" ></script>
        <script type="text/javascript"
            src="{{ asset('themes/zepomart/assets/js/bootstrap.min.js') }}" ></script>
        <script type="text/javascript"
            src="{{ asset('themes/zepomart/assets/js/bootstrap-select.js') }}"></script>
        <script type="text/javascript"
            src="{{ asset('themes/zepomart/assets/js/slick.min.js') }}" ></script>
        <script type="text/javascript"
            src="{{ asset('themes/zepomart/assets/js/custom.js') }}" ></script>
        <script>
            $('.carousel').carousel({
                interval: 2000
            });
        </script>
        <!-- @stack('scripts')

        <script>
            {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
        </script> -->
    </body>
</html>
