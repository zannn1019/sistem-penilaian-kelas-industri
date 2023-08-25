<div class="w-full p-5">
    <div class="flex h-50 justify-center items-center gap-2 text-lg">
        @if ($paginator->onFirstPage())
            <div class="prev w-auto h-auto grid grid-cols-2 grid-rows-1 gap-1">
                <span class="border bg-gray-200 text-gray-400 w-10 h-10 flex justify-center items-center rounded-circle"
                    rel="prev"><i class="fa-solid fa-angles-left"></i></span>
                <span class="border bg-gray-200 text-gray-400 w-10 h-10 flex justify-center items-center rounded-circle"
                    rel="prev"><i class="fa-solid fa-chevron-left"></i></span>
            </div>
        @else
            <div class="prev w-auto h-auto grid grid-cols-2 grid-rows-1 gap-1">
                <a href="?page=1" class="border w-10 h-10 flex justify-center items-center rounded-circle p-3"
                    rel="prev"><i class="fa-solid fa-angles-left"></i></a>
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="border w-10 h-10 flex justify-center items-center rounded-circle p-3" rel="prev"><i
                        class="fa-solid fa-chevron-left"></i></a>
            </div>
        @endif
        <div class="prev grid grid-flow-col grid-rows-1 gap-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span
                        class="pagination-ellipsis border flex justify-center items-center rounded-circle w-10 h-10">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="pagination-link border flex justify-center items-center rounded-circle w-10 h-10 bg-darkblue-500 text-white">{{ $page }}</span>
                        @elseif ($paginator->lastPage() > 3)
                            @if ($page === 1 || $page === $paginator->lastPage() || abs($page - $paginator->currentPage()) <= 1)
                                <a href="{{ $url }}"
                                    class="pagination-link border flex justify-center items-center rounded-circle w-10 h-10">{{ $page }}</a>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <div class="next w-auto h-auto grid grid-cols-2 grid-rows-1 gap-1">
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="border w-10 h-10 flex justify-center items-center rounded-circle" rel="prev"
                    aria-label="@lang('pagination.next')"><i class="fa-solid fa-chevron-right"></i></a>
                <a href="?page={{ $paginator->lastPage() }}"
                    class="border w-10 h-10 flex justify-center items-center rounded-circle" rel="prev"
                    aria-label="@lang('pagination.next')"><i class="fa-solid fa-angles-right"></i></a>
            </div>
        @else
            <div class="prev w-auto h-auto grid grid-cols-2 grid-rows-1 gap-1">
                <span class="border bg-gray-200 text-gray-400 w-10 h-10 flex justify-center items-center rounded-circle"
                    rel="prev"><i class="fa-solid fa-angles-right"></i></span>
                <span class="border bg-gray-200 text-gray-400 w-10 h-10 flex justify-center items-center rounded-circle"
                    rel="prev"><i class="fa-solid fa-chevron-right"></i></span>
            </div>
        @endif
    </div>
</div>
