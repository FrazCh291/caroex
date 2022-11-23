<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Careox') }}</title>
{{--Comments Starting--}}
<!-- Fonts -->
{{--    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">--}}

<!-- Styles -->
{{--    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicon.ico') }}">--}}
{{--    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.ico') }}">--}}
{{--    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.ico') }}">--}}
<!-- Fonts -->
{{--    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">--}}

<!-- Styles -->
    {{--    <link rel="stylesheet" type="text/css" href="https://unpkg.com/select2@4.0.3/dist/css/select2.min.css"/>--}}
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('frest/css/themes/dark-layout.css')}}">--}}
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('frest/css/themes/semi-dark-layout.css')}}">--}}
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/forms/select/select2.min.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/assets/css/style.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/pickers/pickadate/pickadate.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/pickers/daterange/daterangepicker.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/tables/datatable/datatables.min.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css"--}}
    {{--              href="{{asset('frest/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css"--}}
    {{--              href="{{asset('frest/vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">--}}
    {{--        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/css/pages/app-invoice.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/css/core/menu/menu-types/horizontal-menu.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/css/plugins/calendars/app-calendar.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/calendars/tui-time-picker.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/calendars/tui-date-picker.css')}}">--}}
    {{--        <link rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/plugins/calendars/app-calendar.min.css')}}">--}}
    {{--    <script src="{{asset('js/dropzone/dist/dropzone.js')}}"></script>--}}
    {{--Comments Ending--}}

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700"
          rel="stylesheet">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/css/core/menu/menu-types/vertical-menu.css')}}">
    <link defer href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link defer rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/css/bootstrap.css')}}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/css/bootstrap-extended.css')}}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/css/colors.css')}}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/css/components.css')}}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/extensions/toastr.css')}}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/extensions/sweetalert2.min.css')}}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/css/pages/app-email.css')}}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/vendors.min.css')}}">
    <link defer rel="stylesheet" type="text/css" href="{{asset('frest/vendors/css/calendars/tui-calendar.min.css')}}">

    <!-- Scripts -->
    @routes
    <script src="{{ mix('js/app.js') }}" defer></script>


</head>
<style>
    body * {
        /* color: #222; */
        font-family: "Rubik", Helvetica, Arial, serif;;
        /* font-size: 14px; */
    }
</style>
<body
    class="careox-bg vertical-layout boxicon-layout no-card-shadow 2-columns navbar-sticky footer-static pace-done pace-done email-application calendar-application menu-expanded vertical-menu-modern"
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" style="line-height: 1.2">
@inertia
{{--<div id="noprogress" style="transition: none"></div>--}}
</body>

{{--Comments Starting--}}
{{--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>--}}

{{--<script src="https://unpkg.com/vue@2.5.13/dist/vue.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>--}}
{{--<script src="https://unpkg.com/select2@4.0.3/dist/js/select2.js"></script>--}}

<!-- Select2 -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>--}}
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"--}}
{{--      type="text/css">--}}


<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

{{--<script src="{{asset('frest/assets/js/scripts.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/configs/vertical-menu-light.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/pages/app-invoice.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/tables/datatable/datatables.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/forms/select/select2.full.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/navs/navs.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/tooltip/tooltip.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/extensions/dragula.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/forms/select/form-select2.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/ui/jquery.sticky.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/editors/quill/quill.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/configs/horizontal-menu.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/calendar/chance.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/calendar/tui-calendar.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/extensions/calendar/calendars-data.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/extensions/calendar/schedules.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/extensions/calendar/app-calendar.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/calendar/tui-code-snippet.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/calendar/tui-dom.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/calendar/tui-time-picker.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/vendors/js/calendar/tui-date-picker.min.js')}}"></script>--}}

{{--<script src="{{asset('frest/vendors/js/pickers/daterange/moment.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/extensions/sweet-alerts.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/extensions/sweet-alerts.min.js')}}"></script>--}}
{{--<script src="{{asset('frest/js/scripts/pages/app-email.js')}}"></script>--}}
{{--Comments Endings--}}

<!-- Dropzone JS -->
<script>
    var assetBaseUrl = "{{ asset('/') }}";
</script>

<script defer src="{{asset('frest/vendors/js/vendors.min.js')}}"></script>
<script defer src="{{asset('frest/vendors/js/extensions/toastr.min.js')}}"></script>
<script defer src="{{asset('frest/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script defer src="{{asset('frest/vendors/js/extensions/moment.min.js')}}"></script>
<script defer type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>$.noConflict();</script>

<script src="{{asset('frest/vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('frest/fonts/LivIconsEvo/js/LivIconsEvo.tools.js')}}"></script>
<script src="{{asset('frest/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js')}}"></script>
<script src="{{asset('frest/fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>
<script src="{{asset('frest/js/core/app-menu.js')}}"></script>
<script src="{{asset('frest/js/core/app.js')}}"></script>
<script src="{{asset('frest/js/scripts/components.js')}}"></script>
<script src="{{asset('frest/js/scripts/customizer.js')}}"></script>
<script src="{{asset('frest/vendors/js/extensions/swiper.min.js')}}"></script>
<script src="{{asset('frest/js/scripts/configs/vertical-menu-light.js')}}"></script>
<script src="{{asset('frest/vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('frest/vendors/js/editors/quill/quill.min.js')}}"></script>

<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->

<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->

<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
</html>
