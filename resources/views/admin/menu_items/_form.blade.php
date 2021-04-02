<div class="modal-header">
    <h5 class="modal-title">{{ trans('app.admin.menu.creation') }}</h5>
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
                'value' => $menu['name'] ?? '',
                'label' => trans('app.admin.menu.title'),
                'rules' => $rules
            ])
        </div>
        <div class="col-md-6">
            @include('helpers.form_control', [
                'type' => 'select',
                'name' => 'page',
                'id' => 'page',
                'label' => trans('app.admin.menu.page_list'),
                'placeholder' => trans('app.admin.menu.page'),
                'value' => $menu['page'] ?? old('page'),
                'rules' => $rules,
                'options' => $pages,
                'include_blank' => '',
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ])
        </div>
        <div class="col-md-12">
            @include('helpers.form_control', [
                'type' => 'checkbox',
                'name' => 'status',
                'value' => 'active',
                'checked' => $menu['status'] === 'active',
                'label' => trans('app.admin.menu.status_active')
            ])
        </div>
    </div>
</div>