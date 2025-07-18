<div class=""
     id="content-locale-{{$code}}"
     role="tabpanel"
     aria-labelledby="content-locale-item-{{$code}}">
    <div class="p-5 border rounded-ss-none rounded-sm dark:border-white/10 border-gray-200 content-section">

        <x-backend.input
            type="text"
            :lang="$lang"
            :data="$data"
            label="title"
            column="title"
            place-holder="holder_title"
            success-text="success_field"
            help-text="error_field"
            :required="true"
            :disabled="false"
        />

        @if(empty($slogan))
        <x-backend.input
            type="text"
            :lang="$lang"
            :data="$data"
            label="short_description"
            column="slogan"
            place-holder="holder_short_description"
            success-text="success_field"
            help-text="error_field"
            :required="false"
            :disabled="false"
        />
        @endif
        @if(!empty($url))
        <x-backend.input
            type="text"
            :lang="$lang"
            :data="$data"
            label="url"
            column="url"
            place-holder="holder_url"
            success-text="success_field"
            help-text="error_field"
            :required="false"
            :disabled="false"
        />
        @endif

        <x-backend.textareaQuill
            :lang="$lang"
            :data="$data"
            :code="$code"
            title="content"
            column="content"
            label="content"
            place-holder="start_writing"
            :required="false"
            :disabled="false"
        />

    </div>
</div>
