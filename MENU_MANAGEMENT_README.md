# Vanilla JavaScript Menu Management System

This document describes the new vanilla JavaScript menu management system that replaces the jQuery-based implementation.

## Overview

The menu management system has been completely rewritten in vanilla JavaScript to remove jQuery dependencies while maintaining all the original functionality. The new system provides:

- Drag and drop menu item reordering
- Menu item creation and editing
- Menu structure management
- Accordion-style interface
- Responsive design
- Accessibility features

## Files

### New Files
- `public/admin/menu/menu-vanilla.js` - Main JavaScript functionality
- `public/admin/menu/menu-vanilla.css` - Styling for the menu system
- `MENU_MANAGEMENT_README.md` - This documentation

### Modified Files
- `resources/views/backend/menus/edit.blade.php` - Updated to use vanilla JS

### Removed Dependencies
- `public/admin/menu/scripts.js` - jQuery UI scripts (no longer needed)
- `public/admin/menu/scripts2.js` - Additional jQuery scripts (no longer needed)
- `public/admin/menu/menu.js` - Original jQuery-based menu script
- `public/admin/menu/style.css` - Original CSS with jQuery UI dependencies

## Features

### 1. Menu Item Management
- **Add Menu Items**: Click "Add Menu Item" buttons in the sidebar sections
- **Edit Menu Items**: Click the edit icon (pencil) on any menu item
- **Delete Menu Items**: Click the delete link in the menu item settings
- **Update Menu Items**: Click "Update Item" to save changes

### 2. Drag and Drop
- **Reorder Items**: Drag menu items to reorder them
- **Create Submenus**: Drag items to the right edge of another item to nest them as submenus
- **Visual Feedback**: Placeholder shows where the item will be placed
- **Hierarchy Support**: Items maintain their depth levels during drag operations
- **Multi-level Nesting**: Support for up to 11 levels of nested submenus

### 3. Menu Structure
- **Depth Levels**: Menu items can be nested up to 11 levels deep
- **Visual Indentation**: Each level is visually indented with colored borders
- **Parent-Child Relationships**: Automatically calculated based on DOM hierarchy
- **Submenu Indicators**: Visual indicators show which items are submenus
- **Dynamic Nesting**: Create and modify submenu structures through drag and drop

### 4. Interface Features
- **Accordion Sections**: Collapsible sidebar sections for different content types
- **Responsive Design**: Works on desktop and mobile devices
- **Loading Indicators**: Spinners show during AJAX operations
- **Error Handling**: Graceful error handling with user feedback

## Technical Implementation

### Class Structure
The system uses a `MenuManager` class that encapsulates all functionality:

```javascript
class MenuManager {
    constructor() {
        // Initialize with configuration from Blade template
    }
    
    init() {
        // Set up event listeners and initialize features
    }
    
    // ... other methods
}
```

### Configuration
The system reads configuration from the Blade template:

```javascript
window.menuConfig = {
    menus: {
        // Localized strings
    },
    routes: {
        // Laravel routes
    },
    csrfToken: "token",
    currentUrl: "url"
};
```

### Event Handling
All events are handled using vanilla JavaScript:

```javascript
// Example: Add menu item button
document.querySelectorAll('.submit-add-to-menu').forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        this.addCustomMenu(e.target);
    });
});
```

### AJAX Requests
Uses `XMLHttpRequest` instead of jQuery AJAX:

```javascript
makeRequest(url, data, method = 'POST') {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        // ... request implementation
    });
}
```

## Usage

### Basic Setup
1. Include the CSS file in your layout:
```html
<link href="{{asset('admin/menu/menu-vanilla.css')}}" rel="stylesheet">
```

2. Include the JavaScript file:
```html
<script src="{{asset('admin/menu/menu-vanilla.js')}}"></script>
```

3. Add the configuration script:
```html
<script>
window.menuConfig = {
    // ... configuration
};
</script>
```

### Adding Menu Items
1. Open an accordion section in the sidebar
2. Select an item from the dropdown
3. Click "Add Menu Item"

