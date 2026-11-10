<x-publik-layout title="SIRAT RT 02 Graha Indah — Sistem Informasi Rukun Tetangga">
    {{-- === HERO === --}}
    <section class="relative rounded-[32px] overflow-hidden min-h-[560px] md:min-h-[640px] flex flex-col justify-between p-8 md:p-14 shadow-2xl text-surface-white"
             style="background: linear-gradient(160deg, #1F5130 0%, #0F2E1A 70%);">
        {{-- Media hero: diunggah admin di Pengaturan Tampilan (backend). --}}
        <x-hero-media :media="$heroMedia ?? null" fallback="images/hero-beranda.jpg" />

        <div class="relative z-10 max-w-3xl my-auto py-10 mx-auto text-center">
            <h1 class="text-4xl sm:text-5xl md:text-headline-display font-bold tracking-tight mb-6">
                Selamat datang di <br class="hidden sm:inline">
                <span class="font-serif italic text-lime text-5xl sm:text-6xl md:text-7xl">RT 02 Graha Indah</span>
            </h1>
            <p class="text-surface-white/85 text-body-lg leading-relaxed max-w-2xl mb-10 mx-auto">
                Sistem Informasi Rukun Tetangga (SIRAT) menghadirkan keterbukaan agenda lingkungan, transparansi iuran kas gotong royong, dan pelayanan administrasi warga secara langsung dan terpercaya.
            </p>

            <div class="flex flex-wrap items-center gap-5 justify-center">
                <a class="inline-flex items-center gap-3 pl-6 pr-2.5 py-3 rounded-full bg-lime text-dark text-headline-sm font-bold shadow-lg shadow-lime/20 hover:bg-lime/90 transition-all active:scale-95 duration-150" href="{{ route('login') }}">
                    Masuk ke Portal Warga
                    <span class="w-9 h-9 rounded-full bg-dark text-lime flex items-center justify-center font-bold text-base">↗</span>
                </a>
                <a class="inline-flex items-center gap-2 text-surface-white hover:text-lime text-body-lg underline underline-offset-8 transition-colors" href="{{ route('kegiatan.index') }}">
                    Lihat Arsip Kegiatan <span class="text-lime font-bold">↗</span>
                </a>
            </div>
        </div>

        <div class="relative z-10 border-t border-surface-white/15 pt-4 flex flex-wrap items-center justify-between gap-4 text-xs text-surface-white/70">
            <div class="flex items-center gap-2">
                <x-material-icon name="verified" class="text-lime text-base"/>
                <span>Pusat Administrasi & Informasi Resmi Warga RT 02 Kelurahan Graha Indah</span>
            </div>
            <div class="font-mono">Balikpapan Utara, Kalimantan Timur</div>
        </div>
    </section>

    {{-- === TENTANG + PETA === --}}
    <section class="w-full max-w-[1200px] mx-auto scroll-mt-28" id="tentang">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-stretch">
            <div class="lg:col-span-7 flex flex-col justify-between">
                <div class="flex flex-col h-full justify-between">
                    <div>
                        <h2 class="text-dark text-headline-md tracking-tight mb-4">
                            Satu tempat untuk <span class="font-serif italic text-dark font-normal">urusan warga</span>
                        </h2>
                        <p class="text-text-secondary text-body-lg mb-8 leading-relaxed">
                            SIRAT Graha Indah dikembangkan atas dasar semangat kerukunan dan kegotongroyongan warga. Menghubungkan {{ number_format($jumlahKk) }} kepala keluarga dengan tata kelola lingkungan yang terbuka, akuntabel, dan berlandaskan keterbukaan data.
                        </p>
                    </div>

                    <div class="flex flex-col divide-y divide-border-line/40 border-y border-border-line/40 my-2">
                        <div class="py-4 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-soft flex items-center justify-center text-mid shrink-0">
                                <x-material-icon name="badge"/>
                            </div>
                            <div>
                                <h3 class="text-dark text-headline-sm font-bold mb-1">Administrasi Kependudukan</h3>
                                <p class="text-text-secondary text-body-md leading-relaxed">Pencatatan data kartu keluarga terverifikasi, permohonan surat pengantar RT secara mandiri, dan integrasi catatan kependudukan.</p>
                            </div>
                        </div>
                        <div class="py-4 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-soft flex items-center justify-center text-mid shrink-0">
                                <x-material-icon name="account_balance_wallet"/>
                            </div>
                            <div>
                                <h3 class="text-dark text-headline-sm font-bold mb-1">Akuntabilitas Kas RT</h3>
                                <p class="text-text-secondary text-body-md leading-relaxed">Laporan iuran kebersihan, kas gotong royong, dan belanja pemeliharaan sarana umum disajikan secara terbuka setiap bulan.</p>
                            </div>
                        </div>
                        <div class="py-4 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-soft flex items-center justify-center text-mid shrink-0">
                                <x-material-icon name="contact_phone"/>
                            </div>
                            <div>
                                <h3 class="text-dark text-headline-sm font-bold mb-1">Tanggap Darurat 24 Jam</h3>
                                <p class="text-text-secondary text-body-md leading-relaxed">Akses cepat ke pos ronda utama, kontak darurat damkar Balikpapan, fasilitas kesehatan terdekat, serta linmas lingkungan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 rounded-xl bg-soft border border-border-line/40 flex items-center gap-2 text-xs text-text-secondary">
                        <x-material-icon name="schedule" class="text-mid text-base"/>
                        <span>Jadwal layanan balai warga diumumkan oleh pengurus RT melalui kabar warga.</span>
                    </div>
                </div>
            </div>

            {{-- Peta embed --}}
            <div class="lg:col-span-5">
                <div class="h-full min-h-[420px] rounded-[24px] bg-soft border border-border-line/60 overflow-hidden flex flex-col shadow-sm">
                    <div class="relative flex justify-between items-start p-4">
                        <div class="bg-surface-white/95 backdrop-blur-md px-4 py-2.5 rounded-full shadow-md border border-border-line/40 flex items-center gap-2 relative z-10">
                            <x-material-icon name="pin_drop" filled class="text-mid"/>
                            <span class="text-dark text-body-md font-bold">RT 02 Graha Indah</span>
                        </div>
                        <span class="bg-dark/80 backdrop-blur-md text-lime text-chip px-3 py-1.5 rounded-full font-semibold">Area Aktif Warga</span>
                    </div>
                    <iframe class="w-full flex-1 min-h-[320px] border-0"
                            title="Peta lokasi RT 02 Graha Indah"
                            src="https://www.google.com/maps?q=Perumahan+Graha+Indah,+Balikpapan+Utara,+Kalimantan+Timur&output=embed"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <div class="p-4 bg-surface-white/95 text-xs text-text-secondary border-t border-border-line/40 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <x-material-icon name="apartment" class="text-sm text-mid"/>
                            <span>Sekretariat RT 02 Graha Indah</span>
                        </div>
                        <div class="font-mono text-dark font-medium">116.852° E, 1.238° S</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- === KABAR WARGA === --}}
    <section class="scroll-mt-28" id="kabar-warga">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8">
            <div>
                <h2 class="text-dark text-headline-md tracking-tight">
                    Kabar terbaru <span class="font-serif italic font-normal">lingkungan kita</span>
                </h2>
            </div>
            <div class="flex items-center gap-2 self-end sm:self-auto">
                <button aria-label="Sebelumnya" data-scroll-left data-scroll-target="#karusel-kegiatan" class="w-11 h-11 rounded-full border border-border-line flex items-center justify-center text-dark hover:bg-soft hover:border-dark transition-colors active:scale-95">‹</button>
                <button aria-label="Selanjutnya" data-scroll-right data-scroll-target="#karusel-kegiatan" class="w-11 h-11 rounded-full border border-border-line flex items-center justify-center text-dark hover:bg-soft hover:border-dark transition-colors active:scale-95">›</button>
            </div>
        </div>

        @if ($kegiatanTerbaru->isEmpty())
            <div class="rounded-[24px] bg-soft border border-border-line/40 p-10 text-center">
                <p class="text-text-secondary text-body-lg">Belum ada kegiatan yang didokumentasikan. Kabar kegiatan dikelola dan diunggah pengurus RT.</p>
            </div>
        @else
            <div id="karusel-kegiatan" data-scroll class="flex overflow-x-auto snap-x snap-mandatory gap-5 pb-2 scrollbar-thin">
                @foreach ($kegiatanTerbaru as $item)
                    <div class="snap-start shrink-0 w-[280px] sm:w-[calc((100%-3rem)/4)]">
                        <x-card-kegiatan :kegiatan="$item"/>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- === PANDUAN LAYANAN === --}}
    <section class="bg-soft rounded-[32px] p-8 sm:p-12 scroll-mt-28 border border-border-line/40" id="layanan">
        <div class="max-w-2xl mb-10">
            <h2 class="text-dark text-headline-md tracking-tight">
                Cara mengakses <span class="font-serif italic font-normal">layanan warga</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-surface-white rounded-[24px] p-6 flex flex-col justify-between border border-border-line/50 shadow-sm hover:shadow-md transition-shadow">
                <div>
                    <span class="inline-block text-mid font-mono text-xs font-semibold uppercase tracking-wider mb-4 bg-soft px-3 py-1 rounded-full">Langkah 01</span>
                    <h3 class="text-dark text-headline-sm font-bold mb-2">Login dengan Akun Warga</h3>
                    <p class="text-text-secondary text-body-md leading-relaxed">Masuk menggunakan email yang diberikan pengurus RT yang sudah terhubung ke data anggota keluarga.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-border-line/30 flex items-center text-xs text-text-secondary gap-1">
                    <x-material-icon name="lock_open" class="text-sm"/><span>Aman & Terverifikasi</span>
                </div>
            </div>

            <div class="bg-surface-white rounded-[24px] p-6 flex flex-col justify-between border border-border-line/50 shadow-sm hover:shadow-md transition-shadow">
                <div>
                    <span class="inline-block text-mid font-mono text-xs font-semibold uppercase tracking-wider mb-4 bg-soft px-3 py-1 rounded-full">Langkah 02</span>
                    <h3 class="text-dark text-headline-sm font-bold mb-2">Pilih Menu Layanan</h3>
                    <p class="text-text-secondary text-body-md leading-relaxed">Pilih kanal keuangan RT, kontak darurat, atau data keluarga Anda pada portal warga.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-border-line/30 flex items-center text-xs text-text-secondary gap-1">
                    <x-material-icon name="dashboard" class="text-sm"/><span>Navigasi Cepat</span>
                </div>
            </div>

            <div class="bg-surface-white rounded-[24px] p-6 flex flex-col justify-between border border-border-line/50 shadow-sm hover:shadow-md transition-shadow">
                <div>
                    <span class="inline-block text-mid font-mono text-xs font-semibold uppercase tracking-wider mb-4 bg-soft px-3 py-1 rounded-full">Langkah 03</span>
                    <h3 class="text-dark text-headline-sm font-bold mb-2">Akses Sesuai Hak Warga</h3>
                    <p class="text-text-secondary text-body-md leading-relaxed">Lihat transparansi anggaran kas RT dan catatan data keluarga secara aman dan terlindungi.</p>
                </div>
                <div class="mt-6 pt-4 border-t border-border-line/30 flex items-center text-xs text-text-secondary gap-1">
                    <x-material-icon name="verified_user" class="text-sm"/><span>Transparan & Real-time</span>
                </div>
            </div>

            <div class="bg-dark text-surface-white rounded-[24px] p-6 flex flex-col justify-between shadow-xl">
                <div>
                    <span class="inline-block text-lime font-mono text-xs font-semibold uppercase tracking-wider mb-4 bg-surface-white/10 px-3 py-1 rounded-full">Langkah 04</span>
                    <h3 class="text-surface-white text-headline-sm font-bold mb-2">Bantuan & Dukungan Pengurus</h3>
                    <p class="text-surface-white/80 text-body-md leading-relaxed">Hubungi pengurus RT melalui kontak darurat jika menemukan ketidaksesuaian data.</p>
                </div>
                <div class="mt-6 pt-4">
                    <a class="inline-flex items-center justify-between w-full px-4 py-2.5 rounded-full bg-lime text-dark text-body-md font-bold hover:bg-lime/90 transition-all active:scale-95 duration-150" href="#kontak">
                        Hubungi Pengurus <span class="font-bold text-xs">↗</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-publik-layout>
