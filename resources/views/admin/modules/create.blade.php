<form id="modal-form" method="POST" class="form-validate-jquery">
    @csrf

    @include('admin.modules._form')

    <div class="modal-footer text-center d-block">
        <a href="{{ action('Admin\ModuleController@store', ['puid' => $puid]) }}"
           class="modal-submit module-submit" data-method="POST">
            <button class="btn btn-purple btn-flat">
                <em class="fa fa-check"></em>
                {{ trans('app.admin.save') }}
            </button>
        </a>
    </div>
</form>
