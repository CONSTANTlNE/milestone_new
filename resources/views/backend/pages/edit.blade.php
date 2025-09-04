@extends('backend.layouts.master')
@section('title') {{ __('admin.edit_pages') }} @endsection
@section('styles')
    @vite('public/css/quill-editor.css')
@endsection
@section('content')
    <div class="content">
        <div class="main-content">

            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.375rem] font-semibold font-first-geo">{{ __('admin.edit_pages') }}</h3>
                    <p class="font-second-geo text-defaulttextcolor/70">{{ __('admin.welcome') }}</p>
                </div>
                <ol class="flex items-center whitespace-nowrap min-w-0 gap-3 header-nav-links">
                    @can('backend.pages.index')
                        <li class="text-[0.813rem] ps-[0.5rem]">
                            <a href="{{ route('backend.pages.index') }}" class="ti-btn bg-secondary text-white !font-medium font-second-geo">
                                <i class="ri-arrow-go-back-line text-[1.375rem]"></i>
                                {{ __('admin.return_back') }} - {{ __('admin.all_pages') }}
                            </a>
                        </li>
                    @endcan
                    @can('backend.pages.trash')
                        <li class="text-[0.813rem] text-defaulttextcolor font-semibold hover:text-danger dark:text-[#8c9097] dark:text-white/50">
                            <a href="{{ route('backend.pages.trash') }}" class="ti-btn bg-danger text-white !font-medium font-second-geo">
                                <i class="ri-delete-bin-2-line text-[1.375rem]"></i>
                                {{__('admin.deleted_pages')}}
                            </a>
                        </li>
                    @endcan
                </ol>
            </div>

            @include('backend.layouts.components.errors',[
              'errors' => $errors,
            ])

            <form id="form" method="post" action="{{ route('backend.pages.update', $page->id) }}" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                                            @include('backend.layouts.includes.seoLangTabComponent', ['code' => $lang->code, 'page' => true])
                                            @include('backend.layouts.includes.contentComponent', [
                                                'lang' => $lang,
                                                'code' => $lang->code,
                                                'data' => $page
                                            ])

                                            @include('backend.layouts.includes.seoComponent', [
                                                'lang' => $lang,
                                                'code' => $lang->code,
                                                'data' => $page->seo->first()
                                            ])

                                            @include('backend.layouts.includes.tierComponent', [
                                                    'lang' => $lang,
                                                    'code' => $lang->code,
                                                    'data' => $page->tiers
                                                ])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="box-footer text-end">
                                <button type="submit" class="ti-btn bg-primary text-white font-second-geo">
                                    <i class="ri-add-line"></i>
                                    {{__('admin.update')}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="xl:col-span-3 col-span-12">
                        <div class="box">
                            <div class="box-body">
                                @include('backend.fileManager.layers.both', ['item' => $page])

                                <x-backend.publishDate
                                    :data="$page->created_at"
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

                                @if(count($pages))
                                    <div class="mb-3">
                                        <label for="choices-multiple-remove-button" class="px-3 block text-sm text-gray-600 font-medium dark:text-white font-second-geo">{{ __('admin.main_page') }}</label>
                                        <select class="form-control ti-form-select rounded-sm !py-2 !px-3" name="parent_id" id="choices-multiple-remove-button">
                                            @if(!empty($page->rowParent))
                                                <option value="{{$page->rowParent->id}}">{{ __('admin.selected') }} : {{$page->rowParent->title}}</option>
                                                <option value="">{{ __('admin.no_selected') }}</option>
                                            @else
                                                <option value="">{{ __('admin.choose_main_page') }}</option>
                                            @endif
                                            @foreach($pages as $page)
                                                <option value="{{$page->id}}">{{$page->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <x-backend.selectStatic
                                    :data="config('crm.status')"
                                    :choose="$page->status"
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
        let locales = @json(getLocalesCode());
        // Tier
        let tierCount = 0;

        function addTier() {
            tierCount++
            locales.forEach((abbr, index) => {

                const tiertemplate = document.getElementById('tierTemplate' + abbr);
                const tiercontainer = document.getElementById('tierContainer' + abbr);
                const tierclone = tiertemplate.content.cloneNode(true);

                // Add dynamic class to the button
                const tierbutton = tierclone.querySelector('button.removetier');
                tierbutton.dataset.removetier = tierCount;

                tiercontainer.appendChild(tierclone);

                const removetierbtns = document.querySelectorAll('.removetier')

                removetierbtns.forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const tierdataset = btn.dataset
                        const tierselector = `[data-removetier="${tierdataset.removetier}"]`;
                        const tierremovables = document.querySelectorAll(tierselector);
                        tierremovables.forEach((removable) => {
                            removable.parentElement.remove()
                        })
                    })
                })
            });
        }

        function removeExistingtier(id) {
            const existingTiers = document.querySelectorAll(`.existingtier${id}`)
            existingTiers.forEach((tiercontainer) => {
                tiercontainer.remove()
            })
        }
    </script>
@endpush
