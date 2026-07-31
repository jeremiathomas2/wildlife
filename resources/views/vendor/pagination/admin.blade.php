@if ($paginator->hasPages())
    @if ($paginator->onFirstPage())
        <span class="disabled">Previous</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span>{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="active" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" aria-label="Go to page {{ $page }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
    @else
        <span class="disabled">Next</span>
    @endif
@endif
