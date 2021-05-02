$(function () {
    "use strict";

    let body = $('body');

    $('form.jquery-form-validate').validate();

    $(document).on('click', '#logout', function () {
        $('#logout-form').submit();
    });

    initJs(body);

    notifyAutoCall();

    /**
     * Set data attribute to popover buttons
     */
    $(document).on('click', '.btn-popover', function (e) {
        let _this = $(this);

        $('.popover#' + _this.attr('aria-describedby') + ' .popover-body .popover-confirm')
            .data('overlay-id', _this.data('overlay-id'));

        e.preventDefault();
    });

    /**
     * Send ajax data on popover confirm
     */
    $(document).on('click', '.popover .popover-confirm, a.ajax-load', function (e) {
        let _this = $(this),
            overlay = $('#' + _this.data('overlay-id'));

        overlay.removeClass('d-none');

        setTimeout(function () {
            ajaxRedirectOnResponse(_this.attr('href'), overlay);
        }, 10);

        e.preventDefault();
    });

    /**
     * Popover close on lick event
     */
    $(document).on('click', '.popover .popover-close', function () {
        $(this).closest('.popover').popover('hide');
    });

    /**
     * Do not close dropdown
     */
    $(document).on('click', '.dropdown-menu', function (e) {
        $('body .popover').length > 0 && $(this).parent().is('.show') && e.stopPropagation();
    });

    /**
     * Hide all popovers when dropdown body hides
     */
    $(document).on('hide.bs.dropdown', '.dropdown-body', function () {
        $('.popover').popover('hide');
    });

    /**
     * Do not collapse when submenu is active
     */
    $('.nav-link.active').closest('.submenu.collapse').collapse('show');

    /**
     * Load select2 ajax content
     */
    $(document).on('select2:select', '.select-search.select2-content-loader', function () {
        var _this = $(this);

        loadAjaxContent(
            _this.attr('data-content-url'),
            _this.closest('.select2-content-container').find('.select2-content-body'),
            $('#' + _this.data('overlay-id')),
            {
                value: _this.val()
            }
        );
    });

    /**
     * Clear select2 ajax content
     */
    $(document).on('select2:clear', '.select-search.select2-content-loader', function () {
        $(this).closest('.select2-content-container').find('.select2-content-body').html('');
    });

});

/**
 * JS libraries initialisation
 *
 * @param container
 */
function initJs(container) {
    setTimeout(function () {
        setTinyMceReadonly();
    }, 10);

    container.find('.select').each(function () {
        let _this = $(this),
            selectOptions = _this.parent('div').find('.select-options').html() !== undefined
                ? _this.parent('div').find('.select-options').html()
                : '{}';

        _this.select2($.extend(
            {
                minimumResultsForSearch: 101,
                placeholder: function () {
                    _this.attr('data-placeholder');
                },
                dropdownAutoWidth: true,
                width: _this.hasClass('select-auto') ? 'auto' : '100%',
                tags: true,
                templateResult: formatSelect2TextOption,
                templateSelection: formatSelect2TextSelected,
                language: 'lt'
            },
            JSON.parse(selectOptions)
        ));
    });

    container.find('.btn-popover').each(function () {
        let _this = $(this),
            url = _this.data('ajax-url');

        _this.popover({
            trigger: 'click',
            html: true,
            content: '<a class="btn btn-xs btn-white popover-confirm" href="' + url + '">'
                + POPOVER['yes'] + '</a><a class="btn btn-xs btn-gray popover-close" type="button">'
                + POPOVER['no'] + '</a>'
        });
    });

    container.find('[data-fancybox]').each(function () {
        $(this).fancybox({
            toolbar: false,
            smallBtn: true,
            iframe: {
                preload: true,
                css: {
                    width: '65%',
                    height: '80%'
                }
            },
            spinnerTpl: '<div class="fancybox-loading"><div class="overlay text-purple justify-content-center"><div class="spinner-border" role="status"></div></div></div>'
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

/**
 * Send ajax data and redirect on response url
 *
 * @param url
 * @param overlay
 */
function ajaxRedirectOnResponse(url, overlay) {
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        cache: false,
        success: function (response) {
            if (response['url'] !== undefined) {
                window.location.href = (response['url']);
            }

            if (response['type'] === 'success' || response['type'] === 'error') {
                notify(response['type'], response['title'], response['message']);
            }

            if (response['listReload'] !== undefined && response['listReload']) {
                let modulesList = $('.module-list-container');

                modulesList.load(modulesList.attr('data-url'), function () {
                    initJs($(this));
                });
            }
        },
        error: function () {
            notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);
            overlay.hide();
        }
    });
}

/**
 * Load ajax content
 *
 * @param url
 * @param contentBody
 * @param overlay
 * @param data
 */
function loadAjaxContent(url, contentBody, overlay, data) {
    overlay.removeClass('d-none');
    setTimeout(function () {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            data: $.extend(data, {
                _token: CSRF_TOKEN
            }),
            url: url,
            success: function (response) {
                contentBody.html(response);
                initJs(contentBody);
                overlay.hide();
            },
            error: function () {
                notify('error', LANG_NOTIFY['error'], SOMETHING_WENT_WRONG);
                overlay.hide();
            }
        });
    }, 20);
}

