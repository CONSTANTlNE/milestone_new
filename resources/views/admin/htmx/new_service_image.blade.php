@foreach($newimages as $image)
    <div class="xl:col-span-4 col-span-12" id="removableitemimage{{$image->id}}">
        <div class="box">
            <div class="box-body">
                <img src="{{$image->getUrl()}}" class="card-img mb-4 !rounded-md" alt="...">
                {{--                        <h6 class="box-title font-semibold">Product A</h6>--}}
                {{--                        <p class="card-text mb-4  text-wrap">With supporting text below as a natural--}}
                {{--                            lead-in to additional content.</p>--}}

                <button
                        hx-post="{{route('image.delete')}}"
                        hx-vals='{"_token": "{{csrf_token()}}","image_id": "{{$image->id}}"}'
                        hx-target="#success_respose"
                        class="ti-btn ti-btn-primary-full">
                    Delete
                </button>

            </div>
        </div>
    </div>
@endforeach

