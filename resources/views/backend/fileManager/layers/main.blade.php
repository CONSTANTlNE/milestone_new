<div class="col-md-12">
    <div class="profile-widgets py-3">
        <div class="text-center">
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab" aria-selected="true" style="border: 1px solid #3b5de7;">
                        <span>{{ __('strings.Home') }}</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content pt-3 pb-3 text-muted">
                <div class="tab-pane active" id="home-1" role="tabpanel">
                    <div class="text-center">
                        @include('backend.fileManager.templates.fields.image', [
                          'label' => 'Main Image',
                          'name' => 'mainImage_id',
                          'item' => $item ?? null,
                          'relation' => 'images'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
