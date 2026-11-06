<footer class="relative bg-dark text-surface-white rounded-[32px] p-10 sm:p-14 shadow-2xl overflow-hidden" id="kontak">
    <div class="absolute -left-20 -bottom-20 w-80 h-80 rounded-full bg-mid/30 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 gap-10 pb-10 border-b border-surface-white/15">
        <div class="md:col-span-6 flex flex-col justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <img src="{{ asset('images/lambang-balikpapan.svg') }}" alt="Lambang Kota Balikpapan" class="h-10 w-10 object-contain">
                    <div>
                        <span class="text-headline-md font-bold text-surface-white">SIRAT RT 02</span>
                        <p class="text-chip text-surface-white/70">Kelurahan Graha Indah</p>
                    </div>
                </div>
                <p class="text-surface-white/80 text-body-lg max-w-md leading-relaxed mb-6">
                    Mewujudkan transparansi, kebersamaan, dan kemudahan pelayanan warga yang terintegrasi secara digital demi lingkungan yang aman dan asri.
                </p>
            </div>
            <div class="flex items-start gap-2.5 text-surface-white/70 text-body-md">
                <x-material-icon name="location_on" filled class="text-lime text-xl shrink-0"/>
                <span>Balai Warga RT 02, Kompleks Graha Indah, Balikpapan Utara, Kalimantan Timur</span>
            </div>
        </div>

        <div class="md:col-span-6 flex flex-col justify-between">
            <div>
                <h4 class="text-lime font-label-section text-label-section uppercase mb-5 tracking-wider">
                    KONTAK PENGURUS & PELAYANAN
                </h4>
                <p class="text-surface-white/80 text-body-lg max-w-md leading-relaxed">
                    Untuk administrasi dan layanan warga, hubungi pengurus RT secara langsung di balai warga atau melalui pertemuan rutin lingkungan. Nomor darurat lingkungan tersedia di portal warga.
                </p>
            </div>
            <div class="mt-8 pt-6 border-t border-surface-white/10 flex flex-wrap gap-4 text-body-md">
                <a class="text-surface-white/70 hover:text-lime transition-colors" href="{{ \Illuminate\Support\Facades\Route::has('kegiatan.index') ? route('kegiatan.index') : '#' }}">Berita & Kegiatan</a>
                <span class="text-surface-white/30">•</span>
                <a class="text-surface-white/70 hover:text-lime transition-colors" href="{{ route('layanan.nomor-darurat') }}">Nomor Darurat</a>
                <span class="text-surface-white/30">•</span>
                <a class="text-lime font-medium" href="#kontak">Kontak Pengurus</a>
            </div>
        </div>
    </div>

    <div class="relative z-10 pt-7 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-surface-white/60">
        <p>© {{ now()->year }} RT 02 Graha Indah. All rights reserved.</p>
        <p class="text-center sm:text-right text-surface-white/50">Developed by Program Pengembangan Desa — Institut Teknologi Kalimantan</p>
    </div>
</footer>
