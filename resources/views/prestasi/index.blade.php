<x-publik-layout title="Prestasi — SIRAT RT 02 Graha Indah">
    {{-- === HEADER === --}}
    <section class="bg-surface-white rounded-[24px] border border-border-line/40 p-8 sm:p-10 flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div class="max-w-2xl">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-text-secondary mb-3">
                <a class="hover:text-dark transition-colors" href="{{ route('beranda') }}">Beranda</a>
                <span>/</span>
                <span class="text-dark font-semibold">Prestasi</span>
            </nav>
            <div class="mb-4"><a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark hover:text-mid transition-colors">← Kembali ke beranda</a></div>
            <h1 class="text-headline-lg text-dark tracking-tight">
                Prestasi <span class="font-serif italic font-normal text-mid">warga</span>
            </h1>
            <p class="text-text-secondary text-body-lg leading-relaxed mt-3">
                Sertifikat dan piala yang berhasil diraih warga RT 02 dikumpulkan di sini sebagai apresiasi dan inspirasi.
            </p>
        </div>
    </section>

    {{-- === FILTER JENIS === --}}
    <section class="bg-soft/70 rounded-[24px] border border-border-line/40 p-4 sm:p-5 flex items-center gap-2 flex-wrap">
        <span class="text-xs text-text-secondary mr-1">Saring:</span>
        <a href="{{ route('prestasi.index') }}"
           class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all {{ $jenis === null ? 'bg-dark text-surface-white' : 'bg-surface-white border border-border-line/50 text-text-secondary hover:text-dark' }}">
            Semua
        </a>
        <a href="{{ route('prestasi.index', ['jenis' => 'sertifikat']) }}"
           class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all {{ $jenis === 'sertifikat' ? 'bg-dark text-surface-white' : 'bg-surface-white border border-border-line/50 text-text-secondary hover:text-dark' }}">
            Sertifikat
        </a>
        <a href="{{ route('prestasi.index', ['jenis' => 'piala']) }}"
           class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all {{ $jenis === 'piala' ? 'bg-dark text-surface-white' : 'bg-surface-white border border-border-line/50 text-text-secondary hover:text-dark' }}">
            Piala
        </a>
    </section>

    {{-- === DAFTAR PRESTASI === --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($prestasi as $item)
            @php($foto = $item->foto ? asset('storage/' . $item->foto) : null)
            <article class="bg-surface-white rounded-[24px] border border-border-line/60 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                <div class="relative min-h-[170px] bg-gradient-to-br from-mid to-dark">
                    @if($foto)
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $foto }}');"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark/60 to-transparent"></div>
                    @endif
                    <span class="absolute top-3 left-3 bg-lime text-dark text-chip font-bold px-3 py-1 rounded-full uppercase">
                        {{ $item->jenis === 'piala' ? 'Piala' : 'Sertifikat' }}
                    </span>
                </div>
                <div class="p-5 flex flex-col gap-2 flex-1">
                    <div class="flex items-center gap-2 text-xs text-text-secondary">
                        <x-material-icon name="calendar_today" class="text-[14px] text-mid"/>
                        {{ $item->tanggal?->translatedFormat('d M Y') }}
                    </div>
                    <h2 class="text-headline-sm text-dark font-bold leading-snug">{{ $item->judul }}</h2>
                    @if($item->deskripsi)
                        <p class="text-text-secondary text-body-md leading-relaxed line-clamp-3">
                            {{ str($item->deskripsi)->limit(150) }}
                        </p>
                    @endif
                </div>
            </article>
        @empty
            <div class="sm:col-span-2 lg:col-span-3 rounded-[24px] bg-soft border border-border-line/40 p-10 text-center">
                <h2 class="text-dark text-headline-sm font-bold mb-2">
                    {{ $jenis !== null ? 'Tidak ditemukan' : 'Belum ada prestasi' }}
                </h2>
                <p class="text-text-secondary text-body-md">
                    @if($jenis !== null)
                        Tidak ada prestasi pada jenis yang dipilih ketika ini.
                    @else
                        Belum ada prestasi yang dicatat ketika ini. Prestasi dikelola pengurus RT.
                    @endif
                </p>
            </div>
        @endforelse
    </section>

    <div class="pt-2">
        {{ $prestasi->links('pagination.pill', ['label' => 'prestasi']) }}
    </div>
</x-publik-layout>
