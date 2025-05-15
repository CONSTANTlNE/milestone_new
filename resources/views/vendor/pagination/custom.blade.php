@if($paginator->hasPages())
    @php
        $search  = isset(\App('request')->search) ? 'search='.\App('request')->search.'&' : null;
        $page_id = isset(\App('request')->page_id) ? 'page_id='.\App('request')->page_id.'&' : null;
        $l       = isset(\App('request')->l) ? 'l='.\App('request')->l.'&' : null;
        $page    = isset(\App('request')->page) ? 'page=' : null;
    @endphp

    <div class="pnation">
        <nav aria-label="Page navigation" class="pgnation">
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li><a href="#" aria-label="Previous"><span aria-hidden="true"><i class="fas fa-arrow-left"></i></span></a></li>
                @else
                    <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-arrow-left"></i></a></li>
                @endif


                @if($paginator->currentPage() > 3)
                    <li><a href="{{ url()->current().'?'.$search.$page_id.'page=1' }}">1</a></li>
                @endif
                @if($paginator->currentPage() > 4)
                    <li><a href="#">...</a></li>
                @endif
                @foreach(range(1, $paginator->lastPage()) as $i)
                    @if($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 2)
                        @if ($i == $paginator->currentPage())
                            <li class="active"><a href="#">{{ $i }}</a></li>
                        @else
                            {{-- <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li> --}}
                            <li><a href="{{ url()->current().'?'.$l.$search.$page_id.'page='.$i }}">{{ $i }}</a></li>
                        @endif
                    @endif
                @endforeach
                @if($paginator->currentPage() < $paginator->lastPage() - 3)
                    <li><a href="#">...</a></li>
                @endif
                @if($paginator->currentPage() < $paginator->lastPage() - 2)
                    {{-- <li><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li> --}}
                    <li><a href="{{ url()->current().'?'.$l.$search.$page_id.'page='.$paginator->lastPage() }}">{{ $paginator->lastPage() }}</a></li>
                @endif

                @if ($paginator->hasMorePages())
                    {{-- <li><a href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true"><i class="ion-ios7-arrow-forward"></i></span></a></li> --}}
                    <li><a href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><span aria-hidden="true"><i class="fas fa-arrow-right"></i></span></a></li>
                @else
                    <li><a href="#" aria-label="Next"><span aria-hidden="true"><i class="fas fa-arrow-right"></i></span></a></li>
                @endif
            </ul>

            <div class="custom goto_page">
                <span>{{__('got-to-page')}}</span>
                <input class="page_send_num" type="" name="" value=""> <a class="go_btn"> <i class="fas fa-arrow-right"></i></a>
            </div>
        </nav>
    </div>
@endif
