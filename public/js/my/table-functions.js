/**
 * Comprehensive Admin Table Functions
 * Provides complete table functionality for Laravel admin panels
 * Supports: CRUD operations, search, filtering, pagination, bulk actions, status toggles
 */
class AdminTable {
    constructor(options = {}) {
        this.options = {
            // Table identifiers
            tableId: 'dataTable',
            tableWrapper: '.table-responsive',
            
            // Checkbox and selection
            selectAllId: 'select-all',
            itemCheckboxClass: 'item-checkbox',
            deleteSelectedId: 'delete-selected',
            deleteFormId: 'deleteForm',
            
            // Search and filtering
            searchInputId: 'searchInput',
            filterSelectId: 'filterSelect',
            dateRangeId: 'dateRange',
            
            // Modal and forms
            deleteModalId: 'deleteModal',
            deleteFormId: 'deleteForm',
            itemNameId: 'itemName',
            
            // Status and actions
            statusToggleClass: 'status-toggle',
            deleteButtonClass: 'delete-item',
            editButtonClass: 'edit-item',
            viewButtonClass: 'view-item',
            
            // Pagination
            paginationWrapper: '.pagination',
            itemsPerPageId: 'itemsPerPage',
            
            // Sorting
            sortableColumns: '.sortable',
            
            // Export
            exportButtons: '.export-btn',
            
            // Advanced features
            enableBulkActions: true,
            enableSearch: true,
            enableFiltering: true,
            enableSorting: true,
            enablePagination: true,
            enableExport: false,
            enableStatusToggle: true,
            enableInlineEdit: false,
            enableServerSideSearch: false,
            
            // Callbacks
            onItemSelect: null,
            onBulkAction: null,
            onStatusChange: null,
            onSearch: null,
            onFilter: null,
            onSort: null,
            onDelete: null,
            onEdit: null,
            onView: null,
            
            // API endpoints
            statusUrl: null,
            deleteUrl: null,
            bulkDeleteUrl: null,
            exportUrl: null,
            searchUrl: null,
            
            // Messages
            messages: {
                confirmDelete: 'Are you sure you want to delete this item?',
                confirmBulkDelete: 'Are you sure you want to delete selected items?',
                deleteSuccess: 'Item deleted successfully',
                deleteError: 'Error deleting item',
                statusSuccess: 'Status updated successfully',
                statusError: 'Error updating status',
                noItemsSelected: 'Please select items to delete',
                searchNoResults: 'No results found',
                loading: 'Loading...',
                error: 'An error occurred'
            },
            
            ...options
        };
        
        this.state = {
            selectedItems: new Set(),
            currentPage: 1,
            itemsPerPage: 10,
            sortColumn: null,
            sortDirection: 'asc',
            searchTerm: '',
            filters: {},
            isLoading: false
        };
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeComponents();
        this.setupEventListeners();
    }

    bindEvents() {
        // Core table functionality
        this.initSelectAll();
        this.initIndividualCheckboxes();
        this.initSearch();
        this.initFiltering();
        this.initSorting();
        this.initPagination();
        
        // Action buttons
        this.initDeleteButtons();
        this.initEditButtons();
        this.initViewButtons();
        this.initStatusToggles();
        this.initBulkActions();
        
        // Advanced features
        this.initExport();
        this.initInlineEdit();
        this.initKeyboardShortcuts();
        
        // Utility features
        this.initTooltips();
        this.initResponsive();
    }

    initializeComponents() {
        // Initialize tooltips
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        // Initialize date pickers if available
        if (typeof flatpickr !== 'undefined' && this.options.dateRangeId) {
            const dateRange = document.getElementById(this.options.dateRangeId);
            if (dateRange) {
                flatpickr(dateRange, {
                    mode: "range",
                    dateFormat: "Y-m-d",
                    onChange: (selectedDates) => {
                        this.handleDateFilter(selectedDates);
                    }
                });
            }
        }
    }

    setupEventListeners() {
        // Global event listeners
        document.addEventListener('keydown', (e) => {
            this.handleKeyboardShortcuts(e);
        });
        
        // Window resize for responsive handling
        window.addEventListener('resize', () => {
            this.handleResponsive();
        });
    }

    // ===== SELECTION AND CHECKBOXES =====
    
