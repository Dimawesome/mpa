<script type="text/javascript" src="{{ URL::asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/editor.js') }}"></script>
<div class="col-md-6">
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
<div class="col-md-12">
    @include('helpers.form_control', [
        'type' => 'text',
        'name' => 'video_url',
        'value' => $module->video_url,
        'rules' => $module->rules(),
        'placeholder' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'label' => trans('app.admin.module_video_card.youtube_video_url'),
        'class' => 'youtube-url',
        'disabled' => $view
    ])
</div>
<div class="col-md-12">
    @include('helpers.form_control', [
        'type' => 'checkbox',
        'name' => 'video_autoplay',
        'value' => 1,
        'checked' => $module->video_autoplay,
        'label' => trans('app.admin.module_video_card.video_autoplay'),
        'disabled' => $view
    ])
</div>
<div class="col-md-12">
    @include('helpers.form_control', [
        'type' => 'textarea',
        'name' => 'text',
        'class' => 'basic-text-editor',
        'label' => trans('app.admin.module_card.content'),
        'value' => $module->text,
        'rules' => $module->rules(),
        'readonly' => $view,
        'disabled' => $view
    ])
</div>
