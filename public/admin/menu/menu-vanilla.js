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
        let isDragging = false;
        let startY = 0;
        let startX = 0;
        
        // Set global dragging state
        window.isDragging = false;

        // Enhanced drag start with better touch support
        const handleDragStart = (e) => {
            const target = e.target.closest('.menu-item');
            if (!target) return;

            // Prevent dragging if clicking on controls
            if (e.target.closest('.item-controls') || e.target.closest('.menu-item-settings')) {
                return;
            }

            draggedElement = target;
            isDragging = true;
            window.isDragging = true;
            
            // Store initial position for touch devices
            if (e.type === 'touchstart') {
                startY = e.touches[0].clientY;
                startX = e.touches[0].clientX;
            }

            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', target.outerHTML);
            
            // Create enhanced placeholder
            placeholder = document.createElement('li');
            placeholder.className = 'sortable-placeholder';
            placeholder.style.height = (draggedElement.offsetHeight + 16) + 'px';
            placeholder.style.margin = '8px 0';
            
            // Add dragging class for visual feedback
            draggedElement.classList.add('ui-sortable-helper');
            
            setTimeout(() => {
                draggedElement.style.opacity = '0.8';
            }, 0);

            // Prevent text selection during drag
            document.body.style.userSelect = 'none';
            document.body.style.webkitUserSelect = 'none';
        };

        // Enhanced drag end
        const handleDragEnd = (e) => {
            if (draggedElement) {
                draggedElement.style.opacity = '';
                draggedElement.classList.remove('ui-sortable-helper');
                draggedElement = null;
                isDragging = false;
                window.isDragging = false;
                
                if (placeholder && placeholder.parentNode) {
                    placeholder.parentNode.removeChild(placeholder);
                }
                placeholder = null;
                dropTarget = null;
                dropPosition = null;
            }

            // Restore text selection
            document.body.style.userSelect = '';
            document.body.style.webkitUserSelect = '';

            // Clear all drop indicators
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('drop-before', 'drop-after', 'drop-child');
            });
        };

        // Enhanced drag over with better drop zone detection
        const handleDragOver = (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            
            if (!draggedElement || !isDragging) return;
            
            const target = e.target.closest('.menu-item');
            if (!target || target === draggedElement || this.isDescendant(draggedElement, target)) {
                // Clear drop indicators if not over a valid target
                document.querySelectorAll('.menu-item').forEach(item => {
                    item.classList.remove('drop-before', 'drop-after', 'drop-child');
                });
                return;
            }
            
            const rect = target.getBoundingClientRect();
            const clientY = e.type === 'touchmove' ? e.touches[0].clientY : e.clientY;
            const clientX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
            
            const midpoint = rect.top + rect.height / 2;
            const targetDepth = this.getMenuDepth(target);
            const draggedDepth = this.getMenuDepth(draggedElement);
            
            // Determine drop position with improved logic
            let newDropPosition = 'after';
            if (clientY < midpoint) {
                newDropPosition = 'before';
            }
            
            // Check if we can nest (drop into as child)
            const canNest = this.canNestAsChild(draggedElement, target);
            const nestThreshold = rect.left + 30; // Increased threshold for easier nesting
            
            if (canNest && clientX > nestThreshold && newDropPosition === 'after') {
                newDropPosition = 'child';
            }
            
            // Only update if position changed
            if (dropTarget !== target || dropPosition !== newDropPosition) {
                dropTarget = target;
                dropPosition = newDropPosition;
                
                // Update visual feedback
                this.updateDropVisualFeedback(target, newDropPosition);
            }
        };

        // Enhanced drop handling
        const handleDrop = (e) => {
            e.preventDefault();
            if (draggedElement && dropTarget && dropPosition) {
                this.performDrop(draggedElement, dropTarget, dropPosition);
                this.updateMenuStructure();
            }
        };

        // Touch event handlers for mobile devices
        const handleTouchStart = (e) => {
            const target = e.target.closest('.menu-item');
            if (!target) return;

            // Prevent dragging if clicking on controls
            if (e.target.closest('.item-controls') || e.target.closest('.menu-item-settings')) {
                return;
            }

            startY = e.touches[0].clientY;
            startX = e.touches[0].clientX;
            
            // Set a timer to start dragging after a short delay
            const dragTimer = setTimeout(() => {
                if (Math.abs(e.touches[0].clientY - startY) > 10 || 
                    Math.abs(e.touches[0].clientX - startX) > 10) {
                    handleDragStart(e);
                }
            }, 200);

            // Store timer reference to clear if touch ends quickly
            target._dragTimer = dragTimer;
        };

        const handleTouchMove = (e) => {
            if (!isDragging) return;
            e.preventDefault();
            handleDragOver(e);
        };

        const handleTouchEnd = (e) => {
            if (isDragging) {
                handleDrop(e);
                handleDragEnd(e);
            } else {
                // Clear drag timer if touch ended quickly
                const target = e.target.closest('.menu-item');
                if (target && target._dragTimer) {
                    clearTimeout(target._dragTimer);
                    target._dragTimer = null;
                }
            }
        };

        // Mouse event listeners
        menuContainer.addEventListener('dragstart', handleDragStart);
        menuContainer.addEventListener('dragend', handleDragEnd);
        menuContainer.addEventListener('dragover', handleDragOver);
        menuContainer.addEventListener('drop', handleDrop);

        // Touch event listeners for mobile support
        menuContainer.addEventListener('touchstart', handleTouchStart, { passive: false });
        menuContainer.addEventListener('touchmove', handleTouchMove, { passive: false });
        menuContainer.addEventListener('touchend', handleTouchEnd, { passive: false });

        // Make menu items draggable with enhanced handle detection
        this.makeItemsDraggable();
    }

    makeItemsDraggable() {
        document.querySelectorAll('.menu-item').forEach(item => {
            item.draggable = true;
            
            // Add visual feedback for draggable items
            const handle = item.querySelector('.menu-item-handle');
            if (handle) {
                handle.style.cursor = 'grab';
                
                // Add hover effect to indicate draggable area
                handle.addEventListener('mouseenter', () => {
                    if (!window.isDragging) {
                        handle.style.cursor = 'grabbing';
                    }
                });
                
                handle.addEventListener('mouseleave', () => {
                    if (!window.isDragging) {
                        handle.style.cursor = 'grab';
                    }
                });
            }
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
        const draggedDepth = this.getMenuDepth(draggedElement);
        
        // Remove the dragged element from its current position
        if (draggedElement.parentNode) {
            draggedElement.parentNode.removeChild(draggedElement);
        }
        
        if (position === 'before') {
            targetContainer.insertBefore(draggedElement, target);
            this.updateMenuDepth(draggedElement, targetDepth);
        } else if (position === 'after') {
            targetContainer.insertBefore(draggedElement, target.nextSibling);
            this.updateMenuDepth(draggedElement, targetDepth);
        } else if (position === 'child') {
            // Create submenu container if it doesn't exist
            let submenu = target.querySelector('ul.menu.submenu');
            if (!submenu) {
                submenu = document.createElement('ul');
                submenu.className = 'menu submenu';
                submenu.style.marginLeft = '25px';
                submenu.style.borderLeft = '3px solid #e0e0e0';
                submenu.style.paddingLeft = '20px';
                target.appendChild(submenu);
            }
            
            submenu.appendChild(draggedElement);
            this.updateMenuDepth(draggedElement, targetDepth + 1);
        }
        
        // Ensure the dragged element is still draggable
        draggedElement.draggable = true;
        
        // Rebind events for the moved element
        this.rebindEvents();
        
        // Add visual feedback for successful drop
        draggedElement.style.transition = 'all 0.3s ease';
        draggedElement.style.transform = 'scale(1.02)';
        setTimeout(() => {
            draggedElement.style.transform = 'scale(1)';
        }, 300);
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
        
        // Add smooth transition for depth changes
        element.style.transition = 'all 0.3s ease';
        setTimeout(() => {
            element.style.transition = '';
        }, 300);
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
        
        // Make new menu items draggable and add visual feedback
        this.makeItemsDraggable();
        
        // Ensure all menu items have proper event handlers
        document.querySelectorAll('.menu-item').forEach(item => {
            if (!item.draggable) {
                item.draggable = true;
            }
            
            // Re-add event listeners for controls
            const editBtn = item.querySelector('.item-edit');
            const deleteBtn = item.querySelector('.item-delete-quick');
            const cancelBtn = item.querySelector('.item-cancel');
            const updateBtn = item.querySelector('.updatemenu');
            
            if (editBtn && !editBtn._bound) {
                editBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = editBtn.id.split('-')[1];
                    this.toggleEdit(id);
                });
                editBtn._bound = true;
            }
            
            if (deleteBtn && !deleteBtn._bound) {
                deleteBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = deleteBtn.id.split('-')[2];
                    this.deleteMenuItem(id);
                });
                deleteBtn._bound = true;
            }
            
            if (cancelBtn && !cancelBtn._bound) {
                cancelBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const id = cancelBtn.id.split('-')[1];
                    this.cancelEdit(id);
                });
                cancelBtn._bound = true;
            }
            
            if (updateBtn && !updateBtn._bound) {
                updateBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.getMenus();
                });
                updateBtn._bound = true;
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
                                            <label for="clases_menu_${id}">CSS Classes<br>
                            <input type="text" id="clases_menu_${id}" class="widefat code edit-menu-item-classes" name="clases_menu_${id}" value="">
                        </label>
                    </p>
                    <p class="field-css-url description description-wide">
                        <label for="url_menu_${id}">Prefix<br>
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