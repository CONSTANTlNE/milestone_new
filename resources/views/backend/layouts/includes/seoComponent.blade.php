<div class="hidden" id="seo-locale-{{$code}}" role="tabpanel" aria-labelledby="seo-locale-item-{{$code}}">
    <div class="p-5 border rounded-ss-none rounded-sm dark:border-white/10 border-gray-200 seo-section">
        <x-backend.input
            type="text"
            :lang="$lang"
            :data="$data"
            label="seo_title"
            column="seoTitles"
            place-holder="holder_seo_title"
            success-text="success_field"
            help-text="error_field"
            :required="false"
            :disabled="false"
        />

        <x-backend.input
            type="text"
            :lang="$lang"
            :data="$data"
            label="seo_key"
            column="seoKeywords"
            place-holder="holder_seo_key"
            success-text="success_field"
            help-text="error_field"
            :required="false"
            :disabled="false"
        />

        <x-backend.textarea
            :lang="$lang"
            :data="$data"
            label="seo_text"
            column="seoDescriptions"
            place-holder="holder_seo_text"
            success-text="success_field"
            help-text="error_field"
            :required="false"
            :disabled="false"
        />

    </div>
</div>
