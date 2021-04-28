<div class="modal-header">
    <h5 class="modal-title">{{ trans('app.admin.module.administration') }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            @include('helpers.form_control', [
                'type' => 'select',
                'name' => 'visible_to',
                'id' => 'visible-to-menu',
                'label' => trans('app.admin.visible_to'),
                'placeholder' => trans('app.admin.visible_to_all'),
                'options' => [],
                'disabled' => true
            ])
        </div>
        <div class="col-md-12">
            @include('helpers.form_control', [
                'type' => 'checkbox',
                'name' => 'is_active',
                'value' => 1,
                'checked' => $module->is_active,
                'label' => trans('app.admin.status_active'),
                'disabled' => $view
            ])
        </div>
        <div class="col-md-12 p-0 select2-content-container">
            <div class="col-md-12 {{ isset($module->name) ? ' display-none' : '' }}">
                @include('helpers.form_control', [
                    'type' => 'select',
                    'name' => 'module',
                    'class' => 'select2-content-loader',
                    'label' => trans('app.admin.module.module'),
                    'content_url' => action('Admin\ModuleController@getModule'),
                    'value' => $module->name ?? null,
                    'options' => $additionalData,
                    'rules' => $module->rules(),
                    'placeholder' => trans('app.admin.module.choose'),
                    'min_length' => 0,
                    'readonly' => isset($module->name),
                    'include_blank' => true,
                    'overlayId' => 'module-loader',
                    'disabled' => $view
                ])
            </div>
            <div class="col-md-12 select2-content-body p-0">
                @isset($module->name)
                    @include("admin.modules.partials._$module->name")
                @endisset
            </div>

            @include('partials._html_loader', ['id' => 'module-loader'])
        </div>
    </div>
</div>
