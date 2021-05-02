<div class="row">
    <div class="col-md-12">
        @include('helpers.form_control', [
            'type' => 'text',
            'name' => 'title',
            'id' => 'title-page',
            'label' => trans('app.admin.title'),
            'value' => $page->title,
            'rules' => $page->rules(),
            'disabled' => $view
        ])
    </div>
    <div class="col-md-12">
        @include('helpers.form_control', [
            'type' => 'select',
            'name' => 'visible_to',
            'id' => 'visible-to-page',
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
            'checked' => $page->is_active,
            'label' => trans('app.admin.status_active'),
            'disabled' => $view
        ])
    </div>
    <div class="col-md-12 form-group module-list-container"
         data-url="{{ action('Admin\ModuleController@moduleList', ['puid' => $page->uid]) }}">
        @include('admin.modules._list', ['modules' => $modules ?? null, 'page' => $page])
    </div>
</div>
<hr>
<div class="col-md-12 text-center">
    @if ($view)
        <a href="{{ url()->previous() }}" type="button" class="btn btn-gray"><em
                    class="fa fa-times"></em>{{ trans('app.admin.back') }}</a>
    @else
        <button name="cancel_btn" value="cancel" class="btn btn-gray" formnovalidate><em
                    class="fa fa-ban"></em>{{ trans('app.admin.cancel') }}</button>
        <button class="btn btn-purple"><em class="fa fa-check"></em>{{ trans('app.admin.save') }}</button>
    @endif
    <a href="{{ action('Admin\PageController@preview', ['puid' => $page->uid]) }}" type="button"
       class="btn btn-purple mc-modal-control float-right" modal-size="xxl"
       data-method="GET" title="{{ trans('app.admin.page.preview') }}">
        <em class="fa fa-eye m-0"></em>
    </a>
</div>
@include('partials._html_loader')
