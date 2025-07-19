<div class="file-manager-contextmenu files-contextmenu">
  <a class="download-file"> <i class="ri-file-download-line"></i><span>{{ __('admin.download_file') }}</span></a>
  <!-- <a class="download-original"> <i class="fa fa-download"></i> <span>{{ __('strings.Download Original') }} </span></a> -->
  <!-- <a class="remove-watermark"> <i class="fa fa-download"></i> <span>{{ __('strings.Remove Watermark') }}</span></a> -->
  <!-- <a class="edit-file"><i class="fas fa-pencil-alt"></i> <span>{{ __('strings.Edit') }}</span></a> -->
    <a class="delete-file font-w600 font-second-geo" data-name="{{ __('admin.delete') }}" data-cancel="{{ __('admin.cancel') }}" data-question="{{ __('admin.question_file_delete') }}" data-text="{{ __('admin.text_file_delete') }}"><i class="ri-delete-bin-line"></i> <span>{{ __('admin.delete') }}</span></a>
    <a class="restore-file font-w600 font-second-geo" data-name="{{ __('admin.restore') }}" data-cancel="{{ __('admin.cancel') }}" data-question="{{ __('admin.question_file_restore') }}" data-text="{{ __('admin.text_file_restore') }}"><i class="ri-arrow-go-forward-line"></i><span>{{ __('admin.file_restore') }}</span></a>
    <a class="delete-forever font-w600 font-second-geo" data-name="{{ __('admin.forever') }}" data-cancel="{{ __('admin.cancel') }}" data-question="{{ __('admin.question_file_forever') }}" data-text="{{ __('admin.text_file_forever') }}"><i class="ri-delete-bin-2-line"></i> <span>{{ __('admin.delete_forever') }}</span></a>
</div>
<div class="file-manager-contextmenu folders-contextmenu">
    <a class="delete-file font-w600 font-second-geo" data-name="{{ __('admin.delete') }}" data-cancel="{{ __('admin.cancel') }}" data-question="{{ __('admin.question_delete') }}" data-text="{{ __('admin.text_delete') }}"><i class="ri-delete-bin-line"></i> <span>{{ __('admin.delete') }}</span></a>
    <a class="restore-file font-w600 font-second-geo" data-name="{{ __('admin.restore') }}" data-cancel="{{ __('admin.cancel') }}" data-question="{{ __('admin.question_restore') }}" data-text="{{ __('admin.text_restore') }}"><i class="ri-arrow-go-forward-line"></i><span>{{ __('admin.folder_restore') }}</span></a>
    <a class="delete-forever font-w600 font-second-geo" data-name="{{ __('admin.forever') }}" data-cancel="{{ __('admin.cancel') }}" data-question="{{ __('admin.question_forever') }}" data-text="{{ __('admin.text_forever') }}"><i class="ri-delete-bin-2-line"></i> <span>{{ __('admin.forever') }}</span></a>
</div>

<div class="modal-error hidden"
     data-cancel="{{ __('admin.error_cancel') }}"
     data-question="{{ __('admin.error_question') }}"
     data-text="{{ __('admin.error_text') }}">
</div>
