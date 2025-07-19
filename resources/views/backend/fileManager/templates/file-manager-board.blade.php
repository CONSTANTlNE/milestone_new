<div class="file-manager-board-template fm-container p-2 gap-2 sm:!flex text-defaulttextcolor text-defaultsize">
    <div class="file-manager-navigation file-manager-wrapper">
        {{-- ფაილ-მენეჯერის სათაური და დამატებით ინფორმაცია--}}
        <div class="file-manager flex items-center justify-between w-full p-4 border-b dark:border-defaultborder/10">
            <div>
                <h6 class="font-semibold mb-0 text-[1rem] text-defaulttextcolor font-first-geo">{{ __('admin.file_manager') }}</h6>
            </div>
            <div class="hs-dropdown ti-dropdown">
                <button class="ti-btn ti-btn-sm ti-btn-primary" aria-label="button" type="button" aria-expanded="false">
                    <i class="ri ri-information-line"></i>
                </button>
                <ul class="hs-dropdown-menu ti-dropdown-menu hidden">
                    <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium font-second-geo" href="javascript:void(0);">დამატებითი ინფორმაცია</a></li>
                </ul>
            </div>
        </div>
        {{-- ფაილების ძებნა --}}
        <div class="none-block p-4 border-b dark:border-defaultborder/10">
            <form action="javascript:;">
                <div class="input-group">
                    <label for="filemanager-search-files-unique" class="hidden">
                        {{ __('admin.search_files') }}
                    </label>
                    <input id="filemanager-search-files-unique" name="search-files" autocomplete="off"  type="text" class="form-control !bg-light border-0 !rounded-s-sm font-second-geo" placeholder="{{ __('admin.search_files') }}" aria-describedby="button-addon2">
                    <button aria-label="button" type="button" class="ti-btn ti-btn-light !rounded-s-none !mb-0" id="button-addon2"><i class="ri-search-line text-[#8c9097] dark:text-white/50"></i></button>
                </div>
            </form>
        </div>
        <div>
            {{-- ფაილის ტიპების ფილტრი image, doc, video და სხვა მუშაობს მხოლოდ ფოლდერებში--}}
            <div class="type-filter-container p-4 border-b dark:border-defaultborder/10">
                <a href="javascript:;" class="file-control font-w600 active"
                   data-type="all">{{ __('admin.all') }}</a>
            </div>

            <ul class="list-none files-main-nav" id="files-main-nav">
                {{-- ფაილის დამატება--}}
                <li class="files-type">
                    <div class="btn-group btn-block">
                        <label title="Upload image file" class="w-full btn-file-upload hs-dropdown-toggle ti-btn !gap-0 !py-2 !px-2 text-[0.75rem] !font-medium bg-secondary text-white flex items-center cursor-pointer justify-center font-second-geo">
                            <div class="me-2">
                                <i class="ri ri-upload-cloud-line align-middle text-[1.25rem] !me-1 text-white"></i>
                            </div>
                            <input type="file" name="files[]" class="hidden file-manager-input" multiple>
                            {{ __('admin.upload_files') }}
                        </label>
                    </div>
                </li>
                {{-- ვიდეოს დამატება მალე...--}}
                <li class="files-type none-block">
                    <div class="btn-group btn-block">
                        <button class="w-full hs-dropdown-toggle ti-btn !gap-0 !py-2 !px-2 text-[0.75rem] !font-medium bg-danger text-white flex items-center justify-center open-video-form">
                            <div class="me-2">
                                <i class="ri ri-video-add-line align-middle text-[1.25rem] !me-1 text-white"></i>
                            </div>
                            {{ __('admin.add_video') }}
                        </button>
                    </div>
                    <form action="javascript:;"
                          class="col-lg-12 file-manager-video-form file-manager-form-no-styles"
                          style="display: none">
                        <label for="upload-video-file" class="w-full hs-dropdown-toggle ti-btn !gap-0 !py-2 !px-2 text-[0.75rem] !font-medium ti-btn-outline-success text-white flex items-center cursor-pointer justify-center font-second-geo"  title="Click and change video poster">
                            <div class="me-2">
                                <i class="ri ri-video-upload-line align-middle text-[1.25rem] !me-1 text-success"></i>
                            </div>
                            <input id="upload-video-file" type="file" name="files[]" class="hidden file-manager-video-input block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50
                                        file:me-4 file:py-2 file:px-4
                                        file:rounded-s-sm file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-primary file:text-white
                                        hover:file:bg-primary focus-visible:outline-none
                                      ">
                            {{ __('admin.upload_video') }}
                        </label>
                        <div class="row">
                            <label for="save-video-full-link" class="mb-0 text-[.75rem] text-defaulttextcolor font-second-geo" style="padding: 5px 0 10px 0;">
                                <span class="px-1 py-1"> {{ __('admin.video_link') }} {{ __('admin.video_link_type') }}</span>
                            </label>
                            <div class="input-group">
                                <input id="save-video-full-link" type="text" name="video_link" autocomplete="off" class="video_link_input form-control !bg-light border-0 !rounded-s-sm font-second-geo" placeholder="{{ __('admin.video_full_link') }}">
                                <input type="hidden" name="type" class="hide video-type-input">
                                <input type="hidden" name="video_id" class="hide video-id-input">
                            </div>
                            <div class="inline-flex rounded-md shadow-sm mb-5 mt-3 w-full">
                                <button type="submit" class="w-full save-file-btn ti-btn-group py-3 px-6 border ti-btn-success border-white/10 dark:border-white/10">
                                    {{ __('admin.save') }}
                                </button>
                                <div class="hide-video-btn ti-btn-group cursor-pointer py-3 px-6 border ti-btn-danger border-white/10 dark:border-white/10">
                                    {{ __('admin.folder_cancel') }}
                                </div>
                            </div>
                        </div>
                    </form>
                </li>
                {{-- ფოლდერის დამატება--}}
                <li class="files-type">
                    <div class="btn-group btn-block">
                        <button class="w-full btn-create-folder create-folder-btn hs-dropdown-toggle ti-btn !gap-0 !py-2 !px-2 text-[0.75rem] !font-medium bg-primary text-white flex items-center justify-center">
                            <div class="me-2">
                                <i class="ri ri-folder-add-line align-middle text-[1.25rem] !me-1 text-white"></i>
                            </div>
                            {{ __('admin.create_folder') }}
                        </button>
                    </div>
                    <form action="javascript:;"
                          class="file-manager-folder-form file-manager-form-no-styles"
                          style="display: none">
                        <label for="create-folder" class="mb-0 text-[.75rem] text-defaulttextcolor font-second-geo" style="padding: 5px 0 10px 0;">
                            <i class="ri ri-folder-2-line text-[1rem]"></i>
                            <span class="px-1 py-1"> {{ __('admin.add_a_new_folder') }}</span>
                        </label>
                        <div class="input-group">
                            <input id="create-folder" type="text" name="name" autocomplete="off" class="form-control !bg-light border-0 !rounded-s-sm font-second-geo" placeholder="{{ __('admin.folder_title') }}">
                        </div>
                        <div class="inline-flex rounded-md shadow-sm mb-5 mt-3">
                            <button type="submit" class="save-folder-btn ti-btn-group py-3 px-6 border ti-btn-primary border-white/10 dark:border-white/10">
                                {{ __('admin.folder_create') }}
                            </button>
                            <div class="hide-folder-btn ti-btn-group cursor-pointer py-3 px-6 border ti-btn-danger border-white/10 dark:border-white/10">
                                {{ __('admin.folder_cancel') }}
                            </div>
                        </div>
                    </form>
                </li>
                {{-- ფაილზე სათაურის დამატება მალე...--}}
                <li class="files-type">
{{--                    <form action="javascript:;"--}}
{{--                          class="col-lg-12 file-manager-image-form file-manager-form-no-styles"--}}
{{--                          style="display: none">--}}
{{--                        <div class="image">--}}
{{--                            <img alt="image" class="img-responsive" data-toggle="modal" src="">--}}
{{--                            <input type="hidden" name="crop" value="">--}}
{{--                        </div>--}}
{{--                        <br>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-xs-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Title:</label>--}}
{{--                                    <input class="form-control" value="file title" name="title">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-xs-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Caption:</label>--}}
{{--                                    <input class="form-control" value="Caption" name="caption">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-xs-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <button type="submit" class="btn btn-primary save-file-btn">Save</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                </li>
                {{-- ფაილ-მენეჯერის მდგომარეობა--}}
                <li class="mb-8 none-block">
                    <div class="text-[#8c9097] dark:text-white/50 mb-2">
                        <p class="mb-1 font-second-geo"><span class="font-bold text-[.875rem]">69.42GB</span> {{ __('admin.used') }}</p>
                        <p class="text-[.75rem] mb-0 font-second-geo">58% {{ __('admin.used') }} - 51.04Gb {{ __('admin.free') }}</p>
                    </div>
                    <div class="progress progress-xs">
                        <div class="progress-bar !bg-info w-[58%]" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="file-manager-folders file-manager-area">
        <div class="flex p-4 flex-wrap gap-2 items-center justify-between border-b dark:border-defaultborder/10">
            <div>
                <ol class="breadcrumb font-second-geo">
                    <li class="active">{{ __('admin.all') }}</li>
                </ol>
            </div>
            <div class="text-right rounded right-sidebar-settings flex gap-4">
                <div class="change-view cursor-pointer text-[.8rem] none-block">
                    <i class="ri ri-file-list-line" title="List View"></i>
                </div>
                <label for="hidden-files-uniques" class="i-checks font-second-geo cursor-pointer">
                    <input id="hidden-files-uniques" type="checkbox" name="show_hidden_files" value="1"> {{ __('admin.hidden_files') }}
                </label>
                <button class="btn btn-sm reload-current-folder-btn">
                    <i class="ri-restart-line" title="reload"></i>
                </button>
            </div>
        </div>
        <div class="p-4 file-folders-container" id="file-folders-container">
            <div class="grid grid-cols-12 gap-x-6 mb-4 file-manager-container">
            </div>
            <div class="file-manager-pagination"></div>
        </div>
    </div>
</div>

@include('backend.fileManager.templates.file-box-folder')
@include('backend.fileManager.templates.file-box-image')
@include('backend.fileManager.templates.file-box-file')
@push('scripts')
    @include('backend.fileManager.templates.file-manager-contextmenu')
    <script src="{{ URL::asset('/js/my/file-manager.js')}}"></script>
@endpush
{{--
ფაილ მენეჯერი
1 - ლისტ ვიუს ჩვენება იკონზე დაჭერისას
2 - სერჩი ფაილებში ჯს ვანილათი
3 - ფაილ მენეჯერის ტევადობა
4 - ვიდეოს ატვირთვა
5 - ფოლდერში მყოფი ფაილების დათვლა
6 - ფოლდერის ტევადობა
7 - იკონების გასწორება ფოლდერებზე
--}}
