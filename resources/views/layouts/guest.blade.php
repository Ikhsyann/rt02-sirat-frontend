<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'SIRAT') }} RT 02 — {{ $title ?? 'Masuk Akun' }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@1&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-surface text-text-main antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 bg-surface">
            <a class="sr-only" href="#form-masuk"></a>
            <div class="w-full sm:max-w-2xl">
                <div class="p-8 sm:p-10 bg-surface-white border border-border-line/40 shadow-xl shadow-dark/5 sm:rounded-[28px]">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
