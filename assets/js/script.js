function confirmAction(message) {
    return confirm(message || 'Are you sure?');
}

document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.6s';
            alert.style.opacity   = '0';
            setTimeout(function () { alert.remove(); }, 600);
        }, 4000);
    });
});
