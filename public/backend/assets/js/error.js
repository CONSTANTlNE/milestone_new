(function () {
    "use strict";

    if (localStorage.loaderEnable == 'true') {
        document.querySelector("html").setAttribute("loader", "enable");
    } else {
        if (!document.querySelector("html").getAttribute("loader")) {
            document.querySelector
            ("html").setAttribute("loader", "disable");
        }
    }
})();