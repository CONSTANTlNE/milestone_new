import Quill from 'quill';

// Register custom icons
const icons = Quill.import('ui/icons');
icons['textonly'] = '<span style="font-weight:bold;">TXT</span>';
icons['wordcount'] = '<span style="font-weight:bold;">WC</span>';
icons['fullscreen'] = '<span style="font-weight:bold;"><i class="ri-fullscreen-line"></i></span>';
icons['save'] = '<span style="font-weight:bold;">💾</span>';
icons['print'] = '<span style="font-weight:bold;">🖨️</span>';

class QuillEditor {
    constructor(selector, options = {}) {
        this.selector = selector;
        this.defaultOptions = {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{'header': [1, 2, 3, 4, 5, 6, false]}],
                        [{'font': []}],
                        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                        ['blockquote', 'code-block'],
                
                        [{'header': 1}, {'header': 2}],               // custom button values
                        [{'list': 'ordered'}, {'list': 'bullet'}],
                        [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
                        [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
                        [{'direction': 'rtl'}],                         // text direction
                        [{ 'align': [] }],
                
                        [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
                
                        [{'color': []}, {'background': []}],          // dropdown with defaults from theme
                        [{'align': []}],
                
                        ['link', 'image', 'video'],
                        ['clean', 'textonly', 'wordcount', 'fullscreen', 'save', 'print']
                    ],
                    handlers: {
                        textonly: function() {
                            // Get plain text, replace editor content with it
                            const plain = this.quill.getText();
                            this.quill.setText(plain);
                        },
                        wordcount: function() {
                            // Show word count
                            const text = this.quill.getText();
                            const words = text.trim().split(/\s+/).length;
                            const chars = text.length;
                            alert(`Words: ${words}\nCharacters: ${chars}`);
                        },
                        fullscreen: function() {
                            // Toggle fullscreen
                            const editor = this.quill.root.parentNode;
                            const toolbar = editor.previousElementSibling;
                            const fullscreenButton = this.container.querySelector('.ql-fullscreen');
                            
                            if (editor.style.position === 'fixed') {
                                // Exit fullscreen
                                editor.style.position = 'relative';
                                editor.style.top = 'auto';
                                editor.style.left = 'auto';
                                editor.style.width = 'auto';
                                editor.style.height = 'auto';
                                editor.style.zIndex = 'auto';
                                editor.style.backgroundColor = 'auto';
                                editor.style.padding = 'auto';
                                
                                if (toolbar) {
                                    toolbar.style.position = 'relative';
                                    toolbar.style.top = 'auto';
                                    toolbar.style.left = 'auto';
                                    toolbar.style.width = 'auto';
                                    toolbar.style.zIndex = 'auto';
                                    toolbar.style.backgroundColor = 'auto';
                                    toolbar.style.borderBottom = 'auto';
                                    toolbar.style.padding = 'auto';
                                }
                                
                                // Change icon back to fullscreen
                                if (fullscreenButton) {
                                    fullscreenButton.innerHTML = '<i class="ri-fullscreen-line"></i>';
                                }
                            } else {
                                // Enter fullscreen
                                editor.style.position = 'fixed';
                                editor.style.top = '0';
                                editor.style.left = '0';
                                editor.style.width = '100vw';
                                editor.style.height = '100vh';
                                editor.style.zIndex = '9999';
                                editor.style.backgroundColor = 'white';
                                editor.style.padding = '20px';
                                
                                if (toolbar) {
                                    toolbar.style.position = 'fixed';
                                    toolbar.style.top = '0';
                                    toolbar.style.left = '0';
                                    toolbar.style.width = '100vw';
                                    toolbar.style.zIndex = '10000';
                                    toolbar.style.backgroundColor = 'white';
                                    toolbar.style.borderBottom = '1px solid #ccc';
                                    toolbar.style.padding = '10px';
                                }
                                
                                // Change icon to fullscreen-exit
                                if (fullscreenButton) {
                                    fullscreenButton.innerHTML = '<i class="ri-fullscreen-exit-line"></i>';
                                }
                            }
                        },
                        save: function() {
                            // Save content (you can customize this)
                            const content = this.quill.root.innerHTML;
                            const text = this.quill.getText();
                            alert('Content saved to console!');
                        },
                        print: function() {
                            // Print content
                            const content = this.quill.root.innerHTML;
                            const printWindow = window.open('', '_blank');
                            printWindow.document.write(`
                                <html>
                                    <head><title>Print</title></head>
                                    <body>${content}</body>
                                </html>
                            `);
                            printWindow.document.close();
                            printWindow.print();
                        }
                    }
                },
                history: {
                    delay: 2000,
                    maxStack: 500,
                    userOnly: true
                },
                clipboard: {
                    matchVisual: false
                }
            },
            placeholder: 'Start writing...',
            readOnly: false
        };
        
