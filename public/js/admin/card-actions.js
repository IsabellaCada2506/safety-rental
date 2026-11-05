/*
 * Author: Isabella Cadavid Posada
 * Date: 2026-11-04
 * Description: Confirm administrative card actions before submitting existing forms.
 */

(() => {
    document.querySelectorAll('form[data-confirm-message]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(form.dataset.confirmMessage)) {
                event.preventDefault();
            }
        });
    });
})();
