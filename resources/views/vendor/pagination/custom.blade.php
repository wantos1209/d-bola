
<style>
    .pagination-container {
        display: flex;
        justify-content: space-between; 
        align-items: center;
        margin-top: 20px;
        gap: 15px;
        flex-wrap: wrap;
        width: 100%;
        text-align: right;
    }
    
    .pagination-info {
        font-size: 14px;
        color:  var(--white-color);
    }
    
    .pagination-links {
        display: flex;
        gap: 5px;
    }
    
    .pagination-btn {
        display: inline-block;
        padding: 6px 12px;
        background: var(--bg-box-primary);
        color: var(--white-color);
        border: var(--border-primary);
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.2s ease;
    }
    
    .pagination-btn:hover {
        background-color: rgba(var(--rgba-primary));
    }
    
    .pagination-btn.active {
        background: rgba(var(--rgba-primary));
        color: white;
        cursor: default;
    }
    
    .pagination-btn.disabled {
        background: var(--bg-box-primary);
        color: rgba(var(--rgba-primary));
        border: var(--border-primary);
        pointer-events: none;
    }
    </style>
    
  @if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $start = max(1, $current - 2);
        $end = min($last, $current + 2);
    @endphp

    <div class="pagination-container">
        <div class="pagination-info">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>

        <div class="pagination-links">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn disabled">«</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn">«</a>
            @endif

            {{-- First page --}}
            @if ($start > 1)
                <a href="{{ $paginator->url(1) }}" class="pagination-btn">1</a>
                @if ($start > 2)
                    <span class="pagination-btn disabled">…</span>
                @endif
            @endif

            {{-- Middle Pages --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <span class="pagination-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $paginator->url($page) }}" class="pagination-btn">{{ $page }}</a>
                @endif
            @endfor

            {{-- Last page --}}
            @if ($end < $last)
                @if ($end < $last - 1)
                    <span class="pagination-btn disabled">…</span>
                @endif
                <a href="{{ $paginator->url($last) }}" class="pagination-btn">{{ $last }}</a>
            @endif

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn">»</a>
            @else
                <span class="pagination-btn disabled">»</span>
            @endif
        </div>
    </div>
@endif
