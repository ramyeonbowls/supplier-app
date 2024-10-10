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
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/login/app.js'])
    </head>
    <body>
        <div id="app">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>
