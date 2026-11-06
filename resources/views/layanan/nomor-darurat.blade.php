<x-app-layout>
    <!-- Breadcrumb header -->
    <section class="flex flex-col gap-4">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-text-secondary">
            <a class="hover:text-dark transition-colors" href="{{ route('dashboard') }}">Beranda Warga</a>
            <span>/</span>
            <a class="hover:text-dark transition-colors" href="{{ route('dashboard') }}">Layanan</a>
            <span>/</span>
            <span class="text-dark font-semibold">Nomor Darurat</span>
        </nav>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark hover:text-mid transition-colors">← Beranda Warga</a>

        <div class="max-w-3xl flex flex-col gap-3">
            <h1 class="text-headline-lg text-dark tracking-tight font-bold">
                Kontak penting yang <span class="font-serif italic font-normal text-mid">selalu siap</span>
            </h1>
            <p class="text-text-secondary text-body-lg leading-relaxed">
                Daftar nomor pos ronda, kesehatan terdekat, ambulans, dan pemadam kebakaran yang dapat dihubungi kapan pun. Tekan nomor untuk panggilan langsung.
            </p>
        </div>
    </section>

    <nav aria-label="Sub Layanan" class="inline-flex items-center gap-2 p-1.5 rounded-full bg-soft border border-border-line/50 w-fit max-w-full overflow-x-auto">
        <a class="px-5 py-2 rounded-full text-text-secondary hover:text-dark hover:bg-surface-white/60 text-xs font-medium transition-all whitespace-nowrap" href="{{ route('layanan.keuangan') }}">Keuangan</a>
        <a aria-current="page" class="px-5 py-2 rounded-full bg-lime text-dark font-semibold text-xs shadow-sm whitespace-nowrap" href="{{ route('layanan.nomor-darurat') }}">Nomor Darurat</a>
        <a class="px-5 py-2 rounded-full text-text-secondary hover:text-dark hover:bg-surface-white/60 text-xs font-medium transition-all whitespace-nowrap" href="{{ route('layanan.data-keluarga') }}">Data Keluarga</a>
    </nav>

    <section class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse ($unit as $u)
            @php($ikon = match (true) {
                str_contains($u->nama_unit, 'Ronda') => 'security',
                str_contains($u->nama_unit, 'Kesehatan'), str_contains($u->nama_unit, 'Puskes') => 'health_and_safety',
                str_contains($u->nama_unit, 'Pemadam'), str_contains($u->nama_unit, 'Damkar') => 'local_fire_department',
                str_contains($u->nama_unit, 'Ambulan') => 'ambulance',
                default => 'call',
            })

            <div class="bg-surface-white rounded-[24px] border border-border-line/60 p-6 sm:p-7 flex flex-col gap-4 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-soft text-mid flex items-center justify-center">
                        <x-material-icon name="{{ $ikon }}" class="text-[24px]"/>
                    </div>
                    <span class="text-chip uppercase text-text-secondary font-label-section">{{ $u->nama_unit }}</span>
                </div>
                <div class="divide-y divide-border-line/30 border-y border-border-line/30">
                    @forelse ($u->nomorDarurats as $nomor)
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $nomor->nomor_telepon) }}"
                           class="group flex items-center justify-between py-3 gap-3">
                            <div>
                                <div class="text-dark font-semibold text-sm">{{ $nomor->nomor_telepon }}</div>
                                <div class="text-xs text-text-secondary">{{ $nomor->lokasi ?: 'Lokasi menyusul' }}</div>
                            </div>
                            <span class="w-9 h-9 rounded-full bg-lime text-dark flex items-center justify-center shrink-0 transition-transform group-hover:scale-110">
                                <x-material-icon name="call" class="text-[18px]"/>
                            </span>
                        </a>
                    @empty
                        <p class="py-3 text-xs text-text-secondary">Belum ada kontak pada unit ini.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="rounded-[24px] bg-soft border border-border-line/40 p-10 text-center md:col-span-2">
                <h2 class="text-dark text-headline-sm font-bold mb-2">Daftar kontak masih kosong</h2>
                <p class="text-text-secondary text-body-md">Kontak darurat dan unit akan tampil di sini — pengelolaan daftar dilakukan pengurus RT melalui panel admin.</p>
            </div>
        @endforelse
    </section>
</x-app-layout>
