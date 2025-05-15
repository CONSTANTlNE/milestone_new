<script>
    var imageGroup = null;

    $(function () {
        var fileManager = createFileManager({
            modal: true,
            fileType: "{!! @$anyFileType ? 'undefined' : "" !!}",
            folderId: "{{ @$folderId }}",
            indexRoute: "{{ route('backend.files.index', app()->getLocale()) }}",
            uploadBehaviour: 'related',
            onSelect: function (files) {
                var data = imageGroup.data() || {};
                var name = data.name || 'images[]';
                var multi = !(data.multi === false);
                var siteName = $(location).attr('origin');

                if (files.length > 0) {
                    imageGroup.find('.image-previews').parents('.form-group').show();
                    imageGroup.find('.bxs-file-image').hide();
                }

                if(!multi) {
                    files = files.slice(0, 1);
                }

                $.each(files, function (k, file) {
                    if(!multi) {
                        imageGroup.find('.selected-image-inputs input').remove();
                        imageGroup.find('.image-previews li').remove();
                    }

                    imageGroup.find('.selected-image-inputs').append(
                        $('<input>').attr({type: 'hidden', name: name, value: file.id})
                    );

                    var previewImage = file.type === 'image' ?
                        $('<img>').attr({class: 'avatar-lg', src: siteName+'/'+file.src, alt: file.title, href: siteName+'/'+file.src, 'data-fancybox': 'gallery', 'data-holder-rendered':'true'}) :
                        $('<img>').attr({class: 'avatar-lg', src: siteName+'/storage/defaults/files.svg', alt: file.title, href: siteName+'/'+file.src, 'data-fancybox': 'gallery', 'data-holder-rendered':'true'});


                    var sel = "";
                    if(imageGroup.find('.image-previews').attr('data-type') == "multy" && file.type === 'image'){
                        var sel =  "<select name='cover[]' id='covers' class='form-control covers' data-select2-id='covers' tabindex='-1' aria-hidden='true'><option value='default'>Default</option><option value='slider'>Slider</option><option value='cover'>Cover</option><option value='versus1'>Versus1</option><option value='versus2'>Versus2</option><option value='sent'>Sent</option><option value='received'>Received</option></select>";
                    }else{
                        var sel =  "<select name='cover[]' id='covers' class='form-control covers' data-select2-id='covers' tabindex='-1' aria-hidden='true' style='display:none;'><option value='general'>general</option></select>";
                    }

                    imageGroup.find('.image-previews').append(
                        $('<li>').attr({
                            href: siteName+'/'+file.src,
                            title: file.title,
                            'data-id': file.id,
                        }).addClass("image").append(sel).append(
                            $('<button>').addClass('btn btn-danger btn-circle').attr({
                                'data-id': file.id,
                                type: 'button'
                            }).append($('<i>').addClass('fa fa-times')),
                            previewImage
                        ));

                });

                bindEventsOnRemove();
                // bindFancyboxEvenets();
                bindSortableEvents(true);
            }
        });

        $('.select-media-btn').click(function () {
            imageGroup = $(this).closest('.image-group');
            fileManager.show();
        });

        // function bindFancyboxEvenets() {
        //   $('.image-previews li img').fancybox();
        // }

        function bindSortableEvents(rebind) {
            if (rebind) $(".sortable-images").sortable('destroy');
            $(".sortable-images").sortable({
                handle: 'img',
                cancel: '',
                update: function (event, ui) {
                    var scopeEl = $(this).closest('.image-group');
                    var name = scopeEl.data().name || 'images[]';

                    var imageInputs = scopeEl.find("input[name='" + name + "']");
                    var imageInputsById = {};
                    $.each(imageInputs, function (k, input) {
                        imageInputsById[input.value] = input;
                        $(input).remove();
                    });

                    var sortedIds = $(this).closest(".sortable-images").sortable("toArray", {attribute: 'data-id'});
                    $.each(sortedIds, function (k, imageId) {
                        scopeEl.find('.selected-image-inputs').append($(imageInputsById[imageId]));
                    });
                }
            });
        }

        function bindEventsOnRemove() {
            $('.image-previews .image button').click(function (e) {
                var scopeEl = $(this).closest('.image-group');

                e.stopPropagation();
                e.preventDefault();
                var id = $(this).data().id;
                var parent = $(this).parent();

                Modal.show({
                    yesClass: 'btn-danger',
                    body: 'Are you sure, you want to Remove file?',
                    yes: 'Yes',
                    callback: function (btn) {
                        Modal.hide();

                        if (btn === 'yes') {
                            scopeEl.find('.selected-image-inputs input[value="' + id + '"]').remove();
                            parent.remove();
                            if (scopeEl.find('.image-previews li').length < 1) {
                                scopeEl.find('.image-previews').parents('.form-group').hide();
                                scopeEl.find('.bxs-file-image').show();
                            }
                        }
                    }
                });
            })
        }

        // bindFancyboxEvenets();
        bindEventsOnRemove();
        bindSortableEvents();
    })
</script>
