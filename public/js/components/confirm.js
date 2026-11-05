/*
 * Author: Isabella Cadavid Posada
 * Date: 2026-11-04
 * Description: Display translated confirmation text supplied by existing forms.
 */
document.addEventListener('submit', function (event) {
    const form = event.target;
    if (form instanceof HTMLFormElement && form.dataset.confirmMessage
        && !window.confirm(form.dataset.confirmMessage)) {
        event.preventDefault();
        event.stopImmediatePropagation();
    }
}, true);
