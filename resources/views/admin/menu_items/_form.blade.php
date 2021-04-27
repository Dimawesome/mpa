<div class="modal-header">
    <h5 class="modal-title">{{ trans('app.admin.menu.administration') }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            @include('helpers.form_control', [
                'type' => 'text',
                'name' => 'name',
                'value' => $menu['name'] ?? old('name'),
                'label' => trans('app.admin.title'),
                'rules' => $rules
            ])
        </div>
        <div class="col-md-6">
            @include('helpers.form_control', [
                'type' => 'select',
                'name' => 'url',
                'id' => 'url',
                'label' => trans('app.admin.menu.page_list'),
                'placeholder' => trans('app.admin.menu.page'),
                'value' => $pages['values'],
                'rules' => $rules,
                'options' => $pages['options'],
                'include_blank' => '',
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ])
        </div>
        <div class="col-md-12">
            @include('helpers.form_control', [
                'type' => 'select',
                'name' => 'visible_to',
                'label' => trans('app.admin.visible_to'),
                'placeholder' => trans('app.admin.visible_to_all'),
                'options' => [],
                'include_blank' => '',
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'disabled' => true
            ])
        </div>
        <div class="col-md-12">
            @include('helpers.form_control', [
                'type' => 'checkbox',
                'name' => 'is_active',
                'value' => 1,
                'checked' => $menu['is_active'] ?? 0,
                'label' => trans('app.admin.status_active')
            ])
        </div>
    </div>
</div>