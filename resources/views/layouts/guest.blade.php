<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Equilíbrio') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <!-- Logo/Título -->
            <div class="text-center mb-8">
                <a href="/">
                    <div class="flex items-center justify-center space-x-3 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-500 rounded-2xl flex items-center justify-center shadow-xl">
                            <span class="text-4xl">⚖️</span>
                        </div>
                    </div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                        Equilíbrio
                    </h1>
                    <p class="text-gray-600 mt-2 text-sm">Gestão inteligente de hábitos</p>
                </a>
            </div>

            <!-- Content -->
            <div class="w-full sm:max-w-md">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>Desenvolvido com ❤️ para ajudar você a encontrar o equilíbrio</p>
            </div>
        </div>
    </body>
</html>
