document.addEventListener('DOMContentLoaded', function () {
    const flash = document.getElementById('flash-message');

    if (flash) {
        setTimeout(function () {
            flash.style.opacity = '0';
            flash.style.transition = 'opacity 0.5s ease';

            setTimeout(function () {
                flash.remove();
            }, 500);
        }, 3000); // 3000ms = 3 secondes
    }
});
