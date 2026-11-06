<x-publik-layout title="Berita & Kegiatan — SIRAT RT 02 Graha Indah">
    {{-- === HEADER ARSIP === --}}
    <section class="bg-surface-white rounded-[24px] border border-border-line/40 p-8 sm:p-10 flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div class="max-w-2xl">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-text-secondary mb-3">
                <a class="hover:text-dark transition-colors" href="{{ route('beranda') }}">Beranda</a>
                <span>/</span>
                <span class="text-dark font-semibold">Berita & Kegiatan</span>
            </nav>
            <div class="mb-4"><a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark hover:text-mid transition-colors">← Kembali ke beranda</a></div>
            <h1 class="text-headline-lg text-dark tracking-tight">
                Berita & kegiatan <span class="font-serif italic font-normal text-mid">warga</span>
            </h1>
            <p class="text-text-secondary text-body-lg leading-relaxed mt-3">
                Seluruh pengumuman dan agenda RT dikumpulkan di sini. Cari judul kegiatan, lalu buka artikelnya untuk foto dokumentasi dan rincian.
            </p>
        </div>
    </section>

    {{-- === FILTER === --}}
    <section class="bg-soft/70 rounded-[24px] border border-border-line/40 p-4 sm:p-5 flex flex-col md:flex-row items-stretch md:items-center gap-3">
        <form method="GET" action="{{ route('kegiatan.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full">
            <div class="relative flex-1">
                <x-material-icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-text-secondary text-[18px]"/>
                <input name="q" value="{{ $q }}" placeholder="Cari judul berita atau kegiatan..." type="search"
                       class="w-full pl-10 pr-4 py-2.5 rounded-full bg-surface-white border border-border-line/50 text-xs text-dark placeholder:text-text-secondary/70 focus:ring-2 focus:ring-lime focus:border-lime transition-all"/>
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-dark text-surface-white text-xs font-semibold hover:bg-mid transition-all active:scale-95">
                Terapkan filter <span class="w-5 h-5 rounded-full bg-lime text-dark flex items-center justify-center text-[10px]">↗</span>
            </button>
            @if($q !== '')
                <a href="{{ route('kegiatan.index') }}" class="text-xs text-text-secondary hover:text-dark underline underline-offset-4 text-center px-2">Reset</a>
            @endif
        </form>
    </section>

    {{-- === DAFTAR === --}}
    <section class="flex flex-col gap-5">
        @forelse ($kegiatan as $item)
            @php($foto = $item->foto_dokumentasi ? asset('storage/' . $item->foto_dokumentasi) : null)
            <article class="bg-surface-white rounded-[24px] border border-border-line/60 shadow-sm p-5 sm:p-6 grid grid-cols-1 lg:grid-cols-12 gap-6 hover:shadow-md cursor-pointer transition-shadow" data-card-link="{{ route('kegiatan.show', $item) }}">
                <a class="lg:col-span-4 relative rounded-2xl overflow-hidden min-h-[200px] text-surface-white bg-gradient-to-br from-mid to-dark"
                   href="{{ route('kegiatan.show', $item) }}">
                    @if($foto)
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $foto }}');"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark/60 to-transparent"></div>
                    @endif
                    <span class="absolute top-3 left-3 bg-lime text-dark text-chip font-bold px-3 py-1 rounded-full uppercase">Kegiatan</span>
                </a>

                <div class="lg:col-span-8 flex flex-col justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-text-secondary mb-2">
                            <x-material-icon name="calendar_today" class="text-[14px] text-mid"/>
                            {{ $item->tanggal?->translatedFormat('d M Y') }}
                        </div>
                        <h2 class="text-headline-sm text-dark font-bold mb-3">
                            <a href="{{ route('kegiatan.show', $item) }}" class="hover:text-mid transition-colors">{{ $item->nama_kegiatan }}</a>
                        </h2>
                        <p class="text-text-secondary text-body-md leading-relaxed line-clamp-2 max-w-2xl">
                            {{ str($item->deskripsi)->limit(200) }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-border-line/30 flex items-center justify-between gap-4">
                        <span class="text-xs text-text-secondary">Dokumentasi resmi RT 02</span>
                        <a href="{{ route('kegiatan.show', $item) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-dark hover:text-mid transition-colors group">
                            Baca selengkapnya
                            <span class="w-7 h-7 rounded-full bg-lime text-dark flex items-center justify-center transition-transform group-hover:scale-110 text-[11px]">↗</span>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-[24px] bg-soft border border-border-line/40 p-10 text-center">
                <h2 class="text-dark text-headline-sm font-bold mb-2">{{ $q !== '' ? 'Tidak ditemukan' : 'Arsip masih kosong' }}</h2>
                <p class="text-text-secondary text-body-md">
                    @if($q !== '')
                        Tidak ada berita atau kegiatan dengan kata kunci "{{ $q }}".
                    @else
                        Belum ada kegiatan yang didokumentasikan resmi ketika ini. Dokumentasi kegiatan dikelola pengurus RT.
                    @endif
                </p>
            </div>
        @endforelse
    </section>

    <div class="pt-2">
        {{ $kegiatan->links('pagination.pill', ['label' => 'berita & kegiatan']) }}
    </div>
</x-publik-layout>
