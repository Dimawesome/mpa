<script type="text/javascript" src="{{ URL::asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/editor.js') }}"></script>
<div class="col-md-12">
    @include('helpers.form_control', [
        'type' => 'text',
        'name' => 'module_name',
        'id' => 'module-name-text',
        'label' => trans('app.admin.module.name'),
        'value' => $module->module_name,
        'rules' => $module->rules(),
        'disabled' => $view
    ])
</div>
<div class="col-md-12">
    @include('helpers.form_control', [
        'type' => 'textarea',
        'name' => 'text',
        'class' => 'basic-text-editor',
        'label' => trans('app.admin.module.content'),
        'value' => $module->text,
        'rules' => $module->rules(),
        'readonly' => $view
    ])
</div>
