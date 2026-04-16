const currentPage = location.pathname + location.search;
const previousPage = sessionStorage.getItem("currentPage");
const origin = window.location.origin;

function parseUrl(urlValue) {
    try {
        return new URL(urlValue, origin);
    } catch (e) {
        return null;
    }
}

const fallbackParsed = parseUrl(window.fallbackPage || "/");
const fallbackPage = fallbackParsed && fallbackParsed.origin === origin
    ? fallbackParsed.href
    : `${origin}/`;

if (previousPage) {
    sessionStorage.setItem("lastPage", previousPage);
}

sessionStorage.setItem("currentPage", currentPage);

function isUnsafeBackTarget(urlValue) {
    if (!urlValue) {
        return true;
    }

    const parsed = parseUrl(urlValue);

    if (!parsed || parsed.origin !== origin) {
        return true;
    }

    const pathname = (parsed.pathname || "").toLowerCase();
    const file = pathname.split("/").pop() || "";

    const receivesMutatingGet = /(\?|&)(action|delete|remove|create|edit|login)=/i.test(parsed.search);
    const receivesPost =
        pathname.includes("/actions/") ||
        /^(create|edit|delete|deleteinstrument|login)\.php$/.test(file);

    return receivesMutatingGet || receivesPost;
}

function safeBack() {
    const last = sessionStorage.getItem("lastPage");

    if (!last || last === currentPage) {
        window.location.href = fallbackPage;
        return;
    }

    if (isUnsafeBackTarget(last)) {
        window.location.href = fallbackPage;
        return;
    }

    const target = parseUrl(last);

    if (!target) {
        window.location.href = fallbackPage;
        return;
    }

    window.location.href = target.href;
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
