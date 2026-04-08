function showPassword() {
    let inputPass = document.querySelector('#user-password') || document.querySelector('#new-password') || document.querySelector('#password');
    let btnShowPass = document.querySelector('#password-toggle-button') || document.querySelector('#password-btn');

    if (!inputPass || !btnShowPass) {
        return;
    }

    if (inputPass.type === 'password') {
        inputPass.setAttribute('type', 'text');
        btnShowPass.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
    } else {
        inputPass.setAttribute('type', 'password');
        btnShowPass.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('#password-toggle-button') || document.querySelector('#password-btn');

    if (button) {
        button.addEventListener('click', showPassword);
    }
});