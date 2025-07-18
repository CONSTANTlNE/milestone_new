# Admin Table Functions - Complete Usage Guide

This comprehensive table function library provides all the functionality needed for admin tables in Laravel applications.

## Features

- ✅ **Selection & Bulk Actions**: Select all, individual selection, bulk delete
- ✅ **Search**: Real-time search with debouncing
- ✅ **Filtering**: Multiple filter types (dropdown, date range, etc.)
- ✅ **Sorting**: Click-to-sort columns with visual indicators
- ✅ **Status Toggle**: AJAX status updates with visual feedback
- ✅ **CRUD Operations**: View, edit, delete with confirmation modals
- ✅ **Pagination**: Server-side pagination support
- ✅ **Export**: CSV, Excel export functionality
- ✅ **Inline Edit**: Double-click to edit cells
- ✅ **Keyboard Shortcuts**: Ctrl+A (select all), Ctrl+F (search), Delete (bulk delete)
- ✅ **Responsive Design**: Mobile-friendly table layouts
- ✅ **Loading States**: Visual feedback during operations
- ✅ **Dark Mode Support**: Automatic dark mode detection
- ✅ **Print Styles**: Optimized for printing

## Basic Setup

### 1. Include the Files

Add to your layout or view:

```html
<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">

<!-- JavaScript -->
<script src="{{ asset('js/my/table-functions.js') }}"></script>
```

### 2. HTML Structure

```html
<div class="table-responsive">
    <table id="myTable" class="table">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th>
                <th class="sortable" data-sort="id">ID</th>
                <th class="sortable" data-sort="name">Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr data-id="1">
                <td><input type="checkbox" class="item-checkbox" value="1"></td>
                <td data-id="1">1</td>
                <td data-name="John Doe" data-editable="name">John Doe</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox" 
                               data-id="1" data-url="/api/items/1/status">
                        <label class="form-check-label">
                            <span class="status-text-1">Active</span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="/items/1" class="ti-btn ti-btn-sm ti-btn-info-full view-item" 
                           data-id="1" title="View">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a href="/items/1/edit" class="ti-btn ti-btn-sm ti-btn-warning-full edit-item" 
                           data-id="1" title="Edit">
                            <i class="ri-edit-line"></i>
                        </a>
                        <button class="ti-btn ti-btn-sm ti-btn-danger-full delete-item" 
                                data-id="1" data-name="John Doe" title="Delete">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Search and Controls -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="filter-controls">
        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
        <select id="filterSelect" name="status" class="form-select">
            <option value="all">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="export-buttons">
        <button class="ti-btn export-btn" data-format="csv">Export CSV</button>
        <button class="ti-btn export-btn" data-format="excel">Export Excel</button>
    </div>
</div>

<!-- Bulk Actions -->
<button id="delete-selected" class="ti-btn bg-danger text-white" style="display: none;">
    Delete Selected
</button>
```

### 3. JavaScript Initialization

```javascript
document.addEventListener('DOMContentLoaded', function() {
    const table = AdminTable.init({
        // Basic configuration
        tableId: 'myTable',
        selectAllId: 'select-all',
        itemCheckboxClass: 'item-checkbox',
        deleteSelectedId: 'delete-selected',
        searchInputId: 'searchInput',
        
        // Features
        enableBulkActions: true,
        enableSearch: true,
        enableFiltering: true,
        enableSorting: true,
        enableStatusToggle: true,
        enableInlineEdit: true,
        enableExport: true,
        
        // API endpoints
        statusUrl: '/api/items/{id}/status',
        deleteUrl: '/api/items/{id}',
        bulkDeleteUrl: '/api/items/bulk-delete',
        exportUrl: '/api/items/export',
        
        // Messages
        messages: {
            confirmDelete: 'Are you sure you want to delete this item?',
            confirmBulkDelete: 'Are you sure you want to delete selected items?',
            deleteSuccess: 'Item deleted successfully',
            statusSuccess: 'Status updated successfully'
        },
        
        // Callbacks
        onItemSelect: function(itemId, isSelected) {
            console.log(`Item ${itemId} ${isSelected ? 'selected' : 'deselected'}`);
        },
        
        onStatusChange: function(itemId, isActive, data) {
            console.log(`Item ${itemId} status changed to ${isActive ? 'active' : 'inactive'}`);
        },
        
        onDelete: function(itemId, data) {
            console.log(`Item ${itemId} deleted`);
        },
        
        onBulkAction: function(action, itemIds, data) {
            console.log(`Bulk ${action} performed on ${itemIds.length} items`);
        }
    });
});
```

