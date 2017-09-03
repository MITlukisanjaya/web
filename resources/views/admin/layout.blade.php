<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
         @include('admin.partials.head')
         @yield('css')
    <body class="hold-transition skin-blue-light sidebar-mini">
        <div class="wrapper">
            @include('admin.partials.nav')
            @include('admin.partials.sidebar')

            <div class="content-wrapper">
                 @yield('content')
        @include('admin.partials.footer')
        <div class="control-sidebar-bg"></div>


        @include('admin.partials.js')
        @yield('js')
        @include('sweet::alert')        