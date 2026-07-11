{{-- Reusable custom pagination control. Usage: @include('partials.pagination', ['paginator' => $someList]) --}}
@if($paginator->hasPages())
    <nav class="pagination-nav" aria-label="Pagination">
        @if($paginator->onFirstPage())
            <span class="pagination-btn pagination-btn-disabled">← Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn">← Previous</a>
        @endif

        <span class="pagination-info">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn">Next →</a>
        @else
            <span class="pagination-btn pagination-btn-disabled">Next →</span>
        @endif
    </nav>
@endif
