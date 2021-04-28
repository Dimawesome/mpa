<script type="text/javascript" src="{{ URL::asset('assets/lib/nestable/js/jquery.nestable.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/nestable.js') }}"></script>
<label class="text-purple">{{ trans('app.admin.module.modules') }}</label>
<div class="dd" id="nestable">
    <ol class="dd-list module-list">
        @if ($modules)
            @foreach($modules as $module)
                <li class="dd-item dd3-item"
                    data-type="module"
                    data-id="{{ $module->id }}"
                    data-uid="{{ $module->uid }}"
                    data-name="{{ $module->name }}">
                    <div class="dd-handle dd3-handle">
                        <em class="fa fa-ellipsis-v"></em>
                    </div>
                    <div class="dd3-content">
                        <div class="row">
                            <div class="col-md-8">
                                <span class="title font-weight-bold text-purple">{{ trans('app.admin.module.module') . ': ' }}</span>
                                <span class="title">{{ Lang::has("app.admin.module.$module->name") ? trans("app.admin.module.$module->name") : $module->name }}</span>
                                <span class="font-italic">{{ $module->title ? "($module->title)" : '' }}</span>
                                <input type="hidden" name="modules[{{ "{$module->id}_$module->name" }}][uid]"
                                       value="{{ $module->uid }}">
                                <input type="hidden" name="modules[{{ "{$module->id}_$module->name" }}][name]"
                                       value="{{ $module->name }}"><br>
                                <span class="text-muted">{{ trans('app.admin.created_at') . ": $module->created_at" }}</span><br>
                                <span class="text-muted">{{ trans('app.admin.updated_at') . ": $module->updated_at" }}</span>
                            </div>

                            @include('admin.modules._actions', ['page' => $page])
                        </div>
                    </div>
                </li>
            @endforeach
        @else
            <div class="dd-empty-list">
                <em class="fa fa-cubes"></em>
            </div>
        @endif
        @if (!$view)
            <li class="dd-item dd-nochildren" data-type="module">
                <a href="{{ action('Admin\ModuleController@create', $page->uid) }}"
                   class="mc-modal-control" modal-size="xxl">
                    <div class="dd-nodrag text-purple">
                        <em class="fa fa-plus"></em>
                    </div>
                    <div class="dd3-content dd-nodrag-content">
                        {{ trans('app.admin.module.add') }}
                    </div>
                </a>
            </li>
        @endif
    </ol>

    @include('partials._html_loader', ['id' => 'module-list-overlay'])
</div>
