@if ($paginator->hasPages())
    <ul class="m-datatable__pager-nav">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" style="display: inline-block"><span>&laquo;</span></li>
        @else
            <li style="display: inline-block">
                <a class="m-datatable__pager-link m-datatable__pager-link--prev m-datatable__pager-link--disabled" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <i class="la la-angle-left"></i>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" style="display: inline-block">
                    <a class="m-datatable__pager-link m-datatable__pager-link--more-prev" >{{ $element }}<i class="la la-ellipsis-h"></i></a>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" style="display: inline-block">   
                            <a class="m-datatable__pager-link m-datatable__pager-link-number m-datatable__pager-link--active" >{{ $page }}</a>
                        </li>
                    @else
                        <li style="display: inline-block">
                            <span class="m-badge m-badge--success m-badge--wide">
                                <a href="{{ $url }}" style="color: white">{{ $page }}</a>
                            </span>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="disabled" style="display: inline-block">
                <a class="m-datatable__pager-link m-datatable__pager-link--prev m-datatable__pager-link--disabled" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <i class="la la-angle-right"></i>
                </a>
            </li>
        @else
            <li style="display: inline-block"><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            
        @endif
    </ul>
@endif
