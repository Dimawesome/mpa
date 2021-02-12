$(function () {
    $('form.jquery-form-validate').validate();

    $(document).on('click', '#logout', function () {
        $('#logout-form').submit();
    });
});
