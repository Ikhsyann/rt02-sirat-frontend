@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-4 flex-wrap">
        {{-- Sebelumnya --}}
        <span class="text-xs text-text-secondary font-medium">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} {{ $label ?? 'data' }}
        </span>

        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 rounded-full border border-text-secondary/20 text-xs font-medium text-text-secondary/40 cursor-not-allowed">← Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-4 py-2 rounded-full border border-text-secondary/30 text-xs font-medium text-text-secondary hover:text-dark hover:bg-soft transition-all">← Sebelumnya</a>
            @endif

            @foreach ($elements as $page)
                {{-- Interval "Tiga Data" --}}
                @if (is_string($page))
                    <span class="px-1 text-text-secondary text-xs">{{ $page }}</span>
                @endif

                @if (is_integer($page))
                    @if ($page === $paginator->currentPage())
                        <span aria-current="pagination.page" class="w-9 h-9 rounded-full bg-dark text-surface-white flex items-center justify-center text-xs font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $paginator->url($page) }}" class="w-9 h-9 rounded-full border border-text-secondary/30 text-text-secondary hover:text-dark hover:bg-soft flex items-center justify-center text-xs font-medium transition-all">{{ $page }}</a>
                    @endif
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-4 py-2 rounded-full bg-lime text-dark text-xs font-semibold hover:bg-lime/90 transition-all active:scale-95">Selanjutnya →</a>
            @else
                <span class="px-4 py-2 rounded-full bg-lime/40 text-dark/50 text-xs font-semibold cursor-not-allowed">Selanjutnya →</span>
            @endif
        </div>
    </nav>
@endif
