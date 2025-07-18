    <div class="filemanager-popup-widgets">
            <div class="sm:flex bg-gray-200 transition dark:bg-black/20 dark:hover:bg-black/20 main-image-header">
                <nav class="flex space-x-2 rtl:space-x-reverse tablist" aria-label="Tabs" role="tablist">
                    <button
                        type="button"
                        class="font-second-geo main-image-button hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300 active"
                        id="main-image-item"
                        data-hs-tab="#main-image"
                        aria-controls="main-image"
                    >
                        {{ __('admin.main_image') }}
                    </button>
                    <button
                        type="button"
                        class="font-second-geo additional-image-button hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-primary dark:hs-tab-active:bg-transparent dark:hs-tab-active:border-b-white/10 dark:hs-tab-active:text-primary -mb-px py-2 px-3 inline-flex items-center gap-2 bg-gray-50 text-sm font-medium text-center border text-defaulttextcolor rounded-t-sm hover:text-primary dark:bg-black/20 dark:border-white/10 dark:text-[#8c9097] dark:text-white/50 dark:hover:text-gray-300"
                        id="additional-image-item"
                        data-hs-tab="#additional-image"
                        aria-controls="additional-image"
                    >
                        {{ __('admin.additional_image') }}
                    </button>
                </nav>
            </div>
            <div class="tab-content pt-3 pb-3 text-muted">
                <div class=""
                     id="main-image"
                     role="tabpanel"
                     aria-labelledby="main-image-item">
                    <div class="text-center">
                        @include('backend.fileManager.templates.fields.image', [
                          'label' => 'main_image',
                          'name' => 'mainImage_id',
                          'item' => $item ?? null,
                          'relation' => 'images'
                        ])
                    </div>
                </div>
                <div class="hidden"
                     id="additional-image"
                     role="tabpanel"
                     aria-labelledby="additional-image-item">
                    <div class="text-center">
                        <?php
                        $imageIds = old('ord') ? explode(',', old('ord')) : [];
                        $images = [];
                        foreach ($imageIds as $imageId) {
                            $images[] = \App\Models\File::where('id', $imageId)->first();
                        }
                        ?>
                        @include('backend.fileManager.templates.fields.images', [
                          'label' => 'additional_image',
                          'itemId' => !empty($item) ? $item->id : null,
                          'imageIds' => !empty($item) ? $item->allImages->pluck('id')->toArray() : old('images') ?? [],
                          'images'   =>  $item->allImages ?? $images
                        ])
                    </div>
                </div>
            </div>
            <div class="file-manager-modal-delete-text hidden" data-question="{{__('admin.file_question')}}" data-text="{{__('admin.file_text')}}" data-name="{{__('admin.delete')}}" data-cancel="{{__('admin.file_cancel')}}"></div>
    </div>

