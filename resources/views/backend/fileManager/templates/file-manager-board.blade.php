<div class="file-manager-board-template">
    <div class="row file-manager-wrapper">

        <div class="col-lg-2 pr-0">
            <div class="p-3 left-file-actions">
                <div class="ibox-content">
                    <div class="file-manager">

                        <h5 class="font-w600">{{ __('strings.File filter') }}</h5>
                        <div class="type-filter-container">
                            <a href="javascript:;" class="file-control font-w600 active"
                               data-type="all">{{ __('strings.All') }}</a>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="btn-group btn-block">
                            <label title="Upload image file" class="btn-file-upload btn btn-primary rounded mb-1">
                                <i class="flaticon-381-upload-1"></i> <input type="file" name="files[]" multiple
                                                                             class="hide file-manager-input"> {{ __('strings.Upload Files') }}
                            </label>
                        </div>
                        <!-- <div class="btn-group btn-block">
              <button class="btn btn-info btn-md waves-effect waves-light mb-1 open-video-form"><i class="fa fa-plus-square"></i>  {{ __('strings.Add a Video') }}</button>
            </div> -->
                        <div class="btn-group btn-block">
                            <button class="btn-create-folder btn btn-warning rounded mb-1 create-folder-btn"><i
                                    class="flaticon-381-add-1"></i> {{ __('strings.Create a Folder') }}</button>
                        </div>
                        <br>
                        {{--ფაილზე სათაურის დამატება მალე...--}}
                        <form action="javascript:;"
                              class="col-lg-12 file-manager-image-form file-manager-form-no-styles"
                              style="display: none">
                            <div class="image">
                                <img alt="image" class="img-responsive" data-toggle="modal" src="">
                                <input type="hidden" name="crop" value="">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Title:</label>
                                        <input class="form-control" value="file title" name="title">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Caption:</label>
                                        <input class="form-control" value="Caption" name="caption">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary save-file-btn">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{--ვიდეოს დამატება მალე...--}}
                        <form action="javascript:;"
                              class="col-lg-12 file-manager-video-form file-manager-form-no-styles"
                              style="display: none">
                            <label class="btn-block" title="Click and change video poster">
                                <div class="image">
                                    <img alt="image" class="img-responsive"
                                         src="{{ URL::asset('/admin/img/placeholder.png')}}">
                                </div>
                                <input type="file" name="files[]" class="hide file-manager-video-input">
                            </label>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Video link:</label>
                                        <input class="form-control video_link_input" autocomplete="off"
                                               name="video_link">
                                        <input type="hidden" name="type" class="hide video-type-input">
                                        <input type="hidden" name="video_id" class="hide video-id-input">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn save-file-btn bg-info">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{--ფოლდერის დამატება--}}
                        <form action="javascript:;"
                              class="col-lg-12 file-manager-folder-form file-manager-form-no-styles"
                              style="display: none">
                            <label class="mb-0">
                                <div class="header-icon icon">
                                    <i class="fa fa-folder"></i> <span> {{ __('strings.Add a new Folder') }}</span>
                                </div>
                            </label>
                            <br>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input class="form-control" name="name" autocomplete="off"
                                           placeholder="{{ __('strings.Folder Title') }}">
                                </div>
                            </div>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn-primary btn-sm font-w600 save-folder-btn">{{ __('strings.Create') }}</button>
                                    <div
                                        class="btn btn-warning btn-sm font-w600 hide-folder-btn">{{ __('strings.Cancel') }}</div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-10 file-manager-area grid-view">
            <div class="col-lg-12 p-4 color-wg">
                <div class="page-haeding">
                    <div class="row">
                        <div class="col-md-8">
                            <ol class="breadcrumb">
                                <li class="active">{{ __('strings.All') }}</li>
                            </ol>
                        </div>
                        <div class="col-md-4 text-right rounded right-sidebar-settings">
                            <label class="change-view">
                                <i class="flaticon-381-list-1"></i>
                            </label>
                            <label>
                                <div class="i-checks"><input type="checkbox" name="show_hidden_files"
                                                             value="1"> {{ __('strings.Hidden Files') }} </div>
                            </label>
                            <button class="btn btn-sm reload-current-folder-btn"><i class="flaticon-381-settings-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 file-manager-container pb-4">
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
