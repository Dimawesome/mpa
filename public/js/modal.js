$(function () {
    $(document).on('click', '.mc-modal-control', function (e) {
        e.preventDefault();
        var size = $(this).attr('modal-size');
        var url = $(this).attr('href');
        var method = $(this).attr('data-method');
        var load = htmlLoader();

        var modal = $('#myModal');
        modal.remove();

        var html = '<div class="mc-modal modal fade" role="dialog" id="myModal">' +
            '<div class="modal-dialog modal-' + size + ' modal-select">' +
            '<div class="modal-content">' +
            '<div class="loader-container">' + load + '</div></div></div></div>';

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

            modalContent.html(response);
            // // Select2 ajax
            // modalContent.find(".select2-ajax").each(function () {
            //     select2Ajax($(this));
            // });
            //
            initJs(modalContent);
            // addCollapsedClass(modalContent);
        }).fail(function (jqXHR) {
            html = '<div class="modal-body"><prex class="text-danger">' + jqXHR.responseText + '</prex></div>';

            $('#myModal .modal-content').html(html);
        });

        return false;
    });

    $(document).on('click', '#modal-form .modal-submit', function (e) {
        e.preventDefault();

        var modalForm = $('#modal-form'), data;

        if (modalForm.valid()) {
            var modalFormData = modalForm.serializeArray();

            // if (tinyMCE.activeEditor !== null) {
            //     modalFormData.push({name: 'text', value: tinyMCE.activeEditor.getContent({format: 'raw'})});
            // }

            // modalFormData.push({name: 'keys', value: getUploadedItemKey($('#filemanager-upload'))})

            modalForm.find('input.select').each(function () {
                var _this = $(this);

                modalFormData.push({name: _this.attr('name'), value: _this.val()})
            });

            if ($(this).hasClass('module-submit')) {
                data = {
                    modal: modalFormData,
                    // main: getModuleList()
                }
            } else {
                data = modalFormData;
            }

            uploadModalData(this, data);
        } else {
            $('.has-error').closest('.collapse').collapse('show');
        }

        return false;
    });
});

/**
 * Upload modal data
 *
 * @param _this
 * @param data
 */
function uploadModalData(_this, data) {
    var overlay = $('.overlay');

    $.ajax({
        type: $(_this).attr('data-method'),
        url: $(_this).attr('href'),
        data: data,
        dataType: 'json',
        success: function (data) {
            var modulesList = $('.module-list-container');

            if (data['type'] === 'error') {
                // notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);
            } else {
                $('#myModal').modal('hide');
                // notify(data['type'], data['title'], data['message']);
                modulesList.load(modulesList.attr('data-url'));
            }

            overlay.hide();
        },
        error: function () {
            // notify('error', LANG_NOTIFY['error'], LANG_NOTIFY['check_try_again']);
            overlay.hide();
        },
        beforeSend: function () {
            overlay.show();
        }
    });
}

/**
 * html loader
 *
 * @returns {string}
 */
function htmlLoader() {
    return '<div class="overlay text-purple justify-content-center d-none"><div class="spinner-border" role="status"></div></div>';
}
