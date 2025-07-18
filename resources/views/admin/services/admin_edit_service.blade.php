@extends('admin.admin_layout')



@section('create_service_page')
    @push('css')

    @endpush


    <div class="col-span-12 md:col-span-6 xxl:!col-span-4 mt-5">
        <div class="box">
            <div class="box-header">
                <h5 class="box-title">Edit Service</h5>
            </div>
            <div class="box-body">
                <div class="border-b-0 border-gray-200 dark:border-white/10">
                    <nav class="flex space-x-2 rtl:space-x-reverse justify-center" aria-label="Tabs" role="tablist">
                        @foreach($locales as $localeindex => $locale)
                            <button type="button"
                                    class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300 {{$loop->first ? 'active' : ''}}"
                                    id="hs-tab-js-behavior-item-{{$localeindex}}"
                                    data-hs-tab="#hs-tab-js-behavior-{{$localeindex}}"
                                    aria-controls="hs-tab-js-behavior-{{$localeindex}}">
                                {{$locale}}
                            </button>
                        @endforeach
                    </nav>
                </div>

                <div class="">
                    @foreach($locales as $localeindex2 =>$locale2)
                        <div id="hs-tab-js-behavior-{{$localeindex2}}" class="{{ !$loop->first ? 'hidden' : '' }}"
                             role="tabpanel" aria-labelledby="hs-tab-js-behavior-item-{{$localeindex2}}"
                             style="padding-top: 15px">
                            <div class="border rounded-ss-none rounded-sm dark:border-white/10 border-gray-200">
                                <div class="flex justify-center mb-3 mt-3">
                                    <div class="flex rounded-sm">
                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                        Service Name - {{$locale2}}
                                    </span>
                                        <input form="service_form" name="service_name_{{$locale2}}" type="text"
                                               class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0"
                                               value="{{$service->getTranslation('name',$locale2)}}">
                                    </div>
                                </div>
                                <p class="text-center">Short Description</p>

                                <div id="editor2{{$localeindex2}}">
                                    {!!$service->getTranslation('short_description',$locale2)  !!}
                                </div>
                                <p class="text-center">Long Description</p>
                                <div id="editor{{$localeindex2}}">
                                    {!! $service->getTranslation('description',$locale2) !!}
                                </div>
                            </div>
                            {{--   Features  --}}
                            <div class="mt-3 flex justify-center">
                                @foreach($locales as $localeindex5 =>$locale5)
                                    @if($locale2==$locale5)
                                        <div id="cardContainer{{$locale5}}" class="w-full">
                                            <p class="text-center mt-2 mb-2">Existing Features</p>
                                            @foreach($service->features as $featureindex =>$existingfeature)
                                                <div class="card{{$locale2}} mt-2">
                                                    <div class="flex rounded-sm gap-4 existingfeature{{$existingfeature->id}}">
                                                        <div class="flex w-full">
                                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                        Feature Name - {{$locale2}}
                                                    </span>
                                                            <input form="service_form"
                                                                   name="service_feature_name_{{$locale2}}[]"
                                                                   type="text"
                                                                   value="{{$existingfeature->getTranslation('name',$locale2)}}"
                                                                   class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                                        </div>
                                                        <button onclick="removeExistingFeature({{$existingfeature->id}})"
                                                                class="" style="color:red">
                                                            <i style="font-size: 2rem" class="ri-subtract-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    @endif
                                @endforeach

                                {{--       feature template       --}}
                                @foreach($locales as $localeindex6 =>$locale6)
                                    @if($locale2==$locale6)
                                        <template id="cardTemplate{{$locale6}}">
                                            <div class="card mt-2">
                                                <div class="flex rounded-sm gap-4">
                                                    <div class="flex w-full">
                                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                        Feature Name - {{$locale6}}
                                                    </span>
                                                        <input form="service_form"
                                                               name="service_feature_name_{{$locale6}}[]" type="text"
                                                               class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                                    </div>
                                                    <button data-removefeature="0" class="removebtn" style="color:red">
                                                        <i style="font-size: 2rem" class="ri-subtract-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    @endif
                                @endforeach
                            </div>


                            {{--   faqs  --}}
                            <div class="mt-3 flex justify-center">
                                @foreach($locales as $localeindex5 =>$locale5)
                                    @if($locale2==$locale5)
                                        <div id="faqContainer{{$locale5}}" class="w-full">
                                            <p class="text-center mt-2 mb-2">Existing FAQ</p>
                                            {{--  existing faqs --}}
                                            @foreach($service->faqs as $faqindex => $existingfaq)
                                                <div class="card mt-2">
                                                    <div class="flex flex-col rounded-sm gap-4 existingfaq{{$existingfaq->id}}">
                                                        {{--                                                        <p class="text-center">F.A.Q - {{$locale5}}</p>--}}
                                                        <div class="flex w-full">
                                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                        Question - {{$locale5}}
                                                    </span>
                                                            <input form="service_form"
                                                                   name="faq_question_{{$locale5}}[]"
                                                                   type="text"
                                                                   value="{{$existingfaq->getTranslation('question',$locale2)}}"
                                                                   class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                                        </div>
                                                        <div>
                                                            {{--                                                        <label  class="ti-form-label">Answer</label>--}}
                                                            <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                        Answer -  {{$locale5}}
                                                    </span>
                                                            <textarea form="service_form"
                                                                      name="faq_answer_{{$locale5}}[]"
                                                                      class="ti-form-input" rows="3"
                                                                      placeholder="">{{$existingfaq->getTranslation('answer',$locale2)}}</textarea>
                                                        </div>
                                                        {{--                                                    <button data-removefaq="0" class="removefaq" style="color:red">--}}
                                                        {{--                                                        <i style="font-size: 2rem" class="ri-subtract-line"></i>--}}
                                                        {{--                                                    </button>--}}
                                                        <button type="button"
                                                                onclick="removeExistingfaq({{$existingfaq->id}})"
                                                                class="ti-btn ti-btn-danger-full ti-btn-wave removefaq">
                                                            Remove Question
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    @endif
                                @endforeach
                                {{--          FAQ template             --}}
                                @foreach($locales as $localeindex6 =>$locale6)
                                    @if($locale2==$locale6)
                                        <template id="faqTemplate{{$locale6}}">
                                            <div class="card{{$locale6}} mt-2">

                                                <div class="flex flex-col rounded-sm gap-4">
                                                    <p class="text-center">F.A.Q - {{$locale6}}</p>
                                                    <div class="flex w-full">
                                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                        Question - {{$locale6}}
                                                    </span>
                                                        <input form="service_form"
                                                               name="faq_question_{{$locale6}}[]" type="text"
                                                               class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                                    </div>
                                                    <div>
                                                        {{--                                                        <label  class="ti-form-label">Answer</label>--}}
                                                        <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                        Answer -  {{$locale6}}
                                                    </span>
                                                        <textarea form="service_form" name="faq_answer_{{$locale6}}[]"
                                                                  class="ti-form-input" rows="3"
                                                                  placeholder=""></textarea>
                                                    </div>
                                                    {{--                                                    <button data-removefaq="0" class="removefaq" style="color:red">--}}
                                                    {{--                                                        <i style="font-size: 2rem" class="ri-subtract-line"></i>--}}
                                                    {{--                                                    </button>--}}
                                                    <button type="button"
                                                            class="ti-btn ti-btn-danger-full ti-btn-wave removefaq">
                                                        Remove Question
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    @endif
                                @endforeach
                            </div>

                            {{--   images  --}}
{{--                            @if($loop->first)--}}
{{--                                <div class="flex justify-center">--}}
{{--                                    <div class="flex justify-center mt-3" style="width: 300px">--}}
{{--                                        <label for="file-input" class="sr-only">Choose file</label>--}}
{{--                                        <input type="file" name="service_images[]"--}}
{{--                                               id="file-input"--}}
{{--                                               form="service_form"--}}
{{--                                               multiple--}}
{{--                                               accept="images/*"--}}
{{--                                               class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50 file:border-0 file:bg-light file:me-4 file:py-3 file:px-4 dark:file:bg-black/20 dark:file:text-white/50">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <div class="flex justify-center mt-3 gap-3">--}}
{{--                                <button onclick="addCard()" type="button" class="ti-btn ti-btn-light ti-btn-wave">--}}
{{--                                    Add Feature--}}
{{--                                </button>--}}
{{--                                <button onclick="addFaq()" type="button" class="ti-btn ti-btn-light ti-btn-wave">--}}
{{--                                    Add F.A.Q--}}
{{--                                </button>--}}
{{--                            </div>--}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <form method="POST" action="{{route('service.update')}}" class="flex justify-center mb-5" id="service_form"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="service_id" value="{{$service->id}}">
        @foreach($locales as $localeindex3 => $locale3)
            <input type="hidden" name="description_{{$locale3}}" id="quillContent{{$locale3}}">
            <input type="hidden" name="short_description_{{$locale3}}" id="quillContent2{{$locale3}}">
        @endforeach
        <button type="button" id="saveBtn" class="ti-btn ti-btn-primary-full !rounded-full ti-btn-wave">
            Update Service
        </button>
    </form>

    <script>
        let locales = @json($locales);

        const quillEditors = {};
        const quillEditors2 = {};
        const service_form = document.getElementById('service_form');
        const saveBtn = document.getElementById('saveBtn')
        saveBtn.addEventListener('click', function () {
            locales.forEach((abbr, index) => {
                document.getElementById('quillContent' + abbr).value = quillEditors[abbr].root.innerHTML;
                document.getElementById('quillContent2' + abbr).value = quillEditors2[abbr].root.innerHTML;
            });

            service_form.submit()
        });

        // FEATURES
        let featureCount = 0;

        function addCard() {
            featureCount++
            locales.forEach((abbr, index) => {

                const template = document.getElementById('cardTemplate' + abbr);
                const container = document.getElementById('cardContainer' + abbr);
                const clone = template.content.cloneNode(true);

                // Add dynamic class to the button
                const button = clone.querySelector('button.removebtn');
                button.dataset.removefeature = featureCount;

                container.appendChild(clone);

                const removebtns = document.querySelectorAll('.removebtn')

                removebtns.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const dataset = btn.dataset
                        const selector = `[data-removefeature="${dataset.removefeature}"]`;
                        const removables = document.querySelectorAll(selector);
                        removables.forEach((removable) => {
                            removable.parentElement.remove()
                        })
                    })
                })
            });
        }


        // FAQ
        let faqCount = 0;

        function addFaq() {
            faqCount++
            locales.forEach((abbr, index) => {

                const faqtemplate = document.getElementById('faqTemplate' + abbr);
                const faqcontainer = document.getElementById('faqContainer' + abbr);
                const faqclone = faqtemplate.content.cloneNode(true);

                // Add dynamic class to the button
                const faqbutton = faqclone.querySelector('button.removefaq');
                faqbutton.dataset.removefaq = faqCount;

                faqcontainer.appendChild(faqclone);

                const removefaqbtns = document.querySelectorAll('.removefaq')

                removefaqbtns.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const faqdataset = btn.dataset
                        const faqselector = `[data-removefaq="${faqdataset.removefaq}"]`;
                        const faqremovables = document.querySelectorAll(faqselector);
                        faqremovables.forEach((removable) => {
                            removable.parentElement.remove()
                        })
                    })
                })
            });
        }


        function removeExistingFeature(id) {
            const existingFeatures = document.querySelectorAll(`.existingfeature${id}`)
            existingFeatures.forEach((ftcontainer) => {
                ftcontainer.remove()
            })
        }

        function removeExistingfaq(id) {
            const existingFaqs = document.querySelectorAll(`.existingfaq${id}`)
            existingFaqs.forEach((faqcontainer) => {
                faqcontainer.remove()
            })
        }

    </script>


    @push('js')
        <script src="{{asset('adminassets/js/quill-editor.js')}}"></script>
    @endpush
@endsection