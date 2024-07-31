import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
$(document).ready(function() {
    $('tr').on('click', function() {
        window.location.href = $(this).data('href');
    });
});