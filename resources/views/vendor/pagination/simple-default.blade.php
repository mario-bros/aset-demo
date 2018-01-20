@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <button type="button" class="m-widget__detalis  btn m-btn--pill btn-accent">
                    @lang('pagination.previous')
                </button>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <button type="button" class="m-widget__detalis  btn m-btn--pill btn-accent">
                        @lang('pagination.previous')
                    </button>
                </a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <button type="button" class="m-widget__detalis  btn m-btn--pill btn-accent">
                        @lang('pagination.next')
                    </button>
                </a>
            </li>
        @else
            <li class="disabled">
                <button type="button" class="m-widget__detalis  btn m-btn--pill btn-accent">
                    @lang('pagination.next')
                </button>
            </li>
        @endif
    </ul>
@endif