## Usage Examples

### 1. Simple Permissions Table

```javascript
const permissionsTable = AdminTable.init({
    tableId: 'permissionsTable',
    itemCheckboxClass: 'permission-checkbox-item',
    deleteButtonClass: 'delete-permission',
    statusToggleClass: 'status-toggle',
    
    // Features
    enableBulkActions: true,
    enableSearch: true,
    enableStatusToggle: true,
    
    // API endpoints
    bulkDeleteUrl: '{{ route("backend.permissions.massDestroy", app()->getLocale()) }}',
    
    // Messages
    messages: {
        confirmDelete: '{{ __("admin.confirm_delete") }}',
        confirmBulkDelete: '{{ __("admin.confirm_bulk_delete") }}'
    }
});
```

### 2. Advanced Users Table with Filters

```javascript
const usersTable = AdminTable.init({
    tableId: 'usersTable',
    itemCheckboxClass: 'user-checkbox-item',
    
    // Features
    enableBulkActions: true,
    enableSearch: true,
    enableFiltering: true,
    enableSorting: true,
    enableStatusToggle: true,
    enableInlineEdit: true,
    enableExport: true,
    
    // Filter configuration
    filterSelectId: 'userFilters',
    dateRangeId: 'userDateRange',
    
    // API endpoints
    statusUrl: '/api/users/{id}/status',
    deleteUrl: '/api/users/{id}',
    bulkDeleteUrl: '/api/users/bulk-delete',
    exportUrl: '/api/users/export',
    
    // Callbacks
    onFilter: function(filters) {
        console.log('Filters applied:', filters);
        // You can trigger server-side filtering here
    },
    
    onSort: function(column, direction) {
        console.log(`Sorting by ${column} in ${direction} order`);
        // You can trigger server-side sorting here
    }
});
```

### 3. Products Table with Export

```javascript
const productsTable = AdminTable.init({
    tableId: 'productsTable',
    itemCheckboxClass: 'product-checkbox-item',
    
    // Features
    enableBulkActions: true,
    enableSearch: true,
    enableFiltering: true,
    enableSorting: true,
    enableExport: true,
    
    // Export configuration
    exportButtons: '.export-btn',
    exportUrl: '/api/products/export',
    
    // Callbacks
    onBulkAction: function(action, itemIds, data) {
        if (action === 'delete') {
            // Handle bulk delete
            console.log(`Deleting ${itemIds.length} products`);
        } else if (action === 'export') {
            // Handle bulk export
            console.log(`Exporting ${itemIds.length} products`);
        }
    }
});
```

## API Endpoints

### Status Toggle
```php
// POST /api/items/{id}/status
public function updateStatus(Request $request, $id)
{
    $item = Item::findOrFail($id);
    $item->status = $request->status;
    $item->save();
    
    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully'
    ]);
}
```

### Delete Item
```php
// DELETE /api/items/{id}
public function destroy($id)
{
    $item = Item::findOrFail($id);
    $item->delete();
    
    return response()->json([
        'success' => true,
        'message' => 'Item deleted successfully'
    ]);
}
```

