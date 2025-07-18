@extends('backend.layouts.master')
@section('title') {{ __('admin.create_services') }} @endsection
@section('styles')
@vite('public/css/quill-editor.css')
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.create_services') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.services.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.services.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_services') }}
                            </a>
                        </li>
                    @endcan
                    @can('backend.services.trash')
                        <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                            <a href="{{ route('backend.services.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                                <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                                {{__('admin.deleted_services')}}
                            </a>
                        </li>
                    @endcan
                </ol>
            </div>

            @include('backend.layouts.components.errors',[
              'errors' => $errors,
            ])

            <form id="form" method="post" action="{{ route('backend.services.store') }}" novalidate enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-12 gap-6 white-bg">
                    <div class="xl:col-span-9 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                @include('backend.layouts.includes.langTabComponent')
                                <div class="tab-content">
                                    @foreach(getLocales() as $key => $lang)
                                        <div
                                            class="{{($key == 0) ? '' : 'hidden'}}"
                                            id="locale-{{$lang->code}}"
                                            role="tabpanel"
                                            aria-labelledby="locale-item-{{$lang->code}}"
                                        >
                                            @include('backend.layouts.includes.seoLangTabComponent', ['code' => $lang->code, 'service' => true])
                                                @include('backend.layouts.includes.contentComponent', [
                                                    'lang' => $lang,
                                                    'code' => $lang->code,
                                                    'data' => null
                                                ])
                                                @include('backend.layouts.includes.seoComponent', [
                                                    'lang' => $lang,
                                                    'code' => $lang->code,
                                                    'data' => null
                                                ])

                                                @include('backend.layouts.includes.faqComponent', [
                                                    'lang' => $lang,
                                                    'code' => $lang->code,
                                                    'data' => null
                                                ])

                                                @include('backend.layouts.includes.featureComponent', [
                                                    'lang' => $lang,
                                                    'code' => $lang->code,
                                                    'data' => null
                                                ])


                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="box-footer text-end">
                                <button type="submit" class="ti-btn bg-primary text-white font-second-geo">
                                    <i class="ri-add-line"></i>
                                     {{__('admin.create')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="xl:col-span-3 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                    @include('backend.fileManager.layers.both')

                                    <x-backend.publishDate
                                        :data="null"
                                        column="published_at"
                                        label="published_at"
                                        place-holder=""
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="false"
                                        :disabled="false"
                                        :staticData="false"
                                        width="12"
                                    />

                                    <x-backend.selectStatic
                                        :data="config('crm.status')"
                                        column="status"
                                        label="status_type"
                                        place-holder=""
                                        success-text="success_field"
                                        help-text="error_field"
                                        :required="true"
                                        :disabled="false"
                                        :staticData="false"
                                        hidden="show-search-hidden"
                                        width="12"
                                    />

                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    @include('backend.fileManager.templates.file-manager-modal')
@endsection
@push('scripts')
    @vite('public/js/quill-editor.js')
    @include('backend.fileManager.templates.filemanager', ['indexRoute' => route('backend.files.index')])

    <script>
        let locales = @json(['ka','en']);


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


    </script>

@endpush
