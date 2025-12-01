document.addEventListener('DOMContentLoaded', function() {
    // Flash Messages automatisch ausblenden nach 5 Sekunden
    setTimeout(function() {
        var flashes = document.querySelectorAll('.flash');
        flashes.forEach(function(flash) {
            flash.style.opacity = '0';
            setTimeout(function() {
                flash.style.display = 'none';
            }, 500); // Warten auf CSS Transition
        });
    }, 5000);

    // Einfache Client-Side Validierung oder Bestätigungen
    // ...
});
