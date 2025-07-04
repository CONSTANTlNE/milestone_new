function createFileManager(cfg) {
    const self = {loaded: false};
    const siteName = window.location.origin;
    let currentFolder = null;
    let showHiddenFiles = false;
    let isTrash = false;
    const indexRoute = cfg.indexRoute;
    const uploadBehaviour = cfg.uploadBehaviour || 'default';
    const folderId = cfg.folderId || null;

    // Clone template elements manually - assumes you have HTML templates identified by IDs or classes
    const templateBoard = document.querySelector('.file-manager-board-template');
    const templateModal = document.querySelector('.file-manager-modal-template');
    if (!templateBoard) throw new Error('file-manager-board-template not found in DOM');

    const rootEl = templateBoard.cloneNode(true);
    rootEl.classList.remove('file-manager-board-template');

    let modalEl = null;
    if (cfg.modal) {
        if (!templateModal) throw new Error('file-manager-modal-template not found in DOM');
        modalEl = templateModal.cloneNode(true);
        modalEl.classList.remove('file-manager-modal-template');
        modalEl.querySelector('.modal-body').appendChild(rootEl);
        document.body.appendChild(modalEl);
    } else {
        cfg.el.appendChild(rootEl);
        templateBoard.style.display = 'none';
    }

    // Helper to find elements inside rootEl by selector
    const $ = (selector) => rootEl.querySelector(selector);
    const $$ = (selector) => [...rootEl.querySelectorAll(selector)];

    // Toggle view button
    const changeViewBtn = $('.change-view');
    if (changeViewBtn) {
        changeViewBtn.addEventListener('click', () => {
            const area = document.querySelector('.file-manager-area');
            if (!area) return;

            if (area.classList.contains('list-view')) {
                area.classList.remove('list-view');
                area.classList.add('grid-view');
            } else {
                area.classList.remove('grid-view');
                area.classList.add('list-view');
            }
        });
    }

    // File input change handler to upload files
    const fileInput = rootEl.querySelector('.file-manager-input');
    if (fileInput) {
        fileInput.addEventListener('change', (e) => {
            uploadSelectedFiles(e.target, 'file');
        });
    }

    // Document click hides context menu
    document.addEventListener('click', () => {
        // rootEl.querySelectorAll('.file-box').forEach(el => el.classList.remove('selected'));
        hideContextMenu();
    });

    // Show hidden files checkbox
    const showHiddenCheckbox = rootEl.querySelector('input[name="show_hidden_files"]');
    if (showHiddenCheckbox) {
        showHiddenCheckbox.addEventListener('click', (e) => {
            showHiddenFiles = e.target.checked;
            const hiddenFiles = rootEl.querySelectorAll('.file-box.hidden-file');
            hiddenFiles.forEach(el => el.style.display = showHiddenFiles ? '' : 'none');
        });
    }

    // Reload current folder button
    const reloadBtn = rootEl.querySelector('.reload-current-folder-btn');
    if (reloadBtn) {
        reloadBtn.addEventListener('click', () => {
            reload(currentFolder ? {folderId: currentFolder.id} : undefined);
        });
    }

    // Video input change handler
    const videoInput = rootEl.querySelector('.file-manager-video-input');
    if (videoInput) {
        videoInput.addEventListener('change', setPreviewImageUrl);
    }

    // Video link input event
    const videoLinkInput = rootEl.querySelector('.video_link_input');
    if (videoLinkInput) {
        videoLinkInput.addEventListener('input', loadVideoPoster);
    }

    // Video form submit
    const videoForm = rootEl.querySelector('.file-manager-video-form');
    if (videoForm) {
        videoForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const imageInput = videoForm.querySelector('.file-manager-video-input');
            uploadSelectedFiles(imageInput, 'video');
            videoForm.reset();
            loadVideoPoster();
        });
    }
    const folderForm = rootEl.querySelector('.file-manager-folder-form');
    if (folderForm) {
        folderForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const inputText = folderForm.querySelector('input[type="text"]');
        if (!inputText) return;

        const currentFolderId = getCurrentFolderId();
        const data = {
            name: inputText.value,
            folderId: currentFolderId
        };

        try {
            const response = await fetch(indexRoute + '/createFolder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify(data),
                credentials: 'same-origin'
            });
            const resData = await response.json();

            if (resData.created) {
                inputText.value = '';
                folderForm.style.display = 'none';
                await reload({folderId: currentFolderId});
            } else {
                inputText.value = '';
                folderForm.style.display = 'none';
                const title = document.querySelector('.modal-error').dataset.question || 'Are you sure?';
                const text = document.querySelector('.modal-error').dataset.text || '...';
                const yes = '';
                const no = document.querySelector('.modal-error').dataset.cancel || 'Cancel';
                Modal.show({
                    body: (resData.error || 'Error') + '<br><br>' + (resData.description || ''),
                    withoutYes: true,
                    title,
                    text,
                    yes,
                    no,
                    yesClass : '',
                });
            }
        } catch (error) {
            await reload();
        }
    });
}
    // Show/hide video form
    const openVideoFormBtn = rootEl.querySelector('.open-video-form');
    if (openVideoFormBtn) {
        openVideoFormBtn.addEventListener('click', showVideoForm);
    }

    // Show folder form button
    const createFolderBtn = rootEl.querySelector('.create-folder-btn');
    if (createFolderBtn) {
        createFolderBtn.addEventListener('click', showFolderForm);
    }

    // Hide folder form button
    const hideFolderBtn = rootEl.querySelector('.hide-folder-btn');
    if (hideFolderBtn) {
        hideFolderBtn.addEventListener('click', () => {
            folderForm.style.display = 'none';
        });
    }

    // Show forms helpers
    function showVideoForm() {
        if (!rootEl) return;
        const videoFormEl = rootEl.querySelector('.file-manager-video-form');
        const imageFormEl = rootEl.querySelector('.file-manager-image-form');
        const folderFormEl = rootEl.querySelector('.file-manager-folder-form');
        if (videoFormEl) videoFormEl.style.display = '';
        if (imageFormEl) imageFormEl.style.display = 'none';
        if (folderFormEl) folderFormEl.style.display = 'none';
    }

    function showImageForm() {
        if (!rootEl) return;
        const videoFormEl = rootEl.querySelector('.file-manager-video-form');
        const imageFormEl = rootEl.querySelector('.file-manager-image-form');
        const folderFormEl = rootEl.querySelector('.file-manager-folder-form');
        if (videoFormEl) videoFormEl.style.display = 'none';
        if (imageFormEl) imageFormEl.style.display = '';
        if (folderFormEl) folderFormEl.style.display = 'none';
    }

    function showFolderForm() {
        if (!rootEl) return;
        const folderFormEl = rootEl.querySelector('.file-manager-folder-form');
        const imageFormEl = rootEl.querySelector('.file-manager-image-form');
        const videoFormEl = rootEl.querySelector('.file-manager-video-form');
        if (folderFormEl) {
            folderFormEl.style.display = '';
            const input = folderFormEl.querySelector('input[name="name"]');
            if (input) input.focus();
        }
        if (imageFormEl) imageFormEl.style.display = 'none';
        if (videoFormEl) videoFormEl.style.display = 'none';
    }

    // Helper to get current folder id
    function getCurrentFolderId() {
        return currentFolder ? currentFolder.id : null;
    }

    // Get CSRF token helper
    function getCsrfToken() {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        return tokenMeta ? tokenMeta.getAttribute('content') : '';
    }

    // Vimeo ID fetch (async)
    async function getVimeoIDbyUrl(url) {
        try {
            const response = await fetch(`https://vimeo.com/api/oembed.json?url=${encodeURIComponent(url)}`, {
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            });
            if (!response.ok) return false;
            const data = await response.json();
            return data.video_id || false;
        } catch {
            return false;
        }
    }

    function loadVideoPoster(event) {
        // 'this' replaced by event target
        const el = event ? event.target : null;

        if (!el || el.tagName.toLowerCase() !== 'input') {
            const img = rootEl.querySelector('.file-manager-video-form img');
            if (img) img.src = `${siteName}/admin/img/placeholder.png`;
            return;
        }

        const url = el.value.trim();
        const form = el.closest('form');
        if (!form) return;

        const imageEl = form.querySelector('.img-responsive');
        const youtubeRegXp = /(?:https?:\/\/)?(?:www\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/;
        const fileTypeInput = form.querySelector('.video-type-input');
        const fileIdInput = form.querySelector('.video-id-input');

        form.classList.add('loading-mask');

        let videoId = null;

        const lowerUrl = url.toLowerCase();

        const matchYoutube = url.match(youtubeRegXp);
        if (lowerUrl.includes("youtube.com") && matchYoutube) {
            videoId = matchYoutube[1];
            if (imageEl) imageEl.src = `https://img.youtube.com/vi/${videoId}/sddefault.jpg`;
            if (fileTypeInput) fileTypeInput.value = 'youtube';
            if (fileIdInput) fileIdInput.value = videoId;
            form.classList.remove('loading-mask');
            return;
        } else if (lowerUrl.includes("vimeo.com")) {
            // Async Vimeo thumbnail fetch
            getVimeoIDbyUrl(url).then(vimeoId => {
                if (!vimeoId) {
                    resetPoster();
                    return;
                }
                fetch(`https://vimeo.com/api/v2/video/${vimeoId}.json`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data || !data[0] || !data[0].thumbnail_large) {
                            resetPoster();
                            return;
                        }
                        if (fileIdInput) fileIdInput.value = vimeoId;
                        if (imageEl) imageEl.src = `${siteName}/${data[0].thumbnail_large}`;
                        if (fileTypeInput) fileTypeInput.value = 'vimeo';
                        form.classList.remove('loading-mask');
                    }).catch(() => {
                    resetPoster();
                });
            });
        } else {
            resetPoster();
        }

        function resetPoster() {
            if (imageEl) imageEl.src = `${siteName}/admin/img/placeholder.png`;
            if (fileTypeInput) fileTypeInput.value = '';
            if (fileIdInput) fileIdInput.value = '';
            form.classList.remove('loading-mask');
        }
    }
    function getCurrentFolderId() {
        return currentFolder ? currentFolder.id : null;
    }
    function uploadSelectedFiles(input, uploadType) {
        const files = input.files;
        if (!files.length) return;

        const formData = new FormData();
        for (const file of files) {
            formData.append('files[]', file);
        }

        const currentFolderId = folderId || getCurrentFolderId();
        if (currentFolderId) {
            formData.append('folder_id', currentFolderId);
        }
        formData.append('upload_behaviour', uploadBehaviour);
        let loadingEl = rootEl.querySelector('.file-manager-container');

        if (uploadType === 'video') {
            const videoForm = input.closest('form');
            if (videoForm) {
                loadingEl = videoForm;

                const videoId = videoForm.querySelector('.video-id-input')?.value || '';
                const videoType = videoForm.querySelector('.video-type-input')?.value || '';

                formData.append('video_id', videoId);
                formData.append('video_type', videoType);
            }
        }
        const url = indexRoute + '/store';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken() // ✅ CSRF token only
            },
            body: formData,
            credentials: 'same-origin',
        })

            .then(async (res) => {
                const contentType = res.headers.get('content-type') || '';
                const raw = await res.json();
                const data = raw;
                reload(data?.folder?.id ? { folderId: data.folder.id } : undefined);
            })
            .catch((err) => {
                console.error('Upload error:', err);
            });
    }
    function saveFile() {
        const form = rootEl.querySelector('.file-manager-image-form');
        if (!form) return;

        const items = form._items || [];
        // Fallback if you used jQuery .data('items'), replaced by _items here
        // Make sure you assign form._items = items when setting items data

        const data = serializeForm(form);

        function updateAll(i = 0) {
            if (i >= items.length) return;

            const item = items[i];
            fetch(item.url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: JSON.stringify(data),
                credentials: 'same-origin',
            }).then(res => res.json())
                .then(data => {
                    const fileEl = rootEl.querySelector(`.file-box[data-id="${data.id}"]`);
                    if (fileEl) fillFileData(fileEl, data);

                    updateAll(i + 1);
                }).catch(console.error);
        }

        updateAll();
    }
    function serializeForm(form) {
        const obj = {};
        const elements = form.elements;
        for (const el of elements) {
            if (!el.name || el.disabled) continue;
            if ((el.type === 'checkbox' || el.type === 'radio') && !el.checked) continue;
            if (obj[el.name] !== undefined) {
                if (!Array.isArray(obj[el.name])) obj[el.name] = [obj[el.name]];
                obj[el.name].push(el.value);
            } else {
                obj[el.name] = el.value;
            }
        }
        return obj;
    }
    function drawBreadcrumb(list) {
        const breadcrumb = rootEl.querySelector('.breadcrumb');
        if (!breadcrumb) return;

        breadcrumb.innerHTML = '';

        list.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item.name;
            if (item.active) li.classList.add('active');
            li._data = item; // store data on element for event
            breadcrumb.appendChild(li);
        });

        bindBreadcrumbEvents();
    }
    function bindBreadcrumbEvents() {
        const breadcrumbItems = rootEl.querySelectorAll('.breadcrumb li');
        breadcrumbItems.forEach(li => {
            li.onclick = () => {
                if (li.classList.contains('active')) return;
                const folderId = li._data?.id;
                if (folderId !== undefined) {
                    reload({folderId});
                }
            };
        });
    }
    async function reload(directory = {}, page) {
        if (directory.folderId === 0) {
            const paginationContainer = document.querySelector('.file-manager-pagination');
            if (paginationContainer) paginationContainer.innerHTML = '';
        }

        const folderIdLocal = directory.folderId || null;

        const data = {};
        if (cfg.fileType) {
            const typeFilterContainer = rootEl.querySelector('.type-filter-container');
            if (typeFilterContainer) typeFilterContainer.style.display = 'none';
            data.type = cfg.fileType;
        }

        if (folderIdLocal) data.folderId = folderIdLocal;

        try {
            const params = new URLSearchParams();
            if (page) params.set('page', page);
            for (const [key, value] of Object.entries(data)) {
                params.set(key, value);
            }
            const requestUrl = `${indexRoute}?${params.toString()}`;

            const response = await fetch(requestUrl, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest', // 👈 add this line!
                    'Accept': 'application/json'
                },
                data: data,
                credentials: 'same-origin',
            });
            const dataResp = await response.json();

            if (dataResp.currentFolder && dataResp.currentFolder.id !== 0) {
                displayPaginationLinks(dataResp.files, dataResp.currentFolder);
            }

            if (Array.isArray(dataResp.folders)) {
                dataResp.folders.sort((a, b) => b.id - a.id);
            }
            if (Array.isArray(dataResp.files?.data)) {
                dataResp.files.data.sort((a, b) => b.id - a.id);
            }

            isTrash = (dataResp.currentFolder?.name === 'trash');

            const container = rootEl.querySelector('.file-manager-container');
            if (container) {
                container.innerHTML = '';
                const typeFilterContainer = rootEl.querySelector('.type-filter-container');
                if (typeFilterContainer) {
                    // Remove all except data-type="all"
                    const toRemove = [...typeFilterContainer.querySelectorAll('a:not([data-type="all"])')];
                    toRemove.forEach(el => el.remove());
                }

                // Append folders
                dataResp.folders.forEach(folder => {
                    const folderEl = createFolderElement(folder);
                    fillFolderData(folderEl, folder);
                    container.appendChild(folderEl);
                });

                // Append files
                if (dataResp.files?.data) {
                    dataResp.files.data.forEach(item => {
                        const fileEl = createFileElement(item.type);
                        fillFileData(fileEl, item);
                        container.appendChild(fileEl);
                    });
                }
            }

            drawBreadcrumb(dataResp.breadcrumb);
            currentFolder = dataResp.currentFolder;

            if (!cfg.fileType) {
                // Append file type filters
                if (dataResp.fileTypes) {
                    const typeFilterContainer = rootEl.querySelector('.type-filter-container');
                    if (typeFilterContainer) {
                        dataResp.fileTypes.forEach(item => {
                            const typeFilterEl = createTypeFilterEl(item.type);
                            typeFilterContainer.appendChild(typeFilterEl);
                        });
                    }
                }
                bindTypeFilterEvents();
            }

            bindFileBoxEvents();
            bindFolderBoxEvents();

            self.loaded = true;
        } catch (err) {
            console.error(err);
        }
    }
    function displayPaginationLinks(pagination, folder) {
        if (!folder || !folder.id) return;

        const paginationContainer = document.querySelector('.file-manager-pagination');
        if (!paginationContainer) return;

        paginationContainer.innerHTML = ''; // Clear previous pagination

        if (folder.id === 0) {
            // No pagination if folder ID is 0
            paginationContainer.innerHTML = '';
            return;
        }

        if (!pagination || pagination.last_page <= 1) {
            // Only one or no page - no pagination shown
            return;
        }

        const ul = document.createElement('ul');
        ul.className = 'pagination';

        // Previous Page Link
        const prevLi = document.createElement('li');
        prevLi.className = 'page-item' + (pagination.prev_page_url ? '' : ' disabled');
        const prevA = document.createElement('a');
        prevA.className = 'page-link page-link-prev';
        prevA.href = '#';
        if (pagination.prev_page_url) prevA.dataset.page = pagination.current_page - 1;
        prevLi.appendChild(prevA);
        ul.appendChild(prevLi);

        // Pages range and ellipsis
        const numPagesBeforeCurrent = 3;
        const numPagesAfterCurrent = 3;
        let ellipsisInsertedStart = false;
        let ellipsisInsertedEnd = false;

        for (let i = 1; i <= pagination.last_page; i++) {
            if (
                i === 1 ||
                i === pagination.last_page ||
                i === pagination.current_page ||
                (i >= pagination.current_page - numPagesBeforeCurrent && i <= pagination.current_page + numPagesAfterCurrent)
            ) {
                const li = document.createElement('li');
                li.className = 'page-item' + (pagination.current_page === i ? ' active' : '');
                if (pagination.current_page === i) li.id = 'pageNumber';

                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.dataset.page = i;
                a.textContent = i;

                li.appendChild(a);
                ul.appendChild(li);

                ellipsisInsertedStart = false;
                ellipsisInsertedEnd = false;
            } else {
                if (!ellipsisInsertedStart && i < pagination.current_page - numPagesBeforeCurrent) {
                    const li = document.createElement('li');
                    li.className = 'page-item';
                    const a = document.createElement('a');
                    a.className = 'page-link';
                    a.textContent = '...';
                    li.appendChild(a);
                    ul.appendChild(li);
                    ellipsisInsertedStart = true;
                }
                if (!ellipsisInsertedEnd && i > pagination.current_page + numPagesAfterCurrent) {
                    const li = document.createElement('li');
                    li.className = 'page-item';
                    const a = document.createElement('a');
                    a.className = 'page-link';
                    a.textContent = '...';
                    li.appendChild(a);
                    ul.appendChild(li);
                    ellipsisInsertedEnd = true;
                }
            }
        }

        // Next Page Link
        const nextLi = document.createElement('li');
        nextLi.className = 'page-item' + (pagination.next_page_url ? '' : ' disabled');
        const nextA = document.createElement('a');
        nextA.className = 'page-link page-link-next';
        nextA.href = '#';
        if (pagination.next_page_url) nextA.dataset.page = pagination.current_page + 1;
        nextLi.appendChild(nextA);
        ul.appendChild(nextLi);

        paginationContainer.appendChild(ul);

        // Event delegation for pagination links
        ul.addEventListener('click', (event) => {
            event.preventDefault();
            const target = event.target.closest('a.page-link');
            if (!target || !target.dataset.page) return;

            const page = parseInt(target.dataset.page);
            if (isNaN(page)) return;

            const folderId = folder.id ? {folderId: folder.id} : undefined;
            reload(folderId, page);
        });
    }
    function bindContextMenuEvents() {
        const selectedItems = Array.from(rootEl.querySelectorAll('.file-box.selected'));
        if (!selectedItems.length) return;

        const contextMenu = document.querySelector('.file-manager-contextmenu.folders-contextmenu.visible') ||
            document.querySelector('.file-manager-contextmenu.files-contextmenu.visible');

        if (!contextMenu) return;
        const onEditClick = () => editFile(selectedItems);
        const onFileUrlClick = () => {
            const firstItem = selectedItems[0];
            if (!firstItem) return;

            const filePath = firstItem.dataset.src;
            const site = window.location.origin;
            const fullURL = `${site}/${filePath}`;

            navigator.clipboard.writeText(fullURL).then(() => {
                console.log("File URL copied to clipboard!");
            }).catch(() => {
                console.error("Failed to copy");
            });
        };
        const onDeleteClick = (e) => {
            const el = e.currentTarget;

            const title = el.dataset.question || 'Are you sure?';
            const text = el.dataset.text || '...';
            const yes = el.dataset.name || 'Delete';
            const no = el.dataset.cancel || 'Cancel';

            deleteItems(null, { title, text, yes, no, yesClass: 'ti-btn-danger' });
        };
        const onDeleteForeverClick = (e) => {
            const el = e.currentTarget;
            const title = el.dataset.question || 'Are you sure?';
            const text = el.dataset.text || '...';
            const yes = el.dataset.name || 'Delete';
            const no = el.dataset.cancel || 'Cancel';

            deleteItems('forever', {title, text, yes, no, yesClass: 'ti-btn-danger'});
        };
        const onRestoreClick = (e) => {
            const el = e.currentTarget;

            const title = el.dataset.question || 'Are you sure?';
            const text = el.dataset.text || '...';
            const yes = el.dataset.name || 'Delete';
            const no = el.dataset.cancel || 'Cancel';

            restoreItems({title, text, yes, no, yesClass: 'ti-btn-secondary'});
        }
        const onRemoveWatermarkClick = () => removeWatermark();

        // Clear previous listeners to avoid duplicates
        clearEventListeners(contextMenu, 'a.edit-file', onEditClick);
        clearEventListeners(contextMenu, 'a.file-url', onFileUrlClick);
        clearEventListeners(contextMenu, 'a.delete-file', onDeleteClick);
        clearEventListeners(contextMenu, 'a.delete-forever', onDeleteForeverClick);
        clearEventListeners(contextMenu, 'a.restore-file', onRestoreClick);
        clearEventListeners(contextMenu, 'a.remove-watermark', onRemoveWatermarkClick);

        contextMenu.querySelector('a.edit-file')?.addEventListener('click', onEditClick);
        contextMenu.querySelector('a.file-url')?.addEventListener('click', onFileUrlClick);
        contextMenu.querySelector('a.delete-file')?.addEventListener('click', onDeleteClick);
        contextMenu.querySelector('a.delete-forever')?.addEventListener('click', onDeleteForeverClick);
        contextMenu.querySelector('a.restore-file')?.addEventListener('click', onRestoreClick);
        contextMenu.querySelector('a.remove-watermark')?.addEventListener('click', onRemoveWatermarkClick);
        function removeWatermark() {
            Modal.show({
                title: 'Are you sure?',
                yesClass: 'btn-primary',
                yes: 'Remove Watermark',
                no: 'Cancel',
                callback(btn) {
                    Modal.hide();

                    if (btn === 'yes') {
                        selectedItems.forEach(item => {
                            item.querySelector('.file').classList.add('loading-mask');
                        });

                        let removed = 0;
                        setTimeout(() => {
                            selectedItems.forEach(item => {
                                fetch(`${indexRoute}/removeWatermark/${item.dataset.id}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': getCsrfToken(),
                                    },
                                    credentials: 'same-origin',
                                }).then(() => {
                                    removed++;
                                    if (removed === selectedItems.length) {
                                        reload(currentFolder ? {folderId: currentFolder.id} : undefined);
                                    }
                                }).catch(() => {
                                    // Handle error if needed
                                });
                            });
                        }, 500);
                    }
                }
            });
        }
        function restoreItems(modalOptions = {}) {
            const {
                title = 'Are you sure?',
                text = '',
                yes = 'Restore',
                no = 'Cancel',
                yesClass = 'ti-btn-secondary',
            } = modalOptions;
            Modal.show({
                title,
                text,
                yes,
                no,
                yesClass,
                callback(btn) {
                    Modal.hide();

                    if (btn === 'yes') {
                        selectedItems.forEach(item => {
                            item.querySelector('.file').classList.add('loading-mask');
                        });

                        setTimeout(() => {
                            selectedItems.forEach(item => {
                                if (item.classList.contains('file-box-folder')) {
                                    restoreFolder(item.dataset.id, restored => {
                                        if (restored) {
                                            item.remove();
                                            reload(currentFolder ? {folderId: currentFolder.id} : undefined);
                                        } else {
                                            item.querySelector('.file').classList.remove('loading-mask');
                                        }
                                    });
                                } else {
                                    restoreFile(item.dataset.id, restored => {
                                        if (restored) {
                                            item.remove();
                                            reload(currentFolder ? {folderId: currentFolder.id} : undefined);
                                        } else {
                                            item.querySelector('.file').classList.remove('loading-mask');
                                        }
                                    });
                                }
                            });
                        }, 500);
                    }
                }
            });
        }
        function deleteItems(deleteType, modalOptions = {}) {
            const {
                title = 'Are you sure?',
                text = '',
                yes = 'Delete',
                no = 'Cancel',
                yesClass = 'ti-btn-danger',
            } = modalOptions;

            Modal.show({
                title,
                text,
                yes,
                no,
                yesClass,
                callback(btn) {
                    Modal.hide();

                    if (btn === 'yes') {
                        selectedItems.forEach(item => {
                            item.querySelector('.file').classList.add('loading-mask');
                        });

                        setTimeout(() => {
                            selectedItems.forEach(item => {
                                if (item.classList.contains('file-box-folder')) {
                                    deleteFolder(item.dataset.id, deleteType, deleted => {
                                        if (deleted) {
                                            item.remove();
                                            reload(currentFolder ? {folderId: currentFolder.id} : undefined);
                                        } else {
                                            item.querySelector('.file').classList.remove('loading-mask');
                                        }
                                    });
                                } else {
                                    deleteFile(item.dataset.id, deleteType, deleted => {
                                        if (deleted) item.remove();
                                        else item.querySelector('.file').classList.remove('loading-mask');
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
        const data = items.map(item => item.dataset);
        fillFormData(data);
        showImageForm();
    }
    function createFolderElement() {
        const template = document.querySelector('.file-box-folder.template');
        if (!template) return null;
        const clone = template.cloneNode(true);
        clone.classList.remove('template');
        return clone;
    }
    function createFileElement(type) {
        if (type === 'youtube' || type === 'vimeo') type = 'image';
        if (type !== 'image') type = 'file';
        const template = document.querySelector(`.file-box-${type}.template`);
        if (!template) return null;
        const clone = template.cloneNode(true);
        clone.classList.remove('template');
        return clone;
    }
    function createTypeFilterEl(type) {
        const allFilter = rootEl.querySelector('.type-filter-container a[data-type="all"]');
        if (!allFilter) return null;
        const clone = allFilter.cloneNode(true);
        clone.dataset.type = type;
        clone.classList.remove('active');
        clone.textContent = type;
        return clone;
    }
    function fillFolderData(folderEl, data) {
        if (!folderEl) return;
        folderEl.dataset.id = data.id;
        folderEl.dataset.type = 'folder';

        // Remove any previous data-* attributes set by jQuery.data (optional)

        for (const [key, value] of Object.entries(data)) {
            const el = folderEl.querySelector(`[data-prop="${key}"]`);
            if (el) {
                el.textContent = (key === 'created_at') ? humanDate(value) : value;
                el.title = value;
            }
        }

        if (/^\./.test(data.name)) {
            folderEl.classList.add('hidden-file');
            if (!showHiddenFiles) {
                folderEl.style.display = 'none';
            }
        } else {
            folderEl.classList.remove('hidden-file');
            folderEl.style.display = '';
        }
    }
    function clearEventListeners(container, selector, handler) {
        const el = container.querySelector(selector);
        if (!el) return;
        el.removeEventListener('click', handler);
    }
    function fillFileData(fileEl, data) {
        window.LANG = window.LANG || '';
        if (data['caption_' + window.LANG]) data.caption = data['caption_' + window.LANG];

        // Set data attributes and store full data on the element
        fileEl.dataset.id = data.id;
        fileEl.dataset.type = data.type;
        fileEl._data = data; // store the full data object on element for reference

        if (data.caption) {
            fileEl.title = data.title.substring(0, 500);
        }

        const siteUrl = siteName + '/';

        if (data.type === 'image') {
            const fullImage = siteUrl + data.src;
            const imageEl = fileEl.querySelector('.img-responsive');
            if (imageEl) {
                imageEl.src = fullImage + '?r=' + Math.random();
                imageEl.href = fullImage;
                imageEl.classList.add('various', 'imgModel');
            }
        }

        if (data.type === 'document') {
            const fullDocument = siteUrl + data.src;
            const documentEl = fileEl.querySelector('.document');
            if (documentEl) {
                documentEl.setAttribute('data-src', fullDocument);
                documentEl.classList.add('various', 'documentModel');
            }
        }

        if (data.type === 'archive') {
            const fullArchive = siteUrl + data.src;
            const archiveEl = fileEl.querySelector('.document');
            if (archiveEl) {
                archiveEl.name = fullArchive;
                archiveEl.classList.add('various', 'archiveModel');
            }
        }

        if (data.type === 'youtube') {
            fileEl.classList.add('video');
            if (data.src) {
                const fullImage = siteUrl + data.src;
                const imageEl = fileEl.querySelector('.img-responsive');
                if (imageEl) {
                    imageEl.src = fullImage + '?r=' + Math.random();
                    imageEl.href = 'https://www.youtube.com/embed/' + data.video_id;
                    imageEl.classList.add('various', 'fancybox', 'fancybox.iframe');
                }
            }
            const imageContainer = fileEl.querySelector('.file .image');
            if (imageContainer) {
                const icon = document.createElement('i');
                icon.classList.add('fa', 'fa-youtube-play');
                imageContainer.appendChild(icon);
            }
        }

        // Set other data properties in elements with data-prop attribute
        Object.entries(data).forEach(([key, value]) => {
            const propEl = fileEl.querySelector(`[data-prop="${key}"]`);
            if (propEl) {
                propEl.textContent = key === 'created_at' ? humanDate(value) : value;
                propEl.title = value;
            }
        });
    }
    function humanDate(date) {
        const formattedDate = new Date(date);
        const d = formattedDate.getDate();
        const m = formattedDate.getMonth() + 1;  // months are 0-11 in JS
        const y = formattedDate.getFullYear();
        return `${d}/${m}/${y}`;
    }

    if (cfg.modal) {
        const submitBtn = modalEl.querySelector('.modal-footer .submit-modal-btn');
        submitBtn.replaceWith(submitBtn.cloneNode(true)); // Remove previous event listeners
        modalEl.querySelector('.modal-footer .submit-modal-btn').addEventListener('click', () => {
            if (cfg.onSelect) {
                const files = [];
                const selectedFiles = rootEl.querySelectorAll('.file-manager-container > .selected');
                selectedFiles.forEach(selectedFile => {
                    if (
                        selectedFile.classList.contains('file-box-file') ||
                        selectedFile.classList.contains('file-box-image')
                    ) {
                        files.push(selectedFile._data || getDataFromElement(selectedFile));
                    }
                });
                cfg.onSelect(files);
            }

            rootEl.querySelectorAll('.file-manager-container > *').forEach(el => el.classList.remove('selected'));
            // Assuming modalEl.modal('show') opens modal - replace with native if needed
            if (typeof $(modalEl).modal === 'function') $(modalEl).modal('show');
        });
    }
    function bindFolderBoxEvents() {
        rootEl.querySelectorAll('.file-manager-container .file-box-folder .open-handler').forEach(handler => {
            handler.replaceWith(handler.cloneNode(true)); // Remove old events
        });

        rootEl.querySelectorAll('.file-manager-container .file-box-folder .open-handler').forEach(handler => {
            handler.addEventListener('click', () => {
                if (isTrash) return; // Can't open folders in trash
                const folderBox = handler.closest('.file-box-folder');
                if (!folderBox) return;
                const folderId = folderBox.dataset.id;
                reload({folderId});
            });
        });
        bindContextMenuEvents();
    }
    function showContextMenu(event, item) {
        event.preventDefault();
        const expandedClass = item.classList.contains('file-box-folder')
            ? '.folders-contextmenu'
            : '.files-contextmenu';

        const contextMenu = document.querySelector('.file-manager-contextmenu' + expandedClass);
        if (!contextMenu) return;

        contextMenu.style.left = event.pageX + 'px';
        contextMenu.style.top = event.pageY + 'px';

        contextMenu.classList.add('visible');

        bindContextMenuEvents();

        const selectedCount = rootEl.querySelectorAll('.file-box.selected').length;
        const isMultiple = selectedCount > 1;


        if (isTrash) {
            contextMenu.querySelectorAll('.restore-file, .delete-forever').forEach(el => el.style.display = 'block');
            contextMenu.querySelectorAll('.download-file, .edit-file, .delete-file').forEach(el => el.style.display = 'none');
        } else {
            contextMenu.querySelectorAll('.restore-file, .delete-forever').forEach(el => el.style.display = 'none');
            contextMenu.querySelectorAll('.download-file, .edit-file, .delete-file').forEach(el => el.style.display = 'block');

            const downloadFileEl = contextMenu.querySelector('.download-file');
            if (downloadFileEl) {
                downloadFileEl.style.display = isMultiple ? 'none' : 'block';
            }
        }

        const data = item._data || getDataFromElement(item);
        if (!isTrash && data?.type === 'image') {
            contextMenu.querySelectorAll('.remove-watermark').forEach(el => el.style.display = 'block');
            const downloadOriginalEl = contextMenu.querySelector('.download-original');
            if (downloadOriginalEl) {
                downloadOriginalEl.style.display = 'block';
                downloadOriginalEl.href = indexRoute + '/downloadOriginal/' + data.id;
            }
        } else {
            contextMenu.querySelectorAll('.remove-watermark').forEach(el => el.style.display = 'none');
            contextMenu.querySelectorAll('.download-original').forEach(el => el.style.display = 'none');
        }
    }
    function hideContextMenu() {
        document.querySelectorAll('.file-manager-contextmenu').forEach(menu => menu.classList.remove('visible'));
        setTimeout(() => {
            document.querySelectorAll('.file-manager-contextmenu a.download-file').forEach(el => {
                el.href = 'javascript:;';
            });
        }, 100);
    }
    document.addEventListener('click', () => {
        rootEl.querySelectorAll('.file-manager-container > *').forEach(el => el.classList.remove('selected'));
    });
    let lastSelectedFile = null;
    function bindFileBoxEvents() {
        const oldBoxes = rootEl.querySelectorAll('.file-manager-container .file-box-image, .file-manager-container .file-box-file');
        oldBoxes.forEach(oldBox => {
            const clone = oldBox.cloneNode(true);
            oldBox.replaceWith(clone);
        });

        const container = rootEl.querySelector('.file-manager-container');
        if (!container) return;

        container.addEventListener('click', function (e) {
            const file = e.target.closest('.file-box-image, .file-box-file');
            if (!file || !container.contains(file)) return;
            hideContextMenu();

            if (e.shiftKey) {
                if (lastSelectedFile){
                    const items = Array.from(container.children);
                    const from = Math.min(items.indexOf(lastSelectedFile), items.indexOf(file));
                    const to = Math.max(items.indexOf(lastSelectedFile), items.indexOf(file));

                    items.forEach(el => el.classList.remove('selected'));
                    for (let i = from; i <= to; i++) {
                        items[i].classList.add('selected');
                    }
                }
            } else if (!e.ctrlKey && !e.metaKey) {
                container.querySelectorAll('.file-box').forEach(el => el.classList.remove('selected'));
                file.classList.add('selected');
            } else {
                file.classList.add('selected');
            }

            lastSelectedFile = file;
            e.stopPropagation();
        });

        rootEl.querySelectorAll('.file-box.file-box-file, .file-box.file-box-image, .file-box.file-box-folder').forEach(el => {
            el.replaceWith(el.cloneNode(true)); // Remove old contextmenu
        });

        rootEl.querySelectorAll('.file-box.file-box-file, .file-box.file-box-image, .file-box.file-box-folder').forEach(el => {
            el.addEventListener('contextmenu', e => {
                e.preventDefault();

                if (!el.classList.contains('selected')) {
                    rootEl.querySelectorAll('.file-box').forEach(box => box.classList.remove('selected'));
                    el.classList.add('selected');
                }

                showContextMenu(e, el);

                const selectedFiles = rootEl.querySelectorAll('.file-box.selected');
                if (selectedFiles.length < 2) {
                    const downloadFileEl = document.querySelector('.file-manager-contextmenu .download-file');
                    if (downloadFileEl) {
                        if (el && el.dataset.type === 'image') {
                            downloadFileEl.href = el.querySelector('img.imgModel').getAttribute('src') || '#';
                            downloadFileEl.setAttribute('download', '');
                        }

                        if (el && el.dataset.type === 'document') {
                            downloadFileEl.href = el.querySelector('.documentModel').getAttribute('data-src') || '#';
                            downloadFileEl.setAttribute('download', '');
                        }
                    }
                }
            });
        });

        // Modal references
        const myModal = document.getElementById('myModal');
        const imageClose = document.querySelector('.imageClose');
        const modalImg = document.getElementById('img01');

        const myDocModal = document.getElementById('docModal');
        const docClose = document.querySelector('.docClose');
        const modalDoc = document.getElementById('doc01');

        const allDocModal = document.getElementById('allDocModal');

        rootEl.querySelectorAll('.file-box.file-box-file, .file-box.file-box-image').forEach(el => {
            el.addEventListener('dblclick', () => {
                const documentModel = el.querySelector('.documentModel');
                const archiveModel = el.querySelector('.archiveModel');
                const imageModel = el.querySelector('img.imgModel');
                if (imageModel && checkImageExtension(imageModel.src)) {
                    if (myModal) myModal.style.display = 'block';
                    if (modalImg) modalImg.src = imageModel.src;
                    // body.classList.add('imageOpen');
                } else if (documentModel && checkPdfExtension(documentModel.dataset.src)) {
                    if (myDocModal) myDocModal.style.display = 'block';
                    if (modalDoc) modalDoc.src = documentModel.dataset.src;
                    // body.classList.add('imageOpen');
                } else {
                    if (archiveModel && archiveModel.classList.contains('archiveModel')) {
                        const fileName = archiveModel.name;
                        const fileTitle = archiveModel.title;
                        allDocModal?.addEventListener('click', () => downloadWordFile(fileName, fileTitle), {once: true});
                    } else if (documentModel) {
                        const documentName = documentModel.name;
                        const documentTitle = documentModel.title;
                        allDocModal?.addEventListener('click', () => downloadWordFile(documentName, documentTitle), {once: true});
                    }
                }
            });
        });

        if (imageClose) {
            imageClose.onclick = () => {
                if (myModal) myModal.style.display = 'none';
                // body.classList.remove('imageOpen');
            };
        }

        if (docClose) {
            docClose.onclick = () => {
                if (myDocModal) myDocModal.style.display = 'none';
                // body.classList.remove('imageOpen');
            };
        }
    }
    function downloadWordFile(fileName, fileTitle) {
        const wordFileUrl = fileName;
        const link = document.createElement('a');
        link.href = wordFileUrl;
        link.download = fileTitle;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    function checkImageExtension(filename) {
        if (!filename) return false;
        const parts = filename.split('?');
        const extension = parts[0].split('.').pop().toLowerCase();
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
        return allowedExtensions.includes(extension);
    }
    function checkPdfExtension(filename) {
        if (!filename) return false;
        const parts = filename.split('?');
        const extension = parts[0].split('.').pop().toLowerCase();
        return extension === 'pdf';
    }
    function bindTypeFilterEvents() {
        rootEl.querySelectorAll('.type-filter-container a').forEach(el => {
            el.replaceWith(el.cloneNode(true));
        });

        rootEl.querySelectorAll('.type-filter-container a').forEach(el => {
            el.addEventListener('click', () => {
                rootEl.querySelectorAll('.type-filter-container a').forEach(a => a.classList.remove('active'));
                el.classList.add('active');
                filterFiles({type: el.dataset.type});
            });
        });
    }
    function filterFiles(filter) {
        if (filter.type === 'all') {
            rootEl.querySelectorAll('.file-manager-container .file-box').forEach(el => el.style.display = '');
        } else {
            rootEl.querySelectorAll('.file-manager-container .file-box').forEach(el => el.style.display = 'none');
            rootEl.querySelectorAll(`.file-manager-container .file-box[data-type="${filter.type}"]`).forEach(el => el.style.display = '');
            rootEl.querySelectorAll(`.file-manager-container .file-box[data-type="folder"]`).forEach(el => el.style.display = '');
        }
    }
    function getDataFromElement(el) {
        if (el._data) return el._data;
        // Build data from dataset if needed (dataset only stores strings)
        const data = {};
        for (const key in el.dataset) {
            if (Object.hasOwnProperty.call(el.dataset, key)) {
                data[key] = el.dataset[key];
            }
        }
        return data;
    }
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }
    async function ajaxRequest(url, method = 'GET', body = null) {
        const headers = {
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json',
        };
        if (body) headers['Content-Type'] = 'application/json';

        const options = {
            method,
            headers,
        };
        if (body) options.body = JSON.stringify(body);

        try {
            const response = await fetch(url, options);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return await response.json();
        } catch (error) {
            throw error;
        }
    }
    async function deleteFolder(id, deleteType, callback) {
        const url = deleteType === 'forever'
            ? `${indexRoute}/deleteFolderForever/${id}`
            : `${indexRoute}/deleteFolder/${id}`;
        try {
            const data = await ajaxRequest(url, 'DELETE');
            if (data.deleted) {
                reload(data.folderId ? {folderId: data.folderId} : undefined);
            } else {
                const title = document.querySelector('.modal-error').dataset.question || 'Are you sure?';
                const text = document.querySelector('.modal-error').dataset.text || '...';
                const yes = '';
                const no = document.querySelector('.modal-error').dataset.cancel || 'Cancel';
                Modal.show({
                    body: (data.error || 'Error') + '<br><br>' + (data.description || ''),
                    withoutYes: true,
                    title,
                    text,
                    yes,
                    no,
                    yesClass : '',
                });
                const fileWithLoadingMask = document.querySelector('.file.loading-mask');
                if (fileWithLoadingMask) fileWithLoadingMask.classList.remove('loading-mask');
            }
            if (callback) callback(data);
        } catch {
            reload();
        }
    }
    async function deleteFile(id, deleteType, callback) {
        const url = deleteType === 'forever'
            ? `${indexRoute}/deleteFileForever/${id}`
            : `${indexRoute}/delete/${id}`;
        try {
            const data = await ajaxRequest(url, 'DELETE');
            if (data.deleted) {
                reload(data.folderId ? {folderId: data.folderId} : undefined);
            } else {
                const title = document.querySelector('.modal-error').dataset.question || 'Are you sure?';
                const text = document.querySelector('.modal-error').dataset.text || '...';
                const yes = '';
                const no = document.querySelector('.modal-error').dataset.cancel || 'Cancel';
                Modal.show({
                    body: (data.error || 'Error') + '<br><br>' + (data.description || ''),
                    withoutYes: true,
                    title,
                    text,
                    yes,
                    no,
                    yesClass : '',
                });
                const fileWithLoadingMask = document.querySelector('.file.loading-mask');
                if (fileWithLoadingMask) fileWithLoadingMask.classList.remove('loading-mask');
            }
            if (callback) callback(data);
        } catch {
            reload();
        }
    }
    async function restoreFolder(id, callback) {
        try {
            const data = await ajaxRequest(`${indexRoute}/restoreFolder/${id}`, 'POST');
            if (data.restored) {
                reload(data.folderId ? {folderId: data.folderId} : undefined);
            } else {
                const title = document.querySelector('.modal-error').dataset.question || 'Are you sure?';
                const text = document.querySelector('.modal-error').dataset.text || '...';
                const yes = '';
                const no = document.querySelector('.modal-error').dataset.cancel || 'Cancel';
                Modal.show({
                    body: (data.error || 'Error') + '<br><br>' + (data.description || ''),
                    withoutYes: true,
                    title,
                    text,
                    yes,
                    no,
                    yesClass : '',
                });
            }
            if (callback) callback(data);
        } catch {
            reload();
        }
    }
    async function restoreFile(id, callback) {
        try {
            const data = await ajaxRequest(`${indexRoute}/restoreFile/${id}`, 'POST');
            if (data.restored) {
                reload(data.folderId ? {folderId: data.folderId} : undefined);
            } else {
                const title = document.querySelector('.modal-error').dataset.question || 'Are you sure?';
                const text = document.querySelector('.modal-error').dataset.text || '...';
                const yes = '';
                const no = document.querySelector('.modal-error').dataset.cancel || 'Cancel';
                Modal.show({
                    body: (data.error || 'Error') + '<br><br>' + (data.description || ''),
                    withoutYes: true,
                    title,
                    text,
                    yes,
                    no,
                    yesClass : '',
                });
            }
            if (callback) callback(data);
        } catch {
            reload();
        }
    }

    let updatedCropData = null;
    let currentEditingImage = null;

// Event listeners for edit-image-modal buttons
    document.querySelector('#edit-image-modal .image-crop-btn')?.addEventListener('click', () => {
        if (updatedCropData) {
            const inputCrop = rootEl.querySelector('input[name="crop"]');
            if (inputCrop) inputCrop.value = JSON.stringify(updatedCropData);
        }
    });

    document.querySelector('#edit-image-modal #initCrop')?.addEventListener('click', () => {
        if (currentEditingImage) cropper(currentEditingImage);
    });

// Cropper function assuming Cropper.js usage
    function cropper(imageElement) {
        if (!imageElement) return;

        // Destroy previous cropper instance if exists
        if (imageElement.cropperInstance) {
            imageElement.cropperInstance.destroy();
        }

        imageElement.cropperInstance = new Cropper(imageElement, {
            background: false,
            preview: '.img-preview',
            crop(event) {
                updatedCropData = event.detail;
            },
        });

        document.querySelector('#edit-image-modal #zoomIn')?.addEventListener('click', () => {
            imageElement.cropperInstance.zoom(0.1);
        });

        document.querySelector('#edit-image-modal #zoomOut')?.addEventListener('click', () => {
            imageElement.cropperInstance.zoom(-0.1);
        });

        document.querySelector('#edit-image-modal #rotateLeft')?.addEventListener('click', () => {
            imageElement.cropperInstance.rotate(90);
        });

        document.querySelector('#edit-image-modal #rotateRight')?.addEventListener('click', () => {
            imageElement.cropperInstance.rotate(-90);
        });
    }

// File input preview image update
    function setPreviewImageUrl(event) {
        const input = event.target;
        const imgTag = input.closest('label')?.querySelector('img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                if (imgTag) imgTag.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

// Attach setPreviewImageUrl as input event listener on file inputs (if needed)
// Example:
// document.querySelector('input[type="file"]').addEventListener('change', setPreviewImageUrl);

    function fillFormData(items) {
        window.LANG = window.LANG || '';

        items.forEach(item => {
            if (item[`caption_${window.LANG}`]) item.caption = item[`caption_${window.LANG}`];
            // alert(siteName); // Avoid alert in production
            if (item.type !== 'image' && item.type !== 'youtube') item.src = 'admin/img/file-icon.png';
            item.url = `${indexRoute}/${item.id}`;
        });

        const form = rootEl.querySelector('.file-manager-image-form');
        if (!form) return;

        // Store items on form element (similar to jQuery data)
        form._items = items;

        // Remove previous images
        form.querySelectorAll('img').forEach(img => img.remove());

        items.forEach(item => {
            const img = document.createElement('img');
            img.src = `${siteName}/${item.src}?r=${Math.random()}`;
            img.style.width = items.length === 1 ? '100%' : '50%';
            const imageContainer = form.querySelector('.image');
            if (imageContainer) imageContainer.prepend(img);
        });

        const inputTitle = form.querySelector('input[name="title"]');
        const inputCaption = form.querySelector('input[name="caption"]');
        const inputCrop = form.querySelector('input[name="crop"]');

        if (inputTitle) inputTitle.value = items[0]?.title || '';
        if (inputCaption) inputCaption.value = items[0]?.caption || '';
        if (inputCrop) inputCrop.value = '';

        if (inputTitle) inputTitle.focus();
    }

// Show/hide modal assuming Bootstrap modal or fallback to simple display toggle
    self.show = function () {
        if (!modalEl) return;

        if (typeof $(modalEl)?.modal === 'function') {
            $(modalEl).modal('show');
        } else {
            modalEl.style.display = 'block';
        }

        if (!self.loaded) {
            if (folderId) self.load({folderId});
            else self.load();
        }
    };

    self.hide = function () {
        if (!modalEl) return;

        if (typeof $(modalEl)?.modal === 'function') {
            $(modalEl).modal('hide');
        } else {
            modalEl.style.display = 'none';
        }
    };

    self.load = reload;
    self.reload = reload;

    return self;
}
