<script type="text/javascript" src="{{ URL::asset('assets/lib/nestable/js/jquery.nestable.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/nestable.js') }}"></script>
<div class="col-md-12 no-padding">
    @include('helpers.form_control', [
        'type' => 'text',
        'name' => 'title',
        'label' => trans('app.admin.module.name'),
        'value' => $module->title,
        'rules' => $module->rules()
    ])
</div>
<div class="col-md-12 no-padding">
    <div class="dd" id="nestable">
        <ol class="dd-list filemanager-list">
            @isset($data)
                @include('admin.modules.partials._file_list', ['data' => $data, 'rules' => $rules])
            @endisset

            <li class="dd-item dd-nochildren dd-fixed" data-type="module">
                <a data-src="{{ url('filemanager2/dialog.php?type=2&descending=0&lang=lt&akey=key&field_id=filemanager-upload') }}"
                   data-fancybox data-type="iframe" href="javascript:">
                    <div class="dd-nodrag text-purple">
                        <em class="fa fa-plus"></em>
                    </div>
                    <div class="dd3-content dd-nodrag-content">
                        {{ trans('app.admin.module_file.add') }}
                    </div>
                </a>
            </li>
        </ol>
    </div>
</div>
<input id="filemanager-upload" type="hidden" data-href="{{ action('Admin\ModuleController@fileList') }}"
       data-method="POST" data-overlay-id="module-loader">
