import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
$(document).ready(function() {
    $('tr').on('click', function() {
        window.location.href = $(this).data('href');
    });
});
$('#collapseExample').collapse('show');
$('#collapseExample').collapse('hide');
$('#collapseExample').collapse('toggle');
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleDarkMode');
    const body = document.body;

    toggleButton.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
    });
});