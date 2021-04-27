@if ($items->count() > 0)
    <table class="table table-box pml-table" current-page="{{ empty(request()->page) ? 1 : empty(request()->page) }}">
        @foreach ($items as $key => $item)
            <tr>
                <td class="text-center">
                    <h6 class="m-0 text-purple">
                        <i class="fa fa-bars"></i>
                    </h6>
                </td>
                <td>
                <span class="text-muted">
                    {{ trans('app.admin.title') . ': ' }}
                </span>
                    <span class="font-weight-bold text-purple title">
                    <a class="kq_search"
                       href="{{ action('Admin\PageController@edit', ['puid' => $item->uid]) }}">{{ $item->title }}</a>
                </span>
                </td>
                <td class="text-center">
                    <span class="text-muted2">{{ trans('app.admin.created_at') . ": $item->created_at" }}</span>
                </td>
                <td class="text-center">
                    <span class="text-muted2">{{ trans('app.admin.updated_at') . ": $item->updated_at" }}</span>
                </td>
                <td class="text-center">
                    <span class="mr-3 status-circle bg-{{ $item['is_active'] ? 'success' : 'error' }}"></span>
                </td>
                <td class="text-right">
                    <a href="{{ action('Admin\PageController@edit', ['puid' => $item->uid]) }}"
                       title="{{ trans('app.admin.edit') }}"
                       type="button"
                       class="btn btn-xs btn-purple">
                        <i class="fa fa-pencil"></i>{{ trans('app.admin.edit') }}
                    </a>
                    <div class="btn-group dropdown-body">
                        <button type="button"
                                class="btn btn-white btn-xs dropdown-toggle"
                                data-toggle="dropdown"
                                data-boundary="viewport">
                            <span class="caret ml-0"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            @if (!$item->is_active)
                                <li>
                                    <a class="ajax-load" data-overlay-id="table-overlay"
                                       href="{{ action('Admin\PageController@enable', ['puid' => $item->uid]) }}">
                                        <em class="fa fa-check-square-o"></em>{{ trans('app.admin.enable') }}
                                    </a>
                                </li>
                            @endif
                            @if ($item->is_active)
                                <li>
                                    <a class="ajax-load" data-overlay-id="table-overlay"
                                       href="{{ action('Admin\PageController@disable', ['puid' => $item->uid]) }}">
                                        <em class="fa fa-square-o"></em>{{ trans('app.admin.disable') }}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a data-ajax-url="{{ action('Admin\PageController@remove', ['puid' => $item->uid]) }}"
                                   title="{{ trans('app.popover.remove_confirm') }}"
                                   data-placement="top" data-overlay-id="table-overlay" data-container="body"
                                   data-toggle="popover" type="button" class="btn-popover"
                                >
                                    <em class="fa fa-trash-o"></em>{{ trans('app.admin.remove') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

    @include('partials._html_loader', ['id' => 'table-overlay'])

    @include('partials._per_page_select')

    {{ $items->links() }}

    <div class="clearfix"></div>

@elseif (!empty(request()->keyword))
    @include('partials._empty_list', [
        'icon' => 'fa fa-bars',
        'text' => trans('app.admin.no_search_result')
    ])
@else
    @include('partials._empty_list', [
        'icon' => 'fa fa-bars',
        'text' => trans('app.admin.empty_list')
    ])
@endif
