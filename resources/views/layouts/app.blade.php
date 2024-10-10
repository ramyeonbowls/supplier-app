<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('images/logo/favicon.svg?' . rand(10000, 99999)) }}" type="image/x-icon" />
        @yield('favicon')

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/home/app.js'])
    </head>
    <body class="relative box-border max-h-screen min-w-[375px] bg-sidebar-color font-sans">
        @yield('content')
    </body>
</html>
