<li class="dd-item dd3-item"
    data-type="menu-item"
    data-uid="{{ $item['uid'] }}"
    data-name="{{ $item['name'] }}">
    <div class="dd-handle dd3-handle">
        <i class="fa fa-ellipsis-v"></i>
    </div>
    <div class="dd3-content">
        <div class="row">
            <div class="col-md-9">
                <span class="text-muted">
                    {{ trans('app.admin.menu.title') . ': ' }}
                </span>
                <span class="font-weight-bold primary-dark">
                    {{ $item['name'] }}
                </span>
                <input type="hidden" name="preferences[{{ $item['uid'] }}][id]"
                       value="{{ $item['uid'] }}">
                <input type="hidden" name="preferences[{{ $item['id'] }}][name]"
                       value="{{ $item['name'] }}">
{{--                <input type="hidden" name="preferences[{{ $preference['id'] }}][study_form]"--}}
{{--                       value="{{ $preference['study_form'] }}">--}}
{{--                <input type="hidden" name="preferences[{{ $preference['id'] }}][funding]"--}}
{{--                       value="{{ $preference['funding'] }}">--}}
            </div>
            <div class="col-md-3 text-right">
                <a class="btn btn-purple btn-sm btn-xs" title="{{ trans('app.delete') }}" type="button"
                   delete-confirm="{{ trans('app.delete_item_warning', ['name' => $item['name']]) }}"
                   ajax-container="{{ $item['id'] }}"
                >
                    {{ trans('app.admin.menu.edit') }}
                </a>
                <a class="btn btn-danger btn-sm btn-xs" title="{{ trans('app.delete') }}" type="button"
                   delete-confirm="{{ trans('app.delete_item_warning', ['name' => $item['name']]) }}"
                   ajax-container="{{ $item['id'] }}"
                >
                    <i class="fa fa-trash-o m-0 row-icon"></i>
                </a>
            </div>
        </div>
    </div>
</li>
