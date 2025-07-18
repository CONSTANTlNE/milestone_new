<div id="eidit_name{{$index}}" class="hs-overlay hidden ti-modal [--overlay-backdrop:static]">
    <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out">
        <div class="ti-modal-content">
            <div class="ti-modal-header">
                <h6 class="modal-title text-[1rem] font-semibold"
                    id="mail-ComposeLabel">Service Name</h6>
                <button type="button"
                        class="hs-dropdown-toggle !text-[1rem] !font-semibold !text-defaulttextcolor"
                        data-hs-overlay="#eidit_name{{$index}}">
                    <span class="sr-only">Close</span>
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <form action="">
                <div class="ti-modal-body px-4">
                    <div class="flex flex-col justify-center align-middle gap-2">
                        @foreach($locales as $locale)
                            <input type="text" name="name_{{$locale->abbr}}"
                                   class="form-control"
                                   value="{{$service->getTranslation('name',$locale->abbr)}}">
                        @endforeach
                    </div>
                </div>
                <div class="ti-modal-footer">
                    <button type="button"
                            class="hs-dropdown-toggle ti-btn  ti-btn-secondary-full align-middle"
                            data-hs-overlay="#eidit_name{{$index}}">
                        Close
                    </button>
                    <button
                            class="ti-btn bg-primary text-white !font-medium">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>