### Editing Menu Items
1. Click the edit icon on any menu item
2. Modify the settings in the expanded panel
3. Click "Update Item" to save changes

### Reordering Menu Items
1. Drag any menu item to a new position
2. The placeholder shows where the item will be placed
3. Release to drop the item in its new position

### Creating Submenus

#### Method 1: Drag and Drop (Manual)
1. Drag a menu item to the right edge of another item
2. Watch for the blue border and arrow indicator
3. Release to create a submenu relationship
4. The item will be indented and show a "Subelement" indicator

#### Method 2: Programmatic Creation (JavaScript)
```javascript
// Create a submenu with multiple items
window.menuManager.createSubmenuWithItems(1, [
    {title: 'Submenu Item 1', type: 'page', prefix: 'page-show'},
    {title: 'Submenu Item 2', type: 'page', prefix: 'page-show'}
]);

// Add a single item to existing submenu
window.menuManager.addItemToSubmenu(1, 'New Submenu Item', 'page', 'page-show');
```

#### Creating Multiple Submenu Items
To create a submenu with two or more items:

1. **Use the helper method**:
```javascript
window.menuManager.createSubmenuWithItems(parentId, [
    {title: 'First Submenu Item', type: 'page', prefix: 'page-show'},
    {title: 'Second Submenu Item', type: 'page', prefix: 'page-show'},
    {title: 'Third Submenu Item', type: 'page', prefix: 'page-show'}
]);
```

2. **Or add items one by one**:
```javascript
window.menuManager.addItemToSubmenu(parentId, 'First Item', 'page', 'page-show');
window.menuManager.addItemToSubmenu(parentId, 'Second Item', 'page', 'page-show');
```

### Managing Submenu Structure
- **Nest Items**: Drag items to the right edge to nest them
- **Unnest Items**: Drag items to the left to move them to a higher level
- **Visual Feedback**: Each nesting level has a different colored border
- **Depth Limits**: Maximum nesting depth is 11 levels

## Browser Support

The system supports all modern browsers:
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Performance Benefits

### Reduced Bundle Size
- Removed jQuery dependency (~30KB)
- Removed jQuery UI dependency (~50KB)
- Custom CSS instead of jQuery UI themes

### Improved Performance
- Native drag and drop API
- Direct DOM manipulation
- No jQuery overhead

### Better Maintainability
- Modern JavaScript syntax
- Class-based architecture
- Clear separation of concerns

## Migration from jQuery Version

### What Changed
1. **JavaScript**: Complete rewrite in vanilla JS
2. **CSS**: Simplified styles without jQuery UI dependencies
3. **Dependencies**: Removed jQuery and jQuery UI

### What Stayed the Same
1. **HTML Structure**: No changes to the Blade template structure
2. **API Endpoints**: Same Laravel routes and controllers
3. **User Interface**: Same visual appearance and behavior
4. **Functionality**: All features work exactly the same

### Migration Steps
1. Replace the old CSS file with `menu-vanilla.css`
2. Replace the old JavaScript files with `menu-vanilla.js`
3. Update the configuration script in the Blade template
4. Remove jQuery dependencies from your layout

## Troubleshooting

### Common Issues

1. **Menu items not draggable**
   - Check that the `draggable` attribute is set on menu items
   - Ensure the `initSortable()` method is called

2. **AJAX requests failing**
   - Verify CSRF token is included in requests
   - Check that routes are correctly configured

3. **Accordion not working**
   - Ensure accordion sections have the correct CSS classes
   - Check that event listeners are properly bound

### Debug Mode
Enable debug logging by adding this to the console:

```javascript
window.menuManager.debug = true;
```

## Contributing

When making changes to the menu system:

1. **JavaScript**: Follow ES6+ syntax and class-based patterns
2. **CSS**: Use BEM methodology for class naming
3. **Testing**: Test on multiple browsers and devices
4. **Documentation**: Update this README for any new features

## License

This menu management system is part of the kshop project and follows the same license terms. 