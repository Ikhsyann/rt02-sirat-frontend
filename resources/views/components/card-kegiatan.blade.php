@php($foto = $kegiatan->foto_dokumentasi ? asset('storage/' . $kegiatan->foto_dokumentasi) : null)

<a href="{{ route('kegiatan.show', $kegiatan) }}" class="relative block min-h-[380px] rounded-[24px] overflow-hidden flex flex-col justify-between p-6 shadow-md group hover:-translate-y-1 transition-all duration-300 text-surface-white bg-gradient-to-br from-mid to-dark">
    @if($foto)
        {{-- shortcut: foto asli diberi overlay gelap agar teks putih terbaca (DESIGN.md 3) --}}
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('{{ $foto }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-dark/95 via-dark/65 to-dark/40"></div>
    @endif

    <div class="relative z-10 flex items-center justify-between">
        <span class="bg-lime text-dark text-chip font-bold px-3 py-1 rounded-full uppercase">Kegiatan</span>
        <span class="text-surface-white/80 text-chip">{{ $kegiatan->tanggal?->translatedFormat('d M Y') }}</span>
    </div>

    <div class="relative z-10 pt-16">
        <h3 class="text-surface-white text-headline-sm font-bold mb-4 line-clamp-2 leading-tight">
            {{ $kegiatan->nama_kegiatan }}
        </h3>
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-surface-white text-dark text-body-md font-semibold group-hover:bg-lime transition-colors">
            Baca <span class="text-xs">↗</span>
        </span>
    </div>
</a>
