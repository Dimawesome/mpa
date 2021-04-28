<li class="dd-item dd3-item"
    data-type="menu-item"
    data-uid="{{ $item['uid'] }}"
    data-name="{{ $item['name'] }}">
    <div class="dd-handle dd3-handle">
        <em class="fa fa-ellipsis-v"></em>
    </div>
    <div class="dd3-content">
        <div class="row">
            <div class="col-md-3">
                <span class="text-muted">
                    {{ trans('app.admin.title') . ': ' }}
                </span>
                <span class="font-weight-bold text-purple title">
                    {{ $item['name'] }}
                </span>
            </div>
            <div class="col-md-3">
                <span class="text-muted">{{ trans('app.admin.created_at') . ': ' . date_format(date_create($item['created_at']),'Y-m-d H:i:s') }}</span>
            </div>
            <div class="col-md-3">
                <span class="text-muted">{{ trans('app.admin.updated_at') . ': ' . date_format(date_create($item['updated_at']),'Y-m-d H:i:s') }}</span>
            </div>
            <div class="col-md-3 text-right">
                <span class="mr-3 status-circle bg-{{ $item['is_active'] ? 'success' : 'error' }}"></span>
                <a href="{{ action('Admin\MenuItemController@edit', ['muid' => $item['uid']]) }}"
                   class="btn btn-xs btn-purple mc-modal-control" modal-size="xl"
                   title="{{ trans('app.admin.menu.create') }}"><em
                            class="fa fa-pencil"></em>{{ trans('app.admin.edit') }}
                </a>
                @include('helpers.popover_confirm', [
                    'classes' => 'btn btn-xs btn-danger',
                    'title' => trans('app.popover.delete_confirm'),
                    'ajaxUrl' => action('Admin\MenuItemController@delete', ['muid' => $item['uid']]),
                    'btnContent' => '<em class="fa fa-trash-o m-0 row-icon"></em>',
                    'overlayId' => 'dd-overlay',
                ])
            </div>
        </div>
    </div>
</li>
