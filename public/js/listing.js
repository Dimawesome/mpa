/**
 * Generate unique id
 *
 * @returns {string}
 */
function guid() {
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }

    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
        s4() + '-' + s4() + s4() + s4();
}

/**
 * Highlight search text results
 *
 * @param word
 * @param element
 */
function hiliter(word, element) {
    var rgxp = new RegExp(word, 'gi');
    var string = element.html().match(rgxp);
    var repl = '<hl>' + (string !== null ? string[0] : null) + '</hl>';
    element.html(element.html().replace(rgxp, repl));
}

/**
 * Highlight search text results all list
 *
 * @param form
 * @param keyword
 */
function hiliterList(form, keyword) {
    if (keyword.length > 1) {
        form.find('.kq_search').each(function () {
            hiliter(keyword, $(this));
        });
    }
}

/**
 * Refresh all table data
 */
function tableRefreshAll() {
    $('.listing-form').each(function () {
        tableFilter($(this), $(this).attr('current-url'));
    });
}

/**
 * Filter all table data
 */
function tableFilterAll() {
    $('.listing-form').each(function () {
        tableFilter($(this));
    });
}

/**
 * HTML loader
 *
 * @returns {string}
 */
function htmlLoader() {
    return '<div class="overlay text-purple justify-content-center"><div class="spinner-border" role="status"></div></div>';
}

/**
 * Table filter
 *
 * @param form
 * @param custom_url
 */
function tableFilter(form, custom_url) {
    var url = form.attr('data-url');
    var id = form.attr('data-id');
    var per_page = form.attr('per-page')
    var sort_order = form.find('select[name="sort-order"]').val();
    var container = form.find('.pml-table-container');
    var loading_mask = form.attr('loading-mask');

    form.find('.sort-direction').show();

    var sort_direction = form.find('.sort-direction').attr('rel');
    var keyword = form.find('input[name="search_keyword"], input[name="keyword"]').val();

    // Default page
    if (typeof (custom_url) !== 'undefined') {
        url = custom_url;
    }

    // all data
    var d = {};
    form.serializeArray().forEach(function (entry) {
        if (entry.value !== '') {
            d[entry.name] = entry.value
        }
    });

    if (typeof (loading_mask) === 'undefined' || loading_mask === 'true') {
        form.find('.pml-table-container').prepend(htmlLoader());
    }

    // ajax update custom sort
    if (datalists[id] && datalists[id].readyState !== 4) {
        datalists[id].abort();
    }

    datalists[id] = $.ajax({
        method: 'GET',
        url: url,
        data: {
            per_page: per_page,
            sort_order: sort_order,
            sort_direction: sort_direction,
            keyword: keyword,
            filters: d
        }
    }).done(function (data) {
        container.html(data);

        // Pagination class
        form.find('.pagination').addClass('pagination-separated');

        // Hightlight
        if (typeof (keyword) !== 'undefined' && keyword.trim() !== '') {
            keywords = keyword.split(' ');
            keywords.forEach(function (v) {
                hiliterList(form, v.trim());
            });
        }

        // Save current url for listing form
        form.attr('current-url', url);

        // apply js
        initJs(container);
    });
}

var datalists = {};
$(document).ready(function () {
    $('.listing-form').each(function () {
        var form = $(this);

        if (typeof (form.attr('data-id')) === 'undefined') {
            form.attr('data-id', guid());
        }

        // Render table
        tableFilter(form);
    });

    // Change page
    $(document).on('click', '.listing-form .pagination a', function (e) {
        e.preventDefault();

        tableFilter($(this).parents('.listing-form'), $(this).attr('href'));
    });

    // Change item per page
    $(document).on('change', '.num_per_page select', function () {
        tableFilter($(this).parents('.listing-form').attr('per-page', $(this).val()));
    });

    // Sort direction button
    $(document).on('click', '.sort-direction', function (e) {
        if ($(this).attr('rel') === 'asc') {
            $(this).attr('rel', 'desc');
            $(this).find('em').attr('class', 'fa fa-sort-amount-desc');
        } else {
            $(this).attr('rel', 'asc');
            $(this).find('em').attr('class', 'fa fa-sort-amount-asc');
        }

        tableFilter($(this).parents('.listing-form'));
    });

    // Sort button
    $(document).on('change', '.listing-form select:not(.select_tool)', function () {
        tableFilter($(this).parents('.listing-form'));
    });

    // Search when typing
    $(document).on('keyup', 'input[name="search_keyword"], input[name="keyword"]', function () {
        tableFilter($(this).parents('.listing-form'));
    });
});
