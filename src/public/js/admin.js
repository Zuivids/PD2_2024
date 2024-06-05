"use strict";

function setupDeleteForms() {

    let deleteForms = document.querySelectorAll('form.deletion-form');

    for (let form of deleteForms) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            if (window.confirm('Do you really want to delete this?')) {
                form.submit();
            } else {
                return false;
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", function () {
    setupDeleteForms();
});