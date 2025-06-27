import 'preline';
import Choices from 'choices.js';
window.addEventListener('load', () => {
   window.HSStaticMethods?.autoInit();
    // Example: initialize Choices.js on a select element
    const elements = document.querySelectorAll('.js-choices');
    elements.forEach((el) => new Choices(el));
});
import "../backend/assets/js/defaultmenu.js";
import "../backend/assets/js/switch.js";
import "../backend/assets/js/custom.js";

//        <!-- <script src="../assets/js/custom-switcher.js"></script> -->
