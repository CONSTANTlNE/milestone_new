<div class="xxl:col-span-2 xl:col-span-6 lg:col-span-6 md:col-span-6 col-span-12 text-center bg-white border-b border-dashed dark:border-defaultborder/10 file-box file-box-file template">
    <div class="file">
        <span class="corner"></span>
        <div class="icon file-details !inline-flex">
            <div class="transparent"></div>
            <div class="file-format-icon">
                <i class="ri-file-list-3-line"></i>
            </div>
        </div>
        <div class="file-name">
            <span class="document mb-0 font-semibold mb-0 font-semibold text-[.75rem] block px-5 font-second-geo" data-prop="title"></span>
            <small class="mb-0 text-[#8c9097] dark:text-white/50 text-[.625rem] font-second-geo">{{__('admin.added')}} <span data-prop="created_at"></span></small>
        </div>
    </div>
    <div id="allDocModal" data-name></div>
</div>

<div id="docModal" class="docModal">
    <span class="docClose">&times;</span>
    <iframe class="docModal-content" id="doc01" src="" width="100%" height="75%" frameborder="0"></iframe>
    <div id="docCaption"></div>
</div>
