$(function () {
    $(document).on('click', '.mc-modal-control', function (e) {
        e.preventDefault();
        var size = $(this).attr('modal-size');
        var url = $(this).attr('href');
        var method = $(this).attr('data-method');

        var modal = $('#myModal');
        modal.remove();

        var html = '<div class="mc-modal modal fade" role="dialog" id="myModal">' +
            '<div class="modal-dialog modal-' + size + ' modal-select">' +
            '<div class="modal-content">';

        $('body').append(html);

        modal = $('#myModal');
        modal.modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });

        $.ajax({
            url: url,
            type: method,
            dataType: 'html',
        }).always(function (response) {
            var modalContent = $('#myModal .modal-content');

            if (response === '') {
                notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);
                modal.modal('hide');
            } else {
                modalContent.html(response);
                initJs(modalContent);
            }
        }).fail(function (jqXHR) {
            notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);

            setTimeout(function () {
                modal.modal('hide');
            }, 500);
        });

        return false;
    });

    $(document).on('click', '.modal-close', function (e) {
        e.preventDefault();

        $('#myModal').modal('hide');
    });

    $(document).on('click', '#modal-form .modal-submit', function (e) {
        e.preventDefault();

        var modalForm = $('#modal-form'), data;

        if (modalForm.valid()) {
            var modalFormData = modalForm.serializeArray();

            if (tinyMCE.activeEditor !== null) {
                modalFormData.push({name: 'text', value: tinyMCE.activeEditor.getContent({format: 'raw'})});
            }

            modalFormData.push({name: 'keys', value: getUploadedItemKey($('#filemanager-upload'))})

            modalForm.find('input.select').each(function () {
                var _this = $(this);

                modalFormData.push({name: _this.attr('name'), value: _this.val()})
            });

            if ($(this).hasClass('module-submit')) {
                data = {
                    modal: modalFormData,
                    main: getModuleList()
                }
            } else {
                data = modalFormData;
            }

            uploadModalData($(this), data);
        } else {
            $('.has-error').closest('.collapse').collapse('show');
        }

        return false;
    });
});

/**
 * Upload modal data
 *
 * @param selector
 * @param data
 */
function uploadModalData(selector, data) {
    let modulesList = $('.module-list-container'),
        overlay = modulesList.find('.overlay');

    setTimeout(function () {
        overlay.removeClass('d-none');

        $.ajax({
            type: selector.attr('data-method'),
            url: selector.attr('href'),
            data: $.extend(data, {
                _token: CSRF_TOKEN
            }),
            dataType: 'json',
            success: function (response) {
                if (response['type'] === 'error') {
                    notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);
                } else {
                    $('#myModal').modal('hide');

                    if (response['type'] === 'success' || response['type'] === 'error') {
                        notify(response['type'], response['title'], response['message']);
                    }

                    if (response['url'] !== undefined) {
                        window.location.href = (response['url']);
                    }

                    if (response['listReload'] !== undefined && response['listReload']) {


                        modulesList.load(modulesList.attr('data-url'), function () {
                            initJs($(this));
                        });
                    }
                }

                overlay.hide();
            },
            error: function () {
                notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);
                overlay.hide();
            }
        });
    }, 20);
}