        // Merge options properly, preserving toolbar handlers
        this.options = this.deepMerge(this.defaultOptions, options);
        this.editor = null;
        this.init();
    }

    deepMerge(target, source) {
        const result = { ...target };
        
        for (const key in source) {
            if (source[key] && typeof source[key] === 'object' && !Array.isArray(source[key])) {
                result[key] = this.deepMerge(target[key] || {}, source[key]);
            } else {
                result[key] = source[key];
            }
        }
        
        return result;
    }

    init() {
        const element = document.querySelector(this.selector);
        if (!element) {
            console.error(`Element with selector "${this.selector}" not found`);
            return;
        }

        // Create a container for the editor
        const container = document.createElement('div');
        container.style.height = 'auto';
        element.parentNode.insertBefore(container, element);
        element.style.display = 'none';

        // Initialize Quill
        this.editor = new Quill(container, this.options);

        // Set language attribute from data-lang
        const lang = element.dataset.lang || 'en';
        console.log('Setting language for Quill editor:', lang);
        this.editor.root.setAttribute('lang', lang);
        this.editor.root.setAttribute('spellcheck', 'true');
        this.editor.root.setAttribute('dir', lang === 'ar' || lang === 'he' ? 'rtl' : 'ltr');

        // Enhanced sync function that handles all content including images
        const syncContent = () => {
            const htmlContent = this.editor.root.innerHTML;
            element.value = htmlContent;
        };

        // Sync content with hidden input on any change
        this.editor.on('text-change', syncContent);
        this.editor.on('editor-change', (eventName, ...args) => {
            if (eventName === 'text-change' || eventName === 'selection-change') {
                syncContent();
            }
        });

        // Set initial content if exists
        if (element.value) {
            this.editor.root.innerHTML = element.value;
        }

        // Add event listeners
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Text change event
        this.editor.on('text-change', (delta, oldDelta, source) => {
            console.log('Content changed:', this.editor.getText());
        });

        // Selection change event
        this.editor.on('selection-change', (range, oldRange, source) => {
            if (range) {
                console.log('Selection changed:', range);
            }
        });

        // Editor change event
        this.editor.on('editor-change', (eventName, ...args) => {
            console.log('Editor event:', eventName, args);
        });
    }

    // Content Management Methods
    getContent() {
        return this.editor ? this.editor.root.innerHTML : '';
    }

    setContent(content) {
        if (this.editor) {
            this.editor.root.innerHTML = content;
        }
    }

    getText() {
        return this.editor ? this.editor.getText() : '';
    }

    setText(text) {
        if (this.editor) {
            this.editor.setText(text);
        }
    }

    getContents() {
        return this.editor ? this.editor.getContents() : null;
    }

    setContents(delta) {
        if (this.editor) {
            this.editor.setContents(delta);
        }
    }

    getLength() {
        return this.editor ? this.editor.getLength() : 0;
    }

    isEmpty() {
        return this.editor ? this.editor.getText().trim().length === 0 : true;
    }

    // Selection Methods
    getSelection() {
        return this.editor ? this.editor.getSelection() : null;
    }

    setSelection(index, length) {
        if (this.editor) {
            this.editor.setSelection(index, length);
        }
    }

    hasFocus() {
        return this.editor ? this.editor.hasFocus() : false;
    }

    focus() {
        if (this.editor) {
            this.editor.focus();
        }
    }

    blur() {
        if (this.editor) {
            this.editor.blur();
        }
    }

    // Formatting Methods
    formatText(index, length, formats) {
        if (this.editor) {
            this.editor.formatText(index, length, formats);
        }
    }

    formatLine(index, length, formats) {
        if (this.editor) {
            this.editor.formatLine(index, length, formats);
        }
    }

    format(index, name, value) {
        if (this.editor) {
            this.editor.format(index, name, value);
        }
    }

    getFormat(index) {
        return this.editor ? this.editor.getFormat(index) : {};
    }

    removeFormat(index, length) {
        if (this.editor) {
            this.editor.removeFormat(index, length);
        }
    }

    // Content Insertion Methods
    insertText(index, text, formats) {
        if (this.editor) {
            this.editor.insertText(index, text, formats);
        }
    }

    insertEmbed(index, type, value) {
        if (this.editor) {
            this.editor.insertEmbed(index, type, value);
        }
    }

    deleteText(index, length) {
        if (this.editor) {
            this.editor.deleteText(index, length);
        }
    }

    updateContents(delta) {
        if (this.editor) {
            this.editor.updateContents(delta);
        }
    }

    // History Methods
    undo() {
        if (this.editor) {
            this.editor.history.undo();
        }
    }

    redo() {
        if (this.editor) {
            this.editor.history.redo();
        }
    }

    clearHistory() {
        if (this.editor) {
            this.editor.history.clear();
        }
    }

    // Clipboard Methods
    pasteHTML(html) {
        if (this.editor) {
            this.editor.clipboard.dangerouslyPasteHTML(html);
        }
    }

    pasteHTMLAt(index, html) {
        if (this.editor) {
            this.editor.clipboard.dangerouslyPasteHTML(index, html);
        }
    }

    // Utility Methods
    enable() {
        if (this.editor) {
            this.editor.enable();
        }
    }

    disable() {
        if (this.editor) {
            this.editor.disable();
        }
    }

    getBounds(index) {
        return this.editor ? this.editor.getBounds(index) : null;
    }

    getWordCount() {
        const text = this.getText();
        return text.trim().split(/\s+/).length;
    }

    getCharacterCount() {
        return this.getText().length;
    }

    // Custom Methods
    makeBold() {
        this.format('bold', true);
    }

    makeItalic() {
        this.format('italic', true);
    }

    makeUnderline() {
        this.format('underline', true);
    }

    addLink(url) {
        const range = this.getSelection();
        if (range) {
            this.formatText(range.index, range.length, 'link', url);
        }
    }

    insertImage(url) {
        const range = this.getSelection();
        const index = range ? range.index : this.getLength();
        this.insertEmbed(index, 'image', url);
    }

    insertVideo(url) {
        const range = this.getSelection();
        const index = range ? range.index : this.getLength();
        this.insertEmbed(index, 'video', url);
    }

    // Export Methods
    exportAsHTML() {
        return this.getContent();
    }

    exportAsText() {
        return this.getText();
    }

    exportAsDelta() {
        return this.getContents();
    }

    // Import Methods
    importFromHTML(html) {
        this.setContent(html);
    }

    importFromText(text) {
        this.setText(text);
    }

    importFromDelta(delta) {
        this.setContents(delta);
    }
}

// Make it available globally
window.QuillEditor = QuillEditor;

// Auto-initialize editors with data-quill attribute
document.addEventListener('DOMContentLoaded', () => {
    const quillElements = document.querySelectorAll('[data-quill]');

    quillElements.forEach(element => {
        const options = element.dataset.quillOptions ? 
            JSON.parse(element.dataset.quillOptions) : {};
        console.log('Initializing Quill for element:', element.id, 'with lang:', element.dataset.lang);
        new QuillEditor(`#${element.id}`, options);
    });
});

export default QuillEditor; 