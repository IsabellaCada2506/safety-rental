/*
 * Author: Isabella Cadavid Posada
 * Date: 2026-11-04
 * Description: Request confirmation before submitting reservation cancellation forms.
 */

(() => {
    document
        .querySelectorAll('form[data-reservation-confirm]')
        .forEach((form) => {
            form.addEventListener('submit', (event) => {
                const confirmationMessage =
                    form.dataset.reservationConfirm;

                if (!window.confirm(confirmationMessage)) {
                    event.preventDefault();
                }
            });
        });
})();