<x-app-layout>
    {{-- === breadcrumb & header === --}}
    <section class="flex flex-col gap-4">
        <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-text-secondary">
            <a class="hover:text-dark transition-colors" href="{{ route('dashboard') }}">Beranda Warga</a>
            <span>/</span>
            <a class="hover:text-dark transition-colors" href="{{ route('dashboard') }}">Layanan</a>
            <span>/</span>
            <span class="text-dark font-semibold">Keuangan</span>
        </nav>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark hover:text-mid transition-colors">← Beranda Warga</a>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2">
            <div class="max-w-3xl flex flex-col gap-3">
                <h1 class="text-headline-lg text-dark tracking-tight font-bold">
                    Keuangan RT yang <span class="font-serif italic font-normal text-mid">terbuka</span>
                </h1>
                <p class="text-text-secondary text-body-lg max-w-2xl leading-relaxed">
                    Saldo, pemasukan, dan pengeluaran RT tercatat baris demi baris. Kategori ditulis sebagai teks bebas, sehingga pengurus bebas menamai pos anggaran apa pun. Pencatatan transaksi dilakukan pengurus di panel admin.
                </p>
            </div>
        </div>
    </section>

    {{-- === SUB-NAV TABS === --}}
    <nav aria-label="Sub Layanan" class="inline-flex items-center gap-2 p-1.5 rounded-full bg-soft border border-border-line/50 w-fit max-w-full overflow-x-auto">
        <a aria-current="page" class="px-5 py-2 rounded-full bg-lime text-dark font-semibold text-xs shadow-sm whitespace-nowrap" href="{{ route('layanan.keuangan') }}">Keuangan</a>
        <a class="px-5 py-2 rounded-full text-text-secondary hover:text-dark hover:bg-surface-white/60 text-xs font-medium transition-all whitespace-nowrap" href="{{ route('layanan.nomor-darurat') }}">Nomor Darurat</a>
        <a class="px-5 py-2 rounded-full text-text-secondary hover:text-dark hover:bg-surface-white/60 text-xs font-medium transition-all whitespace-nowrap" href="{{ route('layanan.data-keluarga') }}">Data Keluarga</a>
    </nav>

    {{-- === 3 METRIC SUMMARY === --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-dark text-surface-white p-7 rounded-[24px] flex flex-col justify-between min-h-[190px]">
            <span class="text-xs uppercase tracking-wider text-surface-white/70 font-label-section font-semibold">Saldo akhir kas {{ $periode === 'semua' ? 'terkini' : 'per ' . now()->parse($periode.'-01')->endOfMonth()->translatedFormat('d M Y') }}</span>
            <h2 class="text-3xl lg:text-4xl font-bold tracking-tight my-2">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h2>
            <p class="text-xs text-surface-white/70">Saldo berjalan kas RT.</p>
        </div>
        <div class="bg-surface-white border border-border-line p-7 rounded-[24px] flex flex-col justify-between min-h-[190px]">
            <div class="flex items-start justify-between">
                <span class="text-xs uppercase tracking-wider text-text-secondary font-label-section font-semibold">Pemasukan {{ $periode === 'semua' ? 'total' : 'periode ini' }}</span>
                <span class="w-7 h-7 rounded-full bg-lime/30 text-dark flex items-center justify-center text-xs font-bold">+</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-mid my-2">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h2>
            <p class="text-xs text-text-secondary">Total iuran warga dan sumbangan donatur.</p>
        </div>
        <div class="bg-surface-white border border-border-line p-7 rounded-[24px] flex flex-col justify-between min-h-[190px]">
            <div class="flex items-start justify-between">
                <span class="text-xs uppercase tracking-wider text-text-secondary font-label-section font-semibold">Pengeluaran {{ $periode === 'semua' ? 'total' : 'periode ini' }}</span>
                <span class="w-7 h-7 rounded-full bg-soft text-dark flex items-center justify-center text-xs font-bold border border-border-line/40">−</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-dark my-2">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h2>
            <p class="text-xs text-text-secondary">Operasional fasum, keamanan, dan kegiatan.</p>
        </div>
    </section>

    {{-- === TABEL TRANSAKSI === --}}
    <section class="bg-surface-white rounded-[24px] border border-border-line/60 shadow-sm p-6 md:p-8 flex flex-col gap-6">
        <form method="GET" action="{{ route('layanan.keuangan') }}" class="flex flex-col gap-4">
            <!-- Pemilih jenis -->
            <div class="flex items-center justify-between flex-wrap gap-4 border-b border-border-line/30 pb-4">
                <div class="flex items-center gap-2 p-1 bg-soft rounded-full">
                    <button type="submit"
                            name="jenis" value="semua"
                            @if(! $jenis) class="px-4 py-1.5 rounded-full bg-lime text-dark font-semibold text-xs" @else class="px-4 py-1.5 rounded-full text-text-secondary hover:text-dark text-xs font-medium" @endif>
                        Semua
                    </button>
                    <button type="submit"
                            name="jenis" value="income"
                            @if($jenis === 'income') class="px-4 py-1.5 rounded-full bg-lime text-dark font-semibold text-xs" @else class="px-4 py-1.5 rounded-full text-text-secondary hover:text-dark text-xs font-medium" @endif>
                        Pemasukan
                    </button>
                    <button type="submit"
                            name="jenis" value="expense"
                            @if($jenis === 'expense') class="px-4 py-1.5 rounded-full bg-lime text-dark font-semibold text-xs" @else class="px-4 py-1.5 rounded-full text-text-secondary hover:text-dark text-xs font-medium" @endif>
                        Pengeluaran
                    </button>
                </div>
                <div class="text-xs text-text-secondary font-medium">{{ number_format($rows->total()) }} catatan transaksi</div>
            </div>

            <!-- Baris input filter -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                <div class="md:col-span-4 relative">
                    <x-material-icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-text-secondary text-[18px]"/>
                    <input name="q" value="{{ $cari }}" placeholder="Cari nama barang atau keterangan..." type="search"
                           class="w-full pl-10 pr-4 py-2.5 rounded-full bg-soft border-0 text-xs text-dark placeholder:text-text-secondary/70 focus:ring-2 focus:ring-lime focus:bg-surface-white transition-all"/>
                </div>
                <div class="md:col-span-3">
                    <input name="kategori" value="{{ $kategori }}" placeholder="Kategori (teks bebas)"
                           class="w-full px-4 py-2.5 rounded-full bg-soft border-0 text-xs text-dark placeholder:text-text-secondary/70 focus:ring-2 focus:ring-lime focus:bg-surface-white transition-all"/>
                </div>
                <div class="md:col-span-3 relative">
                    <select name="periode" class="w-full pl-4 pr-10 py-2.5 rounded-full bg-soft border-0 text-xs text-dark appearance-none focus:ring-2 focus:ring-lime focus:bg-surface-white transition-all cursor-pointer">
                        <option value="{{ now()->format('Y-m') }}" {{ $periode === now()->format('Y-m') ? 'selected' : '' }}>Periode berjalan ({{ now()->translatedFormat('F Y') }})</option>
                        <option value="{{ now()->subMonth()->format('Y-m') }}" {{ $periode === now()->subMonth()->format('Y-m') ? 'selected' : '' }}>{{ now()->subMonth()->translatedFormat('F Y') }}</option>
                        <option value="{{ now()->subMonth(2)->format('Y-m') }}" {{ $periode === now()->subMonth(2)->format('Y-m') ? 'selected' : '' }}>{{ now()->subMonth(2)->translatedFormat('F Y') }}</option>
                        <option value="semua" {{ $periode === 'semua' ? 'selected' : '' }}>Semua periode</option>
                    </select>
                    <x-material-icon name="expand_more" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none text-[18px]"/>
                </div>
                <div class="md:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-full bg-dark text-surface-white hover:bg-mid transition-all text-xs font-semibold flex items-center justify-center gap-1.5 shadow-sm active:scale-95">
                        Terapkan
                    </button>
                    <a href="{{ route('layanan.keuangan') }}" aria-label="Reset Filter" class="p-2.5 rounded-full bg-soft hover:bg-border-line/40 text-text-secondary hover:text-dark transition-all" title="Reset Filter">
                        <x-material-icon name="refresh" class="text-[18px]"/>
                    </a>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto -mx-6 md:mx-0">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-soft/70 border-b border-border-line/40 text-[11px] font-semibold text-text-secondary uppercase tracking-wider">
                        <th class="py-3.5 px-4 rounded-l-xl">Tanggal</th>
                        <th class="py-3.5 px-4">Jenis</th>
                        <th class="py-3.5 px-4">Nama barang / Keterangan</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4 text-center">Jumlah</th>
                        <th class="py-3.5 px-4 text-right">Harga satuan</th>
                        <th class="py-3.5 px-4 text-right">Total (Rp)</th>
                        <th class="py-3.5 px-4 rounded-r-xl">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-line/30 text-xs">
                    @forelse ($rows as $row)
                        <tr class="hover:bg-soft/40 transition-colors">
                            <td class="py-4 px-4 font-semibold text-dark whitespace-nowrap">{{ $row->tanggal->translatedFormat('d M Y') }}</td>
                            <td class="py-4 px-4">
                                @if($row->jenis === 'income')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-mid text-surface-white">Pemasukan</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-amber-900 text-surface-white">Pengeluaran</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-semibold text-dark max-w-xs">{{ $row->nama_barang }}</td>
                            <td class="py-4 px-4 text-dark font-medium">{{ $row->kategori }}</td>
                            <td class="py-4 px-4 text-center font-medium text-dark">{{ number_format($row->jumlah) }}</td>
                            <td class="py-4 px-4 text-right text-dark font-medium">Rp {{ number_format($row->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-4 px-4 text-right font-bold whitespace-nowrap text-[13px] {{ $row->jenis === 'income' ? 'text-mid' : 'text-dark' }}">
                                {{ $row->jenis === 'income' ? '+' : '−' }} Rp {{ number_format($row->total, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 text-dark max-w-[220px] truncate">{{ $row->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-10 text-center text-text-secondary">Tidak ada transaksi pada filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $rows->links('pagination.pill', ['label' => 'transaksi kas']) }}
    </section>

    {{-- === CATATAN TRANSPARANSI === --}}
    <section class="bg-soft border border-border-line/60 rounded-[24px] p-6 md:p-8 flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-lime text-dark flex items-center justify-center shrink-0">
            <x-material-icon name="verified_user" class="text-[20px]"/>
        </div>
        <div class="flex flex-col gap-1.5">
            <h3 class="text-sm font-semibold text-dark">Informasi Transparansi Kas RT 02</h3>
            <p class="text-xs text-text-secondary leading-relaxed max-w-4xl">
                Setiap warga berhak memeriksa rincian kwitansi fisik di Balai RT saat jam pelayanan administrasi. Pertanyaan pos anggaran dapat disampaikan langsung melalui agenda musyawarah bulanan atau kontak pengurus.
            </p>
        </div>
    </section>
</x-app-layout>
