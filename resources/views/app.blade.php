<!DOCTYPE html>
@isset($pageConfigs)
  {!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
  $configData = Helper::applClasses();
@endphp
    <html  data-textdirection="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Careox</title>
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/vendors.min.css')}}">
    
    <!-- <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/themes/semi-dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-ecommerce.css')}}"> -->

    <link rel="stylesheet" href="{{mix('css/app.css') }}">
      <script src="{{mix('/js/app.js') }}" defer></script>
    @routes
  </head>
    <body class="vertical-layout vertical-menu-modern 2-columns content-left-sidebar email-application
    @if($configData['isMenuCollapsed'] == true){{'menu-collapsed'}}@endif
@if($configData['theme'] === 'dark'){{'dark-layout'}} @elseif($configData['theme'] === 'semi-dark'){{'semi-dark-layout'}} @else {{'light-layout'}} @endif
@if($configData['isContentSidebar'] === true) {{'content-left-sidebar'}} @endif @if(isset($configData['navbarType'])){{$configData['navbarType']}}@endif
@if(isset($configData['footerType'])) {{$configData['footerType']}} @endif
{{$configData['bodyCustomClass']}}
@if($configData['mainLayoutType'] === 'vertical-menu-boxicons'){{'boxicon-layout'}}@endif
@if($configData['isCardShadow'] === false){{'no-card-shadow'}}@endif" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-framework="laravel">

        @inertia


        @env ('local')
            <script src="http://127.0.0.1:8000/browser-sync/browser-sync-client.js"></script>

        @endenv
        <script>
            var assetBaseUrl = "{{ asset('') }}";
        </script>
        <script src="{{asset('frest/vendors/js/vendors.min.js')}}"></script>

        <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.tools.js')}}"></script>
        <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.defaults.js')}}"></script>
        <script src="{{asset('fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>
        <script src="{{asset('frest/vendors/js/extensions/swiper.min.js')}}"></script>
        <script src="{{asset('frest/js/scripts/configs/vertical-menu-light.js')}}"></script>
        <script src="{{asset('frest/vendors/js/charts/apexcharts.min.js')}}"></script>
        <script src="{{asset('frest/vendors/js/editors/quill/quill.min.js')}}"></script>
        <script defer src="{{asset('frest/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
        <script defer src="{{asset('frest/vendors/js/extensions/moment.min.js')}}"></script>

        <!-- <script defer src="{{asset('frest/vendors/js/extensions/toastr.min.js')}}"></script>
        <script src="{{asset('frest/vendors/js/pickers/pickadate/legacy.js')}}"></script>
        <script src="{{asset('frest/js/core/app-menu.js')}}"></script>
        <script src="{{asset('frest/js/core/app.js')}}"></script>
        <script src="{{asset('frest/js/scripts/customizer.js')}}"></script>
        <script src="{{asset('frest/vendors/js/charts/apexcharts.min.js')}}"></script> -->
    </body>

</html>

