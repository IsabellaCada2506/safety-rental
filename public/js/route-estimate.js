/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Reads the customer geolocation and submits the branch route estimate form.
 */

document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.route-estimate-form');

    forms.forEach(function (form) {
        const submitButton = form.querySelector('.route-estimate-button');
        const statusElement = form.querySelector('.route-estimate-status');
        const latitudeInput = form.querySelector('.route-estimate-latitude');
        const longitudeInput = form.querySelector('.route-estimate-longitude');

        if (!submitButton || !statusElement || !latitudeInput || !longitudeInput) {
            return;
        }

        submitButton.addEventListener('click', function () {
            if (!navigator.geolocation) {
                statusElement.textContent = form.getAttribute('data-unavailable') || '';
                statusElement.classList.remove('d-none');
                return;
            }

            statusElement.textContent = form.getAttribute('data-locating') || '';
            statusElement.classList.remove('d-none');
            submitButton.disabled = true;

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    latitudeInput.value = position.coords.latitude.toFixed(7);
                    longitudeInput.value = position.coords.longitude.toFixed(7);
                    form.submit();
                },
                function (error) {
                    submitButton.disabled = false;

                    if (error.code === error.PERMISSION_DENIED) {
                        statusElement.textContent = form.getAttribute('data-denied') || '';
                        return;
                    }

                    statusElement.textContent = form.getAttribute('data-unavailable') || '';
                }
            );
        });
    });
});