/**
 * Get created module list
 *
 * @returns {[]}
 */
function getModuleList() {
    let module = {}, modules = [];

    $('.module-list').find('li.dd3-item').each(function () {
        let item = $(this);

        module = {name: item.attr('data-name'), uid: item.attr('data-uid')};
        modules.push(module);
    });

    return modules;
}

/**
 * Set readonly to Tiny MCE editor
 */
function setTinyMceReadonly() {
    if ($('textarea.basic-text-editor').attr('readonly')) {
        tinymce.activeEditor.mode.set('readonly');
    }
}

/**
 * Get page name from url
 *
 * @param url
 * @returns {*}
 */
function getPageName(url) {
    return decodeURI(url.substr(url.lastIndexOf('/') + 1).split('.')[0]);
}

/**
 * Responsive filemanager plugin's callback
 *
 * @param field_id
 */
function responsive_filemanager_callback(field_id) {
    var selector = $('#' + field_id),
        uploadedData = [],
        data = {},
        overlay = $('#' + selector.data('overlay-id')),
        maxKey = getMaxObjectValue(getUploadedItemKey(selector)),
        keyData = selector.data('key');

    try {
        uploadedData = JSON.parse(selector.val());
    } catch (e) {
        uploadedData.push(selector.val());
    }

    if (keyData !== undefined) {
        $('input[name=url_' + keyData + ']').val(uploadedData[0]);
        notify('success', LANG_NOTIFY['success'], '<em>„' + $('input[name=filename_' + keyData + ']').val() + '“</em><br>' + FILE_UPDATED);

        return;
    }

    $.each(uploadedData, function (key, value) {
        data[maxKey + 1] = {
            name: getPageName(value),
            url: value
        }

        maxKey += 1;
    });

    $.ajax({
        url: selector.attr('data-href'),
        type: selector.attr('data-method'),
        data: $.extend(data, {
            _token: CSRF_TOKEN
        }),
        success: function (response) {
            var body = $('body');

            $(response).insertBefore('.filemanager-list .dd-fixed');
            initJs(body);
            addCollapsedClass(body);
            overlay.hide();
        },
        error: function () {
            notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);
            overlay.hide();
        },
        beforeSend: function () {
            overlay.removeClass('d-none');
        }
    });
}

/**
 * Get uploaded items keys object
 *
 * @param selector
 * @returns {{}}
 */
function getUploadedItemKey(selector) {
    var keys = {};

    selector.closest('form').find('input[id="key"]').each(function (key) {
        keys[key] = $(this).val();
    });

    return keys;
}

/**
 * Get max object's value
 *
 * @param obj
 * @returns {number}
 */
function getMaxObjectValue(obj) {
    if (!$.isEmptyObject(obj)) {
        var values = Object.values(obj);

        return Math.max.apply(null, values);
    }

    return -1;
}

/**
 * Add 'collapsed' class to toggle button (necessary for expand/collapse icon display)
 *
 * @param selector
 */
function addCollapsedClass(selector) {
    selector.find('.btn[data-toggle=collapse]').each(function () {
        if ($(this).attr('aria-expanded') === 'false') {
            $(this).addClass('collapsed');
        }
    });
}