$(function () {
    let body = $('body');

    $('form.jquery-form-validate').validate();

    $(document).on('click', '#logout', function () {
        $('#logout-form').submit();
    });

    initJs(body);

    notifyAutoCall();

    /**
     * Send ajax data on popover confirm
     */
    $(document).on('click', '.popover .popover-confirm', function (e) {
        let _this = $(this),
            overlay = _this.closest('.overlay');

        overlay.show();
        setTimeout(function () {
            $.ajax({
                type: 'GET',
                url: _this.attr('href'),
                dataType: 'json',
                success: function (response) {
                    window.location.href = (response['url']);

                    overlay.hide();
                },
                error: function () {
                    notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);
                    overlay.hide();
                }
            });
        }, 10);

        e.preventDefault();
    });

    /**
     * Popover close on lick event
     */
    $(document).on('click', '.popover .popover-close', function () {
        $(this).closest('.popover').popover('hide');
    });
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

    container.find('.btn-popover').each(function () {
        let _this = $(this),
            url = _this.data('ajax-url').split("'")[1];

        _this.popover({
            trigger: 'click',
            html: true,
            content: '<a class="btn btn-xs btn-white popover-confirm" href="' + url + '">'
                + POPOVER['yes'] + '</a><a class="btn btn-xs btn-gray popover-close" type="button">'
                + POPOVER['no'] + '</a>'
        });
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

/**
 * Flash notifications
 *
 * @param type
 * @param title
 * @param message
 */
function notify(type, title, message) {
    if (typeof window.stackBottomRight === 'undefined') {
        window.stackBottomRight = {
            'dir1': 'up',
            'dir2': 'left',
            'firstpos1': 25,
            'firstpos2': 25
        };
    }

    PNotify.alert({
        type: type,
        title: title,
        text: message,
        stack: window.stackBottomRight,
        addClass: 'nonblock',
        delay: 4000,
        textTrusted: true,
        titleTrusted: true,
    });
}

/**
 * Auto notify alert
 */
function notifyAutoCall() {
    let alert = $('.alert-notify');

    if (alert.html() !== undefined && alert.html() !== '') {
        let status = alert.data('status');

        notify(status, LANG_NOTIFY[status], alert.html());
    }
}
