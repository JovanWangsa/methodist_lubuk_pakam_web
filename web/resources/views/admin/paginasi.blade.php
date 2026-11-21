@if ($paginator->hasPages())
<nav aria-label="Halaman" class="flex items-center justify-between font-body-sm text-body-sm">
    <span class="text-on-surface-variant">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>
    <div class="flex gap-space-xs">
        @if ($paginator->onFirstPage())
            <span class="a-tombol-kedua opacity-50">Sebelumnya</span>
        @else
            <a class="a-tombol-kedua" href="{{ $paginator->previousPageUrl() }}" rel="prev">Sebelumnya</a>
        @endif
        @if ($paginator->hasMorePages())
            <a class="a-tombol-kedua" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya</a>
        @else
            <span class="a-tombol-kedua opacity-50">Berikutnya</span>
        @endif
    </div>
</nav>
@endif
