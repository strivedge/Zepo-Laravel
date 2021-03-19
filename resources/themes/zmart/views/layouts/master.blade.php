@php
    $velocityHelper = app('Webkul\Velocity\Helpers\Helper');
    $velocityMetaData = $velocityHelper->getVelocityMetaData();
    
    view()->share('velocityMetaData', $velocityMetaData);
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <title>@yield('page_title')</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        
        <link rel="stylesheet" href="{{ asset('themes/zmart/assets/css/velocity.css') }}" />
        <link rel="stylesheet" href="{{ asset('themes/zmart/assets/css/slick-theme.css') }}" />
        <link rel="stylesheet" href="{{ asset('themes/zmart/assets/css/slick.css') }}" />
        <link rel="stylesheet" href="{{ asset('themes/zmart/assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('themes/zmart/assets/css/google-font.css') }}" />
        <link rel="stylesheet" href="{{ asset('themes/zmart/assets/css/custom.css') }}" />
        <link rel="stylesheet" href="{{ asset('themes/zmart/assets/css/boxicons.min.css') }}" />
        


         <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

        @if (core()->getCurrentLocale()->direction == 'rtl')
            <link href="{{ asset('themes/zmart/assets/css/bootstrap-flipped.css') }}" rel="stylesheet">
        @endif

        @if ($favicon = core()->getCurrentChannel()->favicon_url)
            <link rel="icon" sizes="16x16" href="{{ $favicon }}" />
        @else
            <link rel="icon" sizes="16x16" href="{{ asset('/themes/zmart/assets/images/static/z-icon.ico') }}" />
        @endif

        <script type="text/javascript">
            function googleTranslateElementInit() {
              new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
            }
        </script>

        <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

        <script
            type="text/javascript"
            src="{{ asset('themes/zmart/assets/js/jquery.min.js') }}">
        </script>

        <script
            type="text/javascript"
            baseUrl="{{ url()->to('/') }}"
            src="{{ asset('themes/velocity/assets/js/velocity.js') }}">
        </script>

        <script
            type="text/javascript"
            src="{{ asset('themes/zmart/assets/js/jquery.ez-plus.js') }}">
        </script> 

        @yield('head')

        @section('seo')
            <meta name="description" content="{{ core()->getCurrentChannel()->description }}"/>
        @show

        @stack('css')

        {!! view_render_event('bagisto.shop.layout.head') !!}

        <style>
            {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
        </style>

        <style type="text/css">
            .switcher {font-family:Arial;font-size:10pt;text-align:left;cursor:pointer;overflow:hidden;width:163px;line-height:17px;}
            .switcher a {text-decoration:none;display:block;font-size:10pt;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;}
            .switcher a img {vertical-align:middle;display:inline;border:0;padding:0;margin:0;opacity:0.8;}
            .switcher a:hover img {opacity:1;}
            .switcher .selected {background:#FFFFFF url(//www.jdmeditech.com/wp-content/plugins/gtranslate/switcher.png) repeat-x;position:relative;z-index:9999;}
            .switcher .selected a {border:1px solid #CCCCCC;background:url(//www.jdmeditech.com/wp-content/plugins/gtranslate/arrow_down.png) 146px center no-repeat;color:#666666;padding:3px 5px;width:151px;}
            .switcher .selected a.open {background-image:url(//www.jdmeditech.com/wp-content/plugins/gtranslate/arrow_up.png)}
            .switcher .selected a:hover {background:#F0F0F0 url(//www.jdmeditech.com/wp-content/plugins/gtranslate/arrow_down.png) 146px center no-repeat;}
            .switcher .option {position:relative;z-index:9998;border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;background-color:#EEEEEE;display:none;width:161px;max-height:198px;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;overflow-y:auto;overflow-x:hidden;}
            .switcher .option a {color:#000;padding:3px 5px;}
            .switcher .option a:hover {background:#FFC;}
            .switcher .option a.selected {background:#FFC;}
            #selected_lang_name {float: none;}
            .l_name {float: none !important;margin: 0;}
            .switcher .option::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 3px rgba(0,0,0,0.3);border-radius:5px;background-color:#F5F5F5;}
            .switcher .option::-webkit-scrollbar {width:5px;}
            .switcher .option::-webkit-scrollbar-thumb {border-radius:5px;-webkit-box-shadow: inset 0 0 3px rgba(0,0,0,.3);background-color:#888;}
        </style>

    </head>

    <body @if (core()->getCurrentLocale()->direction == 'rtl') class="rtl" @endif>
        {!! view_render_event('bagisto.shop.layout.body.before') !!}

        @include('shop::UI.particals')

        <div id="app">
            {{-- <responsive-sidebar v-html="responsiveSidebarTemplate"></responsive-sidebar> --}}

            <product-quick-view v-if="$root.quickView"></product-quick-view>

            <div class="main-container-wrapper">

                @section('body-header')
                    @include('shop::layouts.top-nav.index')

                    {!! view_render_event('bagisto.shop.layout.header.before') !!}

                        @include('shop::layouts.header.index')

                    {!! view_render_event('bagisto.shop.layout.header.after') !!}

                    <div class="main-content-wrapper col-12 no-padding">
                        <div id="head">
                        </div>
                        @php
                            $velocityContent = app('Webkul\Velocity\Repositories\ContentRepository')->getAllContents();
                        @endphp

                        <content-header
                            url="{{ url()->to('/') }}"
                            :header-content="{{ json_encode($velocityContent) }}"
                            heading= "{{ __('velocity::app.menu-navbar.text-category') }}"
                            category-count="{{ $velocityMetaData ? $velocityMetaData->sidebar_category_count : 10 }}"
                        ></content-header>

                        <div class="">
                            <div class="container">
                                <sidebar-component
                                    main-sidebar=true
                                    id="sidebar-level-0"
                                    url="{{ url()->to('/') }}"
                                    category-count="{{ $velocityMetaData ? $velocityMetaData->sidebar_category_count : 10 }}"
                                    add-class="category-list-container pt10">
                                </sidebar-component>
                            </div>
                            @yield('home-banner-content-wrapper')
                                <div class="container">
                                    <div class="col-12 content" id="home-right-bar-container">

                                            {!! view_render_event('bagisto.shop.layout.content.before') !!}

                                            @yield('content-wrapper')

                                            {!! view_render_event('bagisto.shop.layout.content.after') !!}
                                    </div>
                                </div>
                        </div>
                    </div>
                @show

                    {!! view_render_event('bagisto.shop.layout.full-content.before') !!}
                        
                            @yield('full-content-wrapper')
                        

                    {!! view_render_event('bagisto.shop.layout.full-content.after') !!}

                    {!! view_render_event('bagisto.shop.layout.full-content.before') !!}

                        @yield('home-full-content-wrapper')

                    {!! view_render_event('bagisto.shop.layout.full-content.after') !!}

            </div>

            <div class="modal-parent" id="loader" style="top: 0" v-show="showPageLoader">
                <overlay-loader :is-open="true"></overlay-loader>
            </div>
           
        </div>

        <!-- below footer -->
        @section('footer')
            {!! view_render_event('bagisto.shop.layout.footer.before') !!}

                @include('shop::layouts.footer.index')

            {!! view_render_event('bagisto.shop.layout.footer.after') !!}
        @show

        {!! view_render_event('bagisto.shop.layout.body.after') !!}

        <div id="alert-container"></div>

        <script type="text/javascript">
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
        </script>

         <script
            type="text/javascript"
            baseUrl="{{ url()->to('/') }}"
            src="{{ asset('themes/zmart/assets/js/slick.min.js') }}">
        </script>

         <script
            type="text/javascript"
            baseUrl="{{ url()->to('/') }}"
            src="{{ asset('themes/zmart/assets/js/custom.js') }}">
        </script>

        @stack('scripts')

        <script>
            {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
        </script>
    </body>
</html>
