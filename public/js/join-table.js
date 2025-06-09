// === STRICT MODE === //
"use strict";

// === CONSTANTS === //
const ORIGIN = window.location.origin;
const ENDPOINT_PATH = "/api/";
const ENDPOINT_URI = ORIGIN + ENDPOINT_PATH;
const ENDPOINT = {
    table: {
        join: ENDPOINT_URI + "join-table",
        leave: ENDPOINT_URI + "leave-table",
    },
};
let loader;
let loaderTitle;

// === EVENT LISTENERS === //
window.addEventListener("load", init);

// === METHODS === //

// Init function
function init() {
    // Link DOM elements
    const params = new URLSearchParams(window.location.search);
    const form = document.querySelector(".form");
    const codeElement = document.querySelector('[data-form-element="code"]');
    const codeInputField = codeElement.querySelector(".form__input-field");
    const codeErrors = codeElement.querySelector(".form__element-errors");
    const enterButton = document.querySelector(
        '[data-element="validate-join-form-button"]'
    );
    loader = document.querySelector(".loader");
    loaderTitle = document.querySelector(".loader__title");

    // Helper functions
    const validateCode = () => {
        // Validate code
        if (codeInputField.value.match(/(\d{4})[-]{1}(\d{4})[-]{1}(\d{4})/)) {
            openLoader("Validating table code");
            fetch(ENDPOINT.table.join, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    code: codeInputField.value,
                }),
            })
                .then((data) => data.json())
                .then((response) => {
                    if (response.status !== "error") {
                        codeErrors.textContent = "";
                        localStorage.setItem("table_id", response.table_id);
                        localStorage.setItem("table_code", response.table_code);
                        localStorage.setItem(
                            "user_data",
                            JSON.stringify(response.user_data)
                        );

                        window.location = ORIGIN + "/main";
                    } else {
                        codeErrors.textContent = response.message;
                    }
                    closeLoader();
                })
                .catch((error) => console.error(error));
        } else {
            codeErrors.textContent =
                "Invalid table code format, example: 0000-0000-0000";
        }
    };

    // Add event listeners
    form.addEventListener("submit", (event) => {
        event.preventDefault();
        validateCode();
    });
    codeInputField.addEventListener("keyup", (e) => {
        let value = e.target.value.replace(/\D/g, "");
        // Aplica el formato 0000-0000-0000
        value = value.replace(/(\d{4})(\d{0,4})(\d{0,4})/, function (
            _,
            g1,
            g2,
            g3
        ) {
            let res = g1;
            if (g2) res += "-" + g2;
            if (g3) res += "-" + g3;
            return res;
        });
        e.target.value = value;
    });
    enterButton.addEventListener("click", validateCode);

    // Check if there is any stored code in localStorage
    if (localStorage.getItem("code")) {
        codeInputField.value = localStorage.getItem("code");
    }

    // Check if there is any code in URL data
    const hashCode = params.get("code");
    if (hashCode) {
        codeInputField.value = hashCode;
        enterButton.click();
    }

    // Focus input field
    codeInputField.focus();
}

function openLoader(title) {
    loader.classList.add("loader--active");
    loaderTitle.textContent = title ?? "Loading something";
}

function closeLoader() {
    loader.classList.remove("loader--active");
}
