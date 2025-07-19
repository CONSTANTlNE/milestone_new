<div class="grid grid-cols-12">
    <div class="col-span-12">
        <div id="success_respose"></div>
        <div class="grid grid-cols-12 gap-x-6" id="service_image">
            @foreach($service->media as $image)
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
        </div>
    </div>
</div>
<div class="flex justify-center">
    <form
            hx-post="{{ route('service.upload.image.htmx') }}"
            hx-target="#service_image"
            hx-swap="beforeend"
            enctype="multipart/form-data"
            method="POST"
    >
        @csrf
        <input type="hidden" name="index" value="{{$index}}">
        <input type="hidden" name="service_id" value="{{$service->id}}">
        <div class="flex justify-center mt-3 gap-4">
            <div class="flex justify-center" style="width: 300px">
                <label for="file-input" class="sr-only">Choose file</label>
                <input type="file" name="service_images[]"
                       multiple
                       accept="images/*"
                       class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50 file:border-0 file:bg-light file:me-4 file:py-3 file:px-4 dark:file:bg-black/20 dark:file:text-white/50">
            </div>
            <button style="margin-bottom: 0" type="submit" class="ti-btn ti-btn-light ti-btn-wave">Upload</button>
        </div>
    </form>
</div>

<script>

</script>