<script>
    // Assuming you already have a fileManager function and Modal defined in vanilla JS.
    let imageGroup = null;

    window.addEventListener('DOMContentLoaded', () => {
        const fileManager = createFileManager({
            modal: true,
            fileType: window.anyFileType ?? '',
            folderId: window.folderId ?? '',
            indexRoute: window.indexRoute,
            uploadBehaviour: 'related',
            onSelect: (files) => {
                if (!imageGroup) return;

                const name = imageGroup.dataset.name || 'images[]';
                const multi = imageGroup.dataset.multi !== 'false';
                const siteName = window.location.origin;

                if (files.length > 0) {
                    imageGroup.querySelector('.image-previews').closest('.form-group').style.display = 'block';
                    imageGroup.querySelector('.bxs-file-image').style.display = 'none';
                }

                const previews = imageGroup.querySelector('.image-previews');
                const inputs = imageGroup.querySelector('.selected-image-inputs');

                if (!multi) files = files.slice(0, 1);

                files.forEach(file => {
                    if (!multi) {
                        inputs.innerHTML = '';
                        previews.innerHTML = '';
                    }

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = name;
                    input.value = file.id;
                    inputs.appendChild(input);

                    const previewImage = document.createElement('img');
                    previewImage.className = 'avatar-lg';
                    previewImage.src = file.type === 'image' ? `${siteName}/${file.src}` : `${siteName}/storage/defaults/files.svg`;
                    previewImage.alt = file.title;
                    previewImage.dataset.fancybox = 'gallery';

                    let sel = document.createElement('select');
                    sel.name = 'cover[]';
                    sel.className = 'form-control covers';
                    sel.innerHTML = previews.dataset.type === 'multy' && file.type === 'image'
                        ? '<option value="default">Default</option><option value="slider">Slider</option><option value="cover">Cover</option><option value="versus1">Versus1</option><option value="versus2">Versus2</option><option value="sent">Sent</option><option value="received">Received</option>'
                        : '<option value="general">General</option>';
                    if (previews.dataset.type !== 'multy') sel.style.display = 'none';

                    const li = document.createElement('li');
                    li.className = 'image';
                    li.dataset.id = file.id;
                    li.title = file.title;
                    li.setAttribute('href', `${siteName}/${file.src}`);

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'btn btn-danger btn-circle';
                    btn.dataset.id = file.id;
                    btn.innerHTML = '<i class="fa fa-times"></i>';
                    btn.addEventListener('click', (e) => handleRemove(e, imageGroup));

                    li.appendChild(sel);
                    li.appendChild(btn);
                    li.appendChild(previewImage);
                    previews.appendChild(li);
                });

                bindSortable(previews, inputs, name);
            }
        });

        document.querySelectorAll('.select-media-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                imageGroup = btn.closest('.image-group');
                fileManager.show();
            });
        });
    });

    function handleRemove(e, scopeEl) {
        e.preventDefault();

        const id = e.currentTarget.dataset.id;
        const parent = e.currentTarget.parentElement;

        Modal.show({
            yesClass: 'btn-danger',
            body: 'Are you sure, you want to Remove file?',
            yes: 'Yes',
            callback: (btn) => {
                Modal.hide();
                if (btn === 'yes') {
                    scopeEl.querySelector(`.selected-image-inputs input[value='${id}']`)?.remove();
                    parent.remove();

                    if (!scopeEl.querySelector('.image-previews li')) {
                        scopeEl.querySelector('.image-previews').closest('.form-group').style.display = 'none';
                        scopeEl.querySelector('.bxs-file-image').style.display = 'block';
                    }
                }
            }
        });
    }

    function bindSortable(previewContainer, inputContainer, inputName) {
        new Sortable(previewContainer, {
            handle: 'img',
            onEnd: () => {
                const sorted = Array.from(previewContainer.querySelectorAll('li'))
                    .map(el => el.dataset.id);

                const map = {};
                inputContainer.querySelectorAll(`input[name='${inputName}']`).forEach(input => {
                    map[input.value] = input;
                });

                inputContainer.innerHTML = '';
                sorted.forEach(id => {
                    if (map[id]) inputContainer.appendChild(map[id]);
                });
            }
        });
    }
</script>
