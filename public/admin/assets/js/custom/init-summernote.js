function initSummernote(cfg) {
  var height = cfg.height || 300;
  var el = cfg.el;
  if(!el || !el.length) throw "Unable to initialize summernote, html element not found";

  var lastSummernoteContext = null;

  var fileManager = createFileManager({
    modal: true,
    folderId: cfg.folderId,
    indexRoute: cfg.indexRoute,
    uploadBehaviour: 'related',
    onSelect: function (files) {
      $.each(files, function (k, file) {
        if(file.type === 'youtube') {
          var iframe = document.createElement('iframe');
          iframe.width = 560;
          iframe.height = 315;
          iframe.src = 'https://www.youtube.com/embed/' + file.video_id;
          iframe.border = '0';
          iframe.style.border = '0';
          iframe.allow = 'autoplay; encrypted-media';
          iframe.allowfullscreen = 'allowfullscreen';
          lastSummernoteContext.invoke('editor.insertNode', iframe);
        } else {
          var img = document.createElement('img');
          img.src = '/' + file.src;
          img.alt = file.title;
          img.setAttribute('data-fm-association', file.id);

          lastSummernoteContext.invoke('editor.insertNode', img);
        }
      });
    }
  });

  var mediaButton = function (context) {
    lastSummernoteContext = context;
    var ui = $.summernote.ui;

    var button = ui.button({
      contents: '<i class="fa fa-image"></i>',
      tooltip: 'Insert Media',
      click: function () {
        fileManager.show();
      }
    });

    return button.render();   // return button as jquery object
  };

  el.summernote({
    height: height,
    toolbar: [
      ['main', ['style'] ],
      ['fontsize', ['fontsize']],
      ['style', ['clear', 'bold', 'italic', 'underline', 'strikethrough']],
      ['para', ['paragraph', 'ul', 'ol']],
      ['mediaButton', ['mediaButton', 'link']],
      ['view', ['codeview']]
    ],
    styleTags: ['p', 'blockquote', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
    buttons: {
      mediaButton: mediaButton
    }
  });
}