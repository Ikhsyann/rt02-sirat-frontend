<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'SIRAT') }} RT 02 — Portal Warga</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@1&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-surface text-text-main antialiased selection:bg-lime selection:text-dark min-h-screen flex flex-col">
        <!-- Navbar pill warga -->
        <header class="fixed top-4 left-1/2 -translate-x-1/2 w-[calc(100%-2rem)] z-50">
            <div class="flex items-center justify-between gap-3 px-3 sm:px-4 py-2.5 rounded-full border border-border-line/40 bg-surface-white/95 backdrop-blur-md shadow-lg shadow-dark/5">
                <a class="flex items-center gap-2.5 group" href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/lambang-balikpapan.svg') }}" alt="Lambang Kota Balikpapan" class="h-9 w-9 object-contain">
                    <div class="hidden sm:flex flex-col leading-tight">
                        <span class="text-headline-sm font-bold text-dark tracking-tight">SIRAT RT 02</span>
                        <span class="text-[10px] text-text-secondary">Graha Indah</span>
                    </div>
                </a>

                <nav class="hidden lg:flex items-center gap-1 bg-soft/80 p-1.5 rounded-full border border-border-line/30">
                    <a class="{{ request()->routeIs('dashboard') ? 'text-dark font-semibold bg-lime' : 'text-text-secondary hover:text-dark' }} px-4 py-1.5 rounded-full text-xs transition-all" href="{{ route('dashboard') }}">Beranda</a>
                    <a class="{{ request()->routeIs('layanan.keuangan') ? 'text-dark font-semibold bg-lime' : 'text-text-secondary hover:text-dark' }} px-4 py-1.5 rounded-full text-xs transition-all" href="{{ route('layanan.keuangan') }}">Keuangan</a>
                    <a class="{{ request()->routeIs('layanan.nomor-darurat') ? 'text-dark font-semibold bg-lime' : 'text-text-secondary hover:text-dark' }} px-4 py-1.5 rounded-full text-xs transition-all" href="{{ route('layanan.nomor-darurat') }}">Nomor Darurat</a>
                    <a class="{{ request()->routeIs('layanan.data-keluarga') ? 'text-dark font-semibold bg-lime' : 'text-text-secondary hover:text-dark' }} px-4 py-1.5 rounded-full text-xs transition-all" href="{{ route('layanan.data-keluarga') }}">Data Keluarga</a>
                    <a class="{{ request()->routeIs('profile.*') ? 'text-dark font-semibold bg-lime' : 'text-text-secondary hover:text-dark' }} px-4 py-1.5 rounded-full text-xs transition-all" href="{{ route('profile.edit') }}">Profil</a>
                </nav>

                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="hidden sm:flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-full bg-soft border border-border-line/40 hover:border-dark/30 transition-all">
                            <span class="w-7 h-7 rounded-full bg-mid text-surface-white flex items-center justify-center text-xs font-bold">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                            <span class="flex flex-col text-left leading-tight">
                                <span class="text-xs font-semibold text-dark">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] text-text-secondary">Anggota Keluarga</span>
                            </span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold text-dark bg-soft hover:bg-border-line/30 transition-all active:scale-95">
                                Keluar <span class="material-symbols-outlined text-[14px]">logout</span>
                            </button>
                        </form>
                    @endauth

                    <button id="nav-toggle" aria-label="Buka menu" class="lg:hidden w-9 h-9 rounded-full bg-soft border border-border-line/40 flex items-center justify-center text-dark">
                        <x-material-icon name="menu" class="text-[20px]"/>
                    </button>
                </div>
            </div>

            <div data-menu class="hidden lg:hidden mt-2 p-2 rounded-2xl bg-surface-white border border-border-line/40 shadow-md">
                <a class="block px-4 py-2.5 rounded-xl text-sm text-text-secondary hover:bg-soft hover:text-dark {{ request()->routeIs('dashboard') ? 'bg-soft text-dark font-semibold' : '' }}" href="{{ route('dashboard') }}">Beranda</a>
                <a class="block px-4 py-2.5 rounded-xl text-sm text-text-secondary hover:bg-soft hover:text-dark {{ request()->routeIs('layanan.keuangan') ? 'bg-soft text-dark font-semibold' : '' }}" href="{{ route('layanan.keuangan') }}">Laporan Kas & Keuangan</a>
                <a class="block px-4 py-2.5 rounded-xl text-sm text-text-secondary hover:bg-soft hover:text-dark {{ request()->routeIs('layanan.nomor-darurat') ? 'bg-soft text-dark font-semibold' : '' }}" href="{{ route('layanan.nomor-darurat') }}">Kontak Penting & Darurat</a>
                <a class="block px-4 py-2.5 rounded-xl text-sm text-text-secondary hover:bg-soft hover:text-dark {{ request()->routeIs('layanan.data-keluarga') ? 'bg-soft text-dark font-semibold' : '' }}" href="{{ route('layanan.data-keluarga') }}">Data Kartu Keluarga</a>
                <a class="block px-4 py-2.5 rounded-xl text-sm text-text-secondary hover:bg-soft hover:text-dark {{ request()->routeIs('profile.*') ? 'bg-soft text-dark font-semibold' : '' }}" href="{{ route('profile.edit') }}">Profil Saya</a>
            </div>
        </header>

        <main class="flex-1 w-full mx-auto px-4 sm:px-6 lg:px-10 pt-24 pb-16 flex flex-col gap-8">
            {{ $slot }}
        </main>

        <x-app-footer/>
    </body>
</html>
