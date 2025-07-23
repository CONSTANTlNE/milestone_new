// Vanilla JavaScript Menu Management System
// Replaces jQuery-based menu functionality

class MenuManager {
    constructor() {
        this.arraydata = [];
        
        // Use configuration from Blade template
        const config = window.menuConfig || {};
        this.menus = config.menus || {
            "oneThemeLocationNoMenus": "",
            "moveUnder": "Move Under",
            "moveOutFrom": "Move Out From",
            "under": "Under",
            "outFrom": "Out From",
            "menuFocus": "Menu Focus",
            "deleteMenu": "Are you sure you want to delete this menu?",
            "enterMenuName": "Enter menu name",
            "subMenuFocus": "Submenu Focus"
        };
        
        this.routes = config.routes || {
            addCustomMenu: '/admin/menus/items/create',
            updateItem: '/admin/menus/items/update',
            deleteItem: '/admin/menus/items/delete',
            generateMenu: '/admin/menus/updateMenu',
            deleteMenu: '/admin/menus/deleteMenu',
            createNewMenu: '/admin/menus/store'
        };
        
        this.csrfToken = config.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        this.currentUrl = config.currentUrl || window.location.href;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.initSortable();
        this.initAccordion();
        this.initializeMenuStructure();
    }

    bindEvents() {
        // Add custom menu item buttons
        document.querySelectorAll('.submit-add-to-menu').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.addCustomMenu(e.target);
            });
        });

        // Update menu buttons
        document.querySelectorAll('.updatemenu').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.getMenus();
            });
        });

        // Save menu button
        const saveMenuBtn = document.getElementById('save_menu_header');
        if (saveMenuBtn) {
            saveMenuBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.getMenus();
            });
        }

        // Delete menu item buttons
        document.querySelectorAll('.item-delete').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const id = button.id.split('-')[1];
                this.deleteItem(id);
            });
        });

        // Quick delete buttons
        document.querySelectorAll('.item-delete-quick').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const id = button.id.split('-')[2];
                this.deleteMenuItem(id);
            });
        });

        // Cancel buttons
        document.querySelectorAll('.item-cancel').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const id = button.id.split('-')[1];
                this.cancelEdit(id);
            });
        });

        // Edit buttons
        document.querySelectorAll('.item-edit').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const id = button.id.split('-')[1];
                this.toggleEdit(id);
            });
        });
    }

    initSortable() {
        const menuContainer = document.getElementById('menu-to-edit');
        if (!menuContainer) return;

        let draggedElement = null;
        let placeholder = null;
        let dropTarget = null;
        let dropPosition = null;

        menuContainer.addEventListener('dragstart', (e) => {
            if (e.target.classList.contains('menu-item')) {
                draggedElement = e.target;
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', e.target.outerHTML);
                
                // Create placeholder
                placeholder = document.createElement('li');
                placeholder.className = 'sortable-placeholder';
                placeholder.style.height = draggedElement.offsetHeight + 'px';
                placeholder.style.border = '2px dashed #ccc';
                placeholder.style.backgroundColor = '#f9f9f9';
                placeholder.style.margin = '5px 0';
                
                setTimeout(() => {
                    draggedElement.style.opacity = '0.5';
                }, 0);
            }
        });

        menuContainer.addEventListener('dragend', (e) => {
            if (draggedElement) {
                draggedElement.style.opacity = '';
                draggedElement = null;
                if (placeholder && placeholder.parentNode) {
                    placeholder.parentNode.removeChild(placeholder);
                }
                placeholder = null;
                dropTarget = null;
                dropPosition = null;
            }
        });

        menuContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            
            if (!draggedElement) return;
            
            const target = e.target.closest('.menu-item');
            if (!target || target === draggedElement || this.isDescendant(draggedElement, target)) return;
            
            const rect = target.getBoundingClientRect();
            const midpoint = rect.top + rect.height / 2;
            const targetDepth = this.getMenuDepth(target);
            const draggedDepth = this.getMenuDepth(draggedElement);
            
            // Determine drop position
            if (e.clientY < midpoint) {
                dropPosition = 'before';
            } else {
                dropPosition = 'after';
            }
            
            // Check if we can nest (drop into as child)
            const canNest = this.canNestAsChild(draggedElement, target);
            const nestThreshold = rect.left + 20; // 20px from left edge for nesting
            
            if (canNest && e.clientX > nestThreshold && dropPosition === 'after') {
                dropPosition = 'child';
            }
            
            dropTarget = target;
            
            // Update visual feedback
            this.updateDropVisualFeedback(target, dropPosition);
        });

        menuContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            if (draggedElement && dropTarget && dropPosition) {
                this.performDrop(draggedElement, dropTarget, dropPosition);
                this.updateMenuStructure();
            }
        });

        // Make menu items draggable
        document.querySelectorAll('.menu-item').forEach(item => {
            item.draggable = true;
        });
    }

    isDescendant(parent, child) {
        let current = child.parentElement;
        while (current) {
            if (current === parent) return true;
            current = current.parentElement;
        }
        return false;
    }

    getMenuDepth(element) {
        for (let i = 0; i <= 11; i++) {
            if (element.classList.contains('menu-item-depth-' + i)) {
                return i;
            }
        }
        return 0;
    }

    canNestAsChild(draggedElement, target) {
        const targetDepth = this.getMenuDepth(target);
        const draggedDepth = this.getMenuDepth(draggedElement);
        
        // Can't nest if target is already at max depth
        if (targetDepth >= 10) return false;
        
        // Can't nest if dragged element has children and we're trying to make it a child
        const draggedChildren = draggedElement.querySelectorAll('.menu-item');
        if (draggedChildren.length > 0) return false;
        
        return true;
    }

    updateDropVisualFeedback(target, position) {
        // Remove existing feedback
        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('drop-before', 'drop-after', 'drop-child');
        });
        
        // Add new feedback
        if (position === 'before') {
            target.classList.add('drop-before');
        } else if (position === 'after') {
            target.classList.add('drop-after');
        } else if (position === 'child') {
            target.classList.add('drop-child');
        }
    }

    performDrop(draggedElement, target, position) {
        const targetContainer = target.closest('ul');
        const targetDepth = this.getMenuDepth(target);
        
        if (position === 'before') {
            targetContainer.insertBefore(draggedElement, target);
            this.updateMenuDepth(draggedElement, targetDepth);
        } else if (position === 'after') {
            targetContainer.insertBefore(draggedElement, target.nextSibling);
            this.updateMenuDepth(draggedElement, targetDepth);
        } else if (position === 'child') {
            // Create submenu container if it doesn't exist
            let submenu = target.querySelector('ul.menu');
            if (!submenu) {
                submenu = document.createElement('ul');
                submenu.className = 'menu submenu';
                submenu.style.marginLeft = '20px';
                target.appendChild(submenu);
            }
            
            submenu.appendChild(draggedElement);
            this.updateMenuDepth(draggedElement, targetDepth + 1);
        }
    }

    updateMenuDepth(element, newDepth) {
        // Remove old depth class
        for (let i = 0; i <= 11; i++) {
            element.classList.remove('menu-item-depth-' + i);
        }
        
        // Add new depth class
        element.classList.add('menu-item-depth-' + newDepth);
        
        // Update submenu indicator
        const submenuIndicator = element.querySelector('.is-submenu');
        if (newDepth > 0) {
            if (!submenuIndicator) {
                const titleSpan = element.querySelector('.menu-item-title');
                if (titleSpan) {
                    const indicator = document.createElement('span');
                    indicator.className = 'is-submenu';
                    indicator.textContent = 'Subelement';
                    titleSpan.appendChild(indicator);
                }
            }
        } else {
            if (submenuIndicator) {
                submenuIndicator.remove();
            }
        }
        
        // Update visual indentation - use CSS classes instead of inline styles
        element.style.marginLeft = '';
    }

    initializeMenuStructure() {
        // Clean up any duplicate items first
        this.removeDuplicateItems();
        
        // Ensure all menu items are properly structured on page load
        const menuItems = document.querySelectorAll('#menu-to-edit .menu-item');
        
        menuItems.forEach(item => {
            const depth = this.getMenuDepth(item);
            
            // Ensure proper submenu indicators
            if (depth > 0) {
                const submenuIndicator = item.querySelector('.is-submenu');
                if (!submenuIndicator) {
                    const titleSpan = item.querySelector('.menu-item-title');
                    if (titleSpan) {
                        const indicator = document.createElement('span');
                        indicator.className = 'is-submenu';
                        indicator.textContent = 'Subelement';
                        titleSpan.appendChild(indicator);
                    }
                }
            }
            
            // Ensure proper submenu containers
            const parent = item.parentElement;
            if (depth > 0 && parent && !parent.classList.contains('submenu')) {
                // This item should be in a submenu but isn't
                const grandParent = parent.parentElement;
                if (grandParent && grandParent.classList.contains('menu-item')) {
                    // Create submenu container
                    const submenu = document.createElement('ul');
                    submenu.className = 'menu submenu';
                    grandParent.appendChild(submenu);
                    submenu.appendChild(item);
                }
            }
        });
        
        // Make all menu items draggable
        menuItems.forEach(item => {
            item.draggable = true;
        });
        

    }

    removeDuplicateItems() {
        const menuItems = document.querySelectorAll('#menu-to-edit .menu-item');
        const seenIds = new Set();
        const duplicates = [];
        
        menuItems.forEach(item => {
            const id = item.id.split('-')[2];
            if (seenIds.has(id)) {
                duplicates.push(item);
            } else {
                seenIds.add(id);
            }
        });
        
        if (duplicates.length > 0) {
            duplicates.forEach(item => {
                item.remove();
            });
        }
    }

    initAccordion() {
        document.querySelectorAll('.accordion-section-title').forEach(title => {
            title.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleAccordion(e.target);
            });
            
            title.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.toggleAccordion(e.target);
                }
            });
        });
    }

    toggleAccordion(titleElement) {
        const section = titleElement.closest('.accordion-section');
        const content = section.querySelector('.accordion-section-content');
        
        if (section.classList.contains('open')) {
            section.classList.remove('open');
            content.style.display = 'none';
        } else {
            // Close other open sections
            document.querySelectorAll('.accordion-section.open').forEach(openSection => {
                openSection.classList.remove('open');
                openSection.querySelector('.accordion-section-content').style.display = 'none';
            });
            
            section.classList.add('open');
            content.style.display = 'block';
        }
    }

    getMenus() {
        this.arraydata = [];
        this.showSpinner('spinsavemenu');

        const menuItems = document.querySelectorAll('#menu-to-edit .menu-item');
        let cont = 0;

        menuItems.forEach((item, index) => {
            const dept = this.getMenuDepth(item);
            const id = item.id.split('-')[2];
            let padre = 0;

            // Find parent based on actual DOM hierarchy
            if (dept > 0) {
                const parentElement = this.findParentElement(item);
                if (parentElement) {
                    padre = parentElement.id.split('-')[2];
                }
            }

            this.arraydata.push({
                depth: dept,
                id: id,
                parent: padre,
                sort: cont,
                role_id: this.getElementValue('role_menu_' + id) || 0
            });
            cont++;
        });


        this.updateItem();
        this.actualizarMenu();
    }

    findParentElement(element) {
        // Find the immediate parent menu item in the DOM hierarchy
        let current = element.parentElement;
        
        while (current && current !== document.getElementById('menu-to-edit')) {
            if (current.classList.contains('menu-item')) {
                return current;
            }
            current = current.parentElement;
        }
        
        return null;
    }



    addCustomMenu(element) {
        this.showSpinner('spincustomu');
        
        const container = element.closest('.customlinkdiv');
        const prefix = container.querySelector('#custom-menu-item-prefix').value;
        const slug = container.querySelector('#custom-menu-item-slug')?.value || '';
        const title = container.querySelector('#custom-menu-item-title-' + prefix).value;
        const model = container.querySelector('#custom-menu-item-model').value;
        const role = container.querySelector('#custom-menu-item-role')?.value || '';
        const idmenu = document.getElementById('idmenu').value;

        const data = {
            menuTitle: title,
            menuSlug: slug,
            menuPrefix: prefix,
            menuModel: model,
            rolemenu: role,
            idmenu: idmenu
        };

        this.makeRequest(this.routes.addCustomMenu, data, 'POST')
            .then(response => {
                window.location.reload();
            })
            .catch(error => {
                // Error handling for menu item addition
            })
            .finally(() => {
                this.hideSpinner('spincustomu');
            });
    }

    addMultiplePages(element) {
        const container = element.closest('.customlinkdiv');
        const checkboxes = container.querySelectorAll('.page-checkbox:checked');
        
        if (checkboxes.length === 0) {
            alert('გთხოვთ აირჩიოთ მინიმუმ ერთი გვერდი');
            return;
        }

        this.showSpinner('spincustomu');
        
        const prefix = container.querySelector('#custom-menu-item-prefix').value;
        const model = container.querySelector('#custom-menu-item-model').value;
        const idmenu = document.getElementById('idmenu').value;

        // Create array of selected pages
        const selectedPages = Array.from(checkboxes).map(checkbox => checkbox.value);

        // Show progress message
        const progressDiv = document.createElement('div');
        progressDiv.id = 'bulk-add-progress';
        progressDiv.style.cssText = 'background: #e7f7ff; border: 1px solid #0073aa; padding: 10px; margin: 10px 0; border-radius: 4px; text-align: center;';
        progressDiv.innerHTML = `დასამატებელია ${selectedPages.length} გვერდი...`;
        container.appendChild(progressDiv);

        // Add each page one by one
        let addedCount = 0;
        const totalPages = selectedPages.length;

        const addNextPage = (index) => {
            if (index >= totalPages) {
                // All pages added, reload the page
                progressDiv.innerHTML = `წარმატებით დაემატა ${addedCount} გვერდი! გვერდი იტვირთება...`;
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
                return;
            }

            const pageData = selectedPages[index];
            const data = {
                menuTitle: pageData,
                menuSlug: '',
                menuPrefix: prefix,
                menuModel: model,
                rolemenu: '',
                idmenu: idmenu
            };

            // Update progress
            progressDiv.innerHTML = `დამატებულია ${addedCount} / ${totalPages} გვერდი...`;

            this.makeRequest(this.routes.addCustomMenu, data, 'POST')
                .then(response => {
                    addedCount++;
                    console.log(`Added page ${addedCount} of ${totalPages}`);
                    // Add next page
                    addNextPage(index + 1);
                })
                .catch(error => {
                    console.error(`Error adding page ${index + 1}:`, error);
                    // Continue with next page even if one fails
                    addNextPage(index + 1);
                });
        };

        // Start adding pages
        addNextPage(0);
    }

    addMultipleCategories(element) {
        const container = element.closest('.customlinkdiv');
        const checkboxes = container.querySelectorAll('.category-checkbox:checked');
        
        if (checkboxes.length === 0) {
            alert('Please select at least one category.');
            return;
        }

        this.showSpinner('spincustomu');
        
        const prefix = container.querySelector('#custom-menu-item-prefix').value;
        const model = container.querySelector('#custom-menu-item-model').value;
        const idmenu = document.getElementById('idmenu').value;

        // Create array of selected categories
        const selectedCategories = Array.from(checkboxes).map(checkbox => checkbox.value);

        // Show progress message
        const progressDiv = document.createElement('div');
        progressDiv.id = 'bulk-add-progress';
        progressDiv.style.cssText = 'background: #e7f7ff; border: 1px solid #0073aa; padding: 10px; margin: 10px 0; border-radius: 4px; text-align: center;';
        progressDiv.innerHTML = `Adding ${selectedCategories.length} categories...`;
        container.appendChild(progressDiv);

        // Add each category one by one
        let addedCount = 0;
        const totalCategories = selectedCategories.length;

        const addNextCategory = (index) => {
            if (index >= totalCategories) {
                // All categories added, reload the page
                progressDiv.innerHTML = `Successfully added ${addedCount} categories! Reloading...`;
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
                return;
            }

            const categoryData = selectedCategories[index];
            const data = {
                menuTitle: categoryData,
                menuSlug: '',
                menuPrefix: prefix,
                menuModel: model,
                rolemenu: '',
                idmenu: idmenu
            };

            // Update progress
            progressDiv.innerHTML = `Added ${addedCount} / ${totalCategories} categories...`;

            this.makeRequest(this.routes.addCustomMenu, data, 'POST')
                .then(response => {
                    addedCount++;
                    console.log(`Added category ${addedCount} of ${totalCategories}`);
                    // Add next category
                    addNextCategory(index + 1);
                })
                .catch(error => {
                    console.error(`Error adding category ${index + 1}:`, error);
                    // Continue with next category even if one fails
                    addNextCategory(index + 1);
                });
        };

        // Start adding categories
        addNextCategory(0);
    }

    addMultipleServiceCategories(element) {
        const container = element.closest('.customlinkdiv');
        const checkboxes = container.querySelectorAll('.service-category-checkbox:checked');
        
        if (checkboxes.length === 0) {
            alert('Please select at least one service category.');
            return;
        }

        this.showSpinner('spincustomu');
        
        const prefix = container.querySelector('#custom-menu-item-prefix').value;
        const model = container.querySelector('#custom-menu-item-model').value;
        const idmenu = document.getElementById('idmenu').value;

        // Create array of selected service categories
        const selectedServiceCategories = Array.from(checkboxes).map(checkbox => checkbox.value);

        // Show progress message
        const progressDiv = document.createElement('div');
        progressDiv.id = 'bulk-add-progress';
        progressDiv.style.cssText = 'background: #e7f7ff; border: 1px solid #0073aa; padding: 10px; margin: 10px 0; border-radius: 4px; text-align: center;';
        progressDiv.innerHTML = `Adding ${selectedServiceCategories.length} service categories...`;
        container.appendChild(progressDiv);

        // Add each service category one by one
        let addedCount = 0;
        const totalServiceCategories = selectedServiceCategories.length;

        const addNextServiceCategory = (index) => {
            if (index >= totalServiceCategories) {
                // All service categories added, reload the page
                progressDiv.innerHTML = `Successfully added ${addedCount} service categories! Reloading...`;
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
                return;
            }

            const serviceCategoryData = selectedServiceCategories[index];
            const data = {
                menuTitle: serviceCategoryData,
                menuSlug: '',
                menuPrefix: prefix,
                menuModel: model,
                rolemenu: '',
                idmenu: idmenu
            };

            // Update progress
            progressDiv.innerHTML = `Added ${addedCount} / ${totalServiceCategories} service categories...`;

            this.makeRequest(this.routes.addCustomMenu, data, 'POST')
                .then(response => {
                    addedCount++;
                    console.log(`Added service category ${addedCount} of ${totalServiceCategories}`);
                    // Add next service category
                    addNextServiceCategory(index + 1);
                })
                .catch(error => {
                    console.error(`Error adding service category ${index + 1}:`, error);
                    // Continue with next service category even if one fails
                    addNextServiceCategory(index + 1);
                });
        };

        // Start adding service categories
        addNextServiceCategory(0);
    }

    updateItem(id = 0) {
        let data;

        if (id) {
            const label = this.getElementValue('idlabelmenu_' + id);
            const clases = this.getElementValue('clases_menu_' + id);
            const url = this.getElementValue('url_menu_' + id);
            const role_id = this.getElementValue('role_menu_' + id) || 0;

            data = {
                label: label,
                clases: clases,
                url: url,
                role_id: role_id,
                id: id
            };
        } else {
            const arr_data = [];
            document.querySelectorAll('.menu-item-settings').forEach((setting, k) => {
                const id = setting.querySelector('.edit-menu-item-id').value;
                const label = setting.querySelector('.edit-menu-item-title')?.value || '';
                const clases = setting.querySelector('.edit-menu-item-classes')?.value || '';
                const url = setting.querySelector('.edit-menu-item-url')?.value || '';
                const role = setting.querySelector('.edit-menu-item-role')?.value || '';

                arr_data.push({
                    id: id,
                    label: label,
                    class: clases,
                    link: url,
                    role_id: role
                });
            });

            data = { arraydata: arr_data };
        }

        this.makeRequest(this.routes.updateItem, data, 'POST')
            .then(response => {
                console.log('Item updated successfully');
            })
            .catch(error => {
                console.error('Error updating item:', error);
            });
    }

    actualizarMenu() {
        const data = {
            arraydata: this.arraydata,
            menuname: document.getElementById('menu-name').value,
            idmenu: document.getElementById('idmenu').value
        };

        this.makeRequest(this.routes.generateMenu, data, 'POST')
            .then(response => {
                console.log('Menu updated successfully');
                // Show success message and reload the page after successful update
                const saveButton = document.getElementById('save_menu_header');
                if (saveButton) {
                    const originalText = saveButton.textContent;
                    saveButton.textContent = 'მენიუს განახლება წარმატებით! გვერდი იტვირთება...';
                    saveButton.style.backgroundColor = '#28a745';
                    saveButton.style.color = 'white';
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Fallback if button not found
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error updating menu:', error);
            })
            .finally(() => {
                this.hideSpinner('spincustomu2');
            });
    }

    deleteItem(id) {
        const data = {
            id: id,
            idmenu: document.getElementById('idmenu').value
        };

        this.makeRequest(this.routes.deleteItem, data, 'POST')
            .then(response => {
                const element = document.getElementById('menu-item-' + id);
                if (element) {
                    // Remove the element and all its children
                    element.remove();
                    console.log(`Menu item ${id} deleted successfully`);
                }
            })
            .catch(error => {
                console.error('Error deleting item:', error);
                alert('Error deleting menu item. Please try again.');
            });
    }

    deleteMenuItem(id) {
        if (confirm('Are you sure you want to delete this menu item?')) {
            this.deleteItem(id);
        }
    }

    rebindEvents() {
        // Rebind events for dynamically added elements
        this.bindEvents();
        
        // Make new menu items draggable
        document.querySelectorAll('.menu-item').forEach(item => {
            if (!item.draggable) {
                item.draggable = true;
            }
        });
    }

    // Helper method to create a submenu with multiple items
    createSubmenuWithItems(parentId, submenuItems) {
        const parentElement = document.getElementById('menu-item-' + parentId);
        if (!parentElement) {
            console.error('Parent element not found');
            return;
        }

        // Create submenu container
        let submenu = parentElement.querySelector('ul.menu.submenu');
        if (!submenu) {
            submenu = document.createElement('ul');
            submenu.className = 'menu submenu';
            parentElement.appendChild(submenu);
        }

        // Add submenu items
        submenuItems.forEach((itemData, index) => {
            const itemId = Date.now() + index; // Generate unique ID
            const submenuItem = this.createMenuItemElement(itemId, itemData.title, itemData.type || 'page', itemData.prefix || 'page-show', 1);
            submenu.appendChild(submenuItem);
        });

        // Rebind events for new items
        this.rebindEvents();
        console.log(`Created submenu with ${submenuItems.length} items under menu item ${parentId}`);
    }

    // Helper method to create a menu item element
    createMenuItemElement(id, title, type, prefix, depth = 0) {
        const li = document.createElement('li');
        li.id = 'menu-item-' + id;
        li.className = `menu-item menu-item-depth-${depth} menu-item-page menu-item-edit-inactive pending`;
        li.style.display = 'list-item';
        li.draggable = true;

        const html = `
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title">
                        <span class="menu-item-title">
                            <span id="menutitletemp_${id}">${title}</span>
                            <span style="color: transparent;">|${id}|</span>
                        </span>
                        ${depth > 0 ? '<span class="is-submenu">Subelement</span>' : ''}
                    </span>
                    <span class="item-controls">
                        <span class="item-type">${prefix}</span>
                        <a class="item-edit" id="edit-${id}" title="Edit" href="#"></a>
                        <a class="item-delete-quick" id="delete-quick-${id}" title="Delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a>
                    </span>
                </dt>
            </dl>
            <div class="menu-item-settings" id="menu-item-settings-${id}" style="display: none;">
                <input type="hidden" class="edit-menu-item-id" name="menuid_${id}" value="${id}"/>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-${id}">CSS Classes<br>
                        <input type="text" id="clases_menu_${id}" class="widefat code edit-menu-item-classes" name="clases_menu_${id}" value="">
                    </label>
                </p>
                <p class="field-css-url description description-wide">
                    <label for="edit-menu-item-url-${id}">Prefix<br>
                        <input type="text" id="url_menu_${id}" name="url_menu_${id}" class="widefat code edit-menu-item-url" value="${prefix}" disabled>
                    </label>
                </p>
                <div class="menu-item-actions description-wide submitbox">
                    <a class="item-delete submitdelete deletion" id="delete-${id}" href="javascript:void(0)" onclick="window.menuManager.deleteMenuItem(${id})">Delete</a>
                    <span class="meta-sep hide-if-no-js"> | </span>
                    <a class="item-cancel submitcancel hide-if-no-js button-secondary" id="cancel-${id}" href="#">Cancel</a>
                    <span class="meta-sep hide-if-no-js"> | </span>
                    <a onclick="window.menuManager.getMenus()" class="button button-primary updatemenu" id="update-${id}" href="javascript:void(0)">Update Item</a>
                </div>
            </div>
            <ul class="menu-item-transport"></ul>
        `;

        li.innerHTML = html;
        return li;
    }

    // Helper method to add a single item to an existing submenu
    addItemToSubmenu(parentId, title, type = 'page', prefix = 'page-show') {
        const parentElement = document.getElementById('menu-item-' + parentId);
        if (!parentElement) {
            console.error('Parent element not found');
            return;
        }

        // Get or create submenu container
        let submenu = parentElement.querySelector('ul.menu.submenu');
        if (!submenu) {
            submenu = document.createElement('ul');
            submenu.className = 'menu submenu';
            parentElement.appendChild(submenu);
        }

        // Create and add the new item
        const itemId = Date.now();
        const newItem = this.createMenuItemElement(itemId, title, type, prefix, 1);
        submenu.appendChild(newItem);

        // Rebind events
        this.rebindEvents();
        console.log(`Added item "${title}" to submenu under menu item ${parentId}`);
    }

    deleteMenu() {
        if (confirm(this.menus.deleteMenu)) {
            const data = {
                id: document.getElementById('idmenu').value
            };

            this.makeRequest(this.routes.deleteMenu, data, 'POST')
                .then(response => {
                    if (!response.error) {
                        alert(response.resp);
                        window.location.href = window.location.href.split('?')[0];
                    } else {
                        alert(response.resp);
                    }
                })
                .catch(error => {
                    console.error('Error deleting menu:', error);
                })
                .finally(() => {
                    this.hideSpinner('spincustomu2');
                });
        }
    }

    toggleEdit(id) {
        const element = document.getElementById('menu-item-' + id);
        const settings = document.getElementById('menu-item-settings-' + id);
        
        if (element.classList.contains('menu-item-edit-active')) {
            element.classList.remove('menu-item-edit-active');
            element.classList.add('menu-item-edit-inactive');
            settings.style.display = 'none';
        } else {
            element.classList.remove('menu-item-edit-inactive');
            element.classList.add('menu-item-edit-active');
            settings.style.display = 'block';
        }
    }

    cancelEdit(id) {
        this.toggleEdit(id);
    }

    updateMenuStructure() {
        // Update the menu structure after drag and drop
        this.getMenus();
    }

    getElementValue(id) {
        const element = document.getElementById(id);
        return element ? element.value : '';
    }

    showSpinner(spinnerId) {
        const spinner = document.getElementById(spinnerId);
        if (spinner) {
            spinner.style.display = 'inline-block';
        }
    }

    hideSpinner(spinnerId) {
        const spinner = document.getElementById(spinnerId);
        if (spinner) {
            spinner.style.display = 'none';
        }
    }

    makeRequest(url, data, method = 'POST') {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', this.csrfToken);
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (e) {
                        resolve(xhr.responseText);
                    }
                } else {
                    reject(new Error('Request failed with status: ' + xhr.status));
                }
            };

            xhr.onerror = function() {
                reject(new Error('Request failed'));
            };

            xhr.send(JSON.stringify(data));
        });
    }

    // Utility functions
    static insertParam(key, value) {
        key = encodeURIComponent(key);
        value = encodeURIComponent(value);

        const url = new URL(window.location);
        url.searchParams.set(key, value);
        window.history.replaceState({}, '', url);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.menuManager = new MenuManager();
    
    // Register change handler for compatibility
    window.wpNavMenu = {
        registerChange: function() {
            window.menuManager.getMenus();
        }
    };
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = MenuManager;
} 