@props([
    'paginator' => null,
    'showInfo' => true,
    'onEachSide' => 2
])

@if($paginator && $paginator->hasPages())
    <div class="box-footer border-t-0 flex justify-between">
        @if($showInfo)
            <div class="box-title">
                @if($paginator->total() > 0)
                    <span class="opacity-[0.7] font-normal text-[#536485] block text-[.75rem] font-second-geo pt-2">
                        {{ __('admin.showing_results', [
                            'from' => $paginator->firstItem(),
                            'to' => $paginator->lastItem(),
                            'total' => $paginator->total()
                        ]) }}
                    </span>
                @else
                    <span class="opacity-[0.7] font-normal text-[#536485] block text-[.75rem] font-second-geo pt-2">
                        {{ __('admin.no_results_found') }}
                    </span>
                @endif
            </div>
        @endif

        <div class="prism-toggle flex">
            <nav aria-label="...">
                <ul class="ti-pagination pr-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link p-2 block font-second-geo">{{__('admin.previous')}}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link p-2 block font-second-geo" href="{{ $paginator->previousPageUrl() }}">{{__('admin.previous')}}</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();
                        $onEachSide = $onEachSide;

                        // Calculate the range of pages to show
                        $start = max(1, $currentPage - $onEachSide);
                        $end = min($lastPage, $currentPage + $onEachSide);

                        // Always show first page
                        if ($start > 1) {
                            $start = 1;
                        }

                        // Always show last page
                        if ($end < $lastPage) {
                            $end = $lastPage;
                        }

                        // Adjust range to show more pages around current page
                        if ($currentPage - $onEachSide > 1) {
                            $start = $currentPage - $onEachSide;
                        }

                        if ($currentPage + $onEachSide < $lastPage) {
                            $end = $currentPage + $onEachSide;
                        }
                    @endphp

                    {{-- First Page --}}
                    @if ($start > 1)
                        <li class="page-item">
                            <a class="page-link p-2 block font-second-geo" href="{{ $paginator->url(1) }}">1</a>
                        </li>
                        @if ($start > 2)
                            <li class="page-item disabled">
                                <span class="page-link p-2 block font-second-geo">...</span>
                            </li>
                        @endif
                    @endif

                    {{-- Page Numbers --}}
                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $currentPage)
                            <li class="page-item active" aria-current="page">
                                <span class="page-link active p-2 block font-second-geo">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link p-2 block font-second-geo" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endfor

                    {{-- Last Page --}}
                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <li class="page-item disabled">
                                <span class="page-link p-2 block font-second-geo">...</span>
                            </li>
                        @endif
                        <li class="page-item">
                            <a class="page-link p-2 block font-second-geo" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link p-2 block font-second-geo" href="{{ $paginator->nextPageUrl() }}">{{__('admin.next')}}</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link p-2 block font-second-geo">{{__('admin.next')}}</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endif
