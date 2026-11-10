(() => {
    'use strict';

    const form = document.getElementById('pickup-route-form');

    if (!form) {
        return;
    }

    const address = document.getElementById('origin-address');
    const type = document.getElementById('origin-type');
    const latitude = document.getElementById('origin-latitude');
    const longitude = document.getElementById('origin-longitude');
    const locate = document.getElementById('locate-origin');
    const status = document.getElementById('geolocation-status');
    const submit = form.querySelector('[type="submit"]');

    let requestVersion = 0;

    address.addEventListener('input', () => {
        requestVersion += 1;
        type.value = 'address';
        latitude.value = '';
        longitude.value = '';
        address.required = true;
        status.textContent = '';
    });

    locate.addEventListener('click', () => {
        if (!navigator.geolocation) {
            status.textContent = locate.dataset.error;
            return;
        }

        const version = ++requestVersion;

        locate.disabled = true;
        locate.setAttribute('aria-busy', 'true');

        navigator.geolocation.getCurrentPosition(
            (position) => {
                locate.disabled = false;
                locate.removeAttribute('aria-busy');

                if (version !== requestVersion) {
                    return;
                }

                type.value = 'location';
                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;

                address.value = '';
                address.required = false;

                status.textContent = locate.dataset.success;
                submit.focus();
            },
            () => {
                locate.disabled = false;
                locate.removeAttribute('aria-busy');

                if (version === requestVersion) {
                    status.textContent = locate.dataset.error;
                }
            },
            {
                timeout: 10000,
                maximumAge: 0,
                enableHighAccuracy: true,
            }
        );
    });

    form.addEventListener('submit', () => {
        requestVersion += 1;
        submit.disabled = true;
        submit.setAttribute('aria-busy', 'true');
    });

    window.addEventListener('pageshow', () => {
        type.value = 'address';
        latitude.value = '';
        longitude.value = '';

        address.required = true;

        submit.disabled = false;
        submit.removeAttribute('aria-busy');

        locate.disabled = false;
        locate.removeAttribute('aria-busy');

        status.textContent = '';
    });
})();