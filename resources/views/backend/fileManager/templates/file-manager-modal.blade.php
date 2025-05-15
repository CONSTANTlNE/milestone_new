<div class="general-modal-fullscreen modal inmodal fade file-manager-modal-template" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen file-manager-modal">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title font-w600 mt-0" id="myModalLabel1">{{ __('strings.File Manager') }}</h5>
          <button type="button" class="btn-general-modal btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>

      <div class="modal-body"></div>

      <div class="modal-footer">
        <button class="modal-close btn btn-primary rounded light deleted-archive ml-3" data-dismiss="modal">{{ __('strings.Close') }}</button>
        <button class="modal-choose btn btn-primary rounded submit-modal-btn">{{ __('strings.Choose') }}</button>
      </div>
    </div>
  </div>
</div>

@include('backend.fileManager.templates.file-manager-board')
