<x-app-layout>
    @php($kk = $anggota?->kartuKeluarga)
    @php($alamat = $kk ? 'RT02-BLOK-'.($kk->rumah->blok->nama_blok ?? '?').'-'.($kk->rumah->nomor_rumah ?? '?') : null)

    {{-- === HERO MINI === --}}
    <section class="relative rounded-[28px] overflow-hidden min-h-[340px] flex flex-col justify-between p-8 md:p-10 shadow-xl text-surface-white"
             style="background: linear-gradient(160deg, #1F5130 0%, #0F2E1A 70%);">
        {{-- Media hero: diunggah admin di Pengaturan Tampilan (backend). --}}
        <x-hero-media :media="$heroMedia ?? null" fallback="images/hero-portal.jpg" />

        <div class="relative z-10 text-center max-w-2xl mx-auto my-auto py-8">
            <h1 class="text-4xl sm:text-5xl font-bold tracking-tight mb-4">
                Selamat datang di <span class="font-serif italic text-lime text-5xl sm:text-6xl">RT 02 Graha Indah</span>
            </h1>
            <p class="text-surface-white/85 text-body-lg leading-relaxed mb-8">
                Akun Anda terhubung ke satu data anggota keluarga. Tiga layanan di bawah membuka informasi yang berhubungan langsung dengan rumah Anda.
            </p>
            <div class="flex flex-wrap items-center gap-4 justify-center">
                <a href="{{ route('layanan.keuangan') }}" class="inline-flex items-center gap-3 pl-6 pr-2.5 py-3 rounded-full bg-lime text-dark text-headline-sm font-bold hover:bg-lime/90 transition-all active:scale-95">
                    Buka Keuangan <span class="w-9 h-9 rounded-full bg-dark text-lime flex items-center justify-center text-base">↗</span>
                </a>
                <a href="{{ route('beranda') }}" class="text-surface-white/90 hover:text-lime text-body-lg underline underline-offset-8 transition-colors">Kembali ke beranda publik ↗</a>
            </div>
        </div>
    </section>

    {{-- === TIGA LANSA === --}}
    <section class="scroll-mt-28">
        <div class="flex flex-col gap-3 mb-6">
            <h2 class="text-headline-lg text-dark tracking-tight font-bold">
                Tiga layanan <span class="font-serif italic font-normal text-mid">untuk rumah Anda</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <a href="{{ route('layanan.keuangan') }}" class="group bg-surface-white rounded-[24px] border border-border-line/50 p-7 flex flex-col justify-between min-h-[210px] hover:shadow-md transition-all">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-mid font-label-section text-label-section uppercase">Transparansi Kas</span>
                    <span class="font-mono text-xs text-text-secondary/60">01</span>
                </div>
                <div>
                    <h3 class="text-dark text-headline-md font-bold mb-2">Laporan Kas & Keuangan</h3>
                    <p class="text-text-secondary text-body-md leading-relaxed">Pantau arus kas masuk, pengeluaran RT, ringkasan saldo terkini, dan unduh laporan pembukuan.</p>
                </div>
                <span class="mt-5 inline-flex items-center justify-between px-5 py-2.5 rounded-full bg-dark text-surface-white text-xs font-semibold group-hover:bg-mid transition-all">
                    Periksa Laporan Kas
                    <span class="text-lime">→</span>
                </span>
            </a>

            <a href="{{ route('layanan.nomor-darurat') }}" class="group bg-surface-white rounded-[24px] border border-border-line/50 p-7 flex flex-col justify-between min-h-[210px] hover:shadow-md transition-all">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-mid font-label-section text-label-section uppercase">Keamanan & Medis</span>
                    <span class="font-mono text-xs text-text-secondary/60">02</span>
                </div>
                <div>
                    <h3 class="text-dark text-headline-md font-bold mb-2">Kontak Penting & Darurat</h3>
                    <p class="text-text-secondary text-body-md leading-relaxed">Daftar kontak pos ronda, kesehatan terdekat, ambulans, dan pemadam kebakaran yang dapat langsung dihubungi.</p>
                </div>
                <span class="mt-5 inline-flex items-center justify-between px-5 py-2.5 rounded-full bg-dark text-surface-white text-xs font-semibold group-hover:bg-mid transition-all">
                    Buka Daftar Telepon
                    <span class="text-lime">→</span>
                </span>
            </a>

            <a href="{{ route('layanan.data-keluarga') }}" class="group bg-surface-white rounded-[24px] border border-border-line/50 p-7 flex flex-col justify-between min-h-[210px] hover:shadow-md transition-all">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-mid font-label-section text-label-section uppercase">Kependudukan</span>
                    <span class="font-mono text-xs text-text-secondary/60">03</span>
                </div>
                <div>
                    <h3 class="text-dark text-headline-md font-bold mb-2">Data Kartu Keluarga</h3>
                    <p class="text-text-secondary text-body-md leading-relaxed">Periksa rincian kepala keluarga, daftar anggota tercatat, serta riwayat pencatatan administrasi RT.</p>
                </div>
                <span class="mt-5 inline-flex items-center justify-between px-5 py-2.5 rounded-full bg-dark text-surface-white text-xs font-semibold group-hover:bg-mid transition-all">
                    Lihat Rincian Keluarga
                    <span class="text-lime">→</span>
                </span>
            </a>
        </div>
    </section>

    {{-- === RINGKASAN AKUN === --}}
    <section class="bg-soft rounded-[28px] border border-border-line/40 p-7 sm:p-10">
        <div class="mb-6">
            <h2 class="text-headline-lg text-dark tracking-tight font-bold mt-2">
                Data yang <span class="font-serif italic font-normal text-mid">terhubung</span> dengan akun Anda
            </h2>
        </div>

        @if (! $anggota || ! $kk)
            {{-- Akun warga belum dikaitkan pengurus ke AnggotaKeluarga (integritas data dikelola Backend) --}}
            <div class="bg-surface-white rounded-[24px] border border-border-line/50 p-8 text-center">
                <x-material-icon name="link_off" class="text-3xl text-mid mb-3"/>
                <h3 class="text-dark text-headline-sm font-bold mb-1">Akun belum terhubung ke data keluarga</h3>
                <p class="text-text-secondary text-body-md">Akun warga Anda belum dikaitkan oleh pengurus RT ke data AnggotaKeluarga. Silakan hubungi pengurus untuk verifikasi NIK, atau pantau nomor darurat bila butuh bantuan segera.</p>
                <a href="{{ route('layanan.nomor-darurat') }}" class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-dark hover:text-mid">Lihat nomor darurat <span>↗</span></a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <div class="bg-surface-white border border-border-line/50 rounded-[24px] p-7 flex flex-col justify-between min-h-[170px]">
                    <div class="flex items-start justify-between gap-4">
                        <span class="text-text-secondary font-label-section text-label-section uppercase">Nomor Kartu Keluarga</span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-semibold bg-lime/30 text-dark">
                            <x-material-icon name="check_circle" class="text-[13px]"/> Terdaftar Resmi
                        </span>
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-bold tracking-tight text-dark font-mono my-2">{{ $kk->nomor_kk }}</h3>
                    <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-text-secondary">
                        <span class="inline-flex items-center gap-1.5"><x-material-icon name="info" class="text-[14px] text-mid"/> Satu akun warga terhubung ke tepat satu kartu keluarga.</span>
                        @if($alamat)
                            <span class="font-mono font-semibold text-dark">{{ $alamat }}</span>
                        @endif
                    </div>
                </div>

                <div class="bg-surface-white border border-border-line/50 rounded-[24px] p-7 flex flex-col justify-between min-h-[170px]">
                    <div class="flex items-start justify-between gap-4">
                        <span class="text-text-secondary font-label-section text-label-section uppercase">Anggota Keluarga</span>
                        @php($kepala = $kk->anggotaKeluargas->firstWhere('status_hubungan_keluarga', 'Kepala Keluarga'))
                        @if($kepala)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-semibold bg-lime/30 text-dark">Kepala Keluarga: {{ $kepala->nama }}</span>
                        @endif
                    </div>
                    <h3 class="text-3xl lg:text-4xl font-bold tracking-tight text-mid my-2">{{ $kk->anggotaKeluargas->count() }} <span class="text-lg font-semibold text-dark">jiwa</span></h3>
                    <p class="text-xs text-text-secondary inline-flex items-center gap-1.5">
                        <x-material-icon name="groups" class="text-[14px] text-mid"/>
                        Jumlah anggota tercatat pada kartu keluarga ini.
                    </p>
                </div>
            </div>

            <div class="mt-5 bg-surface-white/80 rounded-full px-5 py-3 flex items-center gap-3 text-xs">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-dark text-lime text-[11px] font-bold">Hak akses</span>
                <p class="text-text-secondary">Sebagai warga, Anda hanya melihat data milik sendiri. Penambahan dan perubahan data kependudukan tetap dilakukan pengurus RT.</p>
            </div>
        @endif
    </section>

    {{-- === AGENDA RT === --}}
    <section>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-6">
            <div class="flex flex-col gap-2">
                <h2 class="text-headline-lg text-dark tracking-tight font-bold">
                    Kegiatan mendatang <span class="font-serif italic font-normal text-mid">lingkungan kita</span>
                </h2>
            </div>
            <a href="{{ route('kegiatan.index') }}" class="text-xs font-semibold text-dark hover:text-mid transition-colors underline underline-offset-4">Lihat semua arsip kegiatan →</a>
        </div>

        @if ($agenda->isEmpty())
            <div class="rounded-[24px] bg-soft border border-border-line/40 p-8 text-center text-text-secondary text-body-md">
                Belum ada agenda kegiatan mendatang. Kabar terbaru selalu tersedia pada halaman berita.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($agenda as $item)
                    <x-card-kegiatan :kegiatan="$item"/>
                @endforeach
            </div>
        @endif
    </section>
</x-app-layout>
