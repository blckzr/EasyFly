$(document).ready(function () {
    $('.edit-profile').on('click', function () {
        $('#passport_number').val($(this).data('passport-number'));
        $('#passport_expiry').val($(this).data('passport-expiry'));
        $('#first_name').val($(this).data('first-name'));
        $('#last_name').val($(this).data('last-name'));
        $('#birth_date').val($(this).data('birthdate'));
        $('#telephone').val($(this).data('telephone'));
        $('#email').val($(this).data('email'));
        $('#address').val($(this).data('address'));
        $('#city').val($(this).data('city'));
        $('#country').val($(this).data('country'));
        $('#postal_code').val($(this).data('postal-code'));
    });
});
