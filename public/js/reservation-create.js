/**
 * Author: Isabella Ocampo
 * Date: 2026-09-16
 * Description: Handles the client-side reservation date and price preview.
 */

document.addEventListener('DOMContentLoaded', function () {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const previewDays = document.getElementById('previewDays');
    const previewTotal = document.getElementById('previewTotal');

    if (!startDateInput || !endDateInput || !previewDays || !previewTotal) {
        return;
    }

    const daysUnit = previewDays.getAttribute('data-unit') || previewDays.textContent.replace(/^\d+\s*/, '').trim();
    const rawPrice = previewTotal.getAttribute('data-price') || previewTotal.textContent.replace(/[^0-9]/g, '');
    const dailyPrice = parseInt(rawPrice, 10) || 0;

    function recalculate() {
        const startVal = startDateInput.value;
        const endVal = endDateInput.value;

        if (startVal && endVal) {
            const start = new Date(startVal);
            const end = new Date(endVal);
            const diffTime = end - start;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                previewDays.textContent = diffDays + (daysUnit ? ' ' + daysUnit : '');
                const total = diffDays * dailyPrice;
                previewTotal.textContent = '$' + total.toLocaleString('es-CO');
            } else {
                previewDays.textContent = '1' + (daysUnit ? ' ' + daysUnit : '');
                previewTotal.textContent = '$' + dailyPrice.toLocaleString('es-CO');
            }
        }
    }

    startDateInput.addEventListener('change', function () {
        endDateInput.min = this.value;
        recalculate();
    });

    endDateInput.addEventListener('change', recalculate);
    recalculate();
});
