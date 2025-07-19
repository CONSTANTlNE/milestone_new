@extends('admin.admin_layout')



@section('admin_faqs_edit_page')
    @push('css')
        <style>
            th {
                text-align: center !important;
            }
        </style>
    @endpush

    <div class="col-span-12 md:col-span-6 xxl:!col-span-4 mt-5">
        <div class="box">
            <div class="box-header">
                <h5 class="box-title">Create a FAQ</h5>
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
                                <h4 class="text-center mt-3 mb-3">Question - {{$locale2}} </h4>
                                <div class="flex justify-center mb-3 mt-3 ">
                                    <div class="flex rounded-sm w-full">
                                    <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                        Question - {{$locale2}}
                                    </span>
                                        <input form="faq_form"
                                               name="question_{{$locale2}}"
                                               type="text"
                                               value="{{$faq->getTranslation('question',$locale2)}}"
                                               placeholder="Please type Question"
                                               class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0 ">
                                    </div>
                                </div>
                                <h4 class="text-center mt-3 mb-3">Answer - {{$locale2}}</h4>

                                <div id="editor{{$localeindex2}}">
                                      {!! $faq->getTranslation('answer',$locale2) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{route('faq.update')}}" class="flex justify-center" id="faq_form">
        @csrf
        <input type="hidden" name="faq_id" value="{{$faq->id}}">
        @foreach($locales as $localeindex3 => $locale3)
            <input type="hidden" name="answer_{{$locale3}}" id="quillContent{{$locale3}}">
        @endforeach
        <button type="button" id="saveBtn" class="ti-btn ti-btn-primary-full !rounded-full ti-btn-wave">
            Update F.A.Q
        </button>
    </form>


    <script>
        let locales = @json($locales);
        const quillEditors = {};
        const service_form = document.getElementById('faq_form');
        const saveBtn = document.getElementById('saveBtn')
        saveBtn.addEventListener('click', function () {
            locales.forEach((abbr, index) => {
                document.getElementById('quillContent' + abbr).value = quillEditors[abbr].root.innerHTML;
            });

            service_form.submit()
        });
    </script>

    @push('js')
        <script src="{{asset('adminassets/js/quill-editor.js')}}"></script>
    @endpush

@endsection
