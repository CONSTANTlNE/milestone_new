@extends('admin.admin_layout')


@section('admin_sliders_page')

    @push('css')
        <style>
            th {
                text-align: center !important;
            }

            .page {
                min-height: 100%;
            }
            .wdt500{
                width: 500px!important;
            }
            .wdt300{
                max-width: 500px!important;
            }
        </style>
    @endpush

    <div class="flex justify-center mt-4">
        <button type="button" class="hs-dropdown-toggle ti-btn ti-btn-primary-full" data-hs-overlay="#hs-large-modal">
            Create Slider
        </button>
        <div id="hs-large-modal" class="hs-overlay hidden ti-modal [--overlay-backdrop:static]">
            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out md:!max-w-2xl md:w-full m-3 md:mx-auto">
                <div class="ti-modal-content">
                    <div class="ti-modal-header">
                        <h6 class="ti-modal-title">
                            Create Slider
                        </h6>
                        <button type="button" class="hs-dropdown-toggle ti-modal-close-btn"
                                data-hs-overlay="#hs-large-modal">
                            <span class="sr-only">Close</span>
                            <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z"
                                      fill="currentColor"/>
                            </svg>
                        </button>
                    </div>
                    <div class="ti-modal-body">
                        <form action="{{route('sliders.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="border-b-0 border-gray-200 dark:border-white/10">
                                <nav class="flex space-x-2 rtl:space-x-reverse justify-center" aria-label="Tabs"
                                     role="tablist">
                                    @foreach($locales as $localeindex => $locale)
                                        <button type="button"
                                                class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300 {{$loop->first ? 'active' : ''}}"
                                                id="hs-tab-js-behavior-item-{{$localeindex}}"
                                                data-hs-tab="#hs-tab-js-behavior-{{$localeindex}}"
                                                aria-controls="hs-tab-js-behavior-{{$localeindex}}">
                                            {{$locale->abbr}}
                                        </button>
                                    @endforeach
                                </nav>
                            </div>
                            @foreach($locales as $localeindex2 =>$locale2)
                                <div id="hs-tab-js-behavior-{{$localeindex2}}"
                                     class="{{ !$loop->first ? 'hidden' : '' }}"
                                     role="tabpanel" aria-labelledby="hs-tab-js-behavior-item-{{$localeindex2}}"
                                     style="padding-top: 15px">
                                    <div class="border rounded-ss-none rounded-sm dark:border-white/10 border-gray-200 w-full p-2">
                                        <div class="flex rounded-sm w-full">
                                                <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                    Header - {{$locale2->abbr}}
                                                </span>
                                            <input name="header_{{$locale2->abbr}}"
                                                   type="text"
                                                   class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                        </div>
                                        <div class="flex rounded-sm w-full  mt-3">
                                                <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                    Annotation - {{$locale2->abbr}}
                                                </span>
                                            <input name="annotation_{{$locale2->abbr}}"
                                                   type="text"
                                                   class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                        </div>
                                        <div class="flex rounded-sm w-full mt-3">
                                                <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                    Text - {{$locale2->abbr}}
                                                </span>
                                            <input name="text_{{$locale2->abbr}}"
                                                   type="text"
                                                   class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{--   images  --}}
                            <div class="flex justify-center mb-3">
                                <div class="flex justify-center mt-3" style="width: 300px">
                                    <label for="file-input" class="sr-only">Choose file</label>
                                    <input type="file" name="slider_image"
                                           id="file-input"
                                           required
                                           accept="image/*"
                                           class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50 file:border-0 file:bg-light file:me-4 file:py-3 file:px-4 dark:file:bg-black/20 dark:file:text-white/50">
                                </div>
                            </div>
                            <div class="ti-modal-footer">
                                <button type="button"
                                        class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                        data-hs-overlay="#hs-large-modal">
                                    Close
                                </button>
                                <button type="submit" class="ti-btn bg-primary text-white !font-medium">
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="grid grid-cols-12 gap-6 mt-3">
        <div class="col-span-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="box-title">Sliders</h5>
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="max-height: calc(100vh - 245px)">
                        <table class="table whitespace-nowrap table-bordered  min-w-full">
                            <thead  class="bg-light">
                            <tr class="text-center border-b border-defaultborder">
                                <th scope="col" class="sticky top-0  z-10">#</th>
                                <th scope="col" class="sticky top-0  z-10">Text</th>
                                <th scope="col" class="sticky top-0  z-10">Images</th>
                                <th scope="col" class="sticky top-0  z-10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $index =>$slider)
                                <tr class="border-b border-defaultborder">
                                    <td>{{$index+1}}</td>
                                    <td>
                                        <div class="flex items-center mb-3">
                                            <div>
                                                <div class="leading-none">
                                                    <span class=" badge bg-primary/10 text-primary text-[1rem]">Header</span>
                                                </div>
                                                <div class="leading-none">
                                                    <span>{{$slider->slide_header}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center mb-5 mt-5">
                                            <div>
                                                <div class="leading-none">
                                                    <span class=" badge bg-primary/10 text-primary text-[1rem]">Annotation</span>
                                                </div>
                                                <div class="leading-none">
                                                    <span>{{$slider->slide_annotation}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center mb-5 mt-5">
                                            <div>
                                                <div class="leading-none">
                                                    <span class=" badge bg-primary/10 text-primary text-[1rem]">Text</span>
                                                </div>
                                                <div class="leading-none">
                                                    <span>{{$slider->slide_text}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="flex justify-center items-center gap-4">
                                        <img  class="wdt300" src="{{$slider->media->first()?->getUrl()}}" alt="">
                                        <form action="{{route('slider.images.update')}}"
                                              method="post"
                                              enctype="multipart/form-data"
                                              class="flex flex-col items-center justify-center mt-2">
                                            @csrf
                                            <input type="hidden" name="slider_id" value="{{$slider->id}}">
                                            <div class="flex justify-center mt-3" style="width: 300px">
                                                <label for="file-input" class="sr-only">Choose file</label>
                                                <input type="file" name="slider_image"
                                                       id="file-input"
                                                       accept="image/*"
                                                       class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/50 file:border-0 file:bg-light file:me-4 file:py-3 file:px-4 dark:file:bg-black/20 dark:file:text-white/50">
                                            </div>
                                            <button style="max-width: 300px" type="submit" class="mt-2 ti-btn ti-btn-light ti-btn-wave">Update Image</button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="flex justify-center gap-2">
                                            <a data-hs-overlay="#edit_slider{{$index}}"  href="javascript:void(0)" style="color:blue;font-size: 1.5rem">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <div id="edit_slider{{$index}}" class="hs-overlay hidden ti-modal [--overlay-backdrop:static]">
                                                <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out md:!max-w-2xl md:w-full m-3 md:mx-auto">
                                                    <div class="ti-modal-content">
                                                        <div class="ti-modal-header">
                                                            <h6 class="ti-modal-title">
                                                                Create Slider
                                                            </h6>
                                                            <button type="button" class="hs-dropdown-toggle ti-modal-close-btn"
                                                                    data-hs-overlay="#edit_slider{{$index}}">
                                                                <span class="sr-only">Close</span>
                                                                <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none"
                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z"
                                                                          fill="currentColor"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="ti-modal-body">
                                                            <form action="{{route('sliders.update')}}" method="post">
                                                                @csrf
                                                                <input type="hidden" value="{{$slider->id}}" name="slider_id">
                                                                <div class="border-b-0 border-gray-200 dark:border-white/10">
                                                                    <nav class="flex space-x-2 rtl:space-x-reverse justify-center" aria-label="Tabs"
                                                                         role="tablist">
                                                                        @foreach($locales as $localeindex => $locale)
                                                                            <button type="button"
                                                                                    class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300 {{$loop->first ? 'active' : ''}}"
                                                                                    id="hs-tab-js-behavior-item-{{$localeindex}}{{$slider->id}}"
                                                                                    data-hs-tab="#hs-tab-js-behavior-{{$localeindex}}{{$slider->id}}"
                                                                                    aria-controls="hs-tab-js-behavior-{{$localeindex}}{{$slider->id}}">
                                                                                {{$locale->abbr}}
                                                                            </button>
                                                                        @endforeach
                                                                    </nav>
                                                                </div>
                                                                @foreach($locales as $localeindex2 =>$locale2)
                                                                    <div id="hs-tab-js-behavior-{{$localeindex2}}{{$slider->id}}"
                                                                         class="{{ !$loop->first ? 'hidden' : '' }}"
                                                                         role="tabpanel" aria-labelledby="hs-tab-js-behavior-item-{{$localeindex2}}{{$slider->id}}"
                                                                         style="padding-top: 15px">
                                                                        <div class="border rounded-ss-none rounded-sm dark:border-white/10 border-gray-200 w-full p-2">
                                                                            <div class="flex rounded-sm w-full">
                                                                        <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                                            Header - {{$locale2->abbr}}
                                                                        </span>
                                                                                <input name="header_{{$locale2->abbr}}"
                                                                                       type="text"
                                                                                       value="{{$slider->getTranslation('slide_header',$locale2->abbr)}}"
                                                                                       class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                                                            </div>
                                                                            <div class="flex rounded-sm w-full  mt-3">
                                                                            <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                                                Annotation - {{$locale2->abbr}}
                                                                            </span>
                                                                                <input name="annotation_{{$locale2->abbr}}"
                                                                                       type="text"
                                                                                       value="{{$slider->getTranslation('slide_annotation',$locale2->abbr)}}"
                                                                                       class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                                                            </div>
                                                                            <div class="flex rounded-sm w-full mt-3">
                                                                                <span class="px-4 inline-flex items-center min-w-fit rounded-s-sm border-e-0 border-gray-200 bg-light text-sm text-gray-500 dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50">
                                                                                    Text - {{$locale2->abbr}}
                                                                                </span>
                                                                                <input name="text_{{$locale2->abbr}}"
                                                                                       type="text"
                                                                                       value="{{$slider->getTranslation('slide_text',$locale2->abbr)}}"
                                                                                       class="py-2 px-3 ti-form-input rounded-none rounded-e-sm focus:z-10 !border-s-0">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                <div class="ti-modal-footer">
                                                                    <button type="button"
                                                                            class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                                                                            data-hs-overlay="#edit_slider{{$index}}">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="ti-btn bg-primary text-white !font-medium">
                                                                        Update
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                              {{--    update image --}}
                                            <form action="{{route('sliders.delete')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="slider_id" value="{{$slider->id}}">
                                                <button style="color:red;font-size: 1.5rem">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection