$(function () {
    $('body .dd').each(function () {
        let _this = $(this);

        _this.nestable({
            group: 0,
            callback: function (e) {
                updateNestableOutput(e);
            },
            onDragStart: function (l) {
                l.find('[data-type=menu-item]').addClass('dd-nochildren');
                l.find('[data-type=module]').addClass('dd-nochildren');
            }
        });
    });

    /**
     * Delete dd item
     */
    $(document).on('click', '.dd .dd-delete:not(.disabled)', function (e) {
        $(this).closest('li.dd-item').fadeOut(300, function () {
            $(this).remove();
        });

        e.preventDefault();
    });
});

/**
 * Update output
 *
 * @param e
 */
function updateNestableOutput(e) {
    let url = e.attr('data-action'),
        list = e.length ? e : $(e.target),
        node = list.nestable('serialize');

    if (node !== undefined && url !== undefined) {
        $.ajax({
            method: 'POST',
            url: url,
            data: {
                _token: CSRF_TOKEN,
                node: node
            }
        }).done(function (response) {
            if (response !== '') {
                notify(response['type'], response['title'], response['message']);
            }
        });
    }
}