### Bulk Delete
```php
// POST /api/items/bulk-delete
public function bulkDestroy(Request $request)
{
    $ids = $request->ids;
    Item::whereIn('id', $ids)->delete();
    
    return response()->json([
        'success' => true,
        'message' => count($ids) . ' items deleted successfully'
    ]);
}
```

### Export
```php
// POST /api/items/export
public function export(Request $request)
{
    $format = $request->format;
    $filters = $request->filters;
    $search = $request->search;
    
    $query = Item::query();
    
    // Apply filters
    if (!empty($filters['status'])) {
        $query->where('status', $filters['status']);
    }
    
    // Apply search
    if (!empty($search)) {
        $query->where('name', 'like', "%{$search}%");
    }
    
    $items = $query->get();
    
    if ($format === 'csv') {
        return $this->exportToCsv($items);
    } else {
        return $this->exportToExcel($items);
    }
}
```

## Public API Methods

```javascript
// Get the table instance
const table = AdminTable.init(options);

// Public methods
table.refresh();                    // Reload the page
table.clearSelection();             // Clear all selections
table.getSelectedItems();           // Get array of selected item IDs
table.selectItem(itemId);           // Select specific item
table.deselectItem(itemId);         // Deselect specific item
```

## Keyboard Shortcuts

- **Ctrl/Cmd + A**: Select all items
- **Ctrl/Cmd + F**: Focus search input
- **Delete**: Delete selected items (if any selected)
- **Escape**: Cancel inline editing

## CSS Classes

The library uses these CSS classes for styling:

- `.sortable`: Sortable column headers
- `.sort-asc` / `.sort-desc`: Sort direction indicators
- `.status-toggle`: Status toggle switches
- `.item-checkbox`: Individual item checkboxes
- `.delete-item` / `.edit-item` / `.view-item`: Action buttons
- `.action-buttons`: Container for action buttons
- `.table-loading-overlay`: Loading overlay
- `.search-results`: Search results counter
- `.empty-state`: Empty state styling

## Customization

### Custom Messages
```javascript
messages: {
    confirmDelete: 'Are you sure?',
    confirmBulkDelete: 'Delete selected items?',
    deleteSuccess: 'Successfully deleted',
    statusSuccess: 'Status updated',
    noItemsSelected: 'Please select items',
    searchNoResults: 'No results found',
    loading: 'Loading...',
    error: 'An error occurred'
}
```

### Custom Callbacks
```javascript
onItemSelect: function(itemId, isSelected) {
    // Custom logic when item is selected/deselected
},

onStatusChange: function(itemId, isActive, data) {
    // Custom logic when status changes
},

onDelete: function(itemId, data) {
    // Custom logic when item is deleted
},

onBulkAction: function(action, itemIds, data) {
    // Custom logic for bulk actions
},

onSearch: function(searchTerm, visibleCount) {
    // Custom logic when search is performed
},

onFilter: function(filters) {
    // Custom logic when filters are applied
},

onSort: function(column, direction) {
    // Custom logic when sorting is performed
}
```

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Dependencies

- Bootstrap 5.x (for modals and tooltips)
- Remix Icons (for icons)
- Optional: Flatpickr (for date pickers)

## Performance Tips

1. **Debounced Search**: Search is automatically debounced to 300ms
2. **Lazy Loading**: Use pagination for large datasets
3. **Virtual Scrolling**: For very large tables, consider virtual scrolling
4. **Server-side Processing**: Use server-side search/filter for large datasets

## Troubleshooting

### Common Issues

1. **CSRF Token Missing**: Ensure `<meta name="csrf-token">` is in your layout
2. **Bootstrap Not Loaded**: Make sure Bootstrap JS is loaded for modals
3. **Icons Not Showing**: Ensure Remix Icons CSS is loaded
4. **AJAX Errors**: Check network tab for failed requests

### Debug Mode

```javascript
const table = AdminTable.init({
    // ... options
    debug: true  // Enable console logging
});
```

This comprehensive table function library provides everything you need for professional admin tables in Laravel applications. 