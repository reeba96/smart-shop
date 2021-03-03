@if ($paginator->hasPages())
    <div class="pagination shop mt-50">
        <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item">
            <a class="page-link" data-page="{{ urldecode($paginator->previousPageUrl()) }}" id="previous" class="page-item previous" style="padding: 6px !important">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" data-page="{{ urldecode($paginator->previousPageUrl()) }}" id="previous" class="page-item previous" style="padding: 6px !important">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
            <li class="page-item">
                <a class="page-link" aria-disabled="true">
                    {{ $element }}
                </a>
            </li>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <li class="page-item active">
                        <a class="page-link">
                            {{ $page }}
                        </a>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link as" href="{{ urldecode($url) }}">
                            {{ $page }}
                        </a>
                    </li>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li>
            <a href="{{ urldecode($paginator->nextPageUrl()) }}" data-page="{{ urldecode($paginator->nextPageUrl()) }}" id="next" class="page-link">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
        @else
        <li>
            <a class="page-link" href="{{ urldecode($paginator->previousPageUrl()) }}" data-page="{{ urldecode($paginator->previousPageUrl()) }}">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        @endif
        </ul>
    </div>
@endif