<x-app-layout>
    {{-- === Breadcrumb header === --}}
    <section class="flex flex-col gap-4">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-text-secondary">
            <a class="hover:text-dark transition-colors" href="{{ route('dashboard') }}">Beranda Warga</a>
            <span>/</span>
            <a class="hover:text-dark transition-colors" href="{{ route('dashboard') }}">Layanan</a>
            <span>/</span>
            <span class="text-dark font-semibold">Data Keluarga</span>
        </nav>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark hover:text-mid transition-colors">← Beranda Warga</a>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="max-w-3xl flex flex-col gap-3">
                <h1 class="text-headline-lg text-dark tracking-tight font-bold">
                    Data keluarga milik <span class="font-serif italic font-normal text-mid">Anda</span>
                </h1>
                <p class="text-text-secondary text-body-lg max-w-2xl leading-relaxed">
                    Rincian kependudukan kartu keluarga Anda sebagaimana tercatat oleh pengurus RT. Anda hanya dapat melihat; perubahan data tetap dikelola pengurus.
                </p>
            </div>
        </div>
    </section>

    <nav aria-label="Sub Layanan" class="inline-flex items-center gap-2 p-1.5 rounded-full bg-soft border border-border-line/50 w-fit max-w-full overflow-x-auto">
        <a class="px-5 py-2 rounded-full text-text-secondary hover:text-dark hover:bg-surface-white/60 text-xs font-medium transition-all whitespace-nowrap" href="{{ route('layanan.keuangan') }}">Keuangan</a>
        <a class="px-5 py-2 rounded-full text-text-secondary hover:text-dark hover:bg-surface-white/60 text-xs font-medium transition-all whitespace-nowrap" href="{{ route('layanan.nomor-darurat') }}">Nomor Darurat</a>
        <a aria-current="page" class="px-5 py-2 rounded-full bg-lime text-dark font-semibold text-xs shadow-sm whitespace-nowrap" href="{{ route('layanan.data-keluarga') }}">Data Keluarga</a>
    </nav>

    @if (! $anggota || ! $anggota->kartuKeluarga)
        {{-- Akun belum dipetakan ke AnggotaKeluarga — integritas data dikelola di Backend --}}
        <section class="bg-surface-white rounded-[24px] border border-border-line/60 p-10 text-center shadow-sm">
            <x-material-icon name="link_off" class="text-3xl text-mid mb-3"/>
            <h2 class="text-dark text-headline-sm font-bold mb-1">Akun belum terhubung ke kartu keluarga</h2>
            <p class="text-text-secondary text-body-md max-w-xl mx-auto">Data kependudukan Anda belum dipetakan. Silakan hubungi pengurus RT untuk verifikasi NIK agar akun warga tertaut dengan data keluarga Anda.</p>
            <a href="{{ route('layanan.nomor-darurat') }}" class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-dark hover:text-mid">Lihat nomor darurat <span>↗</span></a>
        </section>
    @else
        @php($kk = $anggota->kartuKeluarga)
        {{-- === STRUKTUR KEPENDUDUKAN: Blok ➔ Rumah ➔ KK === --}}
        <section class="bg-surface-white rounded-[24px] border border-border-line/60 p-6 md:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row items-stretch gap-3">
                <div class="flex-1 rounded-2xl bg-soft border border-border-line/40 p-5">
                    <span class="text-chip uppercase text-text-secondary font-label-section">Blok</span>
                    <div class="text-headline-sm text-dark font-bold mt-1">{{ $kk->rumah->blok->nama_blok ?? '—' }}</div>
                </div>
                <div class="hidden sm:flex items-center text-text-secondary/50">→</div>
                <div class="flex-1 rounded-2xl bg-soft border border-border-line/40 p-5">
                    <span class="text-chip uppercase text-text-secondary font-label-section">Rumah</span>
                    <div class="text-headline-sm text-dark font-bold mt-1">No. {{ $kk->rumah->nomor_rumah ?? '—' }}</div>
                </div>
                <div class="hidden sm:flex items-center text-text-secondary/50">→</div>
                <div class="flex-1 rounded-2xl bg-dark text-surface-white p-5">
                    <span class="text-chip uppercase text-surface-white/70 font-label-section">Kartu Keluarga</span>
                    <div class="text-headline-sm font-bold mt-1 font-mono">{{ $kk->nomor_kk }}</div>
                </div>
            </div>
        </section>

        @if ($kk->foto_kk)
            {{-- Identitas visual: lampiran foto Kartu Keluarga (Storage disk public) --}}
            <section class="bg-surface-white rounded-[24px] border border-border-line/60 p-6 md:p-8 shadow-sm flex flex-col sm:flex-row items-start gap-5">
                <img src="{{ asset('storage/' . $kk->foto_kk) }}" alt="Foto Kartu Keluarga {{ $kk->nomor_kk }}"
                     class="w-full sm:w-72 rounded-2xl border border-border-line/40 object-cover"/>
                <div class="flex flex-col justify-center">
                    <span class="text-chip uppercase text-text-secondary font-label-section">Dokumen resmi</span>
                    <h2 class="text-headline-sm text-dark font-bold mt-1 mb-2">Foto Kartu Keluarga</h2>
                    <p class="text-xs text-text-secondary leading-relaxed">Salinan foto KK yang tersimpan pada dokumen resmi RT. Bila ada data yang tidak sesuai, hubungi pengurus untuk pembaruan.</p>
                </div>
            </section>
        @endif

        {{-- === RINCIAN === --}}
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="bg-surface-white rounded-[24px] border border-border-line/60 p-6 md:p-8 shadow-sm">
                <div class="text-sm">
                    @foreach ([
                        'Nama' => $anggota->nama,
                        'NIK' => $anggota->nik,
                        'Tempat, tanggal lahir' => trim(($anggota->tempat_lahir ? $anggota->tempat_lahir.', ' : '').($anggota->tanggal_lahir?->translatedFormat('d M Y') ?? '')),
                        'Jenis kelamin' => $anggota->jenis_kelamin,
                        'Pekerjaan' => $anggota->pekerjaan,
                        'Golongan darah' => $anggota->golongan_darah,
                        'Status perkawinan' => $anggota->status_perkawinan,
                        'Status hubungan keluarga' => $anggota->status_hubungan_keluarga,
                    ] as $label => $nilai)
                        <div class="flex justify-between gap-4 py-2 border-b border-border-line/20">
                            <span class="text-text-secondary">{{ $label }}</span>
                            <span class="text-dark font-semibold text-right">{{ $nilai ?: '—' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-surface-white rounded-[24px] border border-border-line/60 p-6 md:p-8 shadow-sm">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <x-material-icon name="groups" class="text-mid text-[20px]"/>
                </div>
                <ul class="divide-y divide-border-line/20">
                    @foreach ($kk->anggotaKeluargas as $member)
                        <li class="flex items-center gap-3 py-3">
                            <span class="w-9 h-9 rounded-full {{ str($member->nama)->startsWith($anggota->nama) ? 'bg-lime text-dark' : 'bg-mid text-surface-white' }} flex items-center justify-center text-xs font-bold shrink-0">
                                {{ mb_substr($member->nama, 0, 2) }}
                            </span>
                            <div class="min-w-0">
                                <div class="text-dark font-semibold text-sm truncate">{{ $member->nama }}</div>
                                <div class="text-[11px] text-text-secondary">{{ $member->status_hubungan_keluarga ?: '—' }}{{ $member->jenis_kelamin ? ' • '.$member->jenis_kelamin : '' }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- === Prosedur mutasi === --}}
        <section class="bg-soft border border-border-line/60 rounded-[24px] p-6 md:p-8 flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-lime text-dark flex items-center justify-center shrink-0">
                <x-material-icon name="sync_alt" class="text-[20px]"/>
            </div>
            <div class="flex flex-col gap-1.5">
                <h3 class="text-sm font-semibold text-dark">Prosedur Pembaruan & Mutasi Data Kependudukan</h3>
                <p class="text-xs text-text-secondary leading-relaxed max-w-4xl">
                    Penambahan anggota keluarga, perubahan NIK, atau mutasi domisili hanya bisa diperbarui oleh pengurus RT. Sampaikan saat jam layanan di Balai RT atau lewat kontak pengurus.
                </p>
            </div>
        </section>
    @endif
</x-app-layout>
