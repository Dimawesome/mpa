<div class="col-md-4 text-right">
    <span class="mr-3 status-circle bg-{{ $module->is_active ? 'success' : 'error' }}"></span>
    @if (!$view)
        <a href="{{ action('Admin\ModuleController@edit', ['uid' => $module->uid, 'name' => $module->name, 'puid' => $page->uid]) }}"
           class="btn btn-xs btn-purple mc-modal-control" modal-size="xxl"
           title="{{ trans('app.admin.module.edit') }}"><em
                    class="fa fa-pencil"></em>{{ trans('app.admin.edit') }}
        </a>
        <div class="btn-group dropdown-body">
            <button type="button"
                    class="btn btn-white btn-xs dropdown-toggle"
                    data-toggle="dropdown"
                    data-boundary="viewport">
                <span class="caret ml-0"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                @if (!$module->is_active)
                    <li>
                        <a class="ajax-load" data-overlay-id="module-list-overlay"
                           href="{{ action('Admin\ModuleController@enable', ['uid' => $module->uid, 'name' => $module->name]) }}">
                            <em class="fa fa-check-square-o"></em>{{ trans('app.admin.enable') }}
                        </a>
                    </li>
                @endif
                @if ($module->is_active)
                    <li>
                        <a class="ajax-load" data-overlay-id="module-list-overlay"
                           href="{{ action('Admin\ModuleController@disable', ['uid' => $module->uid, 'name' => $module->name]) }}">
                            <em class="fa fa-square-o"></em>{{ trans('app.admin.disable') }}
                        </a>
                    </li>
                @endif
                <li>
                    <a data-ajax-url="{{ action('Admin\ModuleController@delete', ['uid' => $module->uid, 'name' => $module->name]) }}"
                       title="{{ trans('app.popover.remove_confirm') }}"
                       data-placement="top" data-overlay-id="module-list-overlay" data-container="body"
                       data-toggle="popover" type="button" class="btn-popover"
                    >
                        <em class="fa fa-trash-o"></em>{{ trans('app.admin.delete') }}
                    </a>
                </li>
            </ul>
        </div>
    @else
        <a href="{{ action('Admin\ModuleController@view', ['uid' => $module->uid, 'name' => $module->name, 'puid' => $page->uid]) }}"
           class="btn btn-xs btn-purple mc-modal-control" modal-size="xxl"
           title="{{ trans('app.admin.module.view') }}"><em
                    class="fa fa-eye"></em>{{ trans('app.admin.view') }}
        </a>
    @endif
</div>
