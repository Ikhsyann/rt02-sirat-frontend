<x-app-layout>
    <section class="flex flex-col gap-3 max-w-3xl mx-auto w-full">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-text-secondary">
            <a class="hover:text-dark transition-colors" href="{{ route('dashboard') }}">Beranda Warga</a>
            <span>/</span>
            <span class="text-dark font-semibold">Profil</span>
        </nav>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark hover:text-mid transition-colors">← Beranda Warga</a>
    </section>

    <div class="flex flex-col gap-3 max-w-3xl mx-auto w-full">
        <h1 class="text-headline-lg text-dark tracking-tight font-bold">
            Profil <span class="font-serif italic font-normal text-mid">warga</span>
        </h1>
    </div>

    <div class="max-w-3xl mx-auto space-y-5">
        <div class="p-4 sm:p-8 bg-surface-white border border-border-line/50 shadow-sm rounded-[24px]">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-surface-white border border-border-line/50 shadow-sm rounded-[24px]">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-surface-white border border-border-line/50 shadow-sm rounded-[24px]">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
