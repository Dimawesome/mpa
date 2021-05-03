<form id="modal-form" method="POST" class="form-validate-jquery">
    @csrf

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="uid" value="{{ $module->uid }}">

    @include('admin.modules._form')

    <div class="modal-footer text-center d-block">
        <a href="{{ action('Admin\ModuleController@update', ['puid' => $puid]) }}"
           class="modal-submit module-submit" data-method="PATCH" data-overlay-id="module-loader">
            <button class="btn btn-purple">
                <em class="fa fa-check"></em>
                {{ trans('app.admin.save') }}
            </button>
        </a>
    </div>

    @include('partials._html_loader', ['id' => 'module-loader'])
</form>

