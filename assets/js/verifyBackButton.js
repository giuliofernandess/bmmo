const currentPage = location.pathname + location.search;
const previousPage = sessionStorage.getItem("currentPage");
const fallbackPage = window.fallbackPage || "/";

if (previousPage) {
    sessionStorage.setItem("lastPage", previousPage);
}

sessionStorage.setItem("currentPage", currentPage);

function isUnsafeBackTarget(urlValue) {
    if (!urlValue) {
        return false;
    }

    let parsed;

    try {
        parsed = new URL(urlValue, window.location.origin);
    } catch (e) {
        return true;
    }

    const pathname = (parsed.pathname || "").toLowerCase();
    const file = pathname.split("/").pop() || "";

    const receivesGet = parsed.search.length > 0;
    const receivesPost =
        pathname.includes("/actions/") ||
        /^(create|edit|delete|login)\.php$/.test(file);

    return receivesGet || receivesPost;
}

function safeBack() {
    const last = sessionStorage.getItem("lastPage");

    if (!last) {
        history.back();
        return;
    }

    if (isUnsafeBackTarget(last)) {
        window.location.href = fallbackPage;
        return;
    }

    history.back();
}

document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('#safe-back-button');

    if (button) {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            safeBack();
        });
    }
});
