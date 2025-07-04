function createFileManager(cfg) {
  var self = {loaded: false};
  var modalEl;
  var rootEl = $('.file-manager-board-template').clone().removeClass('file-manager-board-template');

  var currentFolder = null;
  var showHiddenFiles = false;
  var isTrash = false;

  if (cfg.modal) {
    modalEl = $('.file-manager-modal-template').clone().removeClass('file-manager-modal-template');
    modalEl.find('.modal-body').append(rootEl);
    $('body').append(modalEl);
  } else {
    cfg.el.append(rootEl);
  }

  var indexRoute = cfg.indexRoute;
  var uploadBehaviour = cfg.uploadBehaviour || 'default';
  var folderId = cfg.folderId || null;

  rootEl.find('.file-manager-input').unbind('change').on("change", function () {
    uploadSelectedFiles(this, 'file');
  });

  $(document).on('click', function () {
    // rootEl.find('.file-box').removeClass('selected');
    hideContextMenu();
  });

  rootEl.find('.i-checks').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
  });

  rootEl.find('input[name="show_hidden_files"]').on('ifChanged', function () {
    showHiddenFiles = this.checked;

    if(showHiddenFiles) {
      rootEl.find('.file-box.hidden-file').show();
    } else {
      rootEl.find('.file-box.hidden-file').hide();
    }
  });

  rootEl.find('.reload-current-folder-btn').unbind('click').click(function () {
    reload(currentFolder ? { folderId: currentFolder.id } : undefined);
  });

  rootEl.find('.file-manager-video-input').unbind('change').on("change", setPreviewImageUrl);

  rootEl.find('.video_link_input').unbind('input').on("input", loadVideoPoster);

  rootEl.find('.file-manager-video-form').submit(function () {
    var imageInput = $(this).find('.file-manager-video-input');
    uploadSelectedFiles(imageInput[0], 'video');
    $(this)[0].reset();
    loadVideoPoster()
  });

  rootEl.find('.file-manager-folder-form').submit(function () {
    var form = $(this);
    var data = form.serializeObject();
    var currentFolderId = getCurrentFolderId();
    data.folderId = currentFolderId;

    request({
      method: 'POST',
      url: indexRoute + '/createFolder',
      data: data,
      loadingEl: $(this),
      callback: function () {
        form[0].reset();
        reload({folderId: currentFolderId});
      }
    });
  });

  rootEl.find('.open-video-form').click(function () {
    showVideoForm();
  });

  rootEl.find('.create-folder-btn').click(function () {
    showFolderForm();
  });

  function showVideoForm() {
    rootEl.find('.file-manager-video-form').show();
    rootEl.find('.file-manager-image-form').hide();
    rootEl.find('.file-manager-folder-form').hide();
  }

  function showImageForm() {
    rootEl.find('.file-manager-image-form').show();
    rootEl.find('.file-manager-video-form').hide();
    rootEl.find('.file-manager-folder-form').hide();
  }

  function showFolderForm() {
    rootEl.find('.file-manager-folder-form').show().find('input[name="name"]').focus();
    rootEl.find('.file-manager-image-form').hide();
    rootEl.find('.file-manager-video-form').hide();
  }

  function GetVimeoIDbyUrl(url) {
    var id = false;
    $.ajax({
      url: 'https://vimeo.com/api/oembed.json?url=' + url,
      async: false,
      success: function (response) {
        if (response.video_id) {
          id = response.video_id;
        }
      }
    });
    return id;
  }

  function loadVideoPoster() {
    if (!$(this).is('input')) return rootEl.find('.file-manager-video-form img').attr('src', 'vendor/freems/img/placeholder.png');
    var el = $(this);
    var url = el.val();
    var imageEl = el.parents('form').find('.img-responsive');
    var youtubeRegXp = /(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/;
    var parentForm = $('.video_link_input').parents('form');
    var fileTypeInput = parentForm.find('.video-type-input').val('');
    var fileIdInput = parentForm.find('.video-id-input').val('');
    var videoId;

    parentForm.addClass('loading-mask');
    if (url.match(youtubeRegXp)) {
      videoId = url.match(youtubeRegXp)[1];
    }

    if (url.toLowerCase().indexOf("youtube.com") >= 0 && videoId) {
      var posterSrc = 'https://img.youtube.com/vi/' + videoId;
      imageEl.attr('src', posterSrc + '/sddefault.jpg');
      fileTypeInput.val('youtube');
      fileIdInput.val(videoId);
      parentForm.removeClass('loading-mask');
    } else if (url.toLowerCase().indexOf("vimeo.com") >= 0) {
      videoId = GetVimeoIDbyUrl(url);
      $.getJSON('https://www.vimeo.com/api/v2/video/' + videoId + '.json?callback=?', {format: "json"}, function (data) {
        var posterSrc = data[0].thumbnail_large;
        fileIdInput.val(videoId);
        imageEl.attr('src', posterSrc);
        fileTypeInput.val('vimeo');
        parentForm.removeClass('loading-mask');
      });

    } else {
      imageEl.attr('src', 'vendor/freems/img/placeholder.png');
      parentForm.removeClass('loading-mask');
    }
  }

  function getCurrentFolderId() {
    return currentFolder && currentFolder.id;
  }

  function uploadSelectedFiles(input, uploadType) {
    var files = input.files;

    var formData = new FormData();
    for (var i = 0; i < files.length; i++) {
      formData.append('files[]', files[i]);
    }

    var currentFolderId = getCurrentFolderId();

    if(uploadBehaviour === 'related') {
      if(folderId) {
        formData.append('folder_id', folderId);
      }
    } else {
      if (currentFolderId) {
        formData.append('folder_id', currentFolderId);
      }
    }

    var loadingEl = rootEl.find('.file-manager-container');
    if (uploadType === 'video') {
      var videoForm = $(input).closest('form');
      loadingEl = videoForm;
      var videoData = videoForm.serializeObject();
      formData.append('video_id', videoData.video_id);
      formData.append('video_type', videoData.type);
    }

    formData.append('upload_type', uploadType);
    formData.append('upload_behaviour', uploadBehaviour);

    request({
      method: 'POST',
      url: indexRoute,
      data: formData,
      processData: false,
      contentType: false,
      loadingEl: loadingEl,
      callback: function (r) {
        reload({folderId: r && r.folder && r.folder.id});
      }
    });
  }

  rootEl.find('.file-manager-image-form button.save-file-btn').unbind('click').click(saveFile);

  function saveFile() {
    var form = rootEl.find('.file-manager-image-form');
    var items = form.data().items;
    var data = form.serializeObject();

    updateAll(0);

    function updateAll(i) {
      var item = items[i];

      request({
        method: 'PUT',
        data: data,
        url: item.url,
        loadingEl: form,
        callback: function (data) {
          var fileEl = rootEl.find('.file-box[data-id="' + data.id + '"]');
          //fillFormData([data]);
          fillFileData(fileEl, data);

          if(i + 1 < items.length) updateAll(i + 1);
        }
      });
    }
  }

  function drawBreadcrumb(list) {
    rootEl.find('.breadcrumb li').remove();

    $.each(list, function (k, item) {
      rootEl.find('.breadcrumb').append(
        $('<li>').data(item).text(item.name).addClass(item.active ? 'active' : '')
      );
    });

    bindBreadcrumbEvents();
  }

  function bindBreadcrumbEvents() {
    rootEl.find('.breadcrumb li').unbind('click').click(function () {
      if ($(this).hasClass('active')) return;
      reload({folderId: $(this).data().id});
    });
  }

  function reload(directory) {
    directory = directory || {};
    var folderId = directory.folderId || null;

    var data = {};
    if (cfg.fileType) {
      rootEl.find('.type-filter-container').hide();
      data.type = cfg.fileType;
    }

    if (folderId) {
      data.folderId = folderId;
    }

    request({
      method: 'GET',
      url: indexRoute,
      data: data,
      loadingEl: rootEl.find('.file-manager-container'),
      callback: function (data) {
        isTrash = (data.currentFolder && data.currentFolder.name === '.trash');

        rootEl.find('.file-manager-container').children().remove();
        rootEl.find('.type-filter-container a:not([data-type="all"])').remove();

        $.each(data.folders, function (k, folder) {
          var folderEl = createFolderElement(folder);
          fillFolderData(folderEl, folder);
          rootEl.find('.file-manager-container').append(folderEl);
        });

        $.each(data.files, function (k, item) {
          var fileEl = createFileElement(item.type);
          fillFileData(fileEl, item);
          rootEl.find('.file-manager-container').append(fileEl);
        });

        drawBreadcrumb(data.breadcrumb);
        currentFolder = data.currentFolder;

        if (!cfg.fileType) {

          $.each(data.fileTypes, function (k, item) {
            var typeFilterEl = createTypeFilterEl(item.type);
            rootEl.find('.type-filter-container').append(typeFilterEl);
          });
          bindTypeFilterEvents();

        }
        bindFileBoxEvents();
        bindFolderBoxEvents();

        self.loaded = true;
      }
    });
  }

  function bindContextMenuEvents() {
    var selectedItems = rootEl.find('.file-box.selected');
    var selectedItemsLength = selectedItems.length;
    if (!selectedItemsLength) return;

    $('.file-manager-contextmenu a.edit-file').unbind('click').click(function () {
      editFile(selectedItems);
    });

      $('.file-manager-contextmenu a.delete-file').unbind('click').click(deleteItems);

      $('.file-manager-contextmenu a.file-url').unbind('click').click(function () {
          alert(5);
          console.log(selectedItems);
          console.log(selectedItemsLength);
      });

      $('.file-manager-contextmenu a.delete-forever').unbind('click').click(function () {
      deleteItems('forever');
    });

    $('.file-manager-contextmenu a.restore-file').unbind('click').click(restoreItems);

    $('.file-manager-contextmenu a.remove-watermark').unbind('click').click(removeWatermark);

    function removeWatermark() {
      Modal.show({
        title: 'Are you sure?',
        yesClass: 'btn-primary',
        yes: 'Remove Watermark',
        no: 'Cancel',
        callback: function (btn) {
          Modal.hide();

          if(btn === 'yes') {
            selectedItems.find('.file').addClass('loading-mask');
            var removed = 0;

            setTimeout(function () {
              $.each(selectedItems, function (k, selectedItem) {
                request({
                  method: 'POST',
                  url: indexRoute + '/removeWatermark/' + $(selectedItem).data().id,
                  callback: function () {
                    removed++;

                    if(removed === selectedItems.length) {
                      reload(currentFolder ? { folderId: currentFolder.id } : undefined);
                    }
                  }
                });
              });
            }, 500);
          }
        }
      });
    }

    function restoreItems() {
      Modal.show({
        title: 'Are you sure?',
        yesClass: 'btn-primary',
        yes: 'Restore',
        no: 'Cancel',
        callback: function (btn) {
          Modal.hide();

          if(btn === 'yes') {
            selectedItems.find('.file').addClass('loading-mask');

            setTimeout(function () {
              $.each(selectedItems, function (k, selectedItem) {
                selectedItem = $(selectedItem);

                if (selectedItem.hasClass('file-box-folder')) {
                  restoreFolder(selectedItem.data().id, function (restored) {
                    if (restored) {
                      selectedItem.remove();
                      reload(currentFolder ? { folderId: currentFolder.id } : undefined);
                    } else {
                      selectedItem.find('.file').removeClass('loading-mask');
                    }
                  });
                } else {
                  restoreFile(selectedItem.data().id, function (restored) {
                    if (restored) selectedItem.remove();
                    else selectedItem.find('.file').removeClass('loading-mask');
                  });
                }
              });
            }, 500);
          }
        }
      });
    }

    function deleteItems(deleteType) {
      Modal.show({
        title: 'Are you sure?',
        yesClass: 'btn-danger',
        yes: 'Delete',
        no: 'Cancel',
        callback: function (btn) {
          Modal.hide();

          if(btn === 'yes') {
            selectedItems.find('.file').addClass('loading-mask');

            setTimeout(function () {
              $.each(selectedItems, function (k, selectedItem) {
                selectedItem = $(selectedItem);

                if (selectedItem.hasClass('file-box-folder')) {
                  deleteFolder(selectedItem.data().id, deleteType, function (deleted) {
                    if (deleted) {
                      selectedItem.remove();
                      reload(currentFolder ? { folderId: currentFolder.id } : undefined);
                    } else {
                      selectedItem.find('.file').removeClass('loading-mask');
                    }
                  });
                } else {
                  deleteFile(selectedItem.data().id, deleteType, function (deleted) {
                    if (deleted) selectedItem.remove();
                    else selectedItem.find('.file').removeClass('loading-mask');
                  });
                }
              });
            }, 500);
          }
        }
      });
    }
  }

  function editFile(items) {
    var data = [];

    $.each(items, function (k, item) {
      data.push($(item).data());
    });

    fillFormData(data);
    showImageForm();
  }

  function createFolderElement() {
    return $('.file-box-folder.template').clone().removeClass('template');
  }

  function createFileElement(type) {
    if (type === 'youtube' || type === 'vimeo') type = 'image';
    if (type !== 'image') type = 'file';
    return $('.file-box-' + type + '.template').clone().removeClass('template');
  }

  function createTypeFilterEl(type) {
    return rootEl.find('.type-filter-container a[data-type="all"]').clone().attr('data-type', type).removeClass('active').text(type);
  }

  function fillFolderData(folderEl, data) {
    folderEl.attr({ 'data-id': data.id, 'data-type': 'folder' }).data(data);

    $.each(data, function (k, v) {
      folderEl.find('[data-prop="' + k + '"]').text(k === 'created_at' ? humanDate(v) : v).attr({title: v});
    });

    if(data.name.match(/^\./)) {
      folderEl.addClass('hidden-file');

      if(!showHiddenFiles) folderEl.hide();
    }
  }

  function fillFileData(fileEl, data) {
    window.LANG = window.LANG || '';
    if(data['caption_' + LANG]) data.caption = data['caption_' + LANG];

    var imageEl;
    fileEl.attr('data-id', data.id).attr('data-type', data.type).data(data);
    if (data.caption) fileEl.attr({title: data.title.substring(0, 500)});
    if (data.type === 'image') {
      imageEl = fileEl.find('.img-responsive');
      imageEl.attr({src: data.src + '?r=' + Math.random(), href: data.src});
      imageEl.addClass('various fancybox');
    }
    if (data.type === 'youtube') {
      fileEl.addClass('video');
      if (data.src) {
        imageEl = fileEl.find('.img-responsive');
        imageEl.attr({src: data.src + '?r=' + Math.random(), href: 'https://www.youtube.com/embed/' + data.video_id});
        imageEl.addClass('various fancybox fancybox.iframe');
      }
      fileEl.find('.file .image').append(
        $('<i>').addClass('fa fa-youtube-play')
      )

    }

    $.each(data, function (k, v) {
      fileEl.find('[data-prop="' + k + '"]').text(k === 'created_at' ? humanDate(v) : v).attr({title: v});
    });
  }

  function humanDate(date) {
    var d = new Date(date);
    return d.format('d F, Y');
  }

  if (cfg.modal) {
    modalEl.find('.modal-footer .submit-modal-btn').unbind('click').click(function () {
      if (cfg.onSelect) {
        var files = [];
        var selectedFiles = rootEl.find('.file-manager-container > .selected');
        $.each(selectedFiles, function (k, selectedFile) {
          if($(selectedFile).hasClass('file-box-file') || $(selectedFile).hasClass('file-box-image')) {
            var data = $(selectedFile).data();
            files.push(data);
          }
        });
        cfg.onSelect(files);
      }

      rootEl.find('.file-manager-container').children().removeClass('selected');

      modalEl.modal('hide');
    });
  }

  function bindFolderBoxEvents() {
    rootEl.find('.file-manager-container .file-box-folder .open-handler').unbind('click').click(function () {
      if(isTrash) return; // Can't open folders in trash

      reload({folderId: $(this).closest('.file-box-folder').data().id});
    });

    bindContextMenuEvents();
  }

  function showContextMenu(event,item) {
    var expandedClass = item.hasClass('file-box-folder') ? '.folders-contextmenu' : '.files-contextmenu';
    var contextMenu = $('.file-manager-contextmenu'+expandedClass);
    var left = event.pageX;
    var top = event.pageY;
    contextMenu.css({left: left, top: top});
    bindContextMenuEvents();
    contextMenu.addClass('visible');

    var isMultiple = rootEl.find('.file-box.selected').length > 1;

    if(isTrash) {
      contextMenu.find('.restore-file, .delete-forever').css({ display: 'block' });
      contextMenu.find('.download-file, .edit-file, .delete-file').css({ display: 'none' });
    } else {
      contextMenu.find('.restore-file, .delete-forever').css({ display: 'none' });
      contextMenu.find('.download-file, .edit-file, .delete-file').css({ display: 'block' });

      contextMenu.find('.download-file').css({ display: isMultiple ? 'none' : 'block' });
    }

    var data = item.data();
    if(!isTrash && data.type === 'image') {
      contextMenu.find('.remove-watermark').css({ display: 'block' });
      contextMenu.find('.download-original').css({ display: 'block' }).attr({ href: indexRoute + '/downloadOriginal/' + data.id });
    } else {
      contextMenu.find('.remove-watermark').css({ display: 'none' });
      contextMenu.find('.download-original').css({ display: 'none' });
    }
  }

  function hideContextMenu() {
    $('.file-manager-contextmenu').removeClass('visible');
    setTimeout(function () {
      $('.file-manager-contextmenu a.download-file').attr({href: 'javascript:;'});
    }, 100);
  }

  $(document).click(function () {
    rootEl.find('.file-manager-container > *').removeClass('selected');
  });

  var lastSelectedFile = null;
  function bindFileBoxEvents() {
    rootEl.find('.file-manager-container .file-box-image, .file-manager-container .file-box-file').unbind('click').click(function (e) {
      var file = $(this);
      hideContextMenu();

      if(e.shiftKey) {
        if(lastSelectedFile) {
          rootEl.find('.file-manager-container > *').removeClass('selected');
          var files = rootEl.find('.file-manager-container').children();
          var from = Math.min(lastSelectedFile.index(), file.index());
          var to = Math.max(lastSelectedFile.index(), file.index());
          for(var i = from; i <= to; i++) {
            files.eq(i).addClass('selected');
          }
        }
      } else if(!e.ctrlKey) {
        rootEl.find('.file-manager-container > *').removeClass('selected');
        file.toggleClass('selected');
      } else {
        file.toggleClass('selected');
      }

      lastSelectedFile = file;
      e.stopPropagation();
    });

    rootEl.find('.file-box.file-box-file,.file-box.file-box-image,.file-box.file-box-folder').contextmenu(function (e) {
      e.preventDefault();

      if(!$(this).hasClass('selected')) {
        rootEl.find('.file-box').removeClass('selected');
        $(this).addClass('selected');
      }

      showContextMenu(e,$(this));
      var selectedFile = rootEl.find('.file-box.selected');

      if (selectedFile.length < 2) {
        $('.file-manager-contextmenu .download-file').attr({href: $(this).data().src, download: ''});
      }
    });

    rootEl.find('.file-box.file-box-file,.file-box.file-box-image').dblclick(function () {
      $(this).find('img.fancybox').click();
    });

    rootEl.find('.file-box-image img').fancybox();
  }

  // TODO: open edit image modal
  /*rootEl.find('form .img-responsive').unbind('click').click(function () {
    var data = $(this).closest('form').data();
    if (data.type !== 'image' || data.extension === 'svg') return;

    $('#edit-image-modal').modal('show');

    var src = $(this).attr('src');
    var image = $('#edit-image-modal .image-crop img');
    image.attr('src', src);

    currentEditingImage = image;
  });*/

  function bindTypeFilterEvents() {
    rootEl.find('.type-filter-container a').unbind('click').click(function () {
      rootEl.find('.type-filter-container a').removeClass('active');
      $(this).addClass('active');
      filterFiles({type: $(this).data().type})
    });
  }

  function filterFiles(filter) {
    if (filter.type === 'all') {
      rootEl.find('.file-manager-container .file-box').show();
    } else {
      rootEl.find('.file-manager-container .file-box').hide();
      rootEl.find('.file-manager-container .file-box[data-type="' + filter.type + '"]').show();
      rootEl.find('.file-manager-container .file-box[data-type="folder"]').show();
    }
  }


  function deleteFolder(id, deleteType, callback) {
    var url = deleteType === 'forever' ? indexRoute + '/deleteFolderForever/' + id : indexRoute + '/deleteFolder/' + id;

    request({
      method: 'DELETE',
      url: url,
      callback: function (data) {
        if (data.deleted) {
          callback && callback(true);
        } else {
          callback && callback(false);

          Modal.show({
            body: (data.error || 'Error') + '<br><br>' + (data.description || ''),
            withoutYes: true,
            no: 'Close'
          });
        }
      },
      onError: function () {
        callback && callback(false);
      }
    });
  }

  function deleteFile(id, deleteType, callback) {
    var url = deleteType === 'forever' ? indexRoute + '/deleteFileForever/' + id : indexRoute + '/' + id;

    request({
      method: 'DELETE',
      url: url,
      callback: function (data) {
        if (data.deleted) {
          callback && callback(true);
        } else {
          callback && callback(false);

          Modal.show({
            body: (data.error || 'Error') + '<br><br>' + (data.description || ''),
            withoutYes: true,
            no: 'Close'
          });
        }
      },
      onError: function () {
        callback && callback(false);
      }
    });
  }

  function restoreFolder(id, callback) {
    request({
      method: 'POST',
      url: indexRoute + '/restoreFolder/' + id,
      callback: function (data) {
        if (data.restored) {
          callback && callback(true);
        } else {
          callback && callback(false);

          Modal.show({
            body: (data.error || 'Error') + '<br><br>' + (data.description || ''),
            withoutYes: true,
            no: 'Close'
          });
        }
      },
      onError: function () {
        callback && callback(false);
      }
    });
  }

  function restoreFile(id, callback) {
    request({
      method: 'POST',
      url: indexRoute + '/restoreFile/' + id,
      callback: function (data) {
        if (data.restored) {
          callback && callback(true);
        } else {
          callback && callback(false);

          Modal.show({
            body: (data.error || 'Error') + '<br><br>' + (data.description || ''),
            withoutYes: true,
            no: 'Close'
          });
        }
      },
      onError: function () {
        callback && callback(false);
      }
    });
  }

  var updatedCropData = null, currentEditingImage = null;
  $('#edit-image-modal .image-crop-btn').click(function () {
    if (updatedCropData) rootEl.find('input[name="crop"]').val(JSON.stringify(updatedCropData));
  });

  $('#edit-image-modal #initCrop').click(function () {
    if (currentEditingImage) cropper(currentEditingImage);
  });

  function cropper($image) {
    $image.cropper("destroy");
    $($image).cropper({
      fillColor: '#fff',
      preview: ".img-preview",
      crop: function (data) {
        updatedCropData = data.detail;
      }
    });

    $("#edit-image-modal #zoomIn").unbind('click').click(function () {
      $image.cropper("zoom", 0.1);
    });

    $("#edit-image-modal #zoomOut").unbind('click').click(function () {
      $image.cropper("zoom", -0.1);
    });

    $("#edit-image-modal #rotateLeft").unbind('click').click(function () {
      $image.cropper("rotate", 90);
    });

    $("#edit-image-modal #rotateRight").unbind('click').click(function () {
      $image.cropper("rotate", -90);
    });
  }

  function setPreviewImageUrl() {
    var imgTag = $(this).prev().find('img');
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        imgTag.attr('src', e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
  }

  function fillFormData(items) {
    var img;

    window.LANG = window.LANG || '';
    for(var i = 0; i < items.length; i++) {
      if(items[i]['caption_' + LANG]) items[i].caption = items[i]['caption_' + LANG];
      if (items[i].type !== 'image' && items[i].type !== 'youtube') items[i].src = 'vendor/freems/img/file-icon.png';
      items[i].url = indexRoute + '/' + items[i].id;
    }

    var form = rootEl.find('.file-manager-image-form');
    form.data().items = items;
    form.find('img').remove();

    $.each(items, function (k, item) {
      img = $('<img />').attr('src', item.src + '?r=' + Math.random()).css({ width: (items.length === 1 ? '100' : '50') + '%' });
      form.find('.image').prepend(img);
    });

    form.find('input[name="title"]').val(items[0].title);
    form.find('input[name="caption"]').val(items[0].caption);
    form.find('input[name="crop"]').val('');
    form.find('input[name="title"]').focus();
  }

  self.show = function () {
    if (modalEl) {
      modalEl.modal('show');
      if (!self.loaded) {
        if (folderId) {
          self.load({folderId: folderId});
        } else {
          self.load();
        }
      }
    }
  };
  self.hide = function () {
    if (modalEl) modalEl.modal('hide');
  };

  self.load = reload;
  self.reload = reload;

  return self;
};
