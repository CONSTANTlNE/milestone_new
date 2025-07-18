@extends('backend.layouts.master')
@section('title') {{ __('admin.sidebar_blogs') }} @endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

    <a href="{{route('backend.faq.multiply')}}">create 5 copies</a>
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
                                               value="{{old('question_'.$locale2)}}"
                                               placeholder="Please type Question"
                                               class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0 ">
                                    </div>
                                </div>
                                <h4 class="text-center mt-3 mb-3">Answer - {{$locale2}}</h4>

                                <div id="editor{{$localeindex2}}">

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{route('backend.faq.store')}}" class="flex justify-center" id="faq_form">
        @csrf
        @foreach($locales as $localeindex3 => $locale3)
            <input type="hidden" name="answer_{{$locale3}}" id="quillContent{{$locale3}}">
        @endforeach
        <button type="button" id="saveBtn" class="ti-btn ti-btn-primary-full !rounded-full ti-btn-wave">
            Create F.A.Q
        </button>
    </form>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12">
            <div class="box">

                <div class="box-header">
                    <h5 class="box-title">F.A.Qs</h5>
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="max-height: calc(100vh - 245px)">
                        <table class="table whitespace-nowrap ti-striped-table min-w-full">
                            <thead class="bg-light">
                            <tr class="text-center">
                                <th scope="col" class="sticky top-0  z-10">#</th>
                                <th scope="col" class="sticky top-0  z-10">Question</th>
                                <th scope="col" class="sticky top-0  z-10">Answer</th>
                                <th scope="col" class="sticky top-0 z-10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($faqs as $index =>$faq)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td style="white-space: normal; word-break: break-word; max-width: 200px;">
                                        <p>{{$faq->question}}</p>
                                    </td>
                                    <td style="white-space: normal; word-break: break-word; max-width: 200px;">
                                        <p>{!! $faq->answer !!}</p>
                                    </td>
                                    <td>
                                        <div class="flex justify-center gap-2">
                                            <a target="_blank" href="{{route('faq.edit',$faq->id)}}"
                                               style="color:blue;font-size: 1.5rem"><i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{route('faq.delete')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="faq_id" value="{{$faq->id}}">
                                                <button style="color:red;font-size: 1.5rem">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            {{--  <tfoot>--}}
                            {{--   <tr>--}}
                            {{--                                    <th>Abbr</th>--}}
                            {{--                                    <th>Language</th>--}}
                            {{--                                    <th>Status</th>--}}
                            {{--   <th>Main</th>--}}
                            {{--  </tr>--}}
                            {{--   </tfoot>--}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>




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
