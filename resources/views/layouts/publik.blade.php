<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'SIRAT RT 02 Graha Indah' }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@1&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-surface-white text-on-surface antialiased selection:bg-lime selection:text-dark min-h-screen flex flex-col">
        <!-- Navbar pill melayang -->
        <header class="fixed top-5 left-1/2 -translate-x-1/2 w-[calc(100%-2.5rem)] rounded-full border border-border-line/40 z-50 bg-surface-white/90 backdrop-blur-md shadow-lg shadow-dark/5">
            <nav class="flex justify-between items-center px-4 sm:px-6 py-3 w-full gap-3">
                <a class="flex items-center gap-3 group" href="{{ route('beranda') }}">
                    <img src="{{ asset('images/lambang-balikpapan.svg') }}" alt="Lambang Kota Balikpapan" class="h-10 w-10 object-contain transition-transform group-hover:scale-105 duration-200">
                    <div class="hidden sm:flex flex-col text-left">
                        <span class="text-headline-sm font-bold text-dark leading-tight">SIRAT</span>
                        <span class="text-chip text-on-surface-variant font-medium tracking-wide">RT 02 Graha Indah</span>
                    </div>
                </a>

                {{-- Menu tengah (desktop) --}}
                <div class="hidden md:flex items-center gap-1 bg-soft/80 p-1.5 rounded-full border border-border-line/30">
                    <a class="{{ request()->routeIs('beranda') ? 'text-dark font-semibold bg-lime/40' : 'text-on-surface-variant hover:text-dark' }} px-4 py-2 rounded-full text-body-md whitespace-nowrap transition-all" href="{{ route('beranda') }}">Beranda</a>
                    <a class="{{ request()->routeIs('kegiatan.*') ? 'text-dark font-semibold bg-lime/40' : 'text-on-surface-variant hover:text-dark' }} px-4 py-2 rounded-full text-body-md whitespace-nowrap transition-all" href="{{ route('kegiatan.index') }}">Berita & Kegiatan</a>
                    <a class="text-on-surface-variant hover:text-dark px-4 py-2 rounded-full text-body-md whitespace-nowrap transition-all" href="{{ route('beranda') }}#tentang">Tentang</a>
                    <a class="text-on-surface-variant hover:text-dark px-4 py-2 rounded-full text-body-md whitespace-nowrap transition-all" href="{{ route('beranda') }}#layanan">Layanan</a>
                </div>

                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center gap-2 pl-4 pr-2 py-1.5 rounded-full bg-soft border border-border-line/40 hover:border-dark/30 transition-all">
                            <span class="w-7 h-7 rounded-full bg-mid text-surface-white flex items-center justify-center text-xs font-bold">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                            <span class="text-xs font-semibold text-dark leading-tight">Portal Warga</span>
                            <span class="w-6 h-6 rounded-full bg-lime text-dark flex items-center justify-center text-xs font-bold">↗</span>
                        </a>
                    @else
                        <a class="inline-flex items-center gap-2 pl-5 pr-2 py-2 rounded-full bg-dark text-surface-white text-body-md font-semibold hover:bg-mid transition-all shadow-sm active:scale-95 duration-150" href="{{ route('login') }}">
                            <span>Masuk Warga</span>
                            <span class="w-8 h-8 rounded-full bg-lime text-dark flex items-center justify-center font-bold text-sm">↗</span>
                        </a>
                    @endauth

                    <!-- Hamburger (mobile) -->
                    <button id="nav-toggle" aria-label="Buka menu" class="md:hidden w-9 h-9 rounded-full bg-soft border border-border-line/40 flex items-center justify-center text-dark">
                        <x-material-icon name="menu" class="text-[20px]"/>
                    </button>
                </div>
            </nav>

            <!-- Menu mobile -->
            <div data-menu class="hidden md:hidden mx-4 mb-3 p-2 rounded-2xl bg-surface-white border border-border-line/40 shadow-md">
                <a class="block px-4 py-2.5 rounded-xl text-body-md text-on-surface-variant hover:bg-soft hover:text-dark" href="{{ route('beranda') }}">Beranda</a>
                <a class="block px-4 py-2.5 rounded-xl text-body-md text-on-surface-variant hover:bg-soft hover:text-dark" href="{{ route('kegiatan.index') }}">Berita & Kegiatan</a>
                <a class="block px-4 py-2.5 rounded-xl text-body-md text-on-surface-variant hover:bg-soft hover:text-dark" href="{{ route('beranda') }}#tentang">Tentang</a>
                <a class="block px-4 py-2.5 rounded-xl text-body-md text-on-surface-variant hover:bg-soft hover:text-dark" href="{{ route('beranda') }}#layanan">Layanan</a>
                @auth
                    <a class="block px-4 py-2.5 rounded-xl text-body-md font-semibold text-dark bg-soft mt-1" href="{{ route('dashboard') }}">Portal Warga ↗</a>
                @endauth
            </div>
        </header>

        <main class="flex-1 w-full mx-auto px-5 lg:px-10 pt-28 pb-12 flex flex-col gap-[72px]">
            {{ $slot }}

            <x-app-footer/>
        </main>
    </body>
</html>
