
"use strict"

// for show password 
window.createpassword = function (type, ele) {
    const input = document.getElementById(type);
    input.type = input.type === "password" ? "text" : "password";

    const icon = ele.querySelector('i').classList;
    if (icon.contains("ri-eye-line")) {
        icon.replace("ri-eye-line", "ri-eye-off-line");
    } else {
        icon.replace("ri-eye-off-line", "ri-eye-line");
    }
};