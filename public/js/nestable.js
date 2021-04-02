$(function () {
    $('body .dd').each(function () {
        let _this = $(this);

        _this.nestable({
            group: 0,
            callback: function (e) {
                updateNestableOutput(e);
                // addNotSubmittedClass(e);
            },
            onDragStart: function (l) {
                l.find('[data-type=menu-item]').addClass('dd-nochildren');
            }
        });

        // setEmptyNestableElement(_this);
    });

    // $(document).on('click', '#nestable-menu', function (e) {
    //     let action = $(e.target).data('action');
    //
    //     if (action === 'expand-all') {
    //         $('.dd').nestable('expandAll');
    //     }
    //
    //     if (action === 'collapse-all') {
    //         $('.dd').nestable('collapseAll');
    //     }
    // });
});

/**
 * Update output
 *
 * @param e
 */
function updateNestableOutput(e) {
    var url = e.attr('data-action'),
        list = e.length ? e : $(e.target),
        node = list.nestable('serialize'),
        items = e.find('.dd-item-order');

    // if (items !== undefined) {
    //     handleNestableItemsOrder(items);_
    // }

    if (typeof (node) !== 'undefined' && url !== undefined) {
        $.ajax({
            method: 'POST',
            url: url,
            data: {
                node: node
            }
        }).done(function (msg) {
            var type = 'success';

            if (typeof (msg.status) !== 'undefined') {
                type = msg.status;
                msg = msg.message;
            }

            if (msg.indexOf('is-error') !== -1) {
                type = 'error';
            }

            try {
                var data = JSON.parse(msg);
                type = data.status;
                msg = data.message;
            } catch (evt) {
            }

            if (typeof (msg) == 'object') {
            }

            if (msg !== '') {
                notify(type, LANG_NOTIFY[type], msg);
            }
        });
    }
}

/**
 * Handle items order
 *
 * @param items
 */
// function handleNestableItemsOrder(items) {
//     items.each(function (key, value) {
//         $(value).html(key + 1);
//     });
// }

/**
 * Add nestable item
 *
 * @param list
 * @param item
 */
// function addNestableItem(list, item) {
//     list.append(item);
//
//     if (list.find('li.dd3-item').length) {
//         list.parent('.dd').find('.dd-empty').remove();
//     }
//
//     addNotSubmittedClass(list);
// }

/**
 * Remove nestable item
 *
 * @param item
 * @param id
 */
// function removeNestableItem(item, id) {
//     let list = item.closest('.dd');
//
//     list.nestable('remove', id, function () {
//         // Remove disabled attribute from select option, if this item was deleted from list
//         $('select[name=' + item.data('type') + ']').find('option[value=' + id + ']').attr('disabled', false);
//         notify('success', LANG_NOTIFY['success'], LANG_NOTIFY['item_deleted']);
//     });
//
//     setEmptyNestableElement(list);
//     handleNestableItemsOrder(list.find('.dd-item-order'));
//     addNotSubmittedClass(list);
// }

/**
 * Set empty nestable element
 *
 * @param list
 */
// function setEmptyNestableElement(list) {
//     let container = list.find('.dd-empty'),
//         content = '<i class="fa fa-flag-o"></i><p>' + EMPTY_LIST + '</p>';
//
//     if (container.length) {
//         container.append(content);
//     } else if (!list.find('li.dd3-item').length) {
//         list.append('<div class="dd-empty">' + content + '</div>');
//         list.find('.dd-empty').hide().fadeIn('slow');
//     }
// }
