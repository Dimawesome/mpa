$(function () {
    let body = $('body');

    $('form.jquery-form-validate').validate();

    $(document).on('click', '#logout', function () {
        $('#logout-form').submit();
    });

    initJs(body);
});

/**
 * JS libraries initialisation
 *
 * @param container
 */
function initJs(container) {
    container.find('.select').each(function () {
        let selectOptions = $(this).parent('div').find('.select-options').html() !== undefined
            ? $(this).parent('div').find('.select-options').html()
            : '{}';

        $(this).select2($.extend(
            {
                minimumResultsForSearch: 101,
                placeholder: function () {
                    $(this).attr('data-placeholder');
                },
                dropdownAutoWidth: true,
                width: $(this).hasClass('select-auto') ? 'auto' : '100%',
                tags: true,
                templateResult: formatSelect2TextOption,
                templateSelection: formatSelect2TextSelected
            },
            JSON.parse(selectOptions)
        ));
    });
}

/**
 * Format select2 text options
 *
 * @param d
 * @returns {string|*}
 */
function formatSelect2TextOption(d) {
    var text = d.text;
    var parts = text.split('|||');

    if (parts.length == 1) {
        return parts[0];
    } else {
        return '<div class="select2_title">' + parts[0] + '</div>' + '<div class="select2_sub_line">' + parts[1] + '</div>';
    }
}

/**
 * Format select2 text selected
 *
 * @param d
 * @returns {*|string}
 */
function formatSelect2TextSelected(d) {
    var text = d.text;
    var parts = text.split('|||');

    return parts[0];
}
