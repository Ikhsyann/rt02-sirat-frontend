<x-publik-layout title="{{ $kegiatan->nama_kegiatan }} — SIRAT RT 02 Graha Indah">
    <!-- Breadcrumb + tombol kembali tergabung dengan konten agar jarak wajar -->
    <div class="flex flex-col gap-6">
        <div class="flex flex-col items-start gap-2">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-text-secondary">
                <a class="hover:text-dark transition-colors" href="{{ route('beranda') }}">Beranda</a>
                <span>/</span>
                <a class="hover:text-dark transition-colors" href="{{ route('kegiatan.index') }}">Berita/Kegiatan</a>
                <span>/</span>
                <span class="text-dark font-semibold line-clamp-1 max-w-[40ch]">{{ $kegiatan->nama_kegiatan }}</span>
            </nav>
            <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark hover:text-mid transition-colors">
                <span>←</span> Kembali ke daftar berita
            </a>
        </div>

    <section class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        <!-- Isi artikel -->
        <div class="lg:col-span-8 flex flex-col gap-6">
            <div>
                <span class="bg-lime text-dark text-chip font-bold px-3 py-1 rounded-full uppercase">Kegiatan Lingkungan</span>
                <h1 class="text-headline-lg text-dark tracking-tight mt-4 mb-6 font-bold">{{ $kegiatan->nama_kegiatan }}</h1>

                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-text-secondary py-3 border-y border-border-line/40">
                    <span class="inline-flex items-center gap-1.5">
                        <x-material-icon name="calendar_today" class="text-[14px] text-mid"/>
                        {{ $kegiatan->tanggal?->translatedFormat('l, d M Y') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <x-material-icon name="groups" class="text-[14px] text-mid"/>
                        {{ $kegiatan->absensis()->count() }} warga tercatat hadir
                    </span>
                </div>
            </div>

            <figure class="relative rounded-[24px] overflow-hidden min-h-[300px] sm:min-h-[420px] text-surface-white bg-gradient-to-br from-mid to-dark">
                @if($kegiatan->foto_dokumentasi)
                    <img src="{{ asset('storage/' . $kegiatan->foto_dokumentasi) }}" alt="{{ $kegiatan->nama_kegiatan }}" class="absolute inset-0 w-full h-full object-cover"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-dark/70 via-transparent to-transparent pointer-events-none"></div>
                    <figcaption class="absolute bottom-3 left-3 right-3 flex items-end text-xs text-surface-white/90">
                        <span class="inline-flex items-center gap-1.5 bg-dark/70 backdrop-blur-sm px-3 py-1.5 rounded-full">
                            <x-material-icon name="photo_camera" class="text-[14px]"/>
                            Foto Dokumentasi RT 02
                        </span>
                    </figcaption>
                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 text-center px-8">
                        <x-material-icon name="image" class="text-4xl text-lime"/>
                        <p class="text-sm text-surface-white/85">Foto dokumentasi kegiatan ini belum diunggah.</p>
                    </div>
                @endif
            </figure>

            <!-- Isi deskripsi: paragraf dibangun dari teks deskripsi -->
            <div class="bg-surface-white rounded-[24px] border border-border-line/60 p-6 sm:p-9">
                @foreach (preg_split('/\r\n|\r|\n/', (string) $kegiatan->deskripsi) as $i => $paragraf)
                    @if(trim($paragraf) !== '')
                        <p class="{{ $i === 0 ? 'text-text-main text-body-lg leading-relaxed mb-5' : 'text-text-secondary text-body-md leading-relaxed mb-4' }}">{{ $paragraf }}</p>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 flex flex-col gap-6">
            <div class="bg-surface-white rounded-[24px] border border-border-line/60 p-6">
                <h2 class="text-headline-sm text-dark font-bold mb-4">Kegiatan Terkait</h2>
                @if ($terkait->isEmpty())
                    <p class="text-xs text-text-secondary">Belum ada kegiatan lain yang didokumentasikan.</p>
                @endif
                <ul class="divide-y divide-border-line/30">
                    @foreach ($terkait as $item)
                        <li class="py-3">
                            <div class="flex items-center gap-2 text-[11px] text-text-secondary mb-1">
                                <span class="text-mid font-semibold">{{ $item->tanggal?->translatedFormat('d M Y') }}</span>
                            </div>
                            <a href="{{ route('kegiatan.show', $item) }}" class="text-dark font-semibold text-sm leading-snug hover:text-mid transition-colors line-clamp-2">
                                {{ $item->nama_kegiatan }}
                            </a>
                            <a href="{{ route('kegiatan.show', $item) }}" class="text-[11px] text-text-secondary hover:text-dark transition-colors">baca selengkapnya <span>↗</span></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </section>
    </div>
</x-publik-layout>
