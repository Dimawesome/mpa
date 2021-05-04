/**
 * Form validation
 *
 * @param selector
 */
function customValidate(selector) {
    selector.validate({
        ignore: 'input[type=hidden], .select2-input', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        // Different components require proper error label placement
        errorPlacement: function (error, element) {
            errorPlacement(error, element);
        },
        validClass: "validation-valid-label",
        success: function (label) {
            label.parents('.form-group').removeClass('has-error');
            label.remove();
        },
        rules: {
            video_url: {
                youtube: '#video_url'
            }
        },
        messages: {
            custom: {
                required: "This is a custom error message",
            },
            agree: "Please accept our policy"
        }
    });
}

$(function () {
    $.validator.addMethod('youtube', function(value, element) {
        let p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
        return (value.match(p)) ? RegExp.$1 : false;
    }, NOT_CORRECT_URL);

    // Initialize
    $(document).on('click', '.btn-purple', function (e) {
        customValidate($(this).closest('.form-validate-jquery'));
    });
});

/**
 * Place input fields errors
 *
 * @param error
 * @param element
 */
function errorPlacement(error, element) {
    var formGroup = element.parents('.form-group');

    // Select2
    if (formGroup.find('.input_help').length) {
        error.insertAfter(formGroup.find('.input_help'));
    }

    // Unstyled checkboxes, radios
    else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
        error.appendTo(element.parent().parent().parent());
    }

    // Select2
    else if (formGroup.find('.select2').length) {
        error.insertAfter(formGroup.find('.select2'));
    }

    // Basic text editor
    else if (formGroup.find('.basic-text-editor').length) {
        error.insertAfter(formGroup.find('.tox-tinymce'));
    }

    // File input (FilePond)
    else if (formGroup.find('.file-upload').length) {
        error.appendTo(formGroup.find('.file-upload'));
    }

    // Input group, styled file input
    else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
        error.appendTo(element.parent().parent());
    } else {
        error.insertAfter(element);
    }

    formGroup.addClass('has-error');
}


/**
 * Show validation errors
 *
 * @param errors
 * @param container
 */
function showValidationErrors(errors, container) {
    $.each(errors, function (name, message) {
        let element = container.find('[name=' + name + ']');

        errorPlacement(
            $('<label id="'+ element.attr('id') +'" class="validation-error-label">' + message[0] + '</label>'),
            element
        );
    });
}
