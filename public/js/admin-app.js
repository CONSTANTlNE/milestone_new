import 'preline';
import Choices from 'choices.js';
import Sortable from 'sortablejs';
window.addEventListener('load', () => {
    window.HSStaticMethods?.autoInit();
    // Example: initialize Choices.js on a select element
    const elements = document.querySelectorAll('.js-choices');
    elements.forEach((el) => new Choices(el));

    window.Sortable = Sortable;
});
window.Modal = {
    show({ title, text, yes = 'Yes', no = 'Cancel', yesClass, callback }) {
        const modalHtml = `
        <div class="hs-overlay ti-modal [--overlay-backdrop:static] fade open" id="customModal" tabindex="-1" role="dialog" style="display: block;" aria-modal="true">
            <div class="hs-overlay-open:mt-7 ti-modal-box mt-0 ease-out ti-modal-dialog ti-modal-dialog-centered" role="document">
                <div class="ti-modal-content">
                    <div class="ti-modal-header border-bottom-0">
                        <h5 class="ti-modal-title fw-semibold font-second-geo text-[1rem]">${title}</h5>
                        <button type="button" class="btn-close" aria-label="Close" onclick="Modal.hide()"></button>
                    </div>
                    <div class="ti-modal-body px-4 font-second-geo">
                         ${text}
                    </div>
                    <div class="ti-modal-footer justify-content-end border-top-0">
                        <button type="button" class="hs-dropdown-toggle ti-btn  ti-btn-primary align-middle font-second-geo" onclick="Modal._respond('no')"><i class="ri-close-line"></i> ${no}</button>
                        <button type="button" class="font-second-geo ti-btn text-white !font-medium ${yesClass ? yesClass : 'hidden'}" onclick="Modal._respond('yes')"><i class="ri-delete-bin-line"></i> ${yes}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="transition duration fixed inset-0 z-50 bg-gray-900 bg-opacity-50 dark:bg-opacity-80 hs-overlay-backdrop modal-backdrop fade open" id="customModalBackdrop"></div>
        `;

        // Remove existing modal if any
        Modal.hide();

        // Append modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Store callback
        Modal._callback = callback;

        // Prevent scroll behind modal
        document.body.classList.add('ti-modal-open');
        document.body.style.overflow = 'hidden';
    },

    hide() {
        const modal = document.getElementById('customModal');
        const backdrop = document.getElementById('customModalBackdrop');
        if (modal) modal.remove();
        if (backdrop) backdrop.remove();
        document.body.classList.remove('ti-modal-open');
        document.body.style.overflow = '';
        Modal._callback = null;
    },

    _respond(btn) {
        if (typeof Modal._callback === 'function') {
            Modal._callback(btn);
        }
        Modal.hide();
    }
};

(function () {
    "use strict";
    const el = document.querySelector('#choices-multiple-remove-button');
    if (el) {
        new Choices(el, {
            allowHTML: true,
            removeItemButton: true,
        });
    }
})();

import "../backend/assets/js/defaultmenu.js";
import "../backend/assets/js/switch.js";
import "../backend/assets/js/custom.js";
