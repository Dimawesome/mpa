<li class="dd-item dd3-item"
    data-type="menu-item"
    data-uid="{{ $item['uid'] }}"
    data-name="{{ $item['name'] }}">
    <div class="dd-handle dd3-handle">
        <i class="fa fa-ellipsis-v"></i>
    </div>
    <div class="dd3-content">
        <div class="row">
            <div class="col-md-8">
                <span class="text-muted">
                    {{ trans('app.admin.menu.title') . ': ' }}
                </span>
                <span class="font-weight-bold text-purple">
                    {{ $item['name'] }}
                </span>
            </div>
            <div class="col-md-4 text-right">
                <span class="mr-3 status-circle bg-{{ $item['status'] === 'active' ? 'success' : 'error' }}"></span>
                <a href="{{ action('Admin\MenuItemController@edit', ['muid' => $item['uid']]) }}"
                   class="btn btn-xs btn-purple mc-modal-control" modal-size="xl"
                   title="{{ trans('app.admin.menu.create') }}">
                    {{ trans('app.admin.menu.edit') }}
                </a>
                @include('helpers.popover_confirm', [
                    'classes' => 'btn-xs btn-danger',
                    'title' => trans('app.popover.delete_confirm_title'),
                    'ajaxUrl' => action('Admin\MenuItemController@delete', ['muid' => $item['uid']]),
                    'btnContent' => '<i class="fa fa-trash-o m-0 row-icon"></i>'
                ])
            </div>

            @include('partials._html_loader')
        </div>
    </div>
</li>
