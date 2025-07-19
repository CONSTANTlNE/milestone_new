class SimpleTable {
    constructor(tableId, options = {}) {
        this.tableId = tableId;
        this.options = {
            searchInput: '#searchInput',
            filterSelect: '#filterSelect',
            selectAll: '#select-all',
            deleteSelected: '#delete-selected',
            deleteModal: '#deleteModal',
            deleteForm: '#deletePageForm',
            itemName: '#pageName',
            statusToggle: '.status-toggle',
            deleteItem: '.delete-item',
            clearFilters: '#clearFilters',
            ...options
        };

        this.selectedItems = new Set();
        this.init();
    }

    init() {
        this.initSearch();
        this.initFiltering();
        this.initSelection();
        this.initDelete();
        this.initStatusToggle();
        this.initClearFilters();
        this.initNumberSelector();
        this.initSorting();
        this.initOrderMode(); // <-- Add this line
    }

    // Search functionality
    initSearch() {
        const searchInput = document.querySelector(this.options.searchInput);
        const searchButton = searchInput?.parentElement?.querySelector('button[type="submit"]');
        
        if (searchInput && searchButton) {
            // Handle search button click
            searchButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.performServerSearch(searchInput.value);
            });
            
            // Handle Enter key press in search input
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.performServerSearch(searchInput.value);
                }
            });
        }
    }

    performServerSearch(searchTerm) {
        // Get current URL
        const currentUrl = new URL(window.location);
        
        // Update search parameter
        if (searchTerm.trim() === '') {
            currentUrl.searchParams.delete('search');
        } else {
            currentUrl.searchParams.set('search', searchTerm.trim());
        }
        
        // Reset to first page when searching
        currentUrl.searchParams.delete('page');
        
        // Navigate to search URL
        window.location.href = currentUrl.toString();
    }

    updateSearchResults(count) {
        let resultsDiv = document.querySelector('.search-results');
        if (!resultsDiv) {
            resultsDiv = document.createElement('div');
            resultsDiv.className = 'search-results mt-3';
            document.querySelector('.table-responsive').appendChild(resultsDiv);
        }

        if (count === 0) {
            resultsDiv.innerHTML = '<p class="text-gray-500">No results found</p>';
            resultsDiv.style.display = 'block';
        } else {
            resultsDiv.style.display = 'none';
        }
    }

    // Filtering functionality
    initFiltering() {
        const filterSelect = document.querySelector(this.options.filterSelect);
        if (filterSelect) {
            filterSelect.addEventListener('change', (e) => {
                this.performServerFilter(e.target.value);
            });
        }
    }

    performServerFilter(status) {
        // Get current URL
        const currentUrl = new URL(window.location);
        
        // Update status parameter
        if (status === 'all') {
            currentUrl.searchParams.delete('status');
        } else {
            currentUrl.searchParams.set('status', status);
        }
        
        // Reset to first page when filtering
        currentUrl.searchParams.delete('page');
        
        // Navigate to filtered URL
        window.location.href = currentUrl.toString();
    }

    // Selection functionality
    initSelection() {
        const selectAll = document.querySelector(this.options.selectAll);
        const checkboxes = document.querySelectorAll('.list-checkbox-item');

        if (selectAll) {
            selectAll.addEventListener('change', (e) => {
                checkboxes.forEach(cb => {
                    cb.checked = e.target.checked;
                    this.handleItemSelection(cb);
                });
                this.updateSelectDeleteButton();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                this.handleItemSelection(cb);
                this.updateSelectAll();
                this.updateSelectDeleteButton();
            });
        });
    }

    handleItemSelection(checkbox) {
        const itemId = checkbox.value;
        if (checkbox.checked) {
            this.selectedItems.add(itemId);
        } else {
            this.selectedItems.delete(itemId);
        }
    }

    updateSelectAll() {
        const selectAll = document.querySelector(this.options.selectAll);
        const checkboxes = document.querySelectorAll('.list-checkbox-item:not([style*="display: none"])');
        const checkedBoxes = document.querySelectorAll('.list-checkbox-item:checked:not([style*="display: none"])');

        if (selectAll) {
            selectAll.checked = checkedBoxes.length === checkboxes.length && checkboxes.length > 0;
            selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < checkboxes.length;
        }
    }

    updateSelectDeleteButton() {
        const deleteBtn = document.querySelector(this.options.deleteSelected);
        if (deleteBtn) {
            if (this.selectedItems.size > 0) {
                deleteBtn.disabled = false;
            } else {
                deleteBtn.disabled = true;
            }
        }
    }

    // Delete functionality
    initDelete() {
        const deleteButtons = document.querySelectorAll(this.options.deleteItem);
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showDeleteModal(btn.dataset.id, btn.dataset.name);
            });
        });

        // Restore buttons
        const restoreButtons = document.querySelectorAll('.restore-item');
        restoreButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showRestoreModal(btn.dataset.id, btn.dataset.name, btn);
            });
        });

        const bulkDeleteBtn = document.querySelector(this.options.deleteSelected);
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', () => {
                this.handleBulkDelete();
            });
        }
    }

    showDeleteModal(id, name) {
        const deleteBtn = document.querySelector(this.options.deleteItem);
        const nameElement = document.querySelector(this.options.itemName);
        if (nameElement) nameElement.textContent = name;

        const translatedSingleQuestion = deleteBtn?.dataset.translatedSingleQuestion || 'Do you want to delete';
        const translatedSingleText = deleteBtn?.dataset.translatedSingleText || '...';

        const deleteText = deleteBtn?.dataset.delete || 'Delete';
        const cancelText = deleteBtn?.dataset.cancel || 'Cancel';

        Modal.show({
            title: `${translatedSingleQuestion} "${name}"?`,
            text: translatedSingleText,
            yes: deleteText,
            no: cancelText,
            yesClass: 'ti-btn-danger',
            callback: (btn) => {
                Modal.hide();

                if (btn === 'yes') {
                    this.handleSingleDelete(id, name);
                }
            }
        });
    }

    async handleSingleDelete(id, name) {
        try {
            // Find the delete button to get the URL
            const deleteBtn = document.querySelector(`#${this.tableId} tbody tr[data-id="${id}"] .delete-item`);
            
            // Debug: Check if button is found
            if (!deleteBtn) {
                console.error('Delete button not found for ID:', id);
                this.showMessage('Delete button not found', 'error');
                return;
            }
            
            const url = deleteBtn.dataset.url;
            
            // Debug: Check the URL
            console.log('Delete URL:', url);
            console.log('Delete button:', deleteBtn);
            console.log('Data attributes:', deleteBtn.dataset);
            
            if (!url) {
                console.error('No URL found in delete button');
                this.showMessage('Delete URL not found', 'error');
                return;
            }

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id })
            });

            // Check if response is ok first
            if (response.ok) {
                // Try to parse as JSON first
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    try {
                        const data = await response.json();
                        // Success - remove the row from the table
                        this.removeTableRow(id);
                        this.showMessage(data.message || `${name} deleted successfully`, 'success');

                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } catch (jsonError) {
                        console.error('JSON parsing error:', jsonError);
                        this.showMessage('Invalid JSON response from server', 'error');
                    }
                } else {
                    // Not JSON, try to get text
                    try {
                        const text = await response.text();
                        console.log('Response text:', text);
                        // If we get here, the response was text, not JSON
                        this.showMessage('Server returned non-JSON response', 'error');
                    } catch (textError) {
                        console.error('Failed to read response:', textError);
                        this.showMessage('Failed to read server response', 'error');
                    }
                }
            } else {
                // Handle error response
                let errorMessage = 'Error deleting item';
                try {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorMessage;
                } catch (e) {
                    // If we can't parse JSON, use the status text
                    errorMessage = response.statusText || errorMessage;
                }
                this.showMessage(errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showMessage('Network error occurred', 'error');
        }
    }

    removeTableRow(id) {
        // Find and remove the table row
        const row = document.querySelector(`#${this.tableId} tbody tr[data-id="${id}"]`);
        if (row) {
            // Add fade out animation
            row.style.transition = 'opacity 0.3s ease-out';
            row.style.opacity = '0';
            
            setTimeout(() => {
                row.remove();
                // Update counters if they exist
                this.updateTableCounters();
            }, 300);
        } else {
            // Fallback: reload the page if row not found
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
    }

    updateTableCounters() {
        // Update any counters that might exist
        const totalRows = document.querySelectorAll(`#${this.tableId} tbody tr`).length;
        const counterElements = document.querySelectorAll('.table-counter, .items-count');
        counterElements.forEach(element => {
            element.textContent = totalRows;
        });
    }

    removeBulkTableRows(ids) {
        // Remove multiple rows with animation
        const rows = [];
        ids.forEach(id => {
            const row = document.querySelector(`#${this.tableId} tbody tr[data-id="${id}"]`);
            if (row) {
                rows.push(row);
            }
        });

        if (rows.length > 0) {
            // Add fade out animation to all rows
            rows.forEach(row => {
                row.style.transition = 'opacity 0.3s ease-out';
                row.style.opacity = '0';
            });

            setTimeout(() => {
                // Remove all rows
                rows.forEach(row => row.remove());
                // Update counters
                this.updateTableCounters();
            }, 300);
        } else {
            // Fallback: reload the page if rows not found
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
    }

    async handleBulkDelete() {
        if (this.selectedItems.size === 0) {
            this.showMessage('Please select items to delete', 'warning');
            return;
        }

        this.showBulkDeleteModal();
    }

    showBulkDeleteModal() {
        // Get translations from the delete button
        const deleteBtn = document.querySelector(this.options.deleteSelected);
        const translatedPluralQuestion = deleteBtn?.dataset.translatedPluralQuestion || 'Do you want to delete';
        const translatedPluralSelectedItems = deleteBtn?.dataset.translatedPluralSelectedItems || 'selected items';
        const translatedPluralText = deleteBtn?.dataset.translatedPluralText || '...';

        const deleteText = deleteBtn?.dataset.delete || 'Delete';
        const cancelText = deleteBtn?.dataset.cancel || 'Cancel';

        Modal.show({
            title: `${translatedPluralQuestion} ${this.selectedItems.size} ${translatedPluralSelectedItems}?`,
            text: translatedPluralText,
            yes: deleteText,
            no: cancelText,
            yesClass: 'ti-btn-danger',
            callback: (btn) => {
                Modal.hide();

                if (btn === 'yes') {
                    this.performBulkDelete();
                }
            }
        });
    }

    async performBulkDelete() {
        try {
            const deleteBtn = document.querySelector(this.options.deleteSelected);
            const url = deleteBtn.dataset.url;

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ ids: Array.from(this.selectedItems) })
            });

            if (response.ok) {
                // Try to parse as JSON first
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    try {
                            const data = await response.json();
                            // Remove selected rows from the table
                            this.removeBulkTableRows(Array.from(this.selectedItems));
                            this.showMessage(data.message || 'Items deleted successfully', 'success');
                            // Clear selection
                            this.selectedItems.clear();
                            this.updateSelectDeleteButton();
                            this.updateSelectAll();
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } catch (jsonError) {
                        console.error('JSON parsing error:', jsonError);
                        this.showMessage('Invalid JSON response from server', 'error');
                    }
                } else {
                    // Not JSON, try to get text
                    try {
                        const text = await response.text();
                        console.error('Non-JSON response:', text);
                        this.showMessage('Unexpected server response. Check console for details.', 'error');
                    } catch (textError) {
                        console.error('Failed to read response:', textError);
                        this.showMessage('Failed to read server response', 'error');
                    }
                }
            } else {
                // Handle error response
                let errorMessage = 'Error deleting items';
                try {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorMessage;
                } catch (e) {
                    // If we can't parse JSON, use the status text
                    errorMessage = response.statusText || errorMessage;
                }
                this.showMessage(errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showMessage('Network error occurred', 'error');
        }
    }

    // Status toggle functionality
    initStatusToggle() {
        const toggles = document.querySelectorAll(this.options.statusToggle);
        toggles.forEach(toggle => {
            toggle.addEventListener('change', async (e) => {
                const itemId = e.target.dataset.id;
                const url = e.target.dataset.url;
                const statusText = e.target.parentElement.querySelector('.status-text-' + itemId);
                const originalState = e.target.checked;

                // Add loading state
                e.target.disabled = true;
                e.target.parentElement.style.opacity = '0.6';

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: itemId, status: e.target.checked ? 1 : 0 })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Success
                        if (statusText) {
                            statusText.textContent = e.target.checked ? 'Active' : 'Inactive';
                        }

                        // Show success message
                        this.showMessage(data.message || 'Status updated successfully', 'success');
                    } else {
                        // Error - revert the toggle
                        e.target.checked = !originalState;
                        this.showMessage(data.message || 'Error updating status', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    // Revert on error
                    e.target.checked = !originalState;
                    this.showMessage('Network error occurred', 'error');
                } finally {
                    // Remove loading state
                    e.target.disabled = false;
                    e.target.parentElement.style.opacity = '1';
                }
            });
        });
    }

    // Show message function
    showMessage(message, type = 'info') {
        // Find existing alert-message container
        let alertContainer = document.querySelector('.alert-message');
        
        // If no alert container exists, create one
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.className = 'alert-message';
            
            // Insert at the top of the content
            const content = document.querySelector('.content');
            if (content) {
                content.insertBefore(alertContainer, content.firstChild);
            }
        }

        // Create new message with improved structure
        const messageDiv = document.createElement('div');
        messageDiv.className = `alert alert-${type === 'error' ? 'danger' : type === 'warning' ? 'warning' : type === 'success' ? 'success' : 'info'} fade show flex`;
        messageDiv.setAttribute('role', 'alert');
        messageDiv.id = 'alert-' + Date.now();
        
        const icons = {
            'success': 'ri-check-double-line',
            'error': 'ri-error-warning-line',
            'warning': 'ri-information-line',
            'info': 'ri-information-line'
        };
        
        const icon = icons[type] || 'ri-information-line';
        
        messageDiv.innerHTML = `
            <div class="sm:flex-shrink-0">
                <i class="${icon} me-2"></i>
                ${message}
            </div>
            <div class="ms-auto">
                <div class="mx-1 my-1">
                    <button type="button" 
                            class="inline-flex bg-teal-50 rounded-sm text-teal-500 focus:outline-none focus:ring-0 focus:ring-offset-0 focus:ring-offset-teal-50 focus:ring-teal-600" 
                            data-hs-remove-element="#${messageDiv.id}">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-3 w-3" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M0.92524 0.687069C1.126 0.486219 1.39823 0.373377 1.68209 0.373377C1.96597 0.373377 2.2382 0.486219 2.43894 0.687069L8.10514 6.35813L13.7714 0.687069C13.8701 0.584748 13.9882 0.503105 14.1188 0.446962C14.2494 0.39082 14.3899 0.361248 14.5321 0.360026C14.6742 0.358783 14.8151 0.38589 14.9468 0.439762C15.0782 0.493633 15.1977 0.573197 15.2983 0.673783C15.3987 0.774389 15.4784 0.894026 15.5321 1.02568C15.5859 1.15736 15.6131 1.29845 15.6118 1.44071C15.6105 1.58297 15.5809 1.72357 15.5248 1.85428C15.4688 1.98499 15.3872 2.10324 15.2851 2.20206L9.61883 7.87312L15.2851 13.5441C15.4801 13.7462 15.588 14.0168 15.5854 14.2977C15.5831 14.5787 15.4705 14.8474 15.272 15.046C15.0735 15.2449 14.805 15.3574 14.5244 15.3599C14.2437 15.3623 13.9733 15.2543 13.7714 15.0591L8.10514 9.38812L2.43894 15.0591C2.23704 15.2543 1.96663 15.3623 1.68594 15.3599C1.40526 15.3574 1.13677 15.2449 0.938279 15.046C0.739807 14.8474 0.627232 14.5787 0.624791 14.2977C0.62235 14.0168 0.730236 13.7462 0.92524 13.5441L6.59144 7.87312L0.92524 2.20206C0.724562 2.00115 0.611816 1.72867 0.611816 1.44457C0.611816 1.16047 0.724562 0.887983 0.92524 0.687069Z" fill="currentColor"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;

        // Add the new message to the existing alert container
        alertContainer.appendChild(messageDiv);

        // Auto hide after 5 seconds
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        },1000);
    }

    // Clear filters functionality
    initClearFilters() {
        const clearBtn = document.querySelector(this.options.clearFilters);
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                // Get current URL
                const currentUrl = new URL(window.location);
                
                // Remove all filter parameters
                currentUrl.searchParams.delete('search');
                currentUrl.searchParams.delete('status');
                currentUrl.searchParams.delete('sort_column');
                currentUrl.searchParams.delete('sort_direction');
                currentUrl.searchParams.delete('page');
                currentUrl.searchParams.delete('per_page');
                
                // Navigate to clean URL
                window.location.href = currentUrl.toString();
            });
        }
    }

    // Number selector functionality
    initNumberSelector() {
        const numberSelect = document.querySelector('#table-number');
        if (numberSelect) {
            numberSelect.addEventListener('change', (e) => {
                const perPage = e.target.value;
                this.updateUrlWithPerPage(perPage);
            });
        }
    }

    updateUrlWithPerPage(perPage) {
        const currentUrl = new URL(window.location);
        
        // Update or add per_page parameter
        currentUrl.searchParams.set('per_page', perPage);
        
        // Reset to first page when changing per_page
        currentUrl.searchParams.delete('page');
        
        // Navigate to the new URL
        window.location.href = currentUrl.toString();
    }

    // Sorting functionality
    initSorting() {
        const sortableHeaders = document.querySelectorAll('.sortable');
        
        sortableHeaders.forEach(header => {
            header.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleSort(header);
            });
            
            // Add cursor pointer to sortable headers
            header.style.cursor = 'pointer';
        });
        
        // Add sort indicators for all sortable headers
        this.updateAllSortIndicators();
    }

    handleSort(header) {
        const sortColumn = header.dataset.sort;
        const currentUrl = new URL(window.location);
        const currentSortColumn = currentUrl.searchParams.get('sort_column') || 'id';
        const currentSortDirection = currentUrl.searchParams.get('sort_direction') || 'desc';
        
        let newSortDirection = 'asc';
        
        // If clicking the same column, toggle direction
        if (currentSortColumn === sortColumn) {
            newSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
        }
        
        // Update URL parameters
        currentUrl.searchParams.set('sort_column', sortColumn);
        currentUrl.searchParams.set('sort_direction', newSortDirection);
        
        // Reset to first page when sorting
        currentUrl.searchParams.delete('page');
        
        // Navigate to sorted URL
        window.location.href = currentUrl.toString();
    }

    updateAllSortIndicators() {
        const sortableHeaders = document.querySelectorAll('.sortable');
        const currentUrl = new URL(window.location);
        const currentSortColumn = currentUrl.searchParams.get('sort_column') || 'id';
        const currentSortDirection = currentUrl.searchParams.get('sort_direction') || 'desc';
        
        sortableHeaders.forEach(header => {
            // Remove existing indicators
            const existingIndicator = header.querySelector('.sort-indicator');
            if (existingIndicator) {
                existingIndicator.remove();
            }
            
            const sortColumn = header.dataset.sort;
            
            // Add sort indicator for ALL sortable columns
            const indicator = document.createElement('span');
            indicator.className = 'sort-indicator ml-1';
            
            // If this is the currently sorted column, show active indicator
            if (currentSortColumn === sortColumn) {
                indicator.innerHTML = currentSortDirection === 'asc' ? '<i class="ri-arrow-up-line"></i>' : '<i class="ri-arrow-down-line"></i>';
            } else {
                // Show inactive indicator for other sortable columns
                indicator.innerHTML = '<i class="ri-arrow-up-down-line"></i>';
            }
            
            header.appendChild(indicator);
        });
    }

    addSortIndicators(header) {
        const currentUrl = new URL(window.location);
        const currentSortColumn = currentUrl.searchParams.get('sort_column') || 'id';
        const currentSortDirection = currentUrl.searchParams.get('sort_direction') || 'desc';
        const sortColumn = header.dataset.sort;
        
        // Remove existing indicators
        const existingIndicator = header.querySelector('.sort-indicator');
        if (existingIndicator) {
            existingIndicator.remove();
        }
        
        // Add sort indicator if this is the current sort column
        if (currentSortColumn === sortColumn) {
            const indicator = document.createElement('span');
            indicator.className = 'sort-indicator ml-1';
            indicator.innerHTML = currentSortDirection === 'asc' ? '<i class="ri-arrow-up-line"></i>' : '<i class="ri-arrow-down-line"></i>';
            header.appendChild(indicator);
        }
    }

    showRestoreModal(id, name, btn) {
        const translatedSingleQuestion = btn?.dataset.translatedSingleQuestion || 'Do you want to restore';
        const translatedSingleText = btn?.dataset.translatedSingleText || '...';
        const restoreText = btn?.dataset.restore || 'Restore';
        const cancelText = btn?.dataset.cancel || 'Cancel';
        const url = btn?.dataset.url;

        Modal.show({
            title: `${translatedSingleQuestion} "${name}"?`,
            text: translatedSingleText,
            yes: restoreText,
            no: cancelText,
            yesClass: 'ti-btn-secondary-full',
            callback: (btnResult) => {
                Modal.hide();
                if (btnResult === 'yes') {
                    this.handleSingleRestore(id, name, url);
                }
            }
        });
    }

    async handleSingleRestore(id, name, url) {
        try {
            if (!url) {
                this.showMessage('Restore URL not found', 'error');
                return;
            }
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id })
            });
            if (response.ok) {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    const data = await response.json();
                    this.removeTableRow(id);
                    this.showMessage(data.message || `${name} restored successfully`, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    this.showMessage('Server returned non-JSON response', 'error');
                }
            } else {
                let errorMessage = 'Error restoring item';
                try {
                    const errorData = await response.json();
                    errorMessage = errorData.message || errorMessage;
                } catch (e) {
                    errorMessage = response.statusText || errorMessage;
                }
                this.showMessage(errorMessage, 'error');
            }
        } catch (error) {
            this.showMessage('Network error occurred', 'error');
        }
    }

    /**
     * Drag-and-drop order mode for tables (e.g., socials table)
     */
    initOrderMode() {
        // For socials table (existing)
        const orderBtn = document.getElementById('order-toggle');
        const tbody = document.getElementById('socials-tbody');
        const moveTh = document.getElementById('move-th');
        const dragHandleCells = document.querySelectorAll('.drag-handle-cell');
        let sortable = null;
        let orderMode = false;

        if (!orderBtn || !tbody || !moveTh) return;

        orderBtn.addEventListener('click', function() {
            orderMode = !orderMode;
            document.querySelectorAll('.drag-handle').forEach(el => {
                el.style.display = orderMode ? '' : 'none';
            });
            dragHandleCells.forEach(cell => {
                if (orderMode) {
                    cell.classList.remove('hidden');
                } else {
                    cell.classList.add('hidden');
                }
            });
            // Toggle active class on the move th
            if (orderMode) {
                moveTh.classList.add('active');
                moveTh.classList.remove('hidden');
                sortable = Sortable.create(tbody, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    onEnd: function (evt) {
                        const order = Array.from(tbody.querySelectorAll('tr')).map(row => row.getAttribute('data-id'));
                        fetch(orderBtn.dataset.reorderUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ order })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => { throw new Error('HTTP ' + response.status + ': ' + text); });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if(data['alert-type'] === 'success') {
                                console.log(data.message);
                            } else {
                                console.log(data.message || 'Error');
                            }
                        })
                        .catch(err => {
                            alert('Error: ' + err.message);
                            console.error(err);
                        });
                    }
                });
            } else {
                moveTh.classList.remove('active');
                moveTh.classList.add('hidden');
                if (sortable) {
                    sortable.destroy();
                    sortable = null;
                }
            }
        });

        // For roles table
        const orderBtnRoles = document.getElementById('order-toggle');
        const tbodyRoles = document.getElementById('roles-tbody');
        const moveThRoles = document.getElementById('move-th');
        const dragHandleCellsRoles = document.querySelectorAll('#roles-tbody .drag-handle-cell');
        let sortableRoles = null;
        let orderModeRoles = false;

        if (!orderBtnRoles || !tbodyRoles || !moveThRoles) return;

        orderBtnRoles.addEventListener('click', function() {
            orderModeRoles = !orderModeRoles;
            document.querySelectorAll('#roles-tbody .drag-handle').forEach(el => {
                el.style.display = orderModeRoles ? '' : 'none';
            });
            dragHandleCellsRoles.forEach(cell => {
                if (orderModeRoles) {
                    cell.classList.remove('hidden');
                } else {
                    cell.classList.add('hidden');
                }
            });
            if (orderModeRoles) {
                moveThRoles.classList.add('active');
                moveThRoles.classList.remove('hidden');
                sortableRoles = Sortable.create(tbodyRoles, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    onEnd: function (evt) {
                        const order = Array.from(tbodyRoles.querySelectorAll('tr')).map(row => row.getAttribute('data-id'));
                        fetch(orderBtnRoles.dataset.reorderUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ order })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => { throw new Error('HTTP ' + response.status + ': ' + text); });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if(data['alert-type'] === 'success') {
                                console.log(data.message);
                            } else {
                                console.log(data.message || 'Error');
                            }
                        })
                        .catch(err => {
                            alert('Error: ' + err.message);
                            console.error(err);
                        });
                    }
                });
            } else {
                moveThRoles.classList.remove('active');
                moveThRoles.classList.add('hidden');
                if (sortableRoles) {
                    sortableRoles.destroy();
                    sortableRoles = null;
                }
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const datatablesTable = new SimpleTable('datatablesTable');
});
