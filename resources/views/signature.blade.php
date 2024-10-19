<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-50">
            <div class="relative min-h-screen flex flex-col items-center justify-center">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <main class="mt-1 flex flex-wrap justify-center">
                        <div class="grid items-center justify-center gap-6 lg:grid-cols-1 lg:gap-8">
                            <a href="#" class="relative block overflow-hidden rounded-lg border shadow-sm border-gray-100 p-4 sm:p-6 lg:p-8">
                                <span class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"></span>

                                <div class="sm:flex sm:justify-between sm:gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 sm:text-xl">Dokument ini telah di tandatangani secara digital</h3>

                                        <p class="mt-1 text-sm font-medium text-gray-600">Oleh {{ $id->director }}</p>
                                    </div>

                                    <div class="hidden sm:block sm:shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-16">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <p class="text-pretty text-sm text-gray-500 font-bold"> {{ $id->position}} {{ $id->name }}.</p>
                                </div>

                                <dl class="mt-6 flex gap-4 sm:gap-6">
                                    <div class="flex flex-col-reverse">
                                        <dd class="text-xs text-gray-500 font-bold">{{ $id->regency_name }}</dd>
                                        <dt class="text-sm font-medium text-gray-600">Ditetapkan di</dt>
                                    </div>

                                    @if (!empty($id->created_at))
                                    <div class="flex flex-col-reverse">
                                        <dd class="text-xs text-gray-500 font-bold">{{ $id->created_at }}</dd>
                                        <dt class="text-sm font-medium text-gray-600">Pada tanggal</dt>
                                    </div>
                                    @endif
                                </dl>
                            </a>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