    initSelectAll() {
        const selectAllCheckbox = document.getElementById(this.options.selectAllId);
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', (e) => {
                const checkboxes = document.querySelectorAll(`.${this.options.itemCheckboxClass}`);
                checkboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked;
                    this.handleItemSelection(checkbox);
                });
                this.updateBulkActionButton();
            });
        }
    }

    initIndividualCheckboxes() {
        const checkboxes = document.querySelectorAll(`.${this.options.itemCheckboxClass}`);
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                this.handleItemSelection(checkbox);
                this.updateSelectAllCheckbox();
                this.updateBulkActionButton();
            });
        });
    }

    handleItemSelection(checkbox) {
        const itemId = checkbox.value;
        if (checkbox.checked) {
            this.state.selectedItems.add(itemId);
        } else {
            this.state.selectedItems.delete(itemId);
        }
        
        if (this.options.onItemSelect) {
            this.options.onItemSelect(itemId, checkbox.checked);
        }
    }

    updateSelectAllCheckbox() {
        const selectAllCheckbox = document.getElementById(this.options.selectAllId);
        const checkboxes = document.querySelectorAll(`.${this.options.itemCheckboxClass}`);
        const checkedBoxes = document.querySelectorAll(`.${this.options.itemCheckboxClass}:checked`);
        const totalBoxes = checkboxes.length;

        if (selectAllCheckbox && totalBoxes > 0) {
            selectAllCheckbox.checked = checkedBoxes.length === totalBoxes;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < totalBoxes;
        }
    }

    updateBulkActionButton() {
        const deleteSelectedBtn = document.getElementById(this.options.deleteSelectedId);
        if (deleteSelectedBtn) {
            if (this.state.selectedItems.size > 0) {
                deleteSelectedBtn.style.display = 'inline-block';
                deleteSelectedBtn.disabled = false;
                deleteSelectedBtn.textContent = `Delete Selected (${this.state.selectedItems.size})`;
            } else {
                deleteSelectedBtn.style.display = 'none';
                deleteSelectedBtn.disabled = true;
            }
        }
    }

    // ===== SEARCH FUNCTIONALITY =====
    
    initSearch() {
        if (!this.options.enableSearch) return;
        
        const searchInput = document.getElementById(this.options.searchInputId);
        const searchButton = document.getElementById('searchButton');
        
        // Handle search button click
        if (searchButton) {
            searchButton.addEventListener('click', () => {
                this.state.searchTerm = searchInput ? searchInput.value : '';
                this.performSearch();
            });
        }
        
        // Handle Enter key press in search input
        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.state.searchTerm = e.target.value;
                    this.performSearch();
                }
            });
        }
    }

    performSearch() {
        // Check if server-side search is enabled
        if (this.options.enableServerSideSearch) {
            this.performServerSideSearch();
        } else {
            this.performClientSideSearch();
        }
    }

    performClientSideSearch() {
        const tableRows = document.querySelectorAll(`#${this.options.tableId} tbody tr`);
        const searchTerm = this.state.searchTerm.toLowerCase();
        let visibleCount = 0;
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isVisible = text.includes(searchTerm);
            row.style.display = isVisible ? '' : 'none';
            if (isVisible) visibleCount++;
        });
        
        this.updateSearchResults(visibleCount, tableRows.length);
        
        if (this.options.onSearch) {
            this.options.onSearch(searchTerm, visibleCount);
        }
    }

    async performServerSideSearch() {
        try {
            this.setLoading(true);
            
            const searchData = {
                search: this.state.searchTerm,
                status: this.state.filters.status || 'all',
                sort_column: this.state.sortColumn || 'id',
                sort_direction: this.state.sortDirection || 'desc',
                per_page: this.state.itemsPerPage || 10,
                page: this.state.currentPage || 1
            };
            
            const response = await fetch(this.options.searchUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                body: JSON.stringify(searchData)
            });

            const data = await response.json();
            
            if (data.success) {
                // Update table body with new HTML
                const tbody = document.querySelector(`#${this.options.tableId} tbody`);
                if (tbody) {
                    tbody.innerHTML = data.html;
                }
                
                // Update pagination info
                this.updatePaginationInfo(data.pagination);
                
                // Update search results counter
                this.updateSearchResults(data.pagination.total, data.pagination.total);
                
                // Reinitialize event listeners for new elements
                this.reinitializeEventListeners();
                
                if (this.options.onSearch) {
                    this.options.onSearch(this.state.searchTerm, data.pagination.total);
                }
            } else {
                this.showAlert('error', data.message || 'Search failed');
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showAlert('error', 'Search failed. Please try again.');
        } finally {
            this.setLoading(false);
        }
    }

    updateSearchResults(visibleCount, totalCount) {
        const resultsElement = document.querySelector('.search-results');
        if (resultsElement) {
            if (this.state.searchTerm) {
                resultsElement.textContent = `Showing ${visibleCount} of ${totalCount} results`;
                resultsElement.style.display = 'block';
            } else {
                resultsElement.style.display = 'none';
            }
        }
    }

    updatePaginationInfo(pagination) {
        // Update pagination display if it exists
        const paginationInfo = document.querySelector('.pagination-info');
        if (paginationInfo && pagination) {
            paginationInfo.innerHTML = `
                <span class="opacity-[0.7] font-normal text-[#536485] block text-[0.6875rem]">
                    Showing ${pagination.from} to ${pagination.to} of ${pagination.total} results
                </span>
            `;
        }
    }

    reinitializeEventListeners() {
        // Reinitialize event listeners for new elements
        this.initIndividualCheckboxes();
        this.initStatusToggles();
        this.initDeleteButtons();
        this.initEditButtons();
        this.initViewButtons();
        this.initInlineEdit();
    }

    // ===== FILTERING =====
    
    initFiltering() {
        if (!this.options.enableFiltering) return;
        
        const filterSelects = document.querySelectorAll(`#${this.options.filterSelectId}`);
        filterSelects.forEach(select => {
            select.addEventListener('change', (e) => {
                this.state.filters[e.target.name] = e.target.value;
                this.applyFilters();
            });
        });
    }

    applyFilters() {
        // Check if server-side search is enabled
        if (this.options.enableServerSideSearch) {
            this.performServerSideSearch();
        } else {
            this.applyClientSideFilters();
        }
    }

    applyClientSideFilters() {
        const tableRows = document.querySelectorAll(`#${this.options.tableId} tbody tr`);
        
        tableRows.forEach(row => {
            let shouldShow = true;
            
            Object.entries(this.state.filters).forEach(([filterName, filterValue]) => {
                if (filterValue && filterValue !== 'all') {
                    const cellValue = row.querySelector(`[data-${filterName}]`)?.getAttribute(`data-${filterName}`);
                    if (cellValue !== filterValue) {
                        shouldShow = false;
                    }
                }
            });
            
            row.style.display = shouldShow ? '' : 'none';
        });
        
        if (this.options.onFilter) {
            this.options.onFilter(this.state.filters);
        }
    }

    handleDateFilter(selectedDates) {
        if (selectedDates.length === 2) {
            this.state.filters.dateFrom = selectedDates[0];
            this.state.filters.dateTo = selectedDates[1];
            this.applyFilters();
        }
    }

    // ===== SORTING =====
    
    initSorting() {
        if (!this.options.enableSorting) return;
        
        const sortableColumns = document.querySelectorAll(this.options.sortableColumns);
        sortableColumns.forEach(column => {
            column.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleSort(column);
            });
        });
    }

    handleSort(column) {
        const columnName = column.dataset.sort;
        const currentDirection = this.state.sortDirection;
        
        // Update sort direction
        this.state.sortDirection = this.state.sortColumn === columnName && currentDirection === 'asc' ? 'desc' : 'asc';
        this.state.sortColumn = columnName;
        
        // Update column headers
        this.updateSortIndicators(column);
        
        // Perform sort
        this.performSort(columnName, this.state.sortDirection);
        
        if (this.options.onSort) {
            this.options.onSort(columnName, this.state.sortDirection);
        }
    }

    updateSortIndicators(activeColumn) {
        const allColumns = document.querySelectorAll(this.options.sortableColumns);
        allColumns.forEach(col => {
            col.classList.remove('sort-asc', 'sort-desc');
        });
        
        activeColumn.classList.add(`sort-${this.state.sortDirection}`);
    }

    performSort(columnName, direction) {
        // Check if server-side search is enabled
        if (this.options.enableServerSideSearch) {
            this.state.sortColumn = columnName;
            this.state.sortDirection = direction;
            this.performServerSideSearch();
        } else {
            this.performClientSideSort(columnName, direction);
        }
    }

    performClientSideSort(columnName, direction) {
        const table = document.getElementById(this.options.tableId);
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        rows.sort((a, b) => {
            const aValue = a.querySelector(`[data-${columnName}]`)?.getAttribute(`data-${columnName}`) || '';
            const bValue = b.querySelector(`[data-${columnName}]`)?.getAttribute(`data-${columnName}`) || '';
            
            if (direction === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        });
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
    }

    // ===== STATUS TOGGLE =====
    
    initStatusToggles() {
        if (!this.options.enableStatusToggle) return;
        
        const statusToggles = document.querySelectorAll(`.${this.options.statusToggleClass}`);
        statusToggles.forEach(toggle => {
            toggle.addEventListener('change', (e) => {
                this.handleStatusToggle(e.target);
            });
        });
    }

    async handleStatusToggle(toggle) {
        const itemId = toggle.dataset.id;
        const url = toggle.dataset.url || this.options.statusUrl;
        const statusText = document.querySelector(`.status-text-${itemId}`);
        
        if (!url) {
            console.error('Status URL not provided');
            return;
        }
        
        try {
            this.setLoading(true);
            
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                body: JSON.stringify({
                    status: toggle.checked ? 1 : 0
                })
            });

            const data = await response.json();
            
            if (data.success) {
                if (statusText) {
                    statusText.textContent = toggle.checked ? 'Active' : 'Inactive';
                }
                this.showAlert('success', data.message || this.options.messages.statusSuccess);
                
                if (this.options.onStatusChange) {
                    this.options.onStatusChange(itemId, toggle.checked, data);
                }
            } else {
                toggle.checked = !toggle.checked;
                this.showAlert('error', data.message || this.options.messages.statusError);
            }
        } catch (error) {
            toggle.checked = !toggle.checked;
            this.showAlert('error', this.options.messages.error);
        } finally {
            this.setLoading(false);
        }
    }

    // ===== DELETE FUNCTIONALITY =====
    
    initDeleteButtons() {
        const deleteButtons = document.querySelectorAll(`.${this.options.deleteButtonClass}`);
        deleteButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleDeleteButton(button);
            });
        });
    }

    handleDeleteButton(button) {
        const itemId = button.dataset.id;
        const itemName = button.dataset.name || 'this item';
        
        if (confirm(this.options.messages.confirmDelete.replace('this item', itemName))) {
            this.deleteItem(itemId);
        }
    }

    async deleteItem(itemId) {
        const url = this.options.deleteUrl ? `${this.options.deleteUrl}/${itemId}` : 
                   `${window.location.pathname}/${itemId}`;
        
        try {
            this.setLoading(true);
            
            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken()
                }
            });

            const data = await response.json();
            
            if (data.success) {
                this.showAlert('success', data.message || this.options.messages.deleteSuccess);
                this.removeTableRow(itemId);
                
                if (this.options.onDelete) {
                    this.options.onDelete(itemId, data);
                }
            } else {
                this.showAlert('error', data.message || this.options.messages.deleteError);
            }
        } catch (error) {
            this.showAlert('error', this.options.messages.error);
        } finally {
            this.setLoading(false);
        }
    }

    removeTableRow(itemId) {
        const row = document.querySelector(`tr[data-id="${itemId}"]`);
        if (row) {
            row.remove();
            this.state.selectedItems.delete(itemId);
            this.updateBulkActionButton();
        }
    }

    // ===== BULK ACTIONS =====
    
    initBulkActions() {
        if (!this.options.enableBulkActions) return;
        
        const deleteSelectedBtn = document.getElementById(this.options.deleteSelectedId);
        if (deleteSelectedBtn) {
            deleteSelectedBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleBulkDelete();
            });
        }
    }

    async handleBulkDelete() {
        if (this.state.selectedItems.size === 0) {
            this.showAlert('warning', this.options.messages.noItemsSelected);
            return;
        }
        
        if (confirm(this.options.messages.confirmBulkDelete)) {
            try {
                this.setLoading(true);
                
                const response = await fetch(this.options.bulkDeleteUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.getCsrfToken()
                    },
                    body: JSON.stringify({
                        ids: Array.from(this.state.selectedItems)
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    this.showAlert('success', data.message || 'Items deleted successfully');
                    this.removeSelectedRows();
                    
                    if (this.options.onBulkAction) {
                        this.options.onBulkAction('delete', Array.from(this.state.selectedItems), data);
                    }
                } else {
                    this.showAlert('error', data.message || 'Error deleting items');
                }
            } catch (error) {
                this.showAlert('error', this.options.messages.error);
            } finally {
                this.setLoading(false);
            }
        }
    }

    removeSelectedRows() {
        this.state.selectedItems.forEach(itemId => {
            this.removeTableRow(itemId);
        });
        this.state.selectedItems.clear();
        this.updateBulkActionButton();
    }

    // ===== EDIT AND VIEW BUTTONS =====
    
    initEditButtons() {
        const editButtons = document.querySelectorAll(`.${this.options.editButtonClass}`);
        editButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleEditButton(button);
            });
        });
    }

    handleEditButton(button) {
        const itemId = button.dataset.id;
        const editUrl = button.dataset.url || `${window.location.pathname}/${itemId}/edit`;
        
        if (this.options.onEdit) {
            this.options.onEdit(itemId, editUrl);
        } else {
            window.location.href = editUrl;
        }
    }

    initViewButtons() {
        const viewButtons = document.querySelectorAll(`.${this.options.viewButtonClass}`);
        viewButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleViewButton(button);
            });
        });
    }

    handleViewButton(button) {
        const itemId = button.dataset.id;
        const viewUrl = button.dataset.url || `${window.location.pathname}/${itemId}`;
        
        if (this.options.onView) {
            this.options.onView(itemId, viewUrl);
        } else {
            window.location.href = viewUrl;
        }
    }

    // ===== PAGINATION =====
    
    initPagination() {
        if (!this.options.enablePagination) return;
        
        const itemsPerPageSelect = document.getElementById(this.options.itemsPerPageId);
        if (itemsPerPageSelect) {
            itemsPerPageSelect.addEventListener('change', (e) => {
                this.state.itemsPerPage = parseInt(e.target.value);
                this.updatePagination();
            });
        }
    }

    updatePagination() {
        // Check if server-side search is enabled
        if (this.options.enableServerSideSearch) {
            this.performServerSideSearch();
        } else {
            // This would typically involve a server request to get paginated data
            // For now, we'll just update the display
            if (this.options.onPagination) {
                this.options.onPagination(this.state.currentPage, this.state.itemsPerPage);
            }
        }
    }

    // ===== EXPORT FUNCTIONALITY =====
    
    initExport() {
        if (!this.options.enableExport) return;
        
        const exportButtons = document.querySelectorAll(this.options.exportButtons);
        exportButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleExport(button.dataset.format);
            });
        });
    }

    async handleExport(format = 'csv') {
        try {
            this.setLoading(true);
            
            const response = await fetch(this.options.exportUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                body: JSON.stringify({
                    format: format,
                    filters: this.state.filters,
                    search: this.state.searchTerm
                })
            });

            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `export.${format}`;
                a.click();
                window.URL.revokeObjectURL(url);
            }
        } catch (error) {
            this.showAlert('error', 'Export failed');
        } finally {
            this.setLoading(false);
        }
    }

    // ===== INLINE EDIT =====
    
    initInlineEdit() {
        if (!this.options.enableInlineEdit) return;
        
        const editableCells = document.querySelectorAll('[data-editable]');
        editableCells.forEach(cell => {
            cell.addEventListener('dblclick', (e) => {
                this.makeEditable(cell);
            });
        });
    }

    makeEditable(cell) {
        const currentValue = cell.textContent.trim();
        const input = document.createElement('input');
        input.type = 'text';
        input.value = currentValue;
        input.className = 'form-control form-control-sm';
        
        const originalContent = cell.innerHTML;
        cell.innerHTML = '';
        cell.appendChild(input);
        input.focus();
        
        input.addEventListener('blur', () => {
            this.saveEditableValue(cell, input.value, originalContent);
        });
        
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                this.saveEditableValue(cell, input.value, originalContent);
            } else if (e.key === 'Escape') {
                cell.innerHTML = originalContent;
            }
        });
    }

    async saveEditableValue(cell, newValue, originalContent) {
        const itemId = cell.closest('tr').dataset.id;
        const fieldName = cell.dataset.editable;
        
        try {
            const response = await fetch(`${window.location.pathname}/${itemId}/inline-edit`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                },
                body: JSON.stringify({
                    field: fieldName,
                    value: newValue
                })
            });

            const data = await response.json();
            
            if (data.success) {
                cell.textContent = newValue;
                this.showAlert('success', 'Updated successfully');
            } else {
                cell.innerHTML = originalContent;
                this.showAlert('error', data.message || 'Update failed');
            }
        } catch (error) {
            cell.innerHTML = originalContent;
            this.showAlert('error', 'Update failed');
        }
    }

    // ===== KEYBOARD SHORTCUTS =====
    
    initKeyboardShortcuts() {
        // This is handled in setupEventListeners
    }

    handleKeyboardShortcuts(e) {
        // Ctrl/Cmd + A: Select all
        if ((e.ctrlKey || e.metaKey) && e.key === 'a') {
            e.preventDefault();
            const selectAllCheckbox = document.getElementById(this.options.selectAllId);
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
                selectAllCheckbox.dispatchEvent(new Event('change'));
            }
        }
        
        // Ctrl/Cmd + F: Focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            const searchInput = document.getElementById(this.options.searchInputId);
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Delete: Delete selected items
        if (e.key === 'Delete' && this.state.selectedItems.size > 0) {
            e.preventDefault();
            this.handleBulkDelete();
        }
    }

    // ===== UTILITY FUNCTIONS =====
    
    initTooltips() {
        // Tooltips are initialized in initializeComponents
    }

    initResponsive() {
        // Responsive handling is done in setupEventListeners
    }

    handleResponsive() {
        const table = document.getElementById(this.options.tableId);
        if (table) {
            const wrapper = table.closest(this.options.tableWrapper);
            if (wrapper && window.innerWidth < 768) {
                wrapper.classList.add('table-responsive-sm');
            } else if (wrapper) {
                wrapper.classList.remove('table-responsive-sm');
            }
        }
    }

    setLoading(isLoading) {
        this.state.isLoading = isLoading;
        const table = document.getElementById(this.options.tableId);
        
        if (table) {
            if (isLoading) {
                table.classList.add('loading');
                this.showLoadingOverlay();
            } else {
                table.classList.remove('loading');
                this.hideLoadingOverlay();
            }
        }
    }

    showLoadingOverlay() {
        let overlay = document.querySelector('.table-loading-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'table-loading-overlay';
            overlay.innerHTML = `
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `;
            document.body.appendChild(overlay);
        }
        overlay.style.display = 'flex';
    }

    hideLoadingOverlay() {
        const overlay = document.querySelector('.table-loading-overlay');
        if (overlay) {
            overlay.style.display = 'none';
        }
    }

    showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <i class="ri-${type === 'success' ? 'check-double-line' : type === 'error' ? 'error-warning-line' : 'information-line'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        const container = document.querySelector('.main-content');
        if (container) {
            container.insertBefore(alertDiv, container.firstChild);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    }

    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    // ===== PUBLIC API METHODS =====
    
    refresh() {
        location.reload();
    }

    clearSelection() {
        this.state.selectedItems.clear();
        const checkboxes = document.querySelectorAll(`.${this.options.itemCheckboxClass}`);
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        this.updateSelectAllCheckbox();
        this.updateBulkActionButton();
    }

    getSelectedItems() {
        return Array.from(this.state.selectedItems);
    }

    selectItem(itemId) {
        this.state.selectedItems.add(itemId);
        const checkbox = document.querySelector(`input[value="${itemId}"]`);
        if (checkbox) {
            checkbox.checked = true;
        }
        this.updateSelectAllCheckbox();
        this.updateBulkActionButton();
    }

    deselectItem(itemId) {
        this.state.selectedItems.delete(itemId);
        const checkbox = document.querySelector(`input[value="${itemId}"]`);
        if (checkbox) {
            checkbox.checked = false;
        }
        this.updateSelectAllCheckbox();
        this.updateBulkActionButton();
    }

    // Static method to initialize table with default options
    static init(options = {}) {
        return new AdminTable(options);
    }
}

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AdminTable;
} 