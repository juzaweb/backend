$(document).ready(function () {
    $('#add-menu').on('click', function () {
        if ($('.form-menu-add').is(':hidden')) {
            $('.form-menu-add').show('slow');
        }
        else {
            $('.form-menu-add').hide('slow');
        }
    });
});