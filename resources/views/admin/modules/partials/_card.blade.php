@inject('card', 'App\Models\Card')
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
        'type' => 'text',
        'name' => 'title',
        'id' => 'title-text',
        'label' => trans('app.admin.module_card.title'),
        'value' => $module->title,
        'rules' => $module->rules(),
        'disabled' => $view
    ])
</div>
<div class="col-md-12">
    @include('helpers.form_control', [
        'type' => 'textarea',
        'name' => 'text',
        'label' => trans('app.admin.module_card.content'),
        'value' => $module->text,
        'rules' => $module->rules(),
        'readonly' => $view,
        'disabled' => $view
    ])
</div>
<div class="col-md-12 p-0">
    <div class="col-md-1 mb-0 radio-box-group">
        @include('helpers.form_control', [
            'type' => 'radio',
            'name' => 'url_type',
            'value' => 'page',
            'checked' => $module->url_type === $card::PAGE_TYPE || $module->url_type === null,
            'disabled' => $view
        ])
    </div>
    <div class="col-md-11">
        @include('helpers.form_control', [
            'type' => 'select',
            'name' => 'page',
            'id' => 'page',
            'label' => trans('app.admin.module_card.page_list'),
            'placeholder' => trans('app.admin.module_card.page'),
            'value' => $data['values'],
            'rules' => $module->rules(),
            'class' => 'radio-content mt-0',
            'options' => $data['options'],
            'include_blank' => '',
            'pluginOptions' => [
                'allowClear' => true
            ],
            'disabled' => $view
        ])
    </div>
</div>
<div class="col-md-12 p-0 form-group">
    <div class="col-md-1 mb-0 radio-box-group">
        @include('helpers.form_control', [
            'type' => 'radio',
            'name' => 'url_type',
            'value' => 'external',
            'checked' => $module->url_type === $card::EXTERNAL_TYPE,
            'disabled' => $view
        ])
    </div>
    <div class="col-md-11">
        @include('helpers.form_control', [
            'type' => 'text',
            'name' => 'external',
            'value' => $module->url_type === $card::EXTERNAL_TYPE ? $module->url : '',
            'rules' => $module->rules(),
            'placeholder' => 'https://www.example.com',
            'label' => trans('app.admin.module_card.url'),
            'class' => 'radio-content mt-0',
            'disabled' => $view
        ])
    </div>
</div>
<div class="col-md-6">
    @include('helpers.form_control', [
        'type' => 'select',
        'name' => 'width',
        'id' => 'width-select',
        'label' => trans('app.admin.module_card.width'),
        'value' => $module->width ?: '',
        'options' => [
            [
                'value' => 6,
                'text' => '50%'
            ],
            [
                'value' => 12,
                'text' => '100%'
            ]
        ],
        'rules' => $module->rules(),
        'disabled' => $view
    ])
</div>
<div class="col-md-6">
    @include('helpers.form_control', [
        'type' => 'select',
        'name' => 'align',
        'id' => 'align-select',
        'label' => trans('app.admin.module_card.align'),
        'value' => $module->align ?: '',
        'options' => [
            [
                'value' => 'left',
                'text' => trans('app.admin.module_card.left')
            ],
            [
                'value' => 'center',
                'text' => trans('app.admin.module_card.center')
            ],
            [
                'value' => 'right',
                'text' => trans('app.admin.module_card.right')
            ],
        ],
        'rules' => $module->rules(),
        'disabled' => $view
    ])
</div>

