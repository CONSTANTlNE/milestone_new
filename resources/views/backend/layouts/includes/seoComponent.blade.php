<div class="tab-pane" id="seo-locale-{{$code}}" role="tabpanel">
    <x-input
        type="text"
        :lang="$lang"
        :data="$data"
        label="Seo Title"
        column="seoTitles"
        place-holder="Holder Seo Title"
        success-text="Success Field"
        help-text="Error Field"
        :required="false"
        :disabled="false"
    />
    <x-input
        type="text"
        :lang="$lang"
        :data="$data"
        label="Seo Keywords"
        column="seoKeywords"
        place-holder="Holder Seo Keywords"
        success-text="Success Field"
        help-text="Error Field"
        :required="false"
        :disabled="false"
    />

    @include('backend.layouts.components.textarea',
         [
             'lang' => $lang,
             'data' => $data,
             'column' => 'seoDescriptions',
             'label' => 'Seo Text',
             'required' => false,
             'placeHolder' => 'Holder Seo Text',
             'successText' => 'Success Filed',
             'helpText' => 'Error Filed',
        ])
</div>